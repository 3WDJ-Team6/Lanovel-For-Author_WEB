<?php

namespace App\Http\Controllers\Publish;

use App\Http\Controllers\Controller;
use App\Models\ChapterOfWork;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\ContentOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{

    /*
    남은 일 :
        1. db에 있는 bookcover 이미지 다운받아서 image 폴더에 넣어주기.
        2. 사용자가 사용할려면 epubcheck.jar 및 기타 부속품이 필요한데 어케 해결할지
        3. 사용자별로 epubcheck.jar 파일위치가 달라질텐데 ...
    */
    public function publish($num_of_work, $num_of_chapter)
    {

        $work_title = Work::select(                                                         // 작품 제목 가져오기
            'works.work_title'
        )->where('works.num', '=', $num_of_work)->first()->work_title;

        #S3
        $filePath = 'Author' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $work_title . DIRECTORY_SEPARATOR;
        if (!Storage::disk('s3')->exists($filePath)) {
            return $filePath;
            Storage::disk('s3')->makeDirectory($filePath, 0777, true);
        }

        // $book_cover = Work::select(                                                      // 커버 이미지 위치.
        //     'works.bookcover_of_work'
        // )->where('works.num','=',$num_of_work)->pluck('bookcover_of_work');
        // $book_cover=json_encode($book_cover, JSON_UNESCAPED_UNICODE);
        // return $book_cover;

        $chapter_title = ChapterOfWork::select(                                             // 챕터or권 이름
            'chapter_of_works.subtitle'
        )->where('chapter_of_works.num', '=', $num_of_chapter)->first()->subtitle;

        $participant = WorkList::select(                                                    // 작품 참여자 명단 (id)
            'work_lists.user_id'
        )->where('work_lists.num_of_work', '=', $num_of_work)->pluck('user_id');

        $user = User::select('users.nickname')->wherein('users.id', $participant)->pluck('nickname');

        $work_list = json_encode($user, JSON_UNESCAPED_UNICODE);
        $work_list = str::after($work_list, '["');
        $work_list = str::before($work_list, '"]');

        $chapter_list = ContentOfWork::select(                                                // 각 목차 이름 내용 생성시간.
            'content_of_works.subsubtitle',
            'content_of_works.content',
            'content_of_works.created_at'
        )->where('content_of_works.num_of_chapter', '=', $num_of_chapter)->get();

        if (!Storage::disk('s3')->exists($filePath . 'OEBPS') || !Storage::disk('s3')->exists($filePath . 'META-INF')) {
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'text', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'images', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'css', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'js', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'fonts', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'META-INF', 0777, true);
        }

        Storage::disk('s3')->put($filePath . "mimetype", "application/epub+zip");

        $container = "<?xml version='1.0'?>\n
    <container version='1.0' xmlns='urn:oasis:names:tc:opendocument:xmlns:container'>\n
        <rootfiles>\n
            <rootfile full-path='" . $filePath . 'OEBPS' . "/" . $work_title . ".opf' media-type='application/oebps-package+xml'/>\n
        </rootfiles>\n
    </container>\n";

        Storage::disk('s3')->put($filePath . '/META-INF/container.xml', $container); // container 파일

        $file = fopen("C:/" . $work_title . $chapter_title . "/" . $work_title . $chapter_title . "/" . $work_title . $chapter_title . ".opf", "w");

        $isodate = date('Y-m-d\TH:i:s\Z');
        $opf =
            '<?xml version="1.0"?>
        <package version="3.0" xmlns="http://www.idpf.org/2007/opf" unique-identifier="bookID">
            <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
                <dc:title>' . $work_title . '</dc:title>
                <dc:identifier id="bookID">urn:uuid:C44729F0-0820-11EF-892E-0800200C9A66</dc:identifier>
                <dc:date>' . $isodate . '</dc:date>
                <dc:creator id="__dccreator1">' . $work_list . '</dc:creator>
                <meta refines="#__dccreator1" property="role" scheme="marc:relators" id="role">aut</meta>
                <dc:publisher>OO출판사</dc:publisher>
                <meta property="dcterms:modified">' . $isodate . '</meta>
                <dc:language>ko</dc:language>
            </metadata>

            <manifest>
                <item id="toc" properties="nav" href="nav.xhtml" media-type="application/xhtml+xml"/>
                <item id="coverpage" href="cover.xhtml" media-type="application/xhtml+xml"/>
                <item id="coverimage" properties="cover-image" href="images/cover.png" media-type="image/png"/>
                <item id="stylesheet" href="css/stylesheet.css" media-type="text/css"/>
                ';
        foreach ($chapter_list as $i => $clist) {
            $opf = $opf . '<item id="main' . $i . '"';
            $opf = $opf . ' href="main' . $i . '.xhtml" media-type="application/xhtml+xml"/>
                ';
        }

        $opf = $opf . '</manifest>
            <spine page-progression-direction="ltr">
            <itemref idref="coverpage" linear="yes" />
            <itemref idref="toc" linear="yes" />
            ';
        foreach ($chapter_list as $i => $clist) {
            $opf = $opf . '<itemref idref="main' . $i . '"';
            $opf = $opf . ' linear="yes" />
            ';
        }
        $opf = $opf . '</spine>
        </package>
        ';

        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . $work_title . '.opf', $opf, [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
            'visibility' => 'public',
        ]); // opf파일


        $nav =
            '<?xml version="1.0" encoding="UTF-8"?>
            <!DOCTYPE html>
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" xml:lang="ko" lang="ko">
            <head><title></title></head>
            <body>
                <section class="frontmatter TableOfContents">
                    <nav epub:type="toc" id="toc">
                        <h1>목차</h1>
                        <ol>
                            <li><a href="cover.xhtml">' . $work_title . '</a></li>
                            <li><a href="nav.xhtml">목차</a>
                                <ol>
                                ';
        foreach ($chapter_list as $i => $clist) {
            $nav = $nav . '<li> <a href="main' . $i . '.xhtml">' . $clist['subsubtitle'] . '</a></li>';
        }

        $nav = $nav . '</ol>
                     </li>
                   </ol>
                 </nav>
              </section>
           </body>
        </html>';                                           //nav 파일

        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'nav.xhtml', $nav);

        $cover =  //Cover는 bookURL 가지고 와야함
            "<?xml version='1.0' encoding='UTF-8'?>
        <!DOCTYPE html>
        <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ko' lang='ko'>
        <head><title></title></head>
            <body>
                <img src='images/cover.png' alt='" . $work_title . "'/>
            </body>
        </html>
        ";

        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'cover.xhtml', $cover);


        foreach ($chapter_list as $i => $clist) {
            $contents =
                "<?xml version='1.0' encoding='UTF-8'?>
            <!DOCTYPE html>
            <html xmlns='http://www.w3.org/1999/xhtml' xmlns:epub='http://www.idpf.org/2007/ops' xml:lang='ko' lang='ko'>
                <head>
                    <title>" . $clist['subsubtitle'] . "</title>
                    <link rel='stylesheet' href='css/stylesheet.css' type='text/css' />
                </head>
                <body>
                    <h1>" . $clist['subsubtitle'] . "</h1>
                    " . $clist['content'] . "
                </body>
            </html>
            ";
            Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR . 'main' . $i . '.xhtml', $contents);
        }                                                     // 각 목차 내용

        $cssNmae = 'stylesheet';
        $cssFile =
            "
        body { font-size: 1em; }
        h1 { font-size: 1.6em; }
        h2 { font-size: 1.4em; }
        h3 { font-size: 1.2em; }
        h4 { font-size: 1.1em; }
        p { font-size: 1em; }
            ";
        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $cssNmae . '.css', $cssFile);   // css전체

        $jsNmae = 'viewer';
        $jsFile =
            "
            $('#result').html().replace(/[\|｜](.+?)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>')
            .replace(/[\|｜](.+?)（(.+?)）/g, '<ruby>$1<rt>$2</rt></ruby>').replace(/[\|｜](.+?)\((.+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>')
            .replace(/([一-龠]+)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>').replace(/([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
            .replace(/([一-龠]+)\(([ぁ-んァ-ヶ]+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>').replace(/[\|｜]《(.+?)》/g, '《$1》')
            .replace(/[\|｜]（(.+?)）/g, '（$1）').replace(/[\|｜]\((.+?)\)/g, '($1)');
            ";
        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $jsNmae . '.js', $jsFile);   // css전체
        Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'jquery.js', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'jquery.js');
        // 직접 제작한 js와 css는 resource폴더에 보관하고 있다가 발행시 넣어줌.
        return back()->withSuccess($work_title . '의 ' . $chapter_title . ' 이(가) 정상적으로 발행 되었습니다.');
        /*
                위의 생성된 파일들을 바탕으로 epub 파일 생성됨.(
                image.png만 있으면
                확장자 변경은 파일을 가져올 때 파일 확장자 받아서
                opf 파일이랑 cover.xhtml 수정하면됨.
                )
            */
        // return $num_of_work;

        // $file = 'java -jar c:\epubcheck-4.1.1\epubcheck.jar -mode exp -save "C:\\' . $work_title . $chapter_title . '"';
        // shell_exec($file);

    }
}
