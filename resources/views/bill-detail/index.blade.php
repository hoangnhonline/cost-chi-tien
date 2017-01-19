@extends('layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Chi tiết hóa đơn : <span style="color:red">{{ $detailBill->bill_no }}</span>
  </h1>
  
</section>

<!-- Main content -->
<section class="content">
<a class="btn btn-default btn-sm" href="{{ route('bill.index') }}" style="margin-bottom:5px">Quay lại</a>
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif       
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>       
              <th>Tên sản phẩm</th>
              <th>ĐVT</th>
              <th style="text-align:right">Giá</th>
              <th style="text-align:right">Số lượng</th>
              <th style="text-align:right">Thành tiền</th>
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
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->unit == 1 ? "Phuy" : "Pail" }}</td>
                <td style="text-align:right">{{ number_format($item->price) }}</td>
                <td style="text-align:right">{{ number_format($item->amount) }}</td>
                <td style="text-align:right">{{ number_format($item->total_price) }}</td>
                @if(Auth::user()->role == 3)
                <td style="white-space:nowrap">                                
                  <a href="{{ route( 'bill-detail.index', [ 'id' => $detailBill->id, 'detail_id' => $item->id ]) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>                                   
                  <a onclick="return callDelete('{{ $item->product_name }}','{{ route( 'bill-detail.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger  btn-sm">Xóa</a>
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
      <form role="form" method="POST" action="{{ route('bill-detail.store') }}" id="formData">
        <div class="box box-primary" id="formAdd">           
            <div class="box-header with-border">
              @if($detail->amount > 0)
              <h3 class="box-title">Cập nhật sản phẩm</h3>
              @else
              <h3 class="box-title">Thêm sản phẩm</h3>
              @endif
            </div>
            <!-- /.box-header -->               
              {!! csrf_field() !!}
              <input type="hidden" name="bill_id" value="{{ $detailBill->id }}">
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
                  
                  <div class="form-group col-md-4" style="padding-left:0px">                  
                    <input type="text" placeholder="Tên sản phẩm" class="form-control"  name="product_name" id="product_name" value="{{ old('product_name', $detail->product_name) }}">
                    @if($detail->amount > 0)
                    <input type="hidden" name="id" value="{{ $detail->id }}">
                    @endif
                  </div>
                  <div class="form-group col-md-1" style="padding:0px"> 
                  <select name="unit" class="form-control select2" id="unit">
                      <option value="">-ĐVT-</option>                    
                      <option value="1" {{ old('unit', $detail->unit) == 1 ? "selected" : "" }}>Phuy</option>
                      <option value="2" {{ old('unit', $detail->unit) ? "selected" : "" }}>Pail</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2">                  
                    <input type="text" placeholder="Giá tiền" class="form-control number"  name="price" id="price" value="{{ old('price', ($detail->price)) }}">
                  </div>
                  <div class="form-group col-md-1" style="padding:0px">                  
                    <input type="text" placeholder="Số lượng" class="form-control number"  name="amount" id="amount" value="{{ old('amount', $detail->amount) }}">
                  </div>
                   <div class="form-group col-md-3">                  
                    <input type="text" placeholder="Tổng tiền" class="form-control number" name="total_price" id="total_price" value="{{ old('total_price', ($detail->total_price)) }}">
                  </div>
                  <div class="form-group col-md-1">                  
                    <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
                  </div>
              </div>           
              
          </div> 
        </form>   
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
$(document).ready(function(){
  $('.select2').select2();
  $('#price, #amount').blur(function(){
    calTotal();
  });
});
function calTotal(){
  var amount = 0;
  var price = 0;
  if($('#price').val() != ''){
    price = parseInt($('#price').val());
  }
  if($('#amount').val() != ''){
    amount = parseInt($('#amount').val());
  }
  $('#total_price').val(price*amount);
}
</script>
@stop