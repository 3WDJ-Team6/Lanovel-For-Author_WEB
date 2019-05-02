<?php

namespace App\Http\Controllers\WorkOut;

use Illuminate\Support\Arr;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $work_arrays = DB::table('all_count_view')->select(
            'all_count_view.num',
            'all_count_view.work_title',
            DB::raw('sum(all_count_view.price) sumPrice')
        )->join('work_lists', 'work_lists.num_of_work', '=', 'all_count_view.num')
            ->where('work_lists.user_id', Auth::user()['id'])
            ->groupBy('all_count_view.num')->get();


        // '작품별 수익' 데이터 값 (윤 영진씨가 보통은 이렇게 짠다고 했음. 근데 나도 앎)
        $date_arrays = DB::table('all_count_view')->select(
            'all_count_view.date',
            DB::raw('sum(all_count_view.price) sumPrice')
        )->join('work_lists', 'work_lists.num_of_work', '=', 'all_count_view.num')
            ->where('work_lists.user_id', Auth::user()['id'])
            ->groupBy('all_count_view.date')->get();

        // return $date_arrays;

        // $plucked = $date_arrays->pluck('sumPrice', 'date');
        // return $plucked->toArray();

        // return $work_arrays;

        // 날짜별 수익 데이터값

        // $rental = Rental::select(
        //     'onlyDate'
        // )->join('work_lists', 'work_lists.num_of_work', '=', 'rentals.num_of_work')->where('work_lists.user_id', Auth::user()['id'])->get();
        // return $rental;
        // $onlyDate = \Carbon\Carbon::parse($rentals->created_at)->format('Y/m/d');

        // return $onlyDate;

        // 그 달 날짜 전부
        $today = today();

        $start    = (new DateTime($today))->modify('first day of this month');
        $end      = (new DateTime($today))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 day');
        $period   = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $result[] = [
                'date' => $dt->format("y-m-d"),
                'sumPrice' => 0
            ];
        }
        $month = collect($result);

        foreach ($month as $i => $monthObj) {
            $isSuccess = false;
            foreach ($date_arrays as $j => $day) {
                if ($monthObj['date'] == $day->date) {
                    $resultA[] = [
                        'date' => $monthObj['date'],
                        'sumPrice' => $day->sumPrice
                    ];
                    $isSuccess = true;
                } else {
                    continue;
                }
            }
            if (!$isSuccess) {
                $resultA[] = [
                    'date' => $monthObj['date'],
                    'sumPrice' => $monthObj['sumPrice']
                ];
            }
            $isSuccess = false;
        }
        // return $resultA;

        // // return $result[7]['date'];
        // return response()->json($is_sumPrice, 200, [], JSON_PRETTY_PRINT);

        // data_fill($date_arrays, 'all_count_view.sumPrice', 0);

        // // return $date_arrays;
        // return response()->json(array(
        //     $dates
        // ), 200, [], JSON_PRETTY_PRINT);

        // return response()->json($list, 200, [], JSON_PRETTY_PRINT);
        // return $resultA;
        return view('editor.main.graph', compact('work_arrays', 'resultA'));
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
