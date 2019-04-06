<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tools;
use Auth;

class DirectoryController extends Controller
{
    private $tools = null;
    public function __construct()
    {
        $this->tools = new tools();
        $this->middleware('auth');   # 인증된 사용자만 이용할 수 있게 , route(login)이 실행됨.

    }



    # @return \Illuminate\Http\Response
    # Display a listing of the resource.
    public function index() //get Directories & get Files
    {
        # 디렉토리 접근할 수 있도록 , # file접근법 path url 등등 aws, php sdk 사용
        Auth::user()['roles'] === 2 ? $role = "Author/" : $role = "Illustrator/";
        $userEmail = Auth::user()['email'] . '/';
        $folder = 'Public/';
        $path = $role . $userEmail . $folder;

        $dirFiles = Storage::disk('s3')->files($path);
        $dir = Storage::disk('s3')->directories($role); #해당 경로에 있는 모든 directory (폴더만)
        #리소스 폴더 보여줌 directories -> 폴더 누름(눌럿을 때 모든 파일+폴더 보임) allfile + directories -> file 또는 directory 들어감
        #리소스 폴더 생성

        $inDirectory[] = [
            ['directories' => $dir],
            ['files' => $dirFiles]
        ];

        return response()->json($inDirectory, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인
        return $inDirectory;
        if ($dir === []) {  // 해당 폴더에 더이상 폴더가 없으면?
            $dir = Storage::disk('s3')->allFiles($role);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
