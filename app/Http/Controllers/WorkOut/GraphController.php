<?php

namespace App\Http\Controllers\WorkOut;

use Carbon\Carbon;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

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
        $work_arrays = DB::table('all_count_view')->
            select(
                '*'
            )->join('work_lists', 'work_lists.num_of_work', '=', 'all_count_view.num')
             ->where('work_lists.user_id', Auth::user()['id'])

             ->where(function ($query) {
                $query->whereNotNull('all_count_view.ren');
               })
            //  ->where(function ($query2) {
            //     $query2->whereNotNull('all_count_view.buy');
            //     })
                
             ->get();

        // 날짜별 수익 데이터값

        // $rental = Rental::select(
        //     'onlyDate'
        // )->join('work_lists', 'work_lists.num_of_work', '=', 'rentals.num_of_work')->where('work_lists.user_id', Auth::user()['id'])->get();
        // return $rental;
        // $onlyDate = \Carbon\Carbon::parse($rentals->created_at)->format('Y/m/d');

        // return $onlyDate;

        $date_arrays = DB::table('all_count_view')->
            select(
                'all_count_view.*',
                'rentals.onlyDate'
            )->join('work_lists', 'work_lists.num_of_work', '=', 'all_count_view.num')
            ->join('rentals', 'rentals.num_of_work','=','all_count_view.num')
            ->where('work_lists.user_id', Auth::user()['id'])
            ->where(function ($query) {
                $query->whereNotNull('all_count_view.ren');
               })
            ->distinct()->orderBy('rentals.onlyDate', 'asc')->get();
            
            // return $date_arrays;
            // return response()->json(array(
            //     '작품별'=>$work_arrays,
            //     '날짜별'=>$date_arrays
            // ), 200, [], JSON_PRETTY_PRINT);



        // return response()->json($list, 200, [], JSON_PRETTY_PRINT);
        return view('editor.main.graph', compact('work_arrays','date_arrays'));
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
