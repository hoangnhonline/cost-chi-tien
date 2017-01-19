<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Account;
use App\Models\Department;
use Helper, File, Session, Auth;

class BillDetailController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $customerList = Account::where('type', 2)->get();
        $bill_id = $request->id;
        $detailBill = Bill::find($bill_id);
        $items = BillDetail::where('bill_id', $bill_id)->get();     
        $detail_id = $request->detail_id ? $request->detail_id : 0;
        $detail = (object) [];        
        if($detail_id > 0){
            $detail = BillDetail::find($detail_id);
        }else{
            $detail->product_name = '';
            $detail->price = '';
            $detail->unit = '';
            $detail->total_price = '';
            $detail->amount = '';
        }
        return view('bill-detail.index', compact( 'items' , 'items' , 'detailBill', 'detail'));
    }

   

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('bill-detail.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'product_name' => 'required',
            'unit' => 'required',
            'amount' => 'required',
            'price' => 'required',
            'total_price' => 'required'           
        ],
        [   
            'product_name.required' => 'Bạn chưa nhập tên sản phẩm',
            'unit.required' => 'Bạn chưa chọn đơn vị tính',
            'amount.required' => 'Bạn chưa nhập số lượng',            
            'price.required' => 'Bạn chưa nhập giá',            
            'total_price.required' => 'Bạn chưa nhập tổng tiền'            
        ]);

        $dataArr['price'] = str_replace(",", "", $dataArr['price']);
        $dataArr['total_price'] = str_replace(",", "", $dataArr['total_price']);
        if(isset($dataArr['id']) && $dataArr['id'] > 0){
            $model = BillDetail::find($dataArr['id']);
            $model->update($dataArr);
        }else{
            $rs = BillDetail::create($dataArr);
        }

        Session::flash('message', 'Thêm sản phẩm thành công');

        return redirect()->route('bill-detail.index', ['id' => $dataArr['bill_id']]);
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('bill-detail.index');
        }
        // delete
        $model = BillDetail::find($id);
        $bill_id = $model->bill_id;
        $model->delete();
        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('bill-detail.index', ['id'=> $bill_id]);
    }
}