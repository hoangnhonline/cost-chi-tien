<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\Account;
use App\Models\Department;
use Helper, File, Session, Auth;

class DepartmentController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function ajaxList(Request $request)
    {
        $type = $request->type;
        if($type == ''){
            $items = Department::whereRaw(1)->orderBy('display_order', 'asc')->get();
        }else{
            $items = Department::where('type', $type)->orderBy('display_order', 'asc')->get();    
        }
        
        return view('department.ajax-list', compact( 'items' ));
    }
    public function index(Request $request)
    {
        
        $departmentList = Department::all();
        $staffList = Account::where('type', 1)->get();

        $search['sct'] = $sct = isset($request->sct) && $request->sct != '' ? $request->sct : '';
        $search['fd'] = $fd = isset($request->fd) && $request->fd != '' ? $request->fd : '';
        $search['td'] = $td = isset($request->td) && $request->td != '' ? $request->td : '';        
        $search['department_id'] = $department_id = isset($request->department_id) && $request->department_id != '' ? $request->department_id : '';
        $search['type'] = $type = isset($request->type) && $request->type != '' ? $request->type : '';
        $search['staff_id'] = $staff_id = isset($request->staff_id) && $request->staff_id != '' ? $request->staff_id : '';

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
        $dataArr = $request->all();
        
        $this->validate($request,[
            'type' => 'required',
            'department_id' => 'required',
            'staff_id' => 'required',
            'total_cost' => 'required',
            'date_use' => 'required',
            'sct' => 'required',
            'sct' => 'required'           
        ],
        [            
            'type.required' => 'Bạn chưa chọn phân loại',
            'department_id.required' => 'Bạn chưa chọn phòng ban ',
            'staff_id.required' => 'Bạn chưa chọn nhân viên',
            'total_cost.required' => 'Bạn chưa nhập số tiền',            
            'date_use.required' => 'Bạn chưa nhập ngày',            
            'sct.required' => 'Bạn chưa nhập số chứng từ',            
            'sct.required' => 'Bạn chưa nhập nội dung',
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

        $detail = Cost::find($id);

        return view('cost.edit', compact('detail'));
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
        $dataArr = $request->all();
        
        $this->validate($request,[            
                        
            'sct' => 'required',            
            'slug' => 'required|unique:pages,slug,'.$dataArr['id'],
        ],
        [            
                        
            'sct.required' => 'Bạn chưa nhập tiêu đề',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['sct']);
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['image_url'], config('icho.upload_path').$destionation);
            
            $dataArr['image_url'] = $destionation;
        }

        $dataArr['updated_user'] = Auth::user()->id;

        $model = Cost::find($dataArr['id']);

        $model->update($dataArr);
       
        Session::flash('message', 'Cập nhật thông tin trang thành công');        

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
        // delete
        $model = Cost::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa trang thành công');
        return redirect()->route('cost.index');
    }
}