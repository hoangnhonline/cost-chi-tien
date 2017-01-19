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
      @if(Auth::user()->type == 1 || Auth::user()->role == 3) 
      <li class="treeview active">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Quản lý chi phí</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['cost.edit', 'cost.index', 'cost.create']) ? "class=active" : "" }}>
            <a href="{{ route('cost.index') }}">
              <i class="fa fa-circle-o"></i> 
              <span>Chi phí</span>         
            </a>
          </li>
          @if(Auth::user()->role == 3)
          <li {{ in_array(\Request::route()->getName(), ['account.edit', 'account.index', 'account.create']) ? "class=active" : "" }}>
            <a href="{{ route('account.index') }}">
              <i class="fa fa-circle-o"></i> 
              <span>Nhân viên</span>         
            </a>
          </li>          
          @endif
        </ul>
      </li>
      @endif
      @if(Auth::user()->type == 2 || Auth::user()->role == 3) 
      <li class="treeview active">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Quản lý công nợ</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['bill.edit', 'bill.index', 'bill.create']) ? "class=active" : "" }}>
            <a href="{{ route('bill.index') }}">
              <i class="fa fa-circle-o"></i> 
              <span>Công nợ </span>         
            </a>
          </li>
          @if(Auth::user()->role == 3)
          <li {{ in_array(\Request::route()->getName(), ['customer.edit', 'customer.index', 'customer.create']) ? "class=active" : "" }}>
            <a href="{{ route('customer.index') }}">
              <i class="fa fa-circle-o"></i> 
              <span>Khách hàng</span>         
            </a>
          </li>          
          @endif
        </ul>
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