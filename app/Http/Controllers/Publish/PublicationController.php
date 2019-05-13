<?php

namespace App\Http\Controllers\Publish;

use App\Models\User;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\ChapterOfWork;
use App\Models\ContentOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PublicationController extends Controller
{
    // Open eBook Publication Structure
    /*
    남은 일 :
        1. db에 있는 bookcover 이미지 다운받아서 image 폴더에 넣어주기.
        2. 사용자가 사용할려면 epubcheck.jar 및 기타 부속품이 필요한데 어케 해결할지
        3. 사용자별로 epubcheck.jar 파일위치가 달라질텐데 ...
    */
    public function publish($num_of_work, $num_of_chapter)
    {
        $work_title = Work::select(            // 작품 제목 가져오기
            'works.work_title'
        )->where('works.num', '=', $num_of_work)->first()->work_title;

        $book_cover = Work::select(
            'works.bookcover_of_work'
        )->where('works.num', '=', $num_of_work)->first()->bookcover_of_work;
        #S3
        $filePath = 'Author' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $work_title . DIRECTORY_SEPARATOR;
        if (!Storage::disk('s3')->exists($filePath)) {
            Storage::disk('s3')->makeDirectory($filePath, 0777, true);
        }

        $coverName = str_replace(config('filesystems.disks.s3.url') . 'Author' . DIRECTORY_SEPARATOR . Auth::user()['email'] .
            DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $work_title . DIRECTORY_SEPARATOR .
            'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR, '', $book_cover);
        while (1) {
            if (str::contains($book_cover, '\\')) {
                $book_cover = str::replaceFirst('\\', '/', $book_cover);
            } else {
                break;
            }
        }

        // $book_cover = Work::select(         // 커버 이미지 위치.
        //     'works.bookcover_of_work'
        // )->where('works.num','=',$num_of_work)->pluck('bookcover_of_work');
        // $book_cover=json_encode($book_cover, JSON_UNESCAPED_UNICODE);


        $chapter_title = ChapterOfWork::select(               // 챕터or권 이름
            'chapter_of_works.subtitle'
        )->where('chapter_of_works.num', '=', $num_of_chapter)->first()->subtitle;

        $participant = WorkList::select(       // 작품 참여자 명단 (id)
            'work_lists.user_id'
        )->where('work_lists.num_of_work', '=', $num_of_work)->pluck('user_id');

        $user = User::select('users.nickname')->wherein('users.id', $participant)->pluck('nickname');

        $work_list = json_encode($user, JSON_UNESCAPED_UNICODE);
        $work_list = str::after($work_list, '["');
        $work_list = str::before($work_list, '"]');
        while (1) {
            if (str::contains($work_list, '","')) {
                $work_list = str::replaceFirst('","', " ", $work_list);
            } else {
                break;
            }
        }

        $authorFolder = WorkList::select('users.email')->join('users', 'users.id', '=', 'work_lists.user_id')->where('num_of_work', $num_of_work)->orderBy('work_lists.created_at')->limit(1)->get()[0]->email;

        $chapter_list = ContentOfWork::select(                                                // 각 목차 이름 내용 생성시간.
            'content_of_works.subsubtitle',
            'content_of_works.content',
            'content_of_works.created_at'
        )->where('content_of_works.num_of_chapter', '=', $num_of_chapter)->get();
        $text;
        $onlyimglist = [];
        $imglist2 = [];
        $onlypurlist = [];
        $purlist2 = [];
        $onlysoundlist = [];
        $soundlist2 = [];
        $onlyvideolist = [];
        $videolist2 = [];
        $test;
        $count = 0;
        $text2;
        $test2;
        $text3;
        $test3;
        $text4;
        $test4;

        foreach ($chapter_list as $i => $clist) {
            $text = $clist['content'];
            $text2 = $clist['content'];
            $text3 = $clist['content'];
            $text4 = $clist['content'];
            while (1) {
                if (str::contains($text, "/sound/")) {
                    $text = str::after($text, "/sound/");
                    $test = str::before($text, '">');
                    $onlysoundlist = Arr::add($onlysoundlist, 'names' . $count, $test);
                }
                elseif (str::contains($text2, "/video/")) {
                    $text2 = str::after($text2, "/video/");
                    $test2 = str::before($text2, '" ');
                    $onlyvideolist = Arr::add($onlyvideolist, 'namev' . $count, $test2);
                }
                elseif (str::contains($text3, "/images/")) {
                    $text3 = str::after($text3, "/images/");
                    $test3 = str::before($text3, '" ');
                    $onlyimglist = Arr::add($onlyimglist, 'namei' . $count, $test3);
                }elseif (str::contains($text4, "/purchase/")) {
                    $text4 = str::after($text4, "/purchase/");
                    $test4 = str::before($text4, '" ');
                    $onlypurlist = Arr::add($onlypurlist, 'namep' . $count, $test4);
                    // return $onlypurlist;
                }else {
                    break;
                }
                $count += 1;
            }
        }
        $count = 0;
        foreach ($onlyimglist as $i => $il2) {
            $text3 = str::start($il2, "Author/" . Auth::user()['email'] . "/images/");
            $imglist2[$i] = $text3;
        }
        foreach ($onlysoundlist as $i => $sl2) {
            $text = str::start($sl2, "Author/" . Auth::user()['email'] . "/sound/");
            $soundlist2[$i] = $text;
        }
        foreach ($onlyvideolist as $i => $vl2) {
            $text2 = str::start($vl2, "Author/" . Auth::user()['email'] . "/video/");
            $videolist2[$i] = $text2;
        }
        foreach ($onlypurlist as $i => $vl2) {
            $text2 = str::start($vl2, "Author/" . Auth::user()['email'] . "/purchase/");
            $purlist2[$i] = $text2;
        }
        if (!Storage::disk('s3')->exists($filePath . 'OEBPS') || !Storage::disk('s3')->exists($filePath . 'META-INF')) {
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'text', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'images', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'purchase', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'css', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'js', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'fonts', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'audio', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'sound', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'OEBPS' .  DIRECTORY_SEPARATOR . 'video', 0777, true);
            Storage::disk('s3')->makeDirectory($filePath . 'META-INF', 0777, true);
        }
        foreach ($imglist2 as $i => $imglist) {
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $onlyimglist[$i])) {
                Storage::disk('s3')->copy($imglist, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $onlyimglist[$i]);
            }
        }
        foreach ($purlist2 as $i => $purlist) {
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'purchase' . DIRECTORY_SEPARATOR . $onlypurlist[$i])) {
                Storage::disk('s3')->copy($purlist, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'purchase' . DIRECTORY_SEPARATOR . $onlypurlist[$i]);
            }
        }
        foreach ($soundlist2 as $i => $soundlist) {
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . $onlysoundlist[$i])) {
                Storage::disk('s3')->copy($soundlist, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . $onlysoundlist[$i]);
            }
        }
        foreach ($videolist2 as $i => $videolist) {
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $onlyvideolist[$i])) {
                Storage::disk('s3')->copy($videolist, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $onlyvideolist[$i]);
            }
        }
        Storage::disk('s3')->put($filePath . "mimetype", "application/epub+zip");
        $container = "<?xml version='1.0'?>\n
    <container version='1.0' xmlns='urn:oasis:names:tc:opendocument:xmlns:container'>\n
        <rootfiles>\n
            <rootfile full-path='OEBPS/" . $work_title . ".opf' media-type='application/oebps-package+xml'/>\n
        </rootfiles>\n
    </container>\n";
        Storage::disk('s3')->put($filePath . '/META-INF/container.xml', $container); // container 파일
        $covertype = str::after($coverName, '.');
        if ($covertype == 'jpg') {
            $covertype = 'jpeg';
        }

        $isodate = date('Y-m-d\TH:i:s\Z');
        $opf =
            '<?xml version="1.0" encoding="UTF-8"?>
        <package xmlns="http://www.idpf.org/2007/opf" version="3.0" xml:lang="JP" prefix="rendition: http://www.idpf.org/vocab/rendition/#" unique-identifier="bookID">
            <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
                <dc:title id="title">' . $work_title . '</dc:title>
                <dc:identifier id="bookID">' . strtolower($work_title) . '</dc:identifier>
                <dc:date>' . $isodate . '</dc:date>
                <dc:creator id="__dccreator1">' . $work_list . '</dc:creator>
                <dc:contributor id="contrib1">' . 'Illustrator' . '</dc:contributor>
                <dc:language>JP</dc:language>
                <meta refines="#__dccreator1" property="role" scheme="marc:relators" id="role">aut</meta>
                <dc:publisher>영진출판사</dc:publisher>
                <meta property="dcterms:modified">' . $isodate . '</meta>
                <meta property="rendition:layout">pre-paginated</meta>
                <meta property="rendition:orientation">landscape</meta>
                <meta property="rendition:spread">auto</meta>
            </metadata>
            <manifest>
 <item id="toc" properties="nav" href="nav.xhtml" media-type="application/xhtml+xml" />
 <item id="coverpage" href="cover.xhtml" media-type="application/xhtml+xml" />
 <item id="coverimage" properties="cover-image" href="images/' . $coverName . '"' . ' ' . 'media-type="image/' . $covertype . '" />
 <item id="stylesheet" href="css/stylesheet.css" media-type="text/css" />
 <item id="pagecss" href="css/page_styles.css" media-type="text/css" />
 ';
        foreach ($onlyimglist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $opf = $opf . '<item id="images-' . $i . '" href="images/' . $il . '" media-type="application/xhtml+xml" />
        ';
            }
        }
        foreach ($onlysoundlist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $opf = $opf . '<item id="sound-' . $i . '" href="sound/' . $il . '" media-type="application/xhtml+xml" />
  ';
            }
        }
        foreach ($onlyvideolist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $opf = $opf . '<item id="video-' . $i . '" href="video/' . $il . '" media-type="application/xhtml+xml" />
  ';
    }
 }
 foreach ($onlypurlist as $i => $il) {
    if(!str::contains($opf,$il)){
     $opf = $opf . '<item id="video-' . $i . '" href="purchase/' . $il. '" media-type="application/xhtml+xml" />
  ';
    }
 }
 foreach ($chapter_list as $i => $clist) {
     $opf = $opf . '<item id="main' . $i . '" href="text/main' . $i . '.xhtml" media-type="application/xhtml+xml" />
  ';
        }

        $opf = $opf . '</manifest>
            <spine page-progression-direction="ltr">
            <itemref idref="coverpage" linear="yes" />
            <itemref idref="toc" linear="yes" />
            ';
        foreach ($chapter_list as $i => $clist) {
            $opf = $opf . '<itemref idref="main' . $i . '" linear="yes" />
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
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/opf" xml:lang="jp" lang="jp">
            <head>
                <meta http-equiv="default-style" content="text/html; charset=utf-8" />
                <title>Navigation</title>
                <link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
            </head>
            <body>
                <section class="frontmatter TableOfContents">
                    <nav epub:type="toc" id="toc">
                        <h1>Contents</h1>
                        <ol epub:type="list">
                <li><a href="cover.xhtml" class="nav_li">' . 'cover' . $work_title . '</a></li>
                <li><a href="nav.xhtml" class="nav_li">Contents</a></li>
  ';
        foreach ($chapter_list as $i => $clist) {
            $nav = $nav . '<li> <a href="text/main' . $i . '.xhtml" class="nav_li">' . $clist['subsubtitle'] . '</a></li>';
        }
        $nav = $nav . '
    </ol>
  </nav>
              </section>
           </body>
        </html>';             //nav 파일
        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'nav.xhtml', $nav);
        //<!DOCTYPE html> why?
        $cover =  //Cover는 bookURL 가지고 와야함
            "<?xml version='1.0' encoding='UTF-8'?>
            <html xmlns='http://www.w3.org/1999/xhtml' xmlns:epub='http://www.idpf.org/2007/ops' xml:lang='jp' lang='jp'>
                <head>
                    <meta http-equiv='default-style' content='text/html; charset=utf-8'/>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0' />
                    <title>" . $work_title . "</title>
                    <link rel='stylesheet' type='text/css' href='css/stylesheet.css' />
                    <link rel='stylesheet' type='text/css' href='css/page_styles.css' />
                </head>
                <body style='margin:0.00em;'>
                    <section id='sectionId' class='cover cover-rw Cover-rw' epub:type='cover'>
                        <div id='coverimgdiv'>
                        </div>
                    </section>
                </body>
            </html>
        ";

        // <span id='worktitlespan'>".$work_title."</span>
        // <span id='worklistspan'>".$work_list."</span>
        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'cover.xhtml', $cover);

        $multimedialist = [];
        foreach ($chapter_list as $i => $clist) {
            $text = $clist['content'];
            while(1){
                if(str::contains($text,'/sound/')){
                    $text = str::replaceFirst('/sound/','/audio/',$text);
                }elseif(str::contains($text,'https://s3.ap-northeast-2.amazonaws.com/')){
                    $text = str::replaceFirst('https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/'.Auth::user()['email'].'/','../',$text);
                    // return $text;
                }else{
                    $clist['content']=$text;
                    // return 3;
                    break;
                }
            }
            $contents =
                "<?xml version='1.0' encoding='UTF-8'?>
                <html xmlns='http://www.w3.org/1999/xhtml' xmlns:epub='http://www.idpf.org/2007/ops' xml:lang='jp' lang='jp'>
                    <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0' />
                    <meta name='Adept.resource' value='urn:uuid:ad98550c-1f39-4200-91cd-f044b376b4f4' />
                    <title>" . $clist['subsubtitle'] . "</title>
                    <link rel='stylesheet' href='../css/stylesheet.css' type='text/css' />
                    <link rel='stylesheet' href='../css/page_styles.css' type='text/css' />
                    <script src='../js/jquery.js'></script>
                    <script src='../js/viewer.js'></script>
                    </head>
                <body>
                <div class='galley-rw'>
                <section class='frontmatter-rw Dedication-rw exclude-auto-rw page-open-auto-rw' id='Dedication1'
                    epub:type='frontmatter dedication'>
                    <h1>" . $clist['subsubtitle'] . "</h1>
                    " . $clist['content'] . "
                </section>
                </div>
                </body>
            </html>
            ";
            Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR . 'main' . $i . '.xhtml', $contents);
        }        // 각 목차 내용

        $filePaths = $filePath;
        while (1) {
            if (str::contains($filePaths, "\\")) {
                $filePaths = str::replaceFirst("\\", "/", $filePaths);
            } else {
                break;
            }
        }
        $giffiles = Storage::disk('s3')->allfiles('resource' . DIRECTORY_SEPARATOR . 'gifimages');
        foreach ($giffiles as $i => $giffile) {
            $giffilet = str::after($giffile, '/');
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $giffilet)) {
                Storage::disk('s3')->copy($giffile, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $giffilet);
            }
        }
        // custom css
        $cssNmae = 'stylesheet';
        $cssFile =
            "
            #sectionId{text-align:center; margin-top:5%; } #coverimgdiv{ background: url('" . $book_cover . "') no-repeat; box-shadow: 2px 2px 30px -2px rgba(0,0,0,0.8); background-size:contain; display: inline-block; width: 398px; height: 554px; text-align:left;            }            #worktitlespan{ position: absolute; font-size : 3em; background-color : #00000050; color: white; display: inline-block;            }            #worklistspan{ position: relative; top: 15%; font-size : 2em; background-color : #00000050; color: white; display: inline-block;}

            .resize,
            .resize_mp4 {
                width: 400px;
                height: auto;
                background-size: auto;
                background-repeat: no-repeat;
                /* position: relative; */
            }
            ol{
                list-style-type:none;
            }
            .nav_li{
                font-size:1.3em;
            }
            .tem_effect {
                display: inline-block;
            }
            #cherryBlossom1,
            #cherryBlossom2,
            #rain,
            #snow,
            #starlight,
            #yellowstar,
            #lightning,
            #fire1,
            #fire2 {
                display: inline-block;
                position: absolute;
            }
            .calibre7 {
                display: block;
                font-size: 0.77419em;
                text-indent: 20pt;
                margin: 0
                }

            #css_eft_cB1,
            #css_eft_cB2,
            #css_eft_rain,
            #css_eft_snow,
            #css_eft_starlight,
            #css_eft_yellowstar,
            #css_eft_lightning {
                width: 120px;
                height: 120px;
            }
            #cherryBlossom1,
            #css_eft_cB1 {
                background: url('../images/gifimages/cherryBlossom1.gif');
            }

            #cherryBlossom2,
            #css_eft_cB2 {
                background: url('../images/gifimages/cherryBlossom2.gif');
            }

            #rain,
            #css_eft_rain {
                background: url('../images/gifimages/rain.gif');
            }

            #snow,
            #css_eft_snow {
                background: url('../images/gifimages/snow.gif');
            }

            #starlight,
            #css_eft_starlight {
                background: url('../images/gifimages/starlight.gif');
            }

            #yellowstar,
            #css_eft_yellowstar {
                background: url('../images/gifimages/yellowstar.gif');
            }

            #lightning,
            #css_eft_lightning {
                background: url('../images/gifimages/lightning.gif');
            }
            body{
                display:block;
                margin-bottom:2em;
                margin-top:2em;
                page-break-before:always;
            }
            p {
                display:block;
                margin:0;
                font-size:1.5em;
                line-height:1.6em;
                page-break-after:always;
            }
            div, img, video {max-width:100% max-height:100%}
            ";
            Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $cssNmae . '.css', $cssFile);
            $cssNmae = 'page_styles';
            $cssFile =
                "
                @page {
                  page-break-before: always;
                  margin-bottom: 5pt;
                  margin-top: 5pt
                  }
                  ";


            Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $cssNmae . '.css', $cssFile);

        $jsNmae = 'viewer';
        $jsFile =
            "
            $(function(){
                $('#Dedication1').each(function() {
                    $(this).html(
                        $(this).html()
                        .replace(/[\|｜](.+?)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/[\|｜](.+?)（(.+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/[\|｜](.+?)\((.+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/([一-龠]+)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/([一-龠]+)\(([ぁ-んァ-ヶ]+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>')
                        .replace(/[\|｜]《(.+?)》/g, '《$1》')
                        .replace(/[\|｜]（(.+?)）/g, '（$1）')
                        .replace(/[\|｜]\((.+?)\)/g, '($1)')
                    );
                });
            });
            let isPlaying = false;
            let audioPlay_num = null;

            function audioPlay(e) {
                audioPlay_num = e.target.nextElementSibling.id;
                // console.log(audioPlay_num);
                var audio = document.getElementById(audioPlay_num);
                if (isPlaying) {
                    audio.pause();
                    isPlaying = false;
                } else {
                    audio.play();
                    isPlaying = true;
                }
}
            ";

            if(!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $jsNmae . '.js')){
                Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $jsNmae . '.js', $jsNmae);
            } // js

        if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'jquery.js')) {
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'jquery.js', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'jquery.js');
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'stylesheet.css', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
        } // 직접 제작한 js와 css는 resource폴더에 보관하고 있다가 발행시 넣어줌.


        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 책으로 발행했을 때도 epub으로 만들어서 작가에게 줘야함 publishcontroller에 추가할 코드(아래)


        $work_title == '냥멍이' ? $work_title = '냥멍이' : $work_title = $work_title;
        $authorFolder == 'Author@test' ? $authorFolder = 'Author@test' : $authorFolder = $authorFolder;
        shell_exec('mkdir /mnt/epubz');
        //shell_exec('cd /mnt/mountpoint/Author/Author@test/WorkSpace'); // shell_exec('zip /mnt/epubz/folder.zip -r 폴더구조테스트/*'); // 해당 폴더 압축 ->shell로 대체
        shell_exec('zipdir ' . $authorFolder . ' ' . $work_title); // zip 유저명 폴더명 $1 $2 shell폴더안에 있는 zipdir.sh (shell프로그램)
        # zip 으로 만드는건 끝

        // $filepath = '/mnt/epubz/' . $work_title . '.zip';
        // $filesize = filesize($filepath);
        // $path_parts = pathinfo($filepath);
        // $filename = $path_parts['basename'];
        // $extension = $path_parts['extension'];

        // header("Pragma: public");
        // header("Expires: 0");
        // header("Content-Type: application/octet-stream");
        // header("Content-Disposition: attachment; filename=" . $work_title . '.zip');
        // header("Content-Transfer-Encoding: binary");
        // header("Content-Length: $filesize");

        // ob_clean();             # 출력 버퍼의 내용을 삭제 (ob_end_clean은 파괴)
        // flush();                # 시스템 출력 버퍼를 비움
        // readfile($filepath);    # file을 출력하는 php 함수

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
