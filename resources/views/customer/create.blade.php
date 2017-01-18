@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Thêm mới khách hàng
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('customer.index') }}">Khách hàng</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>
<?php
$area_id = old('area_id', 0);
?>
  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('customer.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('customer.store') }}" id="formData">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thêm mới</h3>
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
                <div class="form-group">                  
                  <select class="form-control" name="area_id" id="area_id"> 
                    <option value="">-- Khu vực --</option>                            
                    @foreach($areaList as $area)                
                    <option value="{{ $area->id }}" {{ $area_id == $area->id ? "selected" : "" }}>{{ $area->name }}</option>
                    @endforeach 
                  </select>
                </div> 
                <div class="form-group">                  
                  <input type="text" placeholder="Tên CTY" class="form-control"  name="company_name" id="company_name" value="{{ old('company_name') }}">
                </div> 
                <div class="form-group">                  
                  <input type="text" placeholder="Mã số thuế" class="form-control"  name="tax_no" id="tax_no" value="{{ old('tax_no') }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Người đại diện" class="form-control"  name="name" id="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Số điện thoại" class="form-control"  name="phone" id="phone" value="{{ old('phone') }}">
                </div>
                 <div class="form-group">                  
                  <input type="text" placeholder="Email ( dùng để đăng nhập )" class="form-control" name="email" id="email" value="{{ old('email') }}">
                </div>                
                    
                <input type="hidden" name="type" value="2">
                <div class="form-group">                  
                  <select class="form-control" name="status" id="status">                                     
                  <option value="">-- Trạng thái --</option>   
                    <option value="1" {{ old('status') == 1 ? "selected" : "" }}>Mở</option>                  
                    <option value="2" {{ old('status') == 2 ? "selected" : "" }}>Khóa</option>
                  </select>
                </div>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('customer.index')}}">Hủy</a>
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
