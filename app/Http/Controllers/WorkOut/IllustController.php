<?php

namespace App\Http\Controllers\WorkOut;

use Auth;
use App\Models\IllustrationList;

use lluminate\Http\RedirectResponse;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\RecommendOfWork;
use App\Models\Grade;
use App\Models\CategoryIllustration;
use App\Models\LikeOfIllustration;
use App\Models\IllustFile;
use App\Models\BuyerOfIllustration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FilePost;
use App\Traits\FileTrait;
use App\Models\CartOfIllustration;

class IllustController extends Controller
{
    use FileTrait;

    private $illustration_model = null;
    private $illust_file_model = null;
    private $category_illust_model = null;
    private $cart_illust_model = null;
    private $like_illust_model = null;
    private $buy_illust_model = null;

    public function __construct()
    {
        // return $this->middleware('auth');
        $this->illustration_model = new IllustrationList();
        $this->illust_file_model = new IllustFile();
        $this->category_illust_model = new CategoryIllustration();
        $this->cart_illust_model = new CartOfIllustration();
        $this->like_illust_model = new LikeOfIllustration();
        $this->buy_illust_model = new BuyerOfIllustration();
    }

    public function illustUpload(FilePost $request)
    {
        $attachments = null;
        $filePath = $this->checkUserMakePath();
        $this->hasFile($request, $filePath);

        $file = $request->file('image');
        $saveFileName = time() . $file->getClientOriginalName();
        $saveFilePath = $filePath . $saveFileName;
        $illustFileUrl = config('filesystems.disks.s3.url') . $saveFilePath;
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [
            'visibility' => 'public',
            'Metadata' => ['Content-Type' => 'image/jpeg'],
        ]);
        $illust_file_info = [
            'url_of_illustration' => $illustFileUrl,
            'name_of_illustration' => $file->getClientOriginalName(),
            'savename_of_illustration' => $saveFileName,
            'folderPath' => 'Illustrator' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images') . DIRECTORY_SEPARATOR,
            'created_at' => Carbon::now()
        ];
        $attachments = IllustFile::create($illust_file_info);  //file을 비동기방식으로 업로드 한 뒤

