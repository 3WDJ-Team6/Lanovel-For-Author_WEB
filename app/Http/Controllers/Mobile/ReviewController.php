<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Grade;
use Carbon;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    private $review_model = null;
    private $grade_model = null;

    public function __construct()
    {
        $this->review_model = new Review();
        $this->grade_model = new Grade();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($workNum)
    {
        /**
         * 리뷰 리스트
         *
         * => 서버로부터 특정 작품에 작성된 리뷰들 리스트 json 형식으로 받음
         *   (리뷰 리스트 : 리뷰 단 유저 프로필사진 url, 유저 닉네임, 평점, 리뷰 내용)
         */
        $reviews = Review::select(
            'users.profile_photo',
            'users.nickname',
            'grades.grade',
            'reviews.content_of_review'
        )->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('grades', 'grades.user_id', '=', 'reviews.user_id')
            ->where('reviews.num_of_work', $workNum)->get();

        return response()->json($reviews, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $workNum, $userId)
    {
        // return "0";
        // return $request;
        // 리뷰 저장 정보

        $review_save = new Review();

        $review_save->content_of_review = $request->content_of_review;
        $review_save->num_of_work = $workNum;
        $review_save->user_id = $userId;
        $review_save->created_at = Carbon::now();
        $review_save->updated_at = Carbon::now();

        $review_save->save();



        $grade_save = new Grade();

        $grade_save->role_of_work = 1;
        $grade_save->num_of_work = $workNum;
        $grade_save->user_id = $userId;
        $grade_save->grade = $request->grade;

        $grade_save->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
