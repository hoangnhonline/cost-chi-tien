@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Tài khoản
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('account.index') }}">Tài khoản</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>
<?php 
$type = old('type', $detail->type);
$department_id = old('department_id', $detail->department_id);
$area_id = old('area_id', $detail->area_id);
?>
  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('account.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('account.update') }}" id="formData">
    <div class="row">
      <!-- left column -->
      <input type="hidden" name="id" value="{{ $detail->id }}"> 
      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Chỉnh sửa</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
                 
                 <!-- text input -->
                <div class="form-group">                  
                  <input type="text" placeholder="Họ tên" class="form-control" name="name" id="name" value="{{ $detail->name }}">
                </div>
                 <div class="form-group">                  
                  <input type="text" placeholder="Email" class="form-control" readonly="true" name="email" id="email" value="{{ $detail->email }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Mã nhân viên" class="form-control" name="staff_code" id="staff_code" value="{{ old('staff_code', $detail->staff_code) }}">
                </div>  
                <div class="form-group" >                  
                  <select name="type" class="form-control select2" id="type">
                    <option value="">-- Phân loại --</option>                    
                    <option value="1" {{ $type == 1 ? "selected" : "" }}>Văn phòng</option>
                    <option value="2" {{ $type == 2 ? "selected" : "" }}>Nhà máy</option>
                  </select>
                </div>
                <div class="form-group" >                  
                  <select name="department_id" class="form-control select2" id="department_id">
                    <option value="">-- Phòng ban --</option>    
                    @foreach($departmentList as $depart)                
                    <option value="{{ $depart->id }}" {{ $department_id == $depart->id ? "selected" : "" }}>{{ $depart->name }}</option>
                    @endforeach                    
                  </select>
                </div>              
                <div class="form-group">                  
                  <select class="form-control" name="role" id="role"> 
                    <option value="">-- Chức vụ --</option>                            
                    <option value="1" {{ old('role', $detail->role) == 1 ? "selected" : "" }}>Nhân viên</option>                  
                    <option value="2" {{ old('role', $detail->role) == 2 ? "selected" : "" }}>Giám đốc KV</option>
                  </select>
                </div>  
                <div class="form-group">                  
                  <select class="form-control" name="area_id" id="area_id"> 
                    <option value="">-- Khu vực --</option>
                    @foreach($areaList as $area)                
                    <option value="{{ $area->id }}" {{ $area_id == $area->id ? "selected" : "" }}>{{ $area->name }}</option>
                    @endforeach 
                  </select>
                </div>                        
                <div class="form-group">                  
                  <select class="form-control" name="status" id="status">                                      
                    <option value="">-- Trạng thái --</option>
                    <option value="1" {{ $detail->status == 1 ? "selected" : "" }}>Mở</option>                  
                    <option value="2" {{ $detail->status == 2 ? "selected" : "" }}>Khóa</option>                    
                  </select>
                </div>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('account.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
    });
    
</script>
@stop
