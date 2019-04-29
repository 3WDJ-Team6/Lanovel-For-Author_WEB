<?php

namespace App\Http\Controllers\InviteUser;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Work;
use App\models\WorkList;
use Illuminate\Support\Str;


class InviteUserController extends Controller{
    public function loadSearchModal(){
        $userlist = User::select(
            'users.email',
            'users.nickname',
            'users.introduction_message',
            'users.profile_photo'
        )->get();

        $text ="
        <script src='".asset('/js/invite_user.js')."'></script>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>search user</h4>
            </div>
            <div class='modal-body'>
                <form>
                    <label>user E-mail</label>
                    <input type='text' placeholder ='상대방의 E-mail로 초대' name='userid' id='userid' class='form-control'/>
                    <div style='width:100%; height:200px; overflow:auto'>
                    <ul id='userlists'>
                    ";
                    foreach($userlist as $i => $user){
                        $text = $text."
                        <a href='".url("loadUserInfoModal/".$user['email'])."' style='display:block; display:none' rel='modal:open' title='".$user['email']."'>
                            <div style='display:inline-block'>
                            <img src='".$user['profile_photo']."' style='width:80px;height:50%;float:left;margin-top:5px;' onError=javascript:this.src='".asset('image/no_image.png')."'>
                            </div>
                            <div id='info' class='".$user['email']."'style='display:inline-block; width:500px;float:right;left:-60px;position:relative;'>"
                            .$user['nickname']."<br>".$user['introduction_message']."<br>
                            ".$user['email']."
                            </div>
                        </a>
                        ";
                    }
                $text = $text."
                </ul>
                </div>
                </form>
            </div>
            <div id='invite' class='modal1' role='dialog'>
        </div>";

        return $text;
    }
    public function loadUserInfoModal($UserEmail){
        $nickname = User::select(
            'users.nickname'
        )->where('users.email','=',$UserEmail)
        ->first()->nickname;
        $introduction_message = User::select(
            'users.introduction_message'
        )->where('users.email','=',$UserEmail)
        ->first()->introduction_message;
        $profile_photo = User::select(
            'users.profile_photo'
        )->where('users.email','=',$UserEmail)
        ->first()->profile_photo;
        // return $nickname;
        $text = "
        <div>
            <div>
                <img src='".$profile_photo."' onError=javascript:this.src='".asset('image/no_image.png')."' style='width:80px;height:50%;float:center;'>
            </div>
            <div>
                ".$nickname."<br>".$introduction_message."
            </div>
            ".$UserEmail."
            <ul class='navbar-nav ml-auto' style='display:block'>
            <li class='nav-item' style='display:inline-block; float:left'>
                <a class='nav-link' style='color:#45b4e6'>View profile</a>
            </li>
            <li class='nav-item' style='display:inline-block; float:right;'>
                <a class='nav-link' style='color:#45b4e6;'>Send invite Message</a>
            </li>
        </ul>
        </div>
        ";
        return $text;
    }
    public function SendingInviteMessage(){
        $user_mail = $_REQUEST['userid'];
        $user_nn = $_REQUEST['usernn'];
        $work_num = $_REQUEST['title'];
        if(empty($user_mail)){
            $user_id = User::select(
                'users.id'
            )->where('users.nickname','=',$user_nn)
            ->pluck('id');
            $user_id = str::after($user_id,'[');
            $user_id = str::before($user_id,']');
        }else{
            $user_id = User::select(
                'users.id'
            )->where('users.email','=',$user_mail)
            ->pluck('id');
            $user_id = str::after($user_id,'[');
            $user_id = str::before($user_id,']');
        }
        $list = new WorkList();
        $list->num_of_work = $work_num;
        $list->user_id = $user_id;
        $list->accept_request = 1;
        $list->last_time_of_working="test";
        $list->save();

        return redirect()->back()->withInput();

    }
}


/*
                    <label>user nickname</label>
                    <input type='text' placeholder ='상대방의 닉네임으로 초대' name='usernn' id='usernn' class='form-control'/>
                    <label>Work Title : </label>
                    <select name = 'title'>";
                    foreach($work_titles as $i => $row){
                        $text = $text."<option value=".$row["num"].">".$row["work_title"]."</option>";
                    }
                    $text =$text.
                    "</select><br>
                    <label>message for invite</label><br>
                    <textarea name='message' style='resize:none' cols ='85' rows='5'></textarea><br>
                    <input type='submit' value='초대'>

        $work_titles = Work::select(
            'works.work_title',
            'works.num'
        )
        ->join('work_lists','works.num','=','work_lists.num_of_work')
        ->whereIn('works.num', function ($query) {
            $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
        })->orderBy('works.created_at', 'desc')
        ->get();

                    <label>Work Title : </label>
                    <select name = 'title'>";
                    foreach($work_titles as $i => $row){
                        $text = $text."<option value=".$row["num"].">".$row["work_title"]."</option>";
                    }


                <br>
                    <label>message for invite</label><br>
                    <textarea name='message' style='resize:none' cols ='85' rows='5'></textarea><br>
                    <input type='submit' value='초대'>


*/
