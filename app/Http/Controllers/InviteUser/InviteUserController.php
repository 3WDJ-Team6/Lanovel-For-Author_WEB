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
        <style>
            .userlist{
                display:none;
                color:#646464;
            }
            .userImage{
                width:100%;
                text-align:center;
            }
            .userthumb {
                width:200px;
                height:200px;
                margin-top:5px;
                position:relative;
            }
            .userinfo {
                width:100%;
            }
        </style>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>협업자 초대</h4>
            </div>
            <div class='modal-body'>
                <form>
                    <input type='text' placeholder ='ID 또는 E-mail로 찾기' name='userid' id='userid' class='form-control'/>
                    <div style='width:100%; height:400px; overflow:auto'>
                    <ul id='userlists'>
                    ";
        foreach ($userlist as $i => $user) {
            $text = $text . "
                <div class='userlist'>
                    <a href='" . url("loadUserInfoModal/" . $user['email']) . "' rel='modal:open' title='" . $user['email'] . "'>
                        <div class='userImage'>
                            <img src='" . $user['profile_photo'] . "' class='userthumb' onError=javascript:this.src='" . asset('image/no_image.png') . "'>
                        </div>
                        <span id='info' class='" . $user['email'] . "'style='width:600px;position:relative;'>
                            <div class='userinfo'>이름 : " . $user['nickname'] . "</div>
                            <div class='userinfo'>소개 : " . $user['introduction_message'] . "</div>
                            <div class='userinfo'>메일 : " . $user['email'] . "</div>
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
        $text = "
        <div>
            <div>
                <img src='" . $profile_photo . "' onError=javascript:this.src='" . asset('image/no_image.png') . "' style='width:80px;height:50%;float:center;'>
            </div>
            <div>
                " . $nickname . "<br>" . $introduction_message . "
            </div>
            " . $UserEmail . "
            <ul class='navbar-nav ml-auto' style='display:block'>
            <li class='nav-item' style='display:inline-block; float:left'>
                <a class='nav-link' style='color:#45b4e6'>View profile</a>
            </li>
            <li class='nav-item' style='display:inline-block; float:right;'>
                <a href='" . url('/inviteUser/' . $nickname) . "' class='nav-link' style='color:#45b4e6;' rel='modal:open'>Send invite Message</a>
            </li>
        </ul>
        </div>
        ";
        return $text;
    }
    public function loadInviteUserModal($nickname)
    {
        $work_titles = Work::select(
            'works.work_title',
            'works.num'
        )->join('work_lists', 'works.num', '=', 'work_lists.num_of_work')
            ->whereIn('works.num', function ($query) {
                $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
            })->orderBy('works.created_at', 'desc')
            ->get();
        $text = "
        <form id='sample_form'>
            <label>user E-mail</label>
            <input type='text' name='userid' id='userid' class='form-control' value = " . $nickname . " readonly>
            <div style='width:100%; overflow:auto'>
            <label>Work Title : </label>
            <select name = 'numofwork'>";
        foreach ($work_titles as $i => $row) {
            $text = $text . "<option value=" . $row["num"] . ">" . $row["work_title"] . "</option>";
        }
        $text = $text . "</select>
            <br>
                <label>message for invite</label><br>
                <textarea name='message' id='message_for_invite' style='resize:none' cols ='85' rows='5'></textarea>
                <br>
            <input type='button' id='submitbtn' value='초대'>
        </form>
  ";

        return $text;
    }
    public function SendingInviteMessage(Request $request)
    {
        $userid = $request->usernickname;
        $work_num = $request->numofwork;
        $invite_message = $request->message;

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
            // $message->message_title = 'invite message';
            $message->message_title = Auth::user()['nickname']."님이 $work_title 작품에 초대하였습니다.";
            $message->message_content = $invite_message;
            $message->num_of_work = $work_num;
            $message->save();
        }
        // event(new InviteEvent(Auth::user()['nickname'], $nickname, 'invite message', $nickname . "님이 " . $work_title . '작품에 초대하셧습니다.'));

        // return redirect()->back()->withInput();
    }
    public function viewMessages()
    {
        return Auth::user()['id'];
        $invite_messages = Message::select(
            'messages.num',
            'messages.message_title',
            'messages.message_content',
            'u2.nickname as from_id',
            'messages.created_at',
            DB::raw("(SELECT COUNT(*) FROM messages WHERE condition_message = 0) count")
        )->leftjoin('users as u1', 'u1.id', 'messages.to_id')
            ->leftjoin('users as u2', 'u2.id', 'messages.from_id')
            // ->where('message_title', 'like', 'invite%')
            ->where('to_id', '=', Auth::user()['id'])
            ->get();
            return $invite_messages;

        $text = "
        <style>
            table{
                width: 100%;
                border: 1px solid #444444;
            }
            th, td{
                border: 1px solid #444444;
            }
        </style>
        <div>
            <table style='width:100%;border:1px solid #444444'>
                <thead>
                    <tr>
                        <td>보낸사람</td>
                        <td>제목</td>
                        <td>내용</td>
                        <td>날짜</td>
                    </tr>
                </thead>
                <tbody>";
        foreach ($invite_messages as $i => $im) {
            $text = $text . "
                    <tr>
                            <td>" . $im['from_id'] . "</td>
                            <td><a href='viewMessage/" . $im['num'] . "' rel='modal:open'>" . $im['message_title'] . "</a></td>
                            <td>" . $im['message_content'] . "</td>
                            <td>" . $im['created_at'] . "</td>
                    </tr>";
        }
        $text = $text . "</tbody>
            </table>
        </div>";
        return $text;
    }

    public function viewMessage($messageNum)
    {
        $inviteRoomNum = Message::select('num_of_work')->where('num', $messageNum)->get()[0]->num_of_work;

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
            <div>보낸 사람 " . $im['from_id'] . "</div>
            <div>받은 시간 " . $im['created_at'] . "</div>
            <div>message title " . $im['message_title'] . "</div>
            <div>" . $im['message_content'] . "</div>
            <div> <a href='/acceptInvite/" . $messageNum . '/' . $inviteRoomNum . "'>accept invite</a></div>
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
        return redirect('editor/main/chapter/' . $inviteRoomNum);
    }
}
