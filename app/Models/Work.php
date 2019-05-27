<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use App\Models\CommentOfWork;
use App\Models\WorkList;
use App\Models\PushAlarm;
use App\Models\SubscribeOrInterest;
use App\Models\ChatRoom;
use App\Models\RecommendOfWork;
use App\Models\Grade;
use App\Models\CategoryWork;
use App\Models\Contract;
use App\Models\PeriodOfWork;
use App\Models\ChapterOfWork;
use App\Models\Memo;
use App\Models\ReadBook;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'works';
    protected $primaryKey = 'num';

    /**
     * 하나의 작품은 여러 회원을 가질 수 있다.
     * 하나의 회원은 여러 작품을 가질 수 있다.
     * 작품 : 회원 = 다 : 다
     */

    // 작품 보여지기
    public function getWork()
    {
        return Work::whereIn('works.num', function ($query) {
            $query->select('num_of_work')->from('work_lists')->whereIn('work_lists.num_of_work', function ($query2) {
                $query2->select('user_id')->where('user_id', '=', \Auth::user()['id']);
            });
        })
            ->select(
                // 작품번호
                'works.num',
                // 제목
                'works.work_title',
                // 연재종류
                'works.type_of_work',
                // 대여 가격
                'works.rental_price',
                // 구매 가격
                'works.buy_price',
                // 연재상태
                'works.status_of_work',
                // 북커버
                'works.bookcover_of_work',
                // 연재주기
                // 'period_of_works.cycle_of_publish'
                // 태그
                'category_works.tag',
                // 협업멤버
                'work_lists.user_id',
                // 최근 수정 시간
                'content_of_works.updated_at'
            )->join(
                'category_works',
                'category_works.num_of_work',
                '=',
                'works.num'
            )
            ->join(
                'work_lists',
                'work_lists.num_of_work',
                '=',
                'works.num'
            )
            ->join(
                'content_of_works',
                'content_of_works.num_of_work',
                '=',
                'works.num'
            )
            ->orderBy('works.created_at', 'desc')
            ->get();
    }

    // 새 작품 저장
    public function storeWork(array $work_info)
    {
        Work::insert($work_info);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * 하나의 작품은 여러 리뷰를 가질 수 있다.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 하나의 작품은 여러 댓글을 가질 수 있다.
     */
    public function comment_of_works()
    {
        return $this->hasMany(CommentOfWork::class);
    }

    /**
     * 하나의 작품은 여러 작품 참여 리스트를 가질 수 있다.
     */
    public function work_lists()
    {
        return $this->hasMany(WorkList::class, 'num_of_work');
    }

    /**
     * 하나의 작품은 여러 readbook 리스트를 가질 수 있다.
     */
    public function read_books()
    {
        return $this->hasMany(ReadBook::class, 'num_of_work');
    }


    /**
     * 하나의 작품은 여러 푸쉬알람을 가질 수 있다.
     */
    public function push_alarms()
    {
        return $this->hasMany(PushAlarm::class);
    }

    /**
     * 하나의 작품은 여러 구독 및 관심 테이블을 가질 수 있다.
     */
    public function subscribe_or_interests()
    {
        return $this->hasMany(SubscribeOrInterest::class, 'num_of_work');
    }

    /**
     * 하나의 작품은 하나의 채팅방을 갖는다.
     */
    public function chat_room()
    {
        return $this->hasOne(ChatRoom::class);
    }

    /**
     * 하나의 작품은 여러 추천 테이블을 갖는다.
     */
    public function recommend_of_works()
    {
        return $this->hasMany(RecommendOfWork::class);
    }

    /**
     * 하나의 작품은 여러 평점을 가질 수 있다.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * 하나의 작품은 여러 카테고리를 가질 수 있다.
     */
    public function category_works()
    {
        return $this->hasMany(CategoryWork::class, 'num_of_work');
    }

    /**
     * 하나의 작품은 하나의 계약서를 가질 수 있다.
     */
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * 하나의 작품은 하나의 연재 주기를 가질 수 있다.
     */
    public function period_of_works()
    {
        return $this->hasMany(PeriodOfWork::class);
    }

    /**
     * 하나의 작품은 여러 좋아요 테이블을 가질 수 있다.
     */
    public function like_of_illustrations()
    {
        return $this->hasMany(LikeOfIllustration::class);
    }

    /**
     * 하나의 작품은 여러 챕터를 가질 수 있다.
     */
    public function chapter_of_works()
    {
        return $this->hasMany(ChapterOfWork::class);
    }

    public function memos()
    {
        return $this->hasMany(Memo::class);
    }
}
