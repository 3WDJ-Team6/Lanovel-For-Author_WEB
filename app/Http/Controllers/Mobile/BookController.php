<?php
namespace App\Http\Controllers\Mobile;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Rental;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    # 구매 또는 대여 -> 책 OPF주소 전달 -> READ
    public function show(Request $request, $bookNum = null, $bookTitle = null, $action = null)
    {
        $userId = Auth::user()['id'] ? $userId =  Auth::user()['id'] : 22;  //유저번호 접속자 or Reader
        $folderPath = 'WorkSpace';
        // bookNum == booktitle의 num 일치 해야함
        $rentOrBuy = Rental::select(
            'user_id',
            'num_of_work',
            'due_of_rental',
            'file_Path',
            DB::raw("if(due_of_rental < NOW(), FALSE, TRUE) as isRental")
        )->where('num_of_work', $bookNum)->where('user_id', $userId)->get(); # 1이면 대여중인책 Or 구입한 책(null)
        //책을 읽을 수 있는 URL을 전달함
        # 일단 칼럼이 있으면 구매 또는 렌탈한 책임. 렌탈한 날짜가 지나면 table값을 삭제 또는 접근 못하게 opf파일주소 눌렀을 때 기간이 초과한 작품이라고 적어 줌
        # 요청이 렌탈이고 현재 렌탈칼럼에 값이 없다면 현재날짜 + 3일로 DB에 table create 있으면 DB저장 없이 OPF파일주소 보내줌.
        # 요청이 구입이고 현재 구입칼럼에 값이 없다면 due_of_rental = NULL(구입),create 있으면 DB저장 없이 OPF파일주소 보내줌.
        # 요청 URL = readBook/WorkSpace/28/냥멍이/buy
        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);
        # '/Author\Author@test\WorkSpace\폴더구조테스트\OEBPS\폴더구조테스트.opf'
        $opfPath = Storage::disk('s3')->url($filePath . DIRECTORY_SEPARATOR . 'OEBPS' . DIRECTORY_SEPARATOR . $bookTitle . '.opf');
        # 렌탈 테이블에 저장할 정보
        # Rentals->firstOrCreate(); return count($rentOrBuy);
        // return $rentOrBuy[0]['isRental']; # 렌탈 기간이 지났거나 구입되지 않은 책이면.
        if (count($rentOrBuy) < 1 || $rentOrBuy[0]['isRental'] == 0) { # 구매나 대여 이력이 없거나 있어도 렌탈기간이 지났다면
            if ($action) {
                switch ($action) {
                    case 'buy':
                        $rentals = Rental::firstOrCreate([
                            'file_path' => $opfPath,                    # 구입 Or 렌탈 주소
                            'num_of_work' => $bookNum,                  # 책 번호
                            'user_id' => $userId,            # 독자 아이디 번호
                            // 'chapter_of_work' => 0,
                        ]);

                        // // 구매 시 포인트 차감
                        // $buyPointM = User::where('id', $userId)
                        //     ->update(
                        //         ['point' => DB::raw("point - (select buy_price from works where num =" . $num . ")")]
                        //     );

                        // // 보유 포인트와 작품 구매 가격 비교
                        // $buyPoint = User::select(
                        //     DB::raw("(select(IF(point>works.buy_price, 'true', 'false')) from users JOIN works ON works.num =" . $num . " WHERE users.id=" . $userId . ") canBuy")
                        // )->where('users.id', $userId)
                        //     ->get();
                        break;
                    case 'lend':
                        try { # 구매이력이 있으나 렌탈기간이 지났다면 +3일 시켜줌
                            if ($rentOrBuy[0]['isRental'] == 0) {
                                $retals = Rental::where('num_of_work', $bookNum)
                                    ->update(['due_of_rental' => Carbon::now()->addDays(3)]);
                            }
                        } catch (\Exception $e) { # 대여기간이 지난게 아니고 그저 구매이력이 없으면 Catch문 실행
                            if (count($rentOrBuy) < 2)
                                $rentals = Rental::firstOrCreate([
                                    'file_path' => $opfPath,                        # 구입 Or 렌탈 주소
                                    'num_of_work' => $bookNum,                      # 책 번호
                                    'user_id' => $userId,                           # 독자 아이디 번호
                                    'due_of_rental' => Carbon::now()->addDays(3),   # 만료 기간
                                ]);
                        }
<<<<<<< HEAD
                        // $point--;
=======
                        // // 보유 포인트와 작품 대여 가격 비교
                        // $rentalPoint = User::select(
                        //     DB::raw("(select(IF(point>works.rental_price, 'true', 'false')) from users JOIN works ON works.num =" . $num . " WHERE id=" . $userId . ") canRental")
                        // )->where('users.id', $userId)
                        //     ->get();

                        // // 대여 시 포인트 차감
                        // $rentalPointM = User::where('id', $userId)
                        //     ->update(
                        //         ['point' => DB::raw("point - (select rental_price from works where num =" . $num . ")")]
                        //     );
>>>>>>> f48000e51e54effd28c94aef34c5e9562e1dcb4b
                        break;
                    case 'read':
                        break;
                    default:
                        return abort(404);  // (대충 그런페이지 없다는 뜻)
                        break;
                }
                # 책의 OPF파일 주소 리턴
                return response()->json(['opfPath' => $opfPath], 200, [], JSON_UNESCAPED_UNICODE);
            } else {    # 액션이 없으면? -> 대여하거나, 구입하지 않고 다른 행위를 한다는 뜻(읽기 등)
                return 'please send action Buy Or Lend';
            }
        } else {
            // return html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $opfPath), ENT_NOQUOTES, 'UTF-8');
            // return htmlentities($opfPath, ENT_QUOTES, "UTF-8");
            # 구매 이력이 있고 대여기간이 남아있으면
            return response()->json(['opfPath' => $opfPath], 200, [], JSON_UNESCAPED_UNICODE);
        }
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
