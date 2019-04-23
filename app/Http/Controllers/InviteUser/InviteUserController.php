<?php

namespace App\Http\Controllers\InviteUser;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Work;
use App\models\WorkList;
use Illuminate\Support\Str;


class InviteUserController extends Controller{
    public function loadModal(){
        $work_titles = Work::select(
            'works.work_title',
            'works.num'
        )
        ->join('work_lists','works.num','=','work_lists.num_of_work')
        ->whereIn('works.num', function ($query) {
            $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
        })->orderBy('works.created_at', 'desc')
        ->get();
        $text ='
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">invite user</h4>
            </div>
            <div class="modal-body">
                <form action="'.url('inviteUser').'">
                    <label>user E-mail</label>
                    <input type="text" placeholder ="상대방의 E-mail로 초대" name="userid" id="userid" class="form-control"/>
                    <label>user nickname</label>
                    <input type="text" placeholder ="상대방의 닉네임으로 초대" name="usernn" id="usernn" class="form-control"/>
                    <label>Work Title : </label>
                    <select name = "title">';
                    foreach($work_titles as $i => $row){
                        $text = $text.'<option value='.$row['num'].'>'.$row['work_title'].'</option>';
                    }
                    $text =$text.
                    '</select><br>
                    <input type="submit" value="초대">
                </form>
            </div>
        </div>';
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
