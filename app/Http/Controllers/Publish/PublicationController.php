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
        )->where('works.num', '=', $num_of_work)->pluck('work_title');
        $title = json_encode($work_title, JSON_UNESCAPED_UNICODE);
        $title = str::after($title, '["');
        $title = str::before($title, '"]');                                                 // 문자열 처리

        // $book_cover = Work::select(                                                      // 커버 이미지 위치.
        //     'works.bookcover_of_work'
        // )->where('works.num','=',$num_of_work)->pluck('bookcover_of_work');
        // $book_cover=json_encode($book_cover, JSON_UNESCAPED_UNICODE);
        // return $book_cover;

        $chapter_title = ChapterOfWork::select(                                             // 챕터or권 이름
            'chapter_of_works.subtitle'
        )->where('chapter_of_works.num', '=', $num_of_chapter)->pluck('subtitle');
        $chapter_title = json_encode($chapter_title, JSON_UNESCAPED_UNICODE);
        $chapter_title = str::after($chapter_title, '["');                                   // 마찬가지로 문자열 처리
        $chapter_title = str::before($chapter_title, '"]');

        $participant = WorkList::select(                                                    // 작품 참여자 명단 (id)
            'work_lists.user_id'
        )->where('work_lists.num_of_work', '=', $num_of_work)->pluck('user_id');
        $user = User::select(
            'users.nickname'
        )->wherein('users.id', $participant)->pluck('nickname');
        $work_list = json_encode($user, JSON_UNESCAPED_UNICODE);
        $work_list = str::after($work_list, '["');
        $work_list = str::before($work_list, '"]');
        $work_list = str_replace('"', '', $work_list);                                    // 가져온 명단 닉네임(필명) 으로 변경

        $chapter_list = ContentOfWork::select(                                                // 각 목차 이름 내용 생성시간.
            'content_of_works.subsubtitle',
            'content_of_works.content',
            'content_of_works.created_at'
        )->where('content_of_works.num_of_chapter', '=', $num_of_chapter)->get();

        mkdir("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/images", 0777, true);
        mkdir("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/css", 0777, true);
        mkdir("C:/" . $title . $chapter_title . "/META-INF", 0777, true);                           // 폴더 생성
        $file = fopen("C:/" . $title . $chapter_title . "/mimetype", "w");
        $text = "application/epub+zip";
        +fwrite($file, $text);
        fclose($file);                                                                                          // mimetype 파일

        $file = fopen("C:/" . $title . $chapter_title . "/META-INF/container.xml", "w");
        $text =
            /*full-path 부분 수정해야함.
        --------------------------수정 했음*/
            "<?xml version='1.0'?>\n
        <container version='1.0' xmlns='urn:oasis:names:tc:opendocument:xmlns:container'>\n
            <rootfiles>\n
                <rootfile full-path='" . $title . $chapter_title . "/" . $title . $chapter_title . ".opf' media-type='application/oebps-package+xml'/>\n
            </rootfiles>\n
        </container>\n";
        fwrite($file, $text);
        fclose($file);                                                                                      // container 파일

        $file = fopen("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/" . $title . $chapter_title . ".opf", "w");
        $isodate = date('Y-m-d\TH:i:s\Z');
        $text =
            '<?xml version="1.0"?>
        <package version="3.0" xmlns="http://www.idpf.org/2007/opf" unique-identifier="bookID">
            <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
                <dc:title>' . $title . '</dc:title>
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
            $text = $text . '<item id="main' . $i . '"';
            $text = $text . ' href="main' . $i . '.xhtml" media-type="application/xhtml+xml"/>
                ';
        }

        $text = $text . '</manifest>
            <spine page-progression-direction="ltr">
            <itemref idref="coverpage" linear="yes" />
            <itemref idref="toc" linear="yes" />
            ';
        foreach ($chapter_list as $i => $clist) {
            $text = $text . '<itemref idref="main' . $i . '"';
            $text = $text . ' linear="yes" />
            ';
        }
        $text = $text . '</spine>
        </package>
        ';
        fwrite($file, $text);
        fclose($file);                                          // opf파일

        $file = fopen("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/nav.xhtml", "w");
        $text =
            '<?xml version="1.0" encoding="UTF-8"?>
            <!DOCTYPE html>
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" xml:lang="ko" lang="ko">
            <head><title></title></head>
            <body>
                <section class="frontmatter TableOfContents">
                    <nav epub:type="toc" id="toc">
                        <h1>목차</h1>
                        <ol>
                            <li><a href="cover.xhtml">' . $title . '</a></li>
                            <li><a href="nav.xhtml">목차</a>
                                <ol>
                                ';
        foreach ($chapter_list as $i => $clist) {
            $text = $text . '<li> <a href="main' . $i . '.xhtml">' . $clist['subsubtitle'] . '</a></li>
                                    ';
        }

        $text = $text . '
                                </ol>
                            </li>
                        </ol>
                    </nav>
                </section>
            </body>
        </html>
        ';
        fwrite($file, $text);
        fclose($file);                                                //nav 파일

        $file = fopen("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/cover.xhtml", "w");
        $text =
            "<?xml version='1.0' encoding='UTF-8'?>
        <!DOCTYPE html>
        <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ko' lang='ko'>
        <head><title></title></head>
            <body>
                <img src='images/cover.png' alt='" . $title . "'/>
            </body>
        </html>
        ";
        fwrite($file, $text);
        fclose($file);                                                // cover.xhtml

        foreach ($chapter_list as $i => $clist) {
            $file = fopen("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/main" . $i . ".xhtml", "w");
            $text =
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
            fwrite($file, $text);
            fclose($file);
        }                                                     // 각 목차 내용


        $file = fopen("C:/" . $title . $chapter_title . "/" . $title . $chapter_title . "/css/stylesheet.css", "w");
        $text =
            "
        body { font-size: 1em; }
        h1 { font-size: 1.6em; }
        h2 { font-size: 1.4em; }
        h3 { font-size: 1.2em; }
        h4 { font-size: 1.1em; }
        p { font-size: 1em; }
        ";
        fwrite($file, $text);
        fclose($file);                                              // css전체
        // 아직 이부분은 민수랑 협의 해야됨

        // 주소 수정하기.
        $file = 'java -jar c:\epubcheck-4.1.1\epubcheck.jar -mode exp -save "C:\\' . $title . $chapter_title . '"';
        shell_exec($file);
        return $file;

        /*
                위의 생성된 파일들을 바탕으로 epub 파일 생성됨.(
                image.png만 있으면
                확장자 변경은 파일을 가져올 때 파일 확장자 받아서
                opf 파일이랑 cover.xhtml 수정하면됨.
                )
            */
        // return $num_of_work;

    }
}
