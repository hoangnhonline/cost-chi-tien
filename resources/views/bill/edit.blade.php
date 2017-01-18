@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cập nhật công nợ
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('bill.index') }}">Công nợ</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>
<?php
$customer_id = old('customer_id', $detail->customer_id);
?>
  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('bill.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('bill.update') }}" id="formData">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cập nhật</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
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
                  <select class="form-control" name="customer_id" id="customer_id"> 
                    <option value="">-- Khách hàng --</option>                            
                    @foreach($customerList as $customer)                
                    <option value="{{ $customer->id }}" {{ $customer_id == $customer->id ? "selected" : "" }}>{{ $customer->company_name }}</option>
                    @endforeach 
                  </select>
                </div> 
                <div class="form-group">                  
                  <input type="text" placeholder="Số hóa đơn" class="form-control"  name="bill_no" id="bill_no" value="{{ old('bill_no', $detail->bill_no) }}">
                </div> 
                <div class="form-group">                  
                  <input type="text" placeholder="Ngày xuất hóa đơn" class="form-control datepicker"  name="date_export" id="date_export" value="{{ old('date_export', $detail->date_export) }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Tiền hàng" class="form-control"  name="product_cost" id="product_cost" value="{{ old('product_cost', $detail->product_cost) }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Tiền thuế" class="form-control"  name="tax" id="tax" value="{{ old('tax', $detail->tax) }}">
                </div>
                 <div class="form-group">                  
                  <input type="text" placeholder="Tổng tiền" class="form-control" name="total_cost" id="total_cost" value="{{ old('total_cost', $detail->total_cost) }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Đã trả" class="form-control" name="pay" id="pay" value="{{ old('pay', $detail->pay) }}">
                </div>
                <div class="form-group">                  
                  <input type="text" placeholder="Còn nợ lại" class="form-control" name="owed" id="owed" value="{{ old('owed', $detail->owed) }}">
                </div>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('bill.index')}}">Hủy</a>
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
