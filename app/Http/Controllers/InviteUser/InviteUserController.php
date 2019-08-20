<?php

namespace App\Http\Controllers\InviteUser;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ContentOfWork;
use App\Models\Message;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InviteUserController extends Controller
{
    public function loadSearchModal()
    {
        $userlist = User::select(
            'users.email',
            'users.nickname',
            'users.introduction_message',
            'users.profile_photo'
        )->get();

        $text = "
        <div class='modal-content'>
            <div class='modal-header'>
                <h3 class='modal-title'><img src='../../../image/logo_book.png' class='logo'><b style='position: absolute;top: 25px;'>&nbsp;協業者コンタクト</b></h3>
            </div>
            <div class='modal-body'>
                <form>
                    <input type='text' placeholder ='ID or E-mailで検索' name='userid' id='userid' class='form-control'/>
                    <img class='search' src='../../../image/search.png'>
                    <div style='width:100%; height:400px; overflow:auto'>
                    <ul id='userlists'>
                    ";
        foreach ($userlist as $i => $user) {
            $text = $text . "
                <div class='userlist'>
                    <a href='" . url("loadUserInfoModal/" . $user['email']) . "' rel='modal:open' title='" . $user['email'] . "'>
                        <span id='info' class='" . $user['email'] . "'style='width:600px;position:relative;'>
                            <img src='" . $user['profile_photo'] . "' class='userthumb' onError=javascript:this.src='" . asset('image/no_image.png') . "'>
                            <div class='userinfo'>-</div>
                            <div class='userinfo'><b>ニックネーム</b> : " . $user['nickname'] . "</div>
                            <div class='userinfo'><b>紹介</b> : " . $user['introduction_message'] . "</div>
                            <div class='userinfo'><b>メール</b> : " . $user['email'] . "</div>
                            <div class='li_ed_icon'>
                                <img src='../../../image/like_icon.png'>
                                <img src='../../../image/edit_icon.png'>
                            </div>
                        </span>
                    </a>
                </div>
        ";
        }
        $text = $text . "
                </ul>
                </div>
                </form>
            </div>
            <div id='invite' class='modal1' role='dialog'>
        </div>";

        return $text;
    }
    public function loadUserInfoModal($UserEmail)
    {
        $nickname = User::select(
            'users.nickname'
        )->where('users.email', '=', $UserEmail)
            ->first()->nickname;
        $introduction_message = User::select(
            'users.introduction_message'
        )->where('users.email', '=', $UserEmail)
            ->first()->introduction_message;
        $profile_photo = User::select(
            'users.profile_photo'
        )->where('users.email', '=', $UserEmail)
            ->first()->profile_photo;
        $email = User::select(
            'users.email'
        )->where('users.email', '=', $UserEmail)
            ->first()->email;
        $text = "
        <div class='modal-content'>
            <div class='modal-header'>
                <h3 class='modal-title'><img src='../../../image/logo_book.png' class='logo'><b style='position: absolute;top: 25px;'>&nbsp;協業者コンタクト</b></h3>
            </div>
            <div class='modal-body'>
                <img src='" . $profile_photo . "' class='userthumb' style='width:150px;height:150px;' onError=javascript:this.src='" . asset('image/no_image.png') . "'>
                <div class='userinfo'><b>ニックネーム</b> : " . $nickname . "</div>
                <div class='userinfo'><b>紹介</b> : " . $introduction_message . "</div>
                <div class='userinfo'><b>メール</b> : " . $email. "</div>
            <ul class='navbar-nav ml-auto' style='display:block;'>
            <li class='nav-item' style='display:inline-block;float:left;padding-bottom: 20px;'>
                <a class='nav-link' style='color:#f1c550;'><b>プロフィール</b></a>
            </li>
            <li class='nav-item' style='display:inline-block; float:right;'>
                <a href='" . url('/inviteUser/' . $nickname) . "' class='nav-link' style='color:#f1c550;padding-right:30px;' rel='modal:open'><b>メッセージ</b></a>
            </li>
        </ul>
        </div>
        ";
        return $text;
    }
    public function loadInviteUserModal($nickname)
    {
        $nickname = User::select(
            'users.nickname'
        )->where('users.nickname', '=', $nickname)
            ->first()->nickname;
        $introduction_message = User::select(
            'users.introduction_message'
        )->where('users.nickname', '=', $nickname)
            ->first()->introduction_message;
        $profile_photo = User::select(
            'users.profile_photo'
        )->where('users.nickname', '=', $nickname)
            ->first()->profile_photo;
        $email = User::select(
            'users.email'
        )->where('users.nickname', '=', $nickname)
            ->first()->email;
        $work_titles = Work::select(
            'works.work_title',
            'works.num'
        )->join('work_lists', 'works.num', '=', 'work_lists.num_of_work')
        ->whereIn('works.num', function ($query) {
            $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
        })->orderBy('works.created_at', 'desc')
        ->get();

        $text = "
        <div class='modal-content'>
            <div class='modal-header'>
                <h3 class='modal-title'><img src='../../../image/logo_book.png' class='logo'><b style='position:absolute;top: 25px;'>&nbsp;協業者コンタクト</b></h3>
            </div>
            <div class='modal-body'>
                <img src='" . $profile_photo . "' class='userthumb' style='width:150px;height:150px;' onError=javascript:this.src='" . asset('image/no_image.png') . "'>
                <div class='userinfo'><b>ニックネーム</b> : " . $nickname . "</div>
                <div class='userinfo'><b>紹介</b> : " . $introduction_message . "</div>
                <div class='userinfo'><b>メール</b> : " . $email . "</div>
                <form id='sample_form'>
                    <input type='text' style='display:none;' name='userid' id='userid' class='form-control' value = " . $nickname . " readonly>
                    <div style='width:100%;border:4px solid #dee2e6;margin-top:100px'>
                        <div style='background-color:#eeeeee;'>
                            <label style='margin:7px;margin-left:10px'>Work Title : </label>
                            <select name = 'numofwork'>";
                            foreach ($work_titles as $i => $row) {
                                $text = $text . "<option value=" . $row["num"] . ">" . $row["work_title"] . "</option>";
                            }
                            $text = $text . "</select>
                        </div>
                        <textarea name='message' placeholder='送るメッセージを書いてください' id='message_for_invite' style='font-size:23px;background-color:#fcfcfc;height:300px;padding:10px;padding-left:30px;resize:none' cols ='85' rows='5'></textarea>
                    </div>
                    <input type='hidden' name='p_p' id='userp_p' value=".$profile_photo.">
                    <input style='width:200px;height:50px;background-color:red;color:white;border:0;border-radius:5px;font-weight:800;margin-left:40%;margin-top:20px;' type='button' id='submitbtn' value='S E N D'>
                </form>
            </div>
        </div>
        <style>
        textarea::placeholder {
            color: #808080;
          }
        </style>";

        return $text;
    }
    public function SendingInviteMessage(Request $request)
    {
        $userid = $request->usernickname;
        $work_num = $request->numofwork;
        $invite_message = $request->message;

        // echo "<script>alert('test');</script>";
        $user_id = User::select(
            'users.id'
        )->where('users.nickname', $userid)
            ->first()->id;
        $work_title = Work::select(
            'works.work_title'
        )->where('works.num', $work_num)
            ->first()->work_title;

        $worklist = WorkList::select(
            DB::raw("SELECT if(user_id = $user_id,'t','f') FROM work_lists WHERE user_id = $user_id AND num_of_work = $work_num")
        );
        if($worklist=='t'){
        }else{
            $list = new WorkList();
            $list->num_of_work = $work_num;
            $list->user_id = $user_id;
            $list->accept_request = 1;
            $list->last_time_of_working = Carbon::now();
            $list->save();

            $message = new Message();
            $message->from_id = Auth::user()['id'];
            $message->to_id = $user_id;
            $message->message_title = Auth::user()['nickname']."様が $work_title 作品に招待しました。";
            $message->message_content = $invite_message;
            $message->num_of_work = $work_num;
            $message->save();
        }
    }

    public function viewMessage(Request $request)
    {
        $messageNum = $request->num;
        $inviteRoomNum = Message::select('num_of_work')->where('num', $messageNum)->get()[0]->num_of_work;

        $inviteEditor = ContentOfWork::select('num')
        ->where('num_of_work',$inviteRoomNum)
        ->orderBy('created_at','asc')->limit(1)->get()[0]->num;

        $invite_message = Message::select(
            'messages.message_title',
            'messages.message_content',
            'u1.nickname as to_id',
            'u2.nickname as from_id',
            'messages.created_at'
        )->leftjoin('users as u1', 'u1.id', 'messages.to_id')
            ->leftjoin('users as u2', 'u2.id', 'messages.from_id')
            ->where('messages.num', $messageNum)
            ->get();

        DB::update('UPDATE messages
        SET condition_message = 1
        WHERE messages.num =' . $messageNum);

        // return $invite_message;
        foreach ($invite_message as $i => $im) {
            $text = "
            <div>送ったID : " . $im['from_id'] . "</div>
            <div>時間 : " . $im['created_at'] . "</div>
            <div>メッセージのタイトル :  " . $im['message_title'] . "</div>
            <div>" . $im['message_content'] . "</div>
            <div> <a href='/acceptInvite/" . $messageNum . '/' . $inviteEditor . "'>Writing Roomに移動</a></div>
            ";
        }
        return $text;
    }
    public function acceptInvite($messageNum, $inviteRoomNum)
    {
        DB::update('UPDATE work_lists INNER JOIN messages
        ON messages.num = ' . $messageNum . '
        SET accept_request = 0
        WHERE work_lists.user_id = messages.to_id
        AND work_lists.created_at = messages.created_at');
        return redirect('editor/' . $inviteRoomNum);
    }
}
