@extends('layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Công nợ
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'bill.index' ) }}">Công nợ</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      @if(Auth::user()->role == 3)
      <a href="{{ route('bill.create') }}" class="btn btn-info" style="margin-bottom:5px">Tạo mới</a>
      @endif
      <div class="panel panel-default">        
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('bill.index') }}">                        
            @if(Auth::user()->role == 3)            
            <div class="form-group">              
              <select name="customer_id" class="form-control select2" id="customer_id">
                <option value="">--Khách hàng --</option>    
                @foreach($customerList as $staff)                
                <option value="{{ $staff->id }}" {{ $search['customer_id'] == $staff->id ? "selected" : "" }}>{{ $staff->company_name }} - {{ $staff->tax_no }}</option>
                @endforeach                    
              </select>
            </div>
            @endif
            <div class="form-group">              
              <input type="text" class="form-control" name="bill_no" placeholder="Số hóa đơn" value="{{ $search['bill_no'] }}" style="width:120px">
            </div>
            <div class="form-group">              
              <input type="text" class="form-control datepicker" name="fd" placeholder="Từ ngày" value="{{ $search['fd'] }}" style="width:100px">
            </div>
            <div class="form-group">              
              <input type="text" class="form-control datepicker" name="td" placeholder="Đến ngày" value="{{ $search['td'] }}" style="width:100px">
            </div>
            <button type="submit" class="btn btn-primary">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách [ <span class="value">{{ $items->total() }} </span>] - Tổng tiền: <span style="color:red">{{ number_format($total) }}</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
            
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>                            
              @if(Auth::user()->role == 3)
              <th>Phân loại</th>
              <th>Phòng ban</th>
              <th>Nhân viên</th>
              @endif
              <th>Ngày</th>              
              <th>Số chứng từ</th>
              <th>Nội dung</th>
              <th style="text-align:right">Số tiền</th>
              @if(Auth::user()->role == 3)
              <th width="1%;white-space:nowrap">Thao tác</th>
              @endif
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                @if(Auth::user()->role == 3) 
                <td>{{ $item->name }}</td>
                @endif
                <td>{{ date('d-m-Y', strtotime($item->date_export)) }}</td>                
                <td>{{ $item->bill_no }}</td>
                <td style="text-align:right">{{ number_format($item->total_cost) }}</td>
                <td style="text-align:right">{{ number_format($item->pay) }}</td>
                <td style="text-align:right">{{ number_format($item->owed) }}</td>
                @if(Auth::user()->role == 3)
                <td style="white-space:nowrap">                                
                  <a href="{{ route( 'bill.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning">Chỉnh sửa</a>                                   
                  <a onclick="return callDelete('{{ $item->title }}','{{ route( 'bill.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger">Xóa</a>
                </td>
                @endif
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
           
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
  .select2-container--default .select2-selection--single{
    height: 34px !important;

  }
  .select2-container .select2-selection--single .select2-selection__rendered{
    padding-left: 0px !important;
  }
</style>
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn chắc chắn xóa ?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
</script>
@stop