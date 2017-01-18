<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Account;
use App\Models\Department;
use Helper, File, Session, Auth;

class BillController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $customerList = Account::where('type', 2)->get();
        $search['bill_no'] = $bill_no = isset($request->bill_no) && $request->bill_no != '' ? $request->bill_no : '';
        $search['fd'] = $fd = isset($request->fd) && $request->fd != '' ? $request->fd : '';
        $search['td'] = $td = isset($request->td) && $request->td != '' ? $request->td : '';
        
        if(Auth::user()->role == 3){
            $search['customer_id'] = $customer_id = isset($request->customer_id) && $request->customer_id != '' ? $request->customer_id : '';           
           
        }else{
            $search['customer_id'] = $customer_id = Auth::user()->id;                       
        }

        $query = Bill::whereRaw('1');        
        
        if($customer_id > 0){
            $query->where('bill.customer_id', $customer_id );
        }
        if( $bill_no != ''){
            $query->where('bill_no', $bill_no );
        }
        if($fd != ''){
            $fd = date('Y-m-d', strtotime($fd));
            $query->where('date_export', '>=', $fd);
        }
        if($td != ''){
            $td = date('Y-m-d', strtotime($td));
            $query->where('date_export', '<=', $td);
        }
        $query->join('users', 'users.id', '=', 'bill.customer_id');       
        
        $items = $query->select(['users.name as full_name', 'bill.*'])->orderBy('date_export', 'asc')->paginate(100);
        $total = $query->selectRaw('sum(owed) as total_cost_owed')->first()->total_cost_owed;       
      
        return view('bill.index', compact( 'items' , 'customerList', 'search', 'total'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {    
        if(Auth::user()->role != 3){
            return redirect()->route('bill.index');
        }        
        $customerList = Account::where('type', 2)->get();
        return view('bill.create', compact('customerList'));
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
            return redirect()->route('bill.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'customer_id' => 'required',
            'date_export' => 'required',
            'bill_no' => 'required',
            'product_cost' => 'required',
            'tax' => 'required',
            'total_cost' => 'required'           
        ],
        [           
            
            'customer_id.required' => 'Bạn chưa chọn khách hàng ',
            'date_export.required' => 'Bạn chưa chọn nhân viên',
            'bill_no.required' => 'Bạn chưa nhập số hóa đơn',            
            'product_cost.required' => 'Bạn chưa nhập tiền hàng',            
            'tax.required' => 'Bạn chưa nhập thuế',            
            'total_cost.required' => 'Bạn chưa nhập tổng tiền',
        ]);

        $dataArr['date_export'] = date('Y-m-d', strtotime($dataArr['date_export']));
        $dataArr['product_cost'] = str_replace(",", "", $dataArr['product_cost']);
        $dataArr['tax'] = str_replace(",", "", $dataArr['tax']);
        $dataArr['total_cost'] = str_replace(",", "", $dataArr['total_cost']);
        $dataArr['pay'] = str_replace(",", "", $dataArr['pay']);
        $dataArr['owed'] = str_replace(",", "", $dataArr['owed']);
        $rs = Bill::create($dataArr);

        Session::flash('message', 'Tạo công nợ thành công');

        return redirect()->route('bill.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {        
        if(Auth::user()->role != 3){
            return redirect()->route('bill.index');
        }
        $detail = Bill::find($id);
        $departmentList = Department::all();
        $staffList = Account::where('type', 1)->get();
        return view('bill.edit', compact('detail', 'departmentList', 'staffList'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('bill.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[
            'type' => 'required',
            'department_id' => 'required',
            'customer_id' => 'required',
            'total_cost' => 'required',
            'date_export' => 'required',
            'bill_no' => 'required',
            'title' => 'required'           
        ],
        [            
            'type.required' => 'Bạn chưa chọn phân loại',
            'department_id.required' => 'Bạn chưa chọn phòng ban ',
            'customer_id.required' => 'Bạn chưa chọn nhân viên',
            'total_bill.required' => 'Bạn chưa nhập số tiền',            
            'date_export.required' => 'Bạn chưa nhập ngày',            
            'bill_no.required' => 'Bạn chưa nhập số chứng từ',            
            'title.required' => 'Bạn chưa nhập nội dung',
        ]);

        $dataArr['date_export'] = date('Y-m-d', strtotime($dataArr['date_export']));
        $dataArr['total_cost'] = str_replace(",", "", $dataArr['total_cost']);

        $model = Bill::find($dataArr['id']);

        $model->update($dataArr);
       
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('bill.edit', $dataArr['id']);
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
            return redirect()->route('bill.index');
        }
        // delete
        $model = Bill::find($id);
        $model->delete();
        // redirect
        Session::flash('message', 'Xóa thông tin thành công');
        return redirect()->route('bill.index');
    }
}