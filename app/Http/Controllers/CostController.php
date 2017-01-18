<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\Account;
use App\Models\Department;
use Helper, File, Session, Auth;

class CostController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        
        $departmentList = Department::all();
        $staffList = Account::where('type', 1)->get();
        $search['sct'] = $sct = isset($request->sct) && $request->sct != '' ? $request->sct : '';
        $search['fd'] = $fd = isset($request->fd) && $request->fd != '' ? $request->fd : '';
        $search['td'] = $td = isset($request->td) && $request->td != '' ? $request->td : '';
        
        if(Auth::user()->role == 3){
            $search['staff_id'] = $staff_id = isset($request->staff_id) && $request->staff_id != '' ? $request->staff_id : '';
            $search['department_id'] = $department_id = isset($request->department_id) && $request->department_id != '' ? $request->department_id : '';
            $search['type'] = $type = isset($request->type) && $request->type != '' ? $request->type : '';
        }else{
            $search['staff_id'] = $staff_id = Auth::user()->id;
            $search['department_id'] = $department_id = '';
            $search['type'] = $type = '';
        }

        $query = Cost::whereRaw('1');

        if($department_id > 0){
            $query->where('cost.department_id', $department_id );
        }
        if($type > 0){
            $query->where('cost.type', $type );
        }
        if($staff_id > 0){
            $query->where('cost.staff_id', $staff_id );
        }
        if( $sct != ''){
            $query->where('sct', $sct );
        }
        if($fd != ''){
            $fd = date('Y-m-d', strtotime($fd));
            $query->where('date_use', '>=', $fd);
        }
        if($td != ''){
            $td = date('Y-m-d', strtotime($td));
            $query->where('date_use', '<=', $td);
        }
        $query->join('users', 'users.id', '=', 'cost.staff_id');
        $query->join('department', 'department.id', '=', 'cost.department_id');
        
        $items = $query->select(['department.name as department_name', 'users.name as full_name', 'cost.*'])->orderBy('date_use', 'asc')->paginate(100);
        $total = $query->selectRaw('sum(total_cost) as total_cost_sum')->first()->total_cost_sum;       
      
        return view('cost.index', compact( 'items' , 'departmentList', 'staffList', 'search', 'total'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {    
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $departmentList = Department::all();
        $staffList = Account::where('type', 1)->get();
        return view('cost.create', compact('departmentList', 'staffList'));
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
            return redirect()->route('cost.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[
            'type' => 'required',
            'department_id' => 'required',
            'staff_id' => 'required',
            'total_cost' => 'required',
            'date_use' => 'required',
            'sct' => 'required',
            'title' => 'required'           
        ],
        [            
            'type.required' => 'Bạn chưa chọn phân loại',
            'department_id.required' => 'Bạn chưa chọn phòng ban ',
            'staff_id.required' => 'Bạn chưa chọn nhân viên',
            'total_cost.required' => 'Bạn chưa nhập số tiền',            
            'date_use.required' => 'Bạn chưa nhập ngày',            
            'sct.required' => 'Bạn chưa nhập số chứng từ',            
            'title.required' => 'Bạn chưa nhập nội dung',
        ]);

        $dataArr['date_use'] = date('Y-m-d', strtotime($dataArr['date_use']));
        $dataArr['total_cost'] = str_replace(",", "", $dataArr['total_cost']);
        $rs = Cost::create($dataArr);

        Session::flash('message', 'Thêm mới chi phí thành công');

        return redirect()->route('cost.index');
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
            return redirect()->route('cost.index');
        }
        $detail = Cost::find($id);
        $departmentList = Department::all();
        $staffList = Account::where('type', 1)->get();
        return view('cost.edit', compact('detail', 'departmentList', 'staffList'));
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
            return redirect()->route('cost.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[
            'type' => 'required',
            'department_id' => 'required',
            'staff_id' => 'required',
            'total_cost' => 'required',
            'date_use' => 'required',
            'sct' => 'required',
            'title' => 'required'           
        ],
        [            
            'type.required' => 'Bạn chưa chọn phân loại',
            'department_id.required' => 'Bạn chưa chọn phòng ban ',
            'staff_id.required' => 'Bạn chưa chọn nhân viên',
            'total_cost.required' => 'Bạn chưa nhập số tiền',            
            'date_use.required' => 'Bạn chưa nhập ngày',            
            'sct.required' => 'Bạn chưa nhập số chứng từ',            
            'title.required' => 'Bạn chưa nhập nội dung',
        ]);

        $dataArr['date_use'] = date('Y-m-d', strtotime($dataArr['date_use']));
        $dataArr['total_cost'] = str_replace(",", "", $dataArr['total_cost']);

        $model = Cost::find($dataArr['id']);

        $model->update($dataArr);
       
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('cost.edit', $dataArr['id']);
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
            return redirect()->route('cost.index');
        }
        // delete
        $model = Cost::find($id);
        $model->delete();
        // redirect
        Session::flash('message', 'Xóa thông tin thành công');
        return redirect()->route('cost.index');
    }
}