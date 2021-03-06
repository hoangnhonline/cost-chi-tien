<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Department;
use App\Models\Area;
use Helper, File, Session, Auth;

class AccountController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function ajaxList(Request $request)
    {
        $department_id = $request->department_id;
        if($department_id == ''){
            $items = Account::all();    
        }else{
            $items = Account::where('department_id', $department_id)->get();
        }
        return view('account.ajax-list', compact( 'items' ));
    }
    public function index(Request $request)
    {          
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $items = Account::where('role', '<', 3)->where('status', '>', 0)->where('type', 1)->orderBy('id')->get();        
        
        //$parentCate = Category::where('parent_id', 0)->where('type', 1)->orderBy('display_order')->get();
        
        return view('account.index', compact('items'));
    }
    public function create()
    {        
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        } 
        //$parentCate = Category::where('parent_id', 0)->where('type', 1)->orderBy('display_order')->get();
        $departmentList = Department::all();
        $areaList = Area::all();
        return view('account.create', compact('departmentList', 'areaList'));
    }
    public function changePass(){
        return view('account.change-pass');   
    }

    public function storeNewPass(Request $request){
        $user_id = Auth::user()->id;
        $detail = Account::find($user_id);
        $old_pass = $request->old_pass;
        $new_pass = $request->new_pass;
        $new_pass_re = $request->new_pass_re;
        if( $old_pass == '' || $new_pass == "" || $new_pass_re == ""){
            return redirect()->back()->withErrors(["Chưa nhập đủ thông tin bắt buộc!"])->withInput();
        }
       
        if(!password_verify($old_pass, $detail->password)){
            return redirect()->back()->withErrors(["Nhập mật khẩu hiện tại không đúng!"])->withInput();
        }
        
        if($new_pass != $new_pass_re ){
            return redirect()->back()->withErrors("Xác nhận mật khẩu mới không đúng!")->withInput();   
        }

        $detail->password = Hash::make($new_pass);
        $detail->save();
        Session::flash('message', 'Đổi mật khẩu thành công');

        return redirect()->route('account.change-pass');

    }
    public function store(Request $request)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $dataArr = $request->all();
         
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users,email',
        ],
        [
            'name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã được sử dụng.'
        ]);       
        
        $tmpPassword = str_random(10);

        $dataArr['password'] = Hash::make( $tmpPassword );
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        $rs = Account::create($dataArr);
        if ( $rs->id > 0 ){
            Mail::send('account.mail', ['name' => $request->name, 'password' => $tmpPassword, 'email' => $request->email], function ($message) use ($request) {
                $message->from( config('mail.username'), config('mail.name'));

                $message->to( $request->email, $request->full_name )->subject('Mật khẩu đăng nhập hệ thống');
            });   
        }

        Session::flash('message', 'Tạo mới tài khoản thành công. Mật khẩu đã được gửi đến email đăng ký.');

        return redirect()->route('account.index');
    }
    public function destroy($id)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        // delete
        $model = Account::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa quốc gia thành công');
        return redirect()->route('account.index');
    }
    public function edit($id)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $detail = Account::find($id);
        $departmentList = Department::all();
        $areaList = Area::all();
        return view('account.edit', compact( 'detail', 'departmentList', 'areaList'));
    }
    public function update(Request $request)
    {
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name' => 'required'            
        ],
        [
            'name.required' => 'Bạn chưa nhập họ tên'           
        ]);      

        $model = Account::find($dataArr['id']);        

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật tài khoản thành công');

        return redirect()->route('account.index');
    }
    public function updateStatus(Request $request)
    {       
        if(Auth::user()->role != 3){
            return redirect()->route('cost.index');
        }
        $model = Account::find( $request->id );

        
        $model->updated_user = Auth::user()->id;
        $model->status = $request->status;

        $model->save();
        $mess = $request->status == 1 ? "Mở khóa tài khoản thành công" : "Khóa tài khoản thành công";
        Session::flash('message', $mess);

        return redirect()->route('account.index');
    }
}
