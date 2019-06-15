<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkList;
use App\Models\Work;
use App\Models\Subscribe;
use DB;
use App\Models\Rental;

class MyListController extends Controller
{
    public function getSubList($userId)
    {
        # 구독 작가 작품
        $forforWhereOfResult1 = Subscribe::select(
            'author_id'
        )->where('reader_id', $userId)
            ->get();
        $collectResult111 = collect($forforWhereOfResult1);
        $forforWhereOfResult1Value = $collectResult111->pluck('author_id')->toarray();

        // return $forforWhereOfResult1Value;

        $forWhereOfResult1 = WorkList::select(
            'num_of_work'
        )->where('work_lists.user_id', $forforWhereOfResult1Value)
            ->get();
        $collectResult11 = collect($forWhereOfResult1);
        $forWhereOfResult1Value = $collectResult11->pluck('num_of_work')->toarray();

        $allSubList = Work::select(
            'works.num',
            'works.work_title',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw("(SELECT COUNT(soi.num_of_work) AS csoi FROM subscribe_or_interests AS soi WHERE soi.role_of_work=2) recommend"),
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            DB::raw("(SELECT GROUP_CONCAT(nickname) FROM users WHERE users.id IN (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=2)) author"),
            DB::raw("(SELECT GROUP_CONCAT(nickname) FROM users WHERE users.id IN (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=3)) illustrator"),
            DB::raw("(SELECT GROUP_CONCAT(tag) AS tag FROM category_works AS cw WHERE cw.num_of_work = works.num) tag")
        )
            ->leftjoin('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            ->leftJoin('users as us1', function ($join) {
                $join->on('work_lists.user_id', '=', 'us1.id')
                    ->where('us1.roles', 2);
            })->leftJoin('users as us2', function ($join) {
                $join->on('work_lists.user_id', '=', 'us2.id')
                    ->where('us1.roles', 3);
            })
            ->whereIn('works.num', $forWhereOfResult1Value)
            ->groupBy('works.num')
            ->get();

        return response()->json($allSubList, 200, [], JSON_PRETTY_PRINT);
    }
    public function getMyList($userId)
    {
        # 구매or 대여작품
        $forWhereOfResult2 = Rental::select(
            'num_of_work'
        )->where('rentals.user_id', $userId)
            ->get();
        $collectResult2 = collect($forWhereOfResult2);
        $forWhereOfResult2Value = $collectResult2->pluck('num_of_work')->toarray();

        $allMyList = Work::select(
            'works.num',
            'works.work_title',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw("(SELECT COUNT(soi.num_of_work) AS csoi FROM subscribe_or_interests AS soi WHERE soi.role_of_work=2) recommend"),
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            DB::raw("(SELECT GROUP_CONCAT(nickname) FROM users WHERE users.id IN (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=2)) author"),
            DB::raw("(SELECT GROUP_CONCAT(nickname) FROM users WHERE users.id IN (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=3)) illustrator"),
            DB::raw("(SELECT GROUP_CONCAT(tag) AS tag FROM category_works AS cw WHERE cw.num_of_work = works.num) tag")
        )
            ->leftjoin('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            ->leftJoin('users as us1', function ($join) {
                $join->on('work_lists.user_id', '=', 'us1.id')
                    ->where('us1.roles', 2);
            })->leftJoin('users as us2', function ($join) {
                $join->on('work_lists.user_id', '=', 'us2.id')
                    ->where('us1.roles', 3);
            })
            ->whereIn('works.num', $forWhereOfResult2Value)
            ->groupBy('works.num')
            ->get();

        return response()->json($allMyList, 200, [], JSON_PRETTY_PRINT);
    }
}
