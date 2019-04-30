<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\FilePost;
use App\Http\Controllers\tools;
use Aws\AwsClientTrait;
use App\Traits\FileTrait;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use ZipArchive;
# https://laracasts.com/discuss/channels/laravel/how-to-get-properties-name-size-type-of-a-file-retrieved-from-storage?page=1
# 컨트롤러 전역함수 만들어서 쓰기

class FileController extends Controller
{
    use FileTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";
        $files = Storage::disk('s3')->files($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images'));    # 파일 주소를 가르킴

        // return response()->json($files, 200, [], JSON_PRETTY_PRINT); //값이 확인
        $images = [];
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace($role . '/' . Auth::user()['email'] . '/' . config('filesystems.disks.s3.images') . '/', '', $file), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소  Carbon settimezone 설정가능
                'updated_at' => str_replace('000000', '', Carbon::createFromTimestamp(Storage::disk('s3')->lastModified($file))),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }
        // 'metadata' => Storage::disk('s3')->getMetadata($file) / 모든 메타데이터 가져옴
        // return response()->json($images, 200, [], JSON_PRETTY_PRINT);
        return view('uploadAssets/uploadPage', compact('images'));

        // $request->file('file')->storeAs(
        //     $storage,   //저장소 명 URL
        //     $file,      //들어온 파일
        //     's3'        //S3에 저장하겠다
        // );
    }

    #유효성 검사가 실패(FilePost를 통과하지 못)하면 responese가 생성되어 이전 위치로 되돌려 보냄.
    public function store(FilePost $request, $folderPath = null, $bookNum = null)                        #0 파일 저장하는 컨트롤러 asset store & editor 사용
    {
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);                         #1~3 FileTrait에서 처리해줌

        $file = $request->file('image');                             #4 Request로 부터 불러온 정보를 변수에 저장
        $name = time() . $file->getClientOriginalName();             #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
        $saveFilePath = $filePath . $name;                           #6 저장 파일 경로 = 폴더 경로 + 파일 이름
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
            'visibility' => 'public',
            'Metadata' => ['Content-Type' => 'image/jpeg'],
            // 'Expires' => now()->addMinute(5),                        #7 expire 현재시간 + 5분 적용 외않되
        ]);
        return back()->withSuccess('Image uploaded successfully');   #8 성공했을 시 이전 화면으로 복귀 (이후 ajax처리 해야할 부분)
    }

    public function destroy($image, $folderPath = null, $bookNum = null)
    {
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        Storage::disk('s3')->delete($filePath . $image);    //$image = 삭제하려는 이미지명
        // return back()->withSuccess('성공적으로 삭제 되었습니다.');
    }
    public function readBook(Request $request, $folderPath = 'WorkSpace', $bookNum = null, $bookTitle = null)
    {
        //책을 읽을 수 있는 URL을 전달함
        # 일단 칼럼이 있으면 구매 또는 렌탈한 책임. 렌탈한 날짜가 지나면 table값을 삭제 또는 접근 못하게 opf파일주소 눌렀을 때 기간이 초과한 작품이라고 적어 줌
        # 요청이 렌탈이고 현재 렌탈칼럼에 값이 없다면 현재날짜 + 3일로 DB에 table create 있으면 DB저장 없이 OPF파일주소 보내줌.
        # 요청이 구입이고 현재 구입칼럼에 값이 없다면 due_of_rental = NULL(구입),create 있으면 DB저장 없이 OPF파일주소 보내줌.
        # 요청 URL = lendBook/WorkSpace/28/냥멍이
        $bookTitle = '냥멍이';
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);
        # '/Author\Author@test\WorkSpace\폴더구조테스트\OEBPS\폴더구조테스트.opf'
        $opfPath = Storage::disk('s3')->url($filePath . DIRECTORY_SEPARATOR . 'OEBPS' . DIRECTORY_SEPARATOR . $bookTitle . '.opf');

        return $opfPath;
        //책의 opf파일을 리턴해줌
    }

    public function copyBook(Request $request, $folderPath = 'WorkSpace', $bookNum = null, $bookTitle = 'BOOKNAME')
    {

        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);


        // return $filePath; #Author\Author@test\WorkSpace\냥멍이
        $files = Storage::disk('s3')->allFiles($filePath);

        return response()->json($files, 200, [], JSON_PRETTY_PRINT);

        $test = explode('/', $files[0])[5];
        $newFilePath = 'Reader' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'lent' . DIRECTORY_SEPARATOR . $bookTitle . DIRECTORY_SEPARATOR;
        // return 'OldFilePath : ' . explode('/', $files[0])[5] . '         To       ' . 'newFilePath : ' . $newFilePath;
        // return $files[0] . '--' . $newFilePath . explode('/', $files[0])[5];;
        Storage::disk('s3')->copy($files[0], $newFilePath . $test);
        foreach ($files as $file) {
            $explode = expload('/', $file);
            if (!Storage::disk('s3')->exists($newFilePath)) Storage::disk('s3')->copy($file, $newFilePath);
        }

        return 0;

        $images = Storage::disk('s3')->allFiles($filePath);
        // return response()->json($images, 200, [], JSON_PRETTY_PRINT);
        if (!Storage::disk('s3')->makeDirectory('Reader' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'lent' . DIRECTORY_SEPARATOR . $bookTitle)) {
            Storage::disk('s3')->makeDirectory('Reader' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'lent' . DIRECTORY_SEPARATOR . $bookTitle, 0777, true);
        }
        $a = 'Reader' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'lent' . DIRECTORY_SEPARATOR . $bookTitle . DIRECTORY_SEPARATOR;


        foreach ($images as $image) {
            Storage::disk('s3')->copy($image, $a);
        }


        return response()->json($arr, 200, [], JSON_PRETTY_PRINT);

        // Storage::disk('s3')->getDriver()->put('Path', 'test?', ['visibillity' => 'public', 'Expires, GMT date()']);
        // $arr[$i] = array(
        //     'from' => $image,
        //     'to' => $moveTo
        // );
    }

    public function downloadZip()
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $client->registerStreamWrapper();
        $expiry = "+10 minutes";

        // Create a new zipstream object
        $zip = new ZipStream($zipName . '.zip');

        foreach ($files as $file) {
            $filename = $file->original_filename;

            // We need to use a command to get a request for the S3 object
            //  and then we can get the presigned URL.
            $command = $client->getCommand('GetObject', [
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $file->path()
            ]);

            $signedUrl = $request = $client->createPresignedRequest($command, $expiry)->getUri();

            // We want to fetch the file to a file pointer so we create it here
            //  and create a curl request and store the response into the file
            //  pointer.
            // After we've fetched the file we add the file to the zip file using
            //  the file pointer and then we close the curl request and the file
            //  pointer.
            // Closing the file pointer removes the file.
            $fp = tmpfile();
            $ch = curl_init($signedUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            $zip->addFileFromStream($filename, $fp);
            fclose($fp);
        }

        $zip->finish();

        $source = [];
        foreach ($images as $i => $image) {
            $source[$i] = array(Storage::disk('s3')->readStream($image));
            echo $source[$i];
        }


        $tmpfname = tempnam(sys_get_temp_dir(), "tmp");
        $destination = fopen($tmpfname, "w");
        while (!feof($source)) {
            fwrite($destination, fread($source, 8192));
        }
        fclose($source);
        fclose($destination);

        $zipfile = sys_get_temp_dir() . '/file.zip';
        $zip = new ZipArchive;
        $zip->open($zipfile);

        $zip->addFile($tmpfname, 'file.txt');

        $zip->close();

        unlink($tmpfname);

        // upload zip back to S3, or you could stream it to the browser if that is what you need.  Make sure to delete the local file after though

        // To upload back to S3
        Storage::disk('s3')->put('file.zip', $zipfile);
        unlink($zipfile);

        // to stream the file to the browser
        $response = new StreamedResponse();
        $response->setCallback(function () use ($zipfile) {
            readfile($zipfile);
            unlink($zipfile);
        });
        $response->headers->set('Content-Type', 'application/x-zip-compressed');
        $response->headers->set('Cache-Control', '');
        $response->headers->set('Content-Length', filesize($zipfile));
        $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s'));
        $contentDisposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, basename($zipfile));
        $response->headers->set('Content-Disposition', $contentDisposition);

        return $response;
    }

    public function functionSet()
    {

        Storage::disk('s3')->directories(); #해당 경로에 있는 모든 directory (폴더만)

        Storage::disk('s3')->allFiles();    #해당 경로에 있는 모든 file (파일만)

        $fileSize = file_size(Storage::disk('s3')->size('images/' . $imageName));

        $naming = time() . $file->getClientOriginalName(); # 시간 + 원본명으로 저장

        //$request->hasFile('image');                        # image 파일이 있으면

        Storage::disk('s3')->exists($filePath);            # 폴더가 있으면 ture 없으면 fasle

        Storage::disk('s3')->makeDirectory($filePath, 0777, true);    # 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨

        //$file = $request->file('image');                   # Request로 부터 불러온 정보를 변수에 저장

        //$saveFilePath = $filePath . $name;                 # 저장 파일 경로 = 폴더 경로 + 파일 이름

        Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수

        // $images = Storage::disk('s3')->allFiles('oldfolder/image/');
        // foreach ($images as $image) {
        //     $new_loc = str_replace('oldfolder/image/', 'newfolder/image/', $image);
        //     $s3->copy($image, $new_loc);
        // }
        return Storage::disk('s3')->url(); //s3 url 가져오는 함수

    }
}
