@extends('layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Thông tin chi phí
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'cost.index' ) }}">Thông tin chi phí</a></li>
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
      <a href="{{ route('cost.create') }}" class="btn btn-info" style="margin-bottom:5px">Thêm mới</a>
      @endif
      <div class="panel panel-default">        
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('cost.index') }}">                        
            @if(Auth::user()->role == 3)
            <div class="form-group">              
              <select name="type" class="form-control select2" id="type">
                <option value="">-- Phân loại --</option>
                <option value="1" {{ $search['type'] == 1 ? "selected" : "" }}>Văn phòng</option>
                <option value="2" {{ $search['type'] == 2 ? "selected" : "" }}>Nhà máy</option>
              </select>
            </div>            
            <div class="form-group">              
              <select name="department_id" class="form-control select2" id="department_id">
                <option value="">-- Phòng ban --</option>    
                @foreach($departmentList as $depart)                
                <option value="{{ $depart->id }}" {{ $search['department_id'] == $depart->id ? "selected" : "" }}>{{ $depart->name }}</option>
                @endforeach                    
              </select>
            </div>
            <div class="form-group">              
              <select name="staff_id" class="form-control select2" id="staff_id">
                <option value="">-- Nhân viên --</option>    
                @foreach($staffList as $staff)                
                <option value="{{ $staff->id }}" {{ $search['staff_id'] == $staff->id ? "selected" : "" }}>{{ $staff->name }} - {{ $staff->staff_code }}</option>
                @endforeach                    
              </select>
            </div>
            @endif
            <div class="form-group">              
              <input type="text" class="form-control" name="sct" placeholder="Số chứng từ" value="{{ $search['sct'] }}" style="width:120px">
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
                <td>{{ $item->type == 1 ? "Văn phòng" : "Nhà máy" }}</td>
                <td>{{ $item->department_name }}</td>
                <td>{{ $item->full_name }}</td>
                @endif
                <td>{{ date('d-m-Y', strtotime($item->date_use)) }}</td>                
                <td>{{ $item->sct }}</td>
                <td>{{ $item->title }}</td>
                <td style="text-align:right">{{ number_format($item->total_cost) }}</td>
                @if(Auth::user()->role == 3)
                <td style="white-space:nowrap">                                
                  <a href="{{ route( 'cost.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning">Chỉnh sửa</a>                                   
                  <a onclick="return callDelete('{{ $item->title }}','{{ route( 'cost.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger">Xóa</a>
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
<?php 
$department_id = $search['department_id'];
$staff_id = $search['staff_id'];
$type = $search['type'];
?>
$(document).ready(function(){
  $('#type').change(function(){
        var type = $(this).val();
        $.ajax({
            url: '{{ route('department.ajax-list') }}',
            type: "GET",
            async: false,
            data: {                         
                type : type
            },
            success: function(data){
                $('#department_id').html(data).select2('refresh');
            }
        });
      });     
      $('#department_id').change(function(){
        var department_id = $(this).val();
        $.ajax({
            url: '{{ route('account.ajax-list') }}',
            type: "GET",
            async: false,
            data: {                         
                department_id : department_id
            },
            success: function(data){
                $('#staff_id').html(data).select2('refresh');
            }
        });
      });

      @if($type > 0)
      $.ajax({
            url: '{{ route('department.ajax-list') }}',
            type: "GET",
            async: false,
            data: {                         
                type : {{ $type }}
            },
            success: function(data){
                @if($department_id > 0)
                $('#department_id').html(data).val({{ $department_id }}).select2('refresh');               
                @else 
                $('#department_id').html(data).select2('refresh');               
                @endif
            }
        });
      @endif      
      @if($department_id > 0)
        $.ajax({
              url: '{{ route('account.ajax-list') }}',
              type: "GET",
              async: false,
              data: {                         
                  department_id : {{ $department_id }}
              },
              success: function(data){
                  @if($staff_id > 0)
                  $('#staff_id').html(data).val({{ $staff_id }}).select2('refresh');               
                  @else 
                  $('#staff_id').html(data).select2('refresh');               
                  @endif
              }
          });
        @endif
  $('.select2').select2();

 
});

</script>
@stop