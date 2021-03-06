<?php

namespace App\Http\Controllers\Publish;

use App\Models\User;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\ChapterOfWork;
use App\Models\ContentOfWork;
use App\Models\Subscribe;
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
    public function publish($num_of_work, $num_of_chapter, request $request)
    {
        $work_title = Work::select(            // 작품 제목 가져오기
            'works.work_title'
        )->where('works.num', '=', $num_of_work)->first()->work_title;


        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = 'fbNGwmVlMUs:APA91bHXrhAoBDjAMC94fKjG2CsFPipXGR3JN3x495S0i9ur2FXNbGP24l1VB6BJyZwIYXuwHs605mjETheLd74hX-UCPVTD33Z0owKB2dU1APxBvzmW9os6M5sAM0KreEffl0ZkLYw6';


        $notification = [
            'title' => $work_title,
            'body' => $work_title . '(이)가 새로 업데이트 되었습니다.'
        ];

        $extraNotificationData = [
            "message" => $notification,
            "num_of_work" => $num_of_work
        ];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AAAAME6lzTk:APA91bG210Qvf5nG3RNwvXWWlXeKB5Gg5k0CTmNoFYnxc7hx8kRcmI_8vk-Gpb23MLTU5a9wY8IIBRg0MV4QY9W7b8fQy3fFDyuPVTttt7eDS45mUukzy4UdqLbYZ_smG53O1mXR_tX2',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


        // dd($result);

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
                } elseif (str::contains($text2, "/video/")) {
                    $text2 = str::after($text2, "/video/");
                    $test2 = str::before($text2, '" ');
                    $onlyvideolist = Arr::add($onlyvideolist, 'namev' . $count, $test2);
                } elseif (str::contains($text3, "/images/")) {
                    // return $text3;
                    $text3 = str::after($text3, "/images/");
                    $test3 = str::before($text3, '" ');
                    $onlyimglist = Arr::add($onlyimglist, 'namei' . $count, $test3);
                } elseif (str::contains($text4, "/purchase/")) {
                    $text4 = str::after($text4, "/purchase/");
                    $test4 = str::before($text4, '" ');
                    $onlypurlist = Arr::add($onlypurlist, 'namep' . $count, $test4);
                    // return $onlypurlist;
                } else {
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
            // return $purlist2[$i];
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
            // return $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $onlyimglist[$i];
            if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $onlyimglist[$i])) {
                Storage::disk('s3')->copy($imglist, $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $onlyimglist[$i]);
            }
        }
        foreach ($purlist2 as $i => $purlist) {
            // return $filePath. 'OEBPS' . DIRECTORY_SEPARATOR . 'purchase' . DIRECTORY_SEPARATOR . $onlypurlist[$i];
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

        // return $coverName;
        $coverimage = str::after($coverName, 'images/');

        $covertype = str::after($coverimage, '.');
        if ($covertype == 'jpg') {
            $covertype = 'jpeg';
        }

        $isodate = date('Y-m-d\TH:i:s\Z');
        $opf =
            '<?xml version="1.0" encoding="UTF-8"?>
        <package xmlns="http://www.idpf.org/2007/opf" version="3.0" xml:lang="JP" prefix="cc: http://creativecommons.org/ns#" unique-identifier="bookID">
            <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
                <dc:title id="title">Novelnoberu</dc:title>
                <dc:identifier id="bookID">Novelnoberu</dc:identifier>
                <dc:date>' . $isodate . '</dc:date>
                <dc:creator id="__dccreator1">nicominmin</dc:creator>
                <dc:contributor id="contrib1">Illustrator</dc:contributor>
                <dc:language>JP</dc:language>
                <dc:publisher>Youngjin Publishing House</dc:publisher>
                <meta property="dcterms:modified">' . $isodate . '</meta>
                <meta refines="#title" property="title-type">main</meta>
                <meta refines="#contrib1" property="role" scheme="marc:relators">mrk</meta>
            </metadata>

            <manifest>
                <item id="toc" properties="nav" href="nav.xhtml" media-type="application/xhtml+xml" />
                <item id="coverpage" href="cover.xhtml" media-type="application/xhtml+xml" />
                <item id="coverimage" properties="cover-image" href="images/' . $coverimage . '"' . ' ' . 'media-type="image/' . $covertype . '" />
                <item id="stylesheet" href="css/stylesheet.css" media-type="text/css" />
                <item id="pagecss" href="css/page_styles.css" media-type="text/css" />
                <item id="images-cherryBlossom1" href="images/gifimages/cherryBlossom1.gif" media-type="image/gif" />
                <item id="images-cherryBlossom2" href="images/gifimages/cherryBlossom2.gif" media-type="image/gif" />
                <item id="images-lightning" href="images/gifimages/lightning.gif" media-type="image/gif" />
                <item id="images-rain" href="images/gifimages/rain.gif" media-type="image/gif" />
                <item id="images-snow" href="images/gifimages/snow.gif" media-type="image/gif" />
                <item id="images-starlight" href="images/gifimages/starlight.gif" media-type="image/gif" />
                <item id="images-yellowstar" href="images/gifimages/yellowstar.gif" media-type="image/gif" />
                <item id="js-jquery" href="js/jquery.min.js" media-type="text/js" />
                <item id="js-viewer" href="js/viewer.js" media-type="text/js" />
                <item id="images-nameia" href="images/prof_misaki.jpg" media-type="image/jpeg" />
                <item id="images-nameib" href="images/prof_mashiro.jpg" media-type="image/jpeg" />
                <item id="images-nameic" href="images/prof_nanami.jpg" media-type="image/jpeg" />
                <item id="images-nameid" href="images/prof_sorata.jpg" media-type="image/jpeg" />
                <item id="images-nameie" href="images/1565264465profile.png" media-type="image/png" />
 ';
        foreach ($onlyimglist as $i => $il) {

            if (!str::contains($opf, $il)) {
                $filetype = str::after($il, '.');
                if ($filetype == 'jpg') {
                    $filetype = 'jpeg';
                }
                $filetype = strtolower('image/' . $filetype);
                $opf = $opf . '
                <item id="images-' . $i . '" href="images/' . $il . '" media-type="' . $filetype . '" />
        ';
            }
        }
        foreach ($onlysoundlist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $filetype = str::after($il, '.');
                if ($filetype == 'mp3') {
                    $filetype = 'mpeg';
                }
                $filetype = strtolower('audio/' . $filetype);
                $opf = $opf . '
                <item id="audio-' . $i . '" href="audio/' . $il . '" media-type="' . $filetype . '" />
  ';
            }
        }
        foreach ($onlyvideolist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $filetype = str::after($il, '.');
                $filetype = strtolower('video/' . $filetype);
                $opf = $opf . '
                <item id="video-' . $i . '" href="video/' . $il . '" media-type="' . $filetype . '" />
                    ';
            }
        }
        foreach ($onlypurlist as $i => $il) {
            if (!str::contains($opf, $il)) {
                $filetype = str::after($il, '.');
                if ($filetype == 'jpg') {
                    $filetype = 'jpeg';
                    $filetype = strtolower('image/' . $filetype);
                }
                if ($filetype == 'png' || $filetype == 'gif') {
                    $filetype = strtolower('image/' . $filetype);
                    // return $filetype;
                }
                $opf = $opf . '
                <item id="purchase-' . $i . '" href="purchase/' . $il . '" media-type="' . $filetype . '" />
        ';
            }
        }
        foreach ($chapter_list as $i => $clist) {
            $opf = $opf . '
                <item id="main' . $i . '" href="text/main' . $i . '.xhtml" properties="scripted" media-type="application/xhtml+xml" />
        ';
        }

        $opf = $opf . '
            </manifest>
            <spine page-progression-direction="ltr">
                <itemref idref="coverpage" linear="yes" />
                <itemref idref="toc" linear="yes" />
            ';
        foreach ($chapter_list as $i => $clist) {
            $opf = $opf . '
                <itemref idref="main' . $i . '" linear="yes" />
 ';
        }
        $opf = $opf . '
            </spine>
        </package>
        ';
        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . $work_title . '.opf', $opf, [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
            'visibility' => 'public',
        ]); // opf파일


        $nav =
            '<?xml version="1.0" encoding="UTF-8"?>
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" xml:lang="jp" lang="jp">
            <head>
                <meta http-equiv="default-style" content="text/html; charset=utf-8" />
                <meta name="viewport"
                    content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0" />
                <title>Navigation</title>
                <link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
            </head>
            <body>
                <section class="frontmatter TableOfContents">
                    <nav epub:type="toc" id="toc">
                        <h1>Contents</h1>
                        <ol epub:type="list">
                        <li><a href="cover.xhtml" class="nav_li"><span class="white_back">' . 'cover' . $work_title . '</span></a></li>
                        <li><a href="nav.xhtml" class="nav_li"><span class="white_back">Contents</span></a></li>
          ';
        foreach ($chapter_list as $i => $clist) {
            $nav = $nav . '<li> <a href="text/main' . $i . '.xhtml" class="nav_li"><span class="white_back">' . $clist['subsubtitle'] . '</span></a>';

            // $a = 50 - strlen($clist['subsubtitle']);
            // for ($b = 0; $a >= $b; $b++) {
            //     $nav = $nav . '-';
            // }
            $nav = $nav . '</li>';
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
                    <meta name='viewport' content='width=1500, height=device-height, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0' />
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
            $int = 1;
            while (1) {
                if (str::contains($text, '/sound/')) {
                    // echo "num : $i a<br>";
                    $text = str::replaceFirst('/sound/', '/audio/', $text);
                } elseif (str::contains($text, 'https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/')) {
                    // echo "num : $i b<br>";
                    $text = str::replaceFirst('https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/' . Auth::user()['email'] . '/', '../', $text);
                    // return $text;
                } elseif (str::contains($text, 'type="video/webm"')) {
                    // echo "num : $i b<br>";
                    $text = str::replaceFirst('type="video/webm"', ' ', $text);
                    // return $text;
                } elseif (preg_match('/WorkSpace\/[A-Za-z0-9%]*\/OEBPS\//', $text)) {
                    // echo "num : $i b<br>";
                    $text = preg_replace('/WorkSpace\/[A-Za-z0-9%]*\/OEBPS\//', "", $text);
                    // return $text;
                } elseif (preg_match('/([、-んァ-ん\ー]*)([一-龠]*)（([、-んァ-ヶ\ー]*)）/', $text)) {
                    // echo "num : $i c<br>";
                    $text = preg_replace('/([、-んァ-ん\ー]*)([一-龠]*)（([、-んァ-ヶ\ー]*)）/', "$1<ruby>$2<rt>$3</rt></ruby>", $text);
                } elseif (str::contains($text, 'alt="alt">')) {
                    $text = str::replaceFirst('alt="alt">', 'alt="alt" />', $text);
                } elseif (str::contains($text, 'onclick="audioPlay(event)" /></span>')) {
                    $text = str::replaceFirst('onclick="audioPlay(event)" /></span>', 'onclick="audioPlay(event)"></span>', $text);
                }
                // elseif (str::contains($text,'<audio id="')){
                //     $text = str::replaceFirst('<audio id="','<audio id ="'.$int,$text);
                // }
                elseif (preg_match('/(\<span\ )([A-Za-z0-9\=\%\"\(\)\.\ \_\:\;]*)( onclick\=\"audioPlay\(event\)\") ([\/\>]{2})/', $text)) {
                    $text = preg_replace('/(\<span\ )([A-Za-z0-9\=\%\"\(\)\.\ \_\:\;]*)( onclick\=\"audioPlay\(event\)\") ([\/\>]{2})/', "$1$2$3 >", $text);
                } else {
                    $clist['content'] = $text;
                    break;
                }
                $int = $int + 1;
            }
            $contents =
                "<?xml version='1.0' encoding='UTF-8'?>
                <html xmlns='http://www.w3.org/1999/xhtml' xmlns:epub='http://www.idpf.org/2007/ops' xml:lang='jp' lang='jp'>
                    <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <meta name='viewport' content='width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0' />
                    <title>" . $clist['subsubtitle'] . "</title>
                    <link rel='stylesheet' href='../css/stylesheet.css' type='text/css' />
                    <link rel='stylesheet' href='../css/page_styles.css' type='text/css' />
                    <script src='../js/jquery.min.js' type='text/javascript'>
                    //<![CDATA[[
                    //]]>
                    </script>
                    <script src='../js/viewer.js' type='text/javascript'>
                    //<![CDATA[[
                    //]]>
                    </script>
                    </head>
                <body>
                    <h1>" . $clist['subsubtitle'] . "</h1>
                    " . $clist['content'];
            if ($i == 0) {
                $contents = $contents .
                    "    <p id='prof-Ol'
                style='position: absolute;top: 0px;left: 0px;opacity: 0.5;height: 100%; width: 100%; z-index: 65555;background-color: rgb(102, 102, 102);display: none;margin: 0;'>
            </p>
            <p id='prof-Bg'
                style='z-index: 65555;top: 100px;left: 35px;display: none;height: 240px;width: 644px;position: absolute;'>
                <img id='prof-misaki' class='prof' src='../images/prof_misaki.jpg' style='width: 350px;  display: none;'
                    alt='alt' />
                <img id='prof-mashiro' class='prof' src='../images/prof_mashiro.jpg' style='width: 350px; display: none;'
                    alt='alt' />
                <img id='prof-nanami' class='prof' src='../images/prof_nanami.jpg' style='width: 350px; display: none;'
                    alt='alt' />
                <img id='prof-sorata' class='prof' src='../images/prof_sorata.jpg' style='width: 350px; display: none;'
                    alt='alt' />
            </p>";
            }
            $contents = $contents . "
            </body>
        </html>
        ";
            Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR . 'main' . $i . '.xhtml', $contents);
        }        // 각 목차 내용

        // return 0;
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
        // 마스터엔 없고 내꺼엔 있었음.
        if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'sound' . DIRECTORY_SEPARATOR . 'tool_icon' . DIRECTORY_SEPARATOR . 'speaker_icon.png')) {
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'speaker_icon.png', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'sound' . DIRECTORY_SEPARATOR . 'tool_icon' . DIRECTORY_SEPARATOR . 'speaker_icon.png');
        } // js
        // custom css
        $cssNmae = 'stylesheet';
        $cssFile =
            "
            #sectionId{text-align:center; margin-top:5%; }
            #coverimgdiv{ background: url('../images/" . $coverimage . "') no-repeat; box-shadow: 2px 2px 30px -2px rgba(0,0,0,0.8); background-size:contain; display: inline-block; width: 398px; height: 554px; text-align:left;            }
            #worktitlespan{  font-size : 3em; background-color : #00000050; color: white; display: inline-block;            }
            #worklistspan{ position: relative; top: 15%; font-size : 2em; background-color : #00000050; color: white; display: inline-block;}

            .resize,
            .resize_mp4 {
                width: 400px;
                height: auto;
                background-size: auto;
                background-repeat: no-repeat;
                /* position: relative; */
            }
            h1{
                text-align:center;
            }
            ol{
                list-style-type:none;
                padding-inline-start: 0px;
            }
            li{
                text-align:center;
                position: relative;
                z-index: 1;
            }
            .nav_li{
                text-decoration: none;
                font-weight: 600;
                color:black;
            }
            .nav_li:before{
                border-top: 2px solid #dfdfdf;
                content:'';
                margin: 0 auto;
                top: 50%; left: 0; right: 0; bottom: 0;
                width: 100%;
                z-index: -1;
            }
            li:hover{
                opacity:0.5;
            }
            .white_back{
                background: #fff;
                padding: 0 15px;
            }
            .tem_effect {
                display: inline-block;
            }
            .cherryBlossom1,
            .cherryBlossom2,
            .rain,
            .snow,
            .starlight,
            .yellowstar,
            .lightning,
            .fire1,
            .fire2 {
                display: inline-block;
                position: absolute;
            }
            .calibre7 {
                display: block;
                font-size: 0.77419em;
                text-indent: 20pt;
                margin: 0
            }

            .deai, .nekowork:hover {
                cursor: pointer;
            }

            .cherryBlossom1{
                background: url('../images/gifimages/cherryBlossom1.gif');
            }

            .cherryBlossom2{
                background: url('../images/gifimages/cherryBlossom2.gif');
            }

            .rain{

                background: url('../images/gifimages/rain.gif');
            }

            .snow{
                background: url('../images/gifimages/snow.gif');
            }

            .starlight{
                background: url('../images/gifimages/starlight.gif');
            }

            .yellowstar{
                background: url('../images/gifimages/yellowstar.gif');
            }

            .lightning {
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
                font-size:1em;
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
                  page-break-after: always;
                  margin-bottom: 5pt;
                  margin-top: 5pt
                  }
                  ";


        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $cssNmae . '.css', $cssFile);

        $jsNmae = 'viewer';
        $jsFile =
            "//<![CDATA[
                $(document).ready(function () {
                    $(function () {
                        $('#Dedication1').each(function () {
                            $(this).html(
                                $(this).html()
                                .replace(/([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
                            );
                        });
                    });
                });
                var gifOn = false;

                let prof_audio_id = null;
                let profId = null;

                $(document).on('click', '.profile', function () {
                    profId = $(this).attr('id');
                    prof_audio_id = $(this).next().attr('id');
                    var prof_audio = document.getElementById(prof_audio_id);
                    $('#prof-Ol').show();
                    $('#prof-Bg').show();
                    switch (profId) {
                        case 'misaki':
                            $('#prof-misaki').fadeIn(1000);
                            break;

                        case 'mashiro':
                            $('#prof-mashiro').fadeIn(1000);
                            break;

                        case 'nanami':
                            $('#prof-nanami').fadeIn(1000);
                            break;

                        case 'sorata':
                            $('#prof-sorata').fadeIn(1000);
                            break;

                        default:
                            break;
                    }
                    prof_audio.play();
                });

                $(document).on('click', '#prof-Ol', function () {
                    $('#prof-Ol').hide();
                    $('#prof-Bg').hide();
                    $('.prof').hide();
                });

                $(document).on('click', '.deai', function () {
                    if (gifOn == false) {
                        $(this).attr('src', '../images/gifimages/deai.gif');
                        gifOn = true;
                    } else {
                        $(this).attr('src', '../images/1565068502deai.png');
                        gifOn = false;
                    }
                });


                $(document).on('click', '.nekowork', function () {
                    $(this).next().fadeToggle(2000);
                });

                let isPlaying = false;
                let audioPlay_num = null;

                var tool_imgId = '';
                $(document).on('click', '.resize, .css_eft', function (e) {
                    // console.log(tool_imgId);
                    tool_imgId = $(this).attr('id');
                    if (e.target.classList.contains('css_eft')) {
                        tool_imgId = $(this)
                            .next()
                            .attr('id');
                        $('#' + tool_imgId).trigger(audioPlay(event));
                    }
                });

                function audioPlay(e) {
                    console.log('a');
                    if (e.target.classList.contains('css_eft')) {
                        audioPlay_num = e.target.nextElementSibling.nextElementSibling.id;
                    } else {
                        audioPlay_num = e.target.nextElementSibling.id;
                    }
                    var audio = document.getElementById(audioPlay_num);
                    if (isPlaying) {
                        audio.pause();
                        isPlaying = false;
                    } else {
                        audio.play();
                        isPlaying = true;
                    }
                }
                //]]>
            ";


        Storage::disk('s3')->put($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . $jsNmae . '.js', $jsFile);

        if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'jquery.js')) {
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'jquery.js', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'jquery.js');
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'stylesheet.css', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
        } // 직접 제작한 js와 css는 resource폴더에 보관하고 있다가 발행시 넣어줌.
        if (!Storage::disk('s3')->exists($filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css')) {
            Storage::disk('s3')->copy('resource' . DIRECTORY_SEPARATOR . 'stylesheet.css', $filePath . 'OEBPS' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'stylesheet.css');
        } // 직접 제작한 js와 css는 resource폴더에 보관하고 있다가 발행시 넣어줌.


        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 책으로 발행했을 때도 epub으로 만들어서 작가에게 줘야함 publishcontroller에 추가할 코드(아래)

        shell_exec('mkdir /mnt/epubz');
        //shell_exec('cd /mnt/mountpoint/Author/Author@test/WorkSpace'); // shell_exec('zip /mnt/epubz/folder.zip -r 폴더구조테스트/*'); // 해당 폴더 압축 ->shell로 대체
        shell_exec('zipdir ' . $authorFolder . ' ' . $work_title); // zip 유저명 폴더명 $1 $2 shell폴더안에 있는 zipdir.sh (shell프로그램)
        # zip 으로 만드는건 끝

        $filepath = '/mnt/epubz/' . $work_title . '.epub';      // file경로 epub으로 저장했음 .epub으로 찾아야함
        $filesize = filesize($filepath);
        $path_parts = pathinfo($filepath);
        $filename = $path_parts['basename'];
        $extension = $path_parts['extension'];

        header("Pragma: public");
        header("Expires: 0");
        header("Content-Type: application/epub+zip");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $work_title . '.epub');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: $filesize");

        return back()->withSuccess($work_title . 'の ' . $chapter_title . ' が成功的に発行されました。');

        ob_clean();             # 출력 버퍼의 내용을 삭제 (ob_end_clean은 파괴)
        flush();                # 시스템 출력 버퍼를 비움
        readfile($filepath);    # file을 출력하는 php 함수

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
