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
use App\Models\BuyerOfIllustration;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Models\SubscribeOrInterest;

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



        $date_arrays = DB::table('all_count_view')->select(
            'all_count_view.date',
            DB::raw('sum(all_count_view.price) sumPrice')
        )->join('work_lists', 'work_lists.num_of_work', '=', 'all_count_view.num')
            ->where('work_lists.user_id', Auth::user()['id'])
            ->groupBy('all_count_view.date')->get();

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

        return view('editor.main.graph', compact('work_arrays', 'resultA'));
    }

    public function illustIndex()
    {

        $illust_arrays = BuyerOfIllustration::select(
            'illustration_lists.illustration_title',
            DB::raw('(count(buyer_of_illustrations.num_of_illustration) * illustration_lists.price_of_illustration) sumPrice')
        )->join('illustration_lists', 'illustration_lists.num', '=', 'buyer_of_illustrations.num_of_illustration')
            ->where('illustration_lists.user_id', Auth::user()['id'])
            ->groupBy('buyer_of_illustrations.num_of_illustration')
            ->get();


        return response()->json($illust_arrays, 200);
    }




    /**
     *
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
