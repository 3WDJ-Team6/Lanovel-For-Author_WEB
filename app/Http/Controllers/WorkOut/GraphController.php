<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\Work;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // '작품별 수익' 데이터 값

        //작가가 참여하는 모든 작품
        $works = Work::select(
            'works.num',
            'works.work_title',
            'works.status_of_work',
            'works.type_of_work'
        )->join('work_lists', 'work_lists.num_of_work', '=', 'works.num')
         ->whereIn('works.num', function ($query) {
            $query->select('work_lists.num_of_work')->where('work_lists.user_id', \Auth::user()['id']);
        })->get();

        // return $works;
        return view('editor.main.graph')->with('works',$works);
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
    public function store(Request $request)
    {
        //
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