        return response()->json($attachments, 200);  //업로드 된 파일의 정보를 front에 전달
    }

    public function fileDelete(Request $request, $id)
    {
        $attachments = IllustFile::find($id);
        return $attachments;
        $folderPath = $attachments->folderPath;
        $fileName = $attachments->savename_of_illustration;
        Storage::disk('s3')->delete($folderPath . $fileName);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname',
            'illust_files.url_of_illustration'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->join('illust_files', 'illustration_lists.num', 'illust_files.num_of_illust')
            ->orderByRaw('illustration_lists.hits_of_illustration', 'desc')
            ->limit(5)
            ->get();

        // $best = IllustrationList::selece(
        //     'i'
        // )

        return view('/store/home/home')->with('products', $products);
    }

    // 대메뉴 구별 (background | character | object)
    public function menuIndex($category)
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname',
            'illust_files.*'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->join('illust_files', 'illustration_lists.num', 'illust_files.num_of_illust')
            ->where('illustration_lists.division_of_illustration', $category)
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')->get();

        /**
         * 썸네일 만드는 법
         *
         * IllustFile 에서 num_of_illust 의 값이 같은 것 끼리 묶은 뒤 id의 desc -> first()
         */
        $thumbnail = IllustFile::select(
            '*'
        )->groupBy('num_of_illust')
            ->orderBy('id', 'desc')->get();

        // return response()->json($thumbnail, 200, [], JSON_PRETTY_PRINT);
        return view('.store.menu.contents')->with('products', $products)->with('thumbnail', $thumbnail);
    }

    public function newContent()
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname',
            'illust_files.url_of_illustration'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->join('illust_files', 'illustration_lists.num', 'illust_files.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->orderByRaw('illustration_lists.created_at', 'desc')
            ->get();

        return view('.store.home.new_collection')->with('product', $products);
    }

    // 좋아요
    public function addLike($num)
    {
        $like_info = array([
            'num_of_illust' => $num,
            'user_id' => Auth::user()['id'],
            'created_at' => Carbon::now()
        ]);

        $this->like_illust_model->storeLikeIllust($like_info);
        return redirect()->back()->with('message', "add like!!");
    }

    // 상세보기_
    public function detailView($num)
    {
        $product = IllustrationList::select(
            'illustration_lists.*',
            'illust_files.*',
            DB::raw('(select count(illust_files.id) from illust_files where illust_files.num_of_illust = illustration_lists.num) count')
        )->join('illust_files', 'illust_files.num_of_illust', 'illustration_lists.num')
            ->where('illustration_lists.num', $num)
            ->first();

        $tags = CategoryIllustration::select(
            'category_illustrations.*'
        )->join('illustration_lists', 'category_illustrations.num_of_illustration', 'illustration_lists.num')
            ->where('category_illustrations.num_of_illustration', $num)->get();

        $posts = IllustFile::select(
            '*'
            // DB::raw('(select count(illust_files.id) from illust_files where illust_files.num_of_illust = illustration_lists.num) count')
        )->join('illustration_lists', 'illustration_lists.num', 'illust_files.num_of_illust')
            ->where('illustration_lists.num', $num)->get();

        // return response()->json($product, 200, [], JSON_PRETTY_PRINT);

        // 유저 정보
        $userInfo = User::select(
            'users.*'
        )->where('users.id', '=', Auth::user()['id'])
            ->first();

        return view('store.detail.view')->with('product', $product)->with('posts', $posts)->with('users', $userInfo)->with('tags', $tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store/menu/upload');
    }

    public function myPage()
    {
        // 유저 정보
        $userInfo = User::select(
            'users.*'
        )->where('users.id', '=', Auth::user()['id'])
            ->first();

        // 내 작품 보기
        $myIllustInfo = IllustrationList::select(
            'illustration_lists.*',
            'illust_files.*'
        )->join('illust_files', 'illust_files.num_of_illust', 'illustration_lists.num')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('illustration_lists.user_id', '=', Auth::user()['id'])
            ->get();

        // 팔로우
        // 메시지
        // 좋아요 작품
        $likeInfo = LikeOfIllustration::select(
            'like_of_illustrations.*',
            'illustration_lists.*',
            'illust_files.*'
        )->join('illust_files', 'illust_files.num_of_illust', 'like_of_illustrations.num_of_illust')
            ->join('illustration_lists', 'illustration_lists.num', 'like_of_illustrations.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('like_of_illustrations.user_id', '=', Auth::user()['id'])
            ->get();

        // 장바구니 작품
        $cartInfo = CartOfIllustration::select(
            'cart_of_illustrations.*',
            'illustration_lists.*',
            'illust_files.*'
        )->join('illustration_lists', 'cart_of_illustrations.num_of_illust', 'illustration_lists.num')
            ->join('illust_files', 'cart_of_illustrations.num_of_illust', 'illust_files.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('cart_of_illustrations.user_id', Auth::user()['id'])
            ->get();

        // 수익관리그래프
        $illust_arrays = BuyerOfIllustration::select(
            'illustration_lists.illustration_title',
            DB::raw('(count(buyer_of_illustrations.num_of_illustration) * illustration_lists.price_of_illustration) sumPrice')
        )->join('illustration_lists', 'illustration_lists.num', '=', 'buyer_of_illustrations.num_of_illustration')
            ->where('illustration_lists.user_id', Auth::user()['id'])
            ->groupBy('buyer_of_illustrations.num_of_illustration')
            ->get();

        // 구입 리스트
        $buyInfo = BuyerOfIllustration::select(
            'buyer_of_illustrations.*',
            'illustration_lists.*',
            'illust_files.*'
        )->join('illustration_lists', 'buyer_of_illustrations.num_of_illustration', 'illustration_lists.num')
            ->join('illust_files', 'buyer_of_illustrations.num_of_illustration', 'illust_files.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('buyer_of_illustrations.user_id', Auth::user()['id'])
            ->get();


        return view('store.menu.mypage')->with('row', $userInfo)->with('products', $myIllustInfo)->with('likeProducts', $likeInfo)->with('cartInfos', $cartInfo)->with('illust_arrays', $illust_arrays)->with('buyProducts', $buyInfo);
    }

    public function addCart($num)
    {
        $cart_info = array([
            'num_of_illust' => $num,
            'user_id' => Auth::user()['id'],
            'created_at' => Carbon::now()
        ]);

        // return $cart_info;
        $this->cart_illust_model->storeCart($cart_info);

        return redirect()->back()->with('message', "add cart!!");
    }

    public function cartIndex()
    {
        $cartProducts = CartOfIllustration::select(
            'cart_of_illustrations.*',
            'illustration_lists.*',
            'illust_files.*'
        )->join('illustration_lists', 'cart_of_illustrations.num_of_illust', 'illustration_lists.num')
            ->join('illust_files', 'cart_of_illustrations.num_of_illust', 'illust_files.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('cart_of_illustrations.user_id', Auth::user()['id'])
            ->get();

        return $cartProducts;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "라우트 성공";
        // 일러스트 저장

        $illust_info = new IllustrationList();
        $illust_info->illustration_title = $request->illustration_title;
        $illust_info->user_id = Auth::user()['id'];
        $illust_info->price_of_illustration = $request->radio_P;
        $illust_info->hits_of_illustration = 0;
        $illust_info->introduction_of_illustration = $request->introduction_of_illustration;
        $illust_info->division_of_illustration = $request->division_of_illustration;
        $illust_info->created_at = Carbon::now();

        $illust_info->save();

        // return response()->json($illust_info, 200, array(), JSON_PRETTY_PRINT);

        // 가장 최근에 저장된 일러스트 불러와서
        $recentIllust = IllustrationList::select(
            'illustration_lists.num',
            'illustration_lists.division_of_illustration'
        )->orderBy('created_at', 'DESC')
            ->first();

        $strExplode = explode(' ', $request->get('moreTag'));
        $strReplace = str_replace("#", "", $strExplode);

        for ($i = 0; $i < count($strReplace); $i++) {
            $illust_tag_info = array([
                'num_of_illustration' => $recentIllust->num,
                'tag' => $recentIllust->division_of_illustration,
                'moreTag' => $strReplace[$i]
            ]);
            // 태그 저장
            $this->category_illust_model->storeTag($illust_tag_info);
        }

        \Log::debug(['attachments' => $request->attachments]);
        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $attach = IllustFile::find($file);
                $attach->illustration_lists()->associate($illust_info);    //belongsTo 관계를 변경 할 때 associate 메소드를 사용할 수 있음, 이 메소드는 자식 모델에 외래 키를 지정함
                $attach->save();
            }
        }

        return redirect('/store')->with('message', "success");
    }

    public function buyIllust($num)
    {
        $illust_buy_info = array([
            'num_of_illustration' => $num,
            'user_id' => Auth::user()['id'],
            'created_at' => Carbon::now()
        ]);

        // return $illust_buy_info;
        $this->buy_illust_model->storeIllustBuy($illust_buy_info, $num, Auth::user()['id']);

        $illust_info = BuyerOfIllustration::select(
            'users.point',
            'buyer_of_illustrations.*',
            'illust_files.*'
        )->join('illust_files', 'illust_files.num_of_illust', 'buyer_of_illustrations.num_of_illustration')
            ->join('users', 'users.id', 'buyer_of_illustrations.user_id')
            ->where('buyer_of_illustrations.user_id', '=', Auth::user()['id'])
            ->where('buyer_of_illustrations.num_of_illustration', '=', $num)
            ->get();

        $userPath = $this->checkUserMakePath('buy');

        foreach ($illust_info as $i => $urls) {
            // return response()->json($urls->savename_of_illustration, 200, [], JSON_PRETTY_PRINT);
            Storage::disk('s3')->copy($urls->folderPath . $urls->savename_of_illustration, $userPath . $urls->savename_of_illustration);
        }
        return response()->json($illust_info, 200, [], JSON_PRETTY_PRINT);
        return redirect()->back()->with('message', '구매 성공')->with('illust_info', $illust_info);
    }

    public function buyIllustInCart()
    {
        $numOfCart = CartOfIllustration::select(
            'cart_of_illustrations.num_of_illust'
        )->where('cart_of_illustrations.user_id', '=', Auth::user()['id'])->get();

        $numOfCarts = $numOfCart->pluck('num_of_illust')->all();

        foreach ($numOfCarts as $num) {
            $illust_buy_info = array([
                'num_of_illustration' => $num,
                'user_id' => Auth::user()['id'],
                'created_at' => Carbon::now()
            ]);
            $this->buy_illust_model->storeIllustBuy($illust_buy_info);
            $this->cart_illust_model->dropCart($num);
        }
        return redirect()->back()->with('message', '구매 성공');
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
