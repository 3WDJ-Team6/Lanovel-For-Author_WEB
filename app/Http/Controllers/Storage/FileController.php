<?php

namespace App\Http\Controllers\Storage;

use Auth;
use ZipArchive;
use Aws\AwsClientTrait;
use App\Http\Controllers\tools;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FilePost;
use Illuminate\Http\Request;
use App\Traits\FileTrait;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
        $files = Storage::disk('s3')->files($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'images');    # 파일 주소를 가르킴

        // return response()->json($files, 200, [], JSON_PRETTY_PRINT); //값이 확인
        $images = [];
        foreach ($files as $file) {
            $images[] = [
                'name' => Storage::disk('s3')->getMetadata($file)['basename'], # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => Storage::disk('s3')->getMetadata($file)['path'], #$file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소  Carbon settimezone 설정가능
                'updated_at' => str_replace('000000', '', Carbon::createFromTimestamp(Storage::disk('s3')->lastModified($file))),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
                // 'metadata' => Storage::disk('s3')->getMetadata($file)
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
    public function store(Request $request, $folderPath = null, $bookNum = null, $folderName = null)                        #0 파일 저장하는 컨트롤러 asset store & editor 사용
    {
        $filePath = $this->checkUserMakePath($folderPath, $bookNum, $folderName);
        $this->hasFile($request, $filePath);                         #1~3 FileTrait에서 처리해줌
        $file = $request->file('image') ? $request->file('image') : $request->file('file'); #4 Request로 부터 불러온 정보를 변수에 저장
        // return dd($file);

        $name = time() . $file->getClientOriginalName();             #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
        $saveFilePath = $filePath . $name;                           #6 저장 파일 경로 = 폴더 경로 + 파일 이름
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
            'visibility' => 'public',
            // 'Metadata' => ['Content-Type' => 'image/jpeg'],
            // 'Expires' => now()->addMinute(5),                        #7 expire 현재시간 + 5분 적용 외않되
        ]);
        return back()->withSuccess('Image uploaded successfully');   #8 성공했을 시 이전 화면으로 복귀 (이후 ajax처리 해야할 부분)

    }

    public function destroy($image, $folderPath = null, $folderName = null, $bookNum = null)
    {
        $filePath = $this->checkUserMakePath($folderPath, $bookNum, $folderName);
        Storage::disk('s3')->delete($filePath . $image);    //$image = 삭제하려는 이미지명
    }

    public function downLoadEpub(Request $request, $bookTitle = null, $authorPath = null)
    {
        // 책으로 발행했을 때도 epub으로 만들어서 작가에게 줘야함 publishcontroller에 추가할 코드(아래)
        $bookTitle == '냥멍이' ? $bookTitle = '냥멍이' : $bookTitle = $bookTitle;
        $authorPath == 'Author@test' ? $authorPath = 'Author@test' : $authorPath = $authorPath;
        /*
        issue : 마운트 시킨 s3폴더 내에 depth가 깊어서 -j 명령어로 뒷 폴더를 잘라야 하고 -r 명령어로 모든 파일 및 폴더를 압축 해야하는데,
                명령어는 두개를 사용할 수 없음.
        resolve : bin(전역)에 shell script(zipdir)를 만들고, 해당 스크립트에 변수를 넘기고, 실행시켜서 폴더로 접근한 뒤 압축함.
        */
        shell_exec('mkdir /mnt/epubz');
        //shell_exec('cd /mnt/mountpoint/Author/Author@test/WorkSpace'); // shell_exec('zip /mnt/epubz/folder.zip -r 폴더구조테스트/*'); // 해당 폴더 압축 ->shell로 대체
        shell_exec('zipdir ' . $authorPath . ' ' . $bookTitle); // zip 유저명 폴더명 $1 $2 shell폴더안에 있는 zipdir.sh (shell프로그램)
        # zip 으로 만드는건 끝

        $filepath = '/mnt/epubz/' . $bookTitle . '.zip';
        $filesize = filesize($filepath);
        $path_parts = pathinfo($filepath);
        $filename = $path_parts['basename'];
        $extension = $path_parts['extension'];


        header("Pragma: public");
        header("Expires: 0");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $bookTitle . '.zip');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: $filesize");

        ob_clean();             # 출력 버퍼의 내용을 삭제 (ob_end_clean은 파괴)
        flush();                # 시스템 출력 버퍼를 비움
        readfile($filepath);    # file을 출력하는 php 함수
    }

    public function makeEpub($bookNum = null, $folderPath = null, $bookTitle = null)
    {
        $bookTitle = "냥멍이";
        $folderPath = "WorkSpace";
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        return $filePath;

        $heart = Work::select()->get();
        # 테이블에 값이 있으면 실행.
        if ($heart->exists()) {
            // $heart->update(['dl_check' => true]);
            shell_exec('mkdir /mnt/zip-point/' . $filePath);
            shell_exec('chmod 777 /mnt/zip-point/' . $filePath);
        }

        //$fileNames = File::where('user_id', \Auth::user()->id)
        //             ->where('dl_check', 0)
        //             ->pluck('name');

        foreach ($fileNames as $name) { //올린 파일을 구매하려는 사용자의 폴더로 옮김 (결제시 옮겨진 폴더를 압축시킴.)
            shell_exec('cp /mnt/mountpoint/files/bbb@naver.com/' . $name . ' /mnt/zip-point/aaa@naver.com/' . $name);
            //      shell_exec('cp /mnt/zip-point/bbb@naver.com/1.txt /mnt/zip-point/aaa@naver.com/1.txt');
        }
    }

    public function fromS3toZip(Request $request, $folderPath = 'WorkSpace', $bookNum = 28, $bookTitle = 'BOOKNAME')
    {

        #https://stackoverflow.com/questions/44900585/aws-s3-copy-and-replicate-folder-in-laravel
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);
        // return $filePath; #Author\Author@test\WorkSpace\냥멍이

        $zipArchive = new ZipArchive();

        //The full path to where we want to save the zip file.
        $zipFilePath = public_path() . '/zip/example.zip';

        //Call the open function.
        $status = $zipArchive->open($zipFilePath,  ZipArchive::CREATE);

        $filesToAdd = Storage::disk('s3')->allFiles($filePath);
        // return response()->json($filesToAdd, 200, [], JSON_PRETTY_PRINT);
        //An array of files that we want to add to our zip archive.
        //You should list the full path to each file.

        //Add our files to the archive by using the addFile function.
        foreach ($filesToAdd as $fileToAdd) {
            //Add the file in question using the addFile function.
            $zipArchive->addFile(Storage::disk('s3')->url($fileToAdd));
        }

        //Finally, close the active archive.
        $zipArchive->close();

        //Get the basename of the zip file.
        $zipBaseName = basename($zipFilePath);

        //Set the Content-Type, Content-Disposition and Content-Length headers.
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$zipBaseName");
        header("Content-Length: " . filesize($zipFilePath));

        //Read the file data and exit the script.
        readfile($zipFilePath);
        exit;
        return 0;
    }

    public function copyBook(Request $request, $folderPath = 'WorkSpace', $bookNum = null, $bookTitle = 'BOOKNAME')
    {
        #https://stackoverflow.com/questions/44900585/aws-s3-copy-and-replicate-folder-in-laravel
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
        $naming = getClientOriginalName(); # 원본명
        //$request->hasFile('image');                        # image 파일이 있으면
        Storage::disk('s3')->exists($filePath);            # 폴더가 있으면 ture 없으면 fasle
        Storage::disk('s3')->makeDirectory($filePath, 0777, true);    # 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
        //$file = $request->file('image');                   # Request로 부터 불러온 정보를 변수에 저장
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); # 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
        return Storage::disk('s3')->url(); //s3 url 가져오는 함수
        // $images = Storage::disk('s3')->allFiles('oldfolder/image/');
        // foreach ($images as $image) {
        //     $new_loc = str_replace('oldfolder/image/', 'newfolder/image/', $image);
        //     $s3->copy($image, $new_loc);
        // }

    }
}
