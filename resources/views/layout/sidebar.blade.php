<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->full_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>     
      <li {{ in_array(\Request::route()->getName(), ['cost.edit', 'cost.index', 'cost.create']) ? "class=active" : "" }}>
        <a href="{{ route('cost.index') }}">
          <i class="fa fa-reorder"></i> 
          <span>Chi phí</span>         
        </a>       
      </li>
      @if(Auth::user()->role == 3)
      <li {{ in_array(\Request::route()->getName(), ['account.edit', 'account.index', 'account.create']) ? "class=active" : "" }}>
        <a href="{{ route('account.index') }}">
          <i class="fa fa-reorder"></i> 
          <span>Tài khoản</span>         
        </a>       
      </li>
      @endif
      <!--<li {{ in_array(\Request::route()->getName(), ['cost.edit', 'cost.index', 'cost.create']) ? "class=active" : "" }}>
        <a href="{{ route('cost.index') }}">
          <i class="fa fa-reorder"></i> 
          <span>Công nợ</span>         
        </a>       
      </li>-->

   
      <!--<li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>