<?php
namespace App\Http\Controllers;
use App\Model\Merchandise;
use App\Model\Transaction;
use App\User;
use Validator;
use Image;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MerchandiseController extends Controller {

    public function merchandiseItemPage($merchandise_id){
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        if(!is_null($Merchandise->photo)){
            $Merchandise->photo = url($Merchandise->photo);
        }
        $binding = ['title' => '商品頁',
        'Merchandise'=>$Merchandise,];
        return view('merchandise.showMerchandise', $binding);
    }

    public function merchandiseListPage(){
        // 撈取商品分頁資料
        $row_per_page = 10;
        $MerchandisePaginate = Merchandise::OrderBy('updated_at', 'desc')->where('status', 'S')->paginate($row_per_page);

        // 設定商品圖片網址
        foreach($MerchandisePaginate as &$Merchandise){
            if(!is_null($Merchandise->photo)){
                //設定商品照片網址
                $Merchandise->photo = url($Merchandise->photo);
            }
        }
            $binding = [
                'title' => '商品列表',
                'MerchandisePaginate' => $MerchandisePaginate,
            ];
            return view('merchandise.listMerchandise', $binding);

    }

    public function merchandiseItemEditPage($merchandise_id){

        // 撈取商品資料
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        if(!is_null($Merchandise->photo)){
            $Merchandise->photo = url($Merchandise->photo);
        }
        $binding = [
            'title'=>'編輯商品',
            'Merchandise'=>$Merchandise,
        ];
        return view('merchandise.editMerchandise', $binding);
    }

    public function merchandiseCreateProcess(){
        $merchandise_data = [
            'status' => 'C', // 建立中
            'name'=> '',
            'name_en'=>'',
            'introduction'=>'',
            'introduction_en'=>'',
            'photo'=>null,
            'price'=>0,
            'remain_count'=>0,
        ];
        $Merchandise = Merchandise::create($merchandise_data);

        return redirect('/merchandise/' . $Merchandise->id . '/edit');
    }

    public function merchandiseItemUpdateProcess($merchandise_id){
        $Merchandise = Merchandise::findOrFail($merchandise_id);
        $input = request()->all();

        $rules = [
            'status' => [
                'required',
                'in:C,S',
            ],
            'name' => [
                'required',
                'max:80',

            ],
            'name_en' => [
                'required',
                'max:80',
            ],
            'introduction' => [
                'required',
                'max:2000',
            ],
            'introduction_en' => [
                'required',
                'max:2000',
            ],
            'photo' =>[
                'file',
                'image',
                'max: 10240',

            ],
            'price' => [
                'required',
                'integer',
                'min:0',
            ],
            'remain_count' => [
                'required',
                'integer',
                'min:0',
            ],
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return redirect('/merchandise/' . $Merchandise->id . '/edit')->withErrors($validator)->withInput();

        }


        if (isset($input['photo'])){
            $photo = $input['photo'];
            $file_extension = $photo->getClientOriginalExtension();
            //隨機產生檔名
            $file_name = uniqid() . '.' . $file_extension;

            $file_relative_path = 'images/merchandise/' . $file_name;

            $file_path = public_path($file_relative_path);




            $image = Image::make($photo)->fit(100, 100)->save($file_path);
            $input['photo'] = $file_relative_path;

        }
        $Merchandise->update($input);


        return redirect('/merchandise/' . $Merchandise->id . '/edit');
    }

    public function merchandiseManageListPage(){
        $row_per_page = 10;
        $MerchandisePaginate = Merchandise::OrderBy("created_at", 'desc')->paginate($row_per_page);

        foreach($MerchandisePaginate as &$Merchandise){

            if(!is_null($Merchandise->photo)){
                $Merchandise->photo = url($Merchandise->photo);
            }
        }
        $binding = [
            'title' => '管理商品',
            'MerchandisePaginate'=> $MerchandisePaginate,
        ];
        return view('merchandise.manageMerchandise', $binding);
    }


    public function merchandiseDelete($merchandise_id){

        // $merchandise = Merchandise::find($merchandise_id);
        // $merchandise->delete($merchandise_id);

        $merchandise = Merchandise::find($merchandise_id);

        $merchandise->delete();
        // DB::table('merchandise')->where('id', '=', $merchandise_id)->delete();

        // merchandiseManageListPage();
        // echo('hi');

        return redirect()->back();


    }

    public function merchandiseItemBuyProcess($merchandise_id){

        $input = request()->all();
        $rules = [
            'buy_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ];

        try{
            // 取得登入會員資料
            // $user_id = session()->get('user_id');
            $user_id = Auth::id();
            $User = User::findOrFail($user_id);
            // 交易開始
            DB::beginTransaction();


                        // 處理交易
            $Merchandise = Merchandise::findOrFail($merchandise_id);

            $buy_count = $input['buy_count'];

            $remain_count_after_buy = $Merchandise->remain_count - $buy_count;
            if($remain_count_after_buy < 0){
                throw new Exception('商品數量不足，無法購買');
            }

            // 記錄購買後剩餘數量
            $Merchandise->remain_count = $remain_count_after_buy;
            $Merchandise->save();

            // $create_at = $Merchandise->create_at;

            $total_price = $buy_count * $Merchandise->price;

            $created_at = session()->get('$created_at');

            $transaction_data = [
                'user_id' => $User->id,
                'merchandise_id' => $Merchandise->id,
                'price' => $Merchandise->price,
                'buy_count' => $buy_count,
                'total_price' => $total_price,
                'created_at'=>$created_at,

            ];

            // 建立交易資料
            Transaction::create($transaction_data);


            // 交易結束
            DB::commit();

            $message = [
                'msg' => [
                    '購買成功',
                ],
            ];

            return redirect()->to('/merchandise/' . $Merchandise->id)->withErrors($message);


        }catch(Exception $exception){
            DB::rollBack();

            // 回傳錯誤訊息
            $error_message = [
                'msg' => [
                    $exception->getMessage(),
                ],
            ];
            return redirect()->back()->withErrors($error_message)->withInput();

        }

        // 處理交易錯誤
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return redirect('/merchandise/' . $merchandise_id)->withErrors($validator)->withInput();
        }
    }

}
