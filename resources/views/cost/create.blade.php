@extends('layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Thêm mới chi phí
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('cost.index') }}">Chi phí</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="{{ route('cost.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('cost.store') }}">
    <div class="row">
      <!-- left column -->
<?php 
$type = old('type', 0);
$department_id = old('department_id', 0);
$staff_id = old('staff_id', 0);
?>
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
                <div class="form-group" >                                    
                  <select name="staff_id" class="form-control select2" id="staff_id">
                    <option value="">-- Nhân viên --</option>    
                    @foreach($staffList as $staff)                
                    <option value="{{ $staff->id }}" {{ $staff_id == $staff->id ? "selected" : "" }}>{{ $staff->name }} - {{ $staff->staff_code }}</option>
                    @endforeach                    
                  </select>
                </div>                
                <div class="form-group">
                  <input placeholder="Số tiền" type="text" class="form-control number" name="total_cost" id="total_cost" value="{{ old('total_cost') }}">
                </div>
                <div class="form-group">
                  <input placeholder="Ngày" type="text" class="form-control datepicker" name="date_use" id="date_use" value="{{ old('date_use') }}">
                </div>
                <div class="form-group">
                  <input placeholder="Số chứng từ" type="text" class="form-control" name="sct" id="sct" value="{{ old('sct') }}">
                </div>
                <div class="form-group">
                  <input placeholder="Nội dung" type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                </div>
                <div class="form-group">                  
                  <textarea class="form-control" rows="6" name="detail" id="detail">{{ old('detail') }}</textarea>
                </div>
                  
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('cost.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">

      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .select2-container--default .select2-selection--single{
    height: 36px !important;

  }
  .select2-container .select2-selection--single .select2-selection__rendered{
    padding-left: 0px !important;
  }
</style>
@stop

@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){
      $('input.number').number( true, 0);
      $(".select2").select2();      
      var editor = CKEDITOR.replace( 'detail',{
          language : 'vi',         
          toolbarGroups : [
              { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
              { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
              { name: 'document', groups: [ 'mode', 'document', 'doctools', 'clipboard', 'undo', 'find', 'selection', 'spellchecker', 'editing'] },
              { name: 'forms', groups: [ 'forms' ] },               
              { name: 'links', groups: [ 'links' ] },
              { name: 'insert', groups: [ 'insert' ] },          
              { name: 'styles', groups: [ 'styles' ] },
              { name: 'colors', groups: [ 'colors' ] },
              { name: 'tools', groups: [ 'tools' ] },
              { name: 'others', groups: [ 'others' ] },
              { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons :'Source,Templates,Save,Find,SelectAll,Scayt,Form,Strike,Checkbox,Radio,TextField,Replace,Print,Preview,NewPage,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Link,Unlink,Anchor,Image,Flash,Smiley,SpecialChar,Iframe,Maximize,About,Subscript,Superscript,CopyFormatting,RemoveFormat,Outdent,Indent,PageBreak,FontSize,Font,Format,Styles,ShowBlocks'
      });      
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
    });
    
</script>
@stop
