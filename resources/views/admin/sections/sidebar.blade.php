<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pr-0" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">AlizDev</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span> داشبورد </span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      لورم ایپسوم
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
        aria-controls="collapseOne">
        <i class="fas fa-fw fa-cog"></i>
        <span>بخش ها</span>
      </a>
      <div id="collapseOne" class="collapse
      {{request()->is('admin-panel/management/brands*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/attributes*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/categories*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/products*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/tags*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/coupons*') ? 'show' : ''}}
      "
      aria-labelledby="headingOne" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">بخش ها</h6>
          <a class="collapse-item {{request()->is('admin-panel/management/brands*') ? 'active' : ''}}" href="{{route('admin.brands.index')}}">برندها</a>
          <a class="collapse-item {{request()->is('admin-panel/management/attributes*') ? 'active' : ''}}" href="{{route('admin.attributes.index')}}">ویژگی ها</a>
          <a class="collapse-item {{request()->is('admin-panel/management/categories*') ? 'active' : ''}}" href="{{route('admin.categories.index')}}">دسته بندی ها</a>
          <a class="collapse-item {{request()->is('admin-panel/management/products*') ? 'active' : ''}}" href="{{route('admin.products.index')}}">محصولات</a>
          <a class="collapse-item {{request()->is('admin-panel/management/tags*') ? 'active' : ''}}" href="{{route('admin.tags.index')}}">تگ ها</a>
          <a class="collapse-item {{request()->is('admin-panel/management/coupons*') ? 'active' : ''}}" href="{{route('admin.coupons.index')}}">کوپن ها</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    @role('owner')
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>مدیریت دسترسی ها</span>
      </a>
      <div id="collapseTwo" class="collapse
      {{request()->is('admin-panel/management/users*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/roles*') ? 'show' : ''}}
      {{request()->is('admin-panel/management/permissions*') ? 'show' : ''}}
      " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">مدیریت دسترسی ها</h6>
          <a class="collapse-item {{request()->is('admin-panel/management/users*') ? 'active' : ''}}" href="{{route('admin.users.index')}}">کاربران</a>
          <a class="collapse-item {{request()->is('admin-panel/management/roles*') ? 'active' : ''}}" href="{{route('admin.roles.index')}}">نقش ها</a>
          <a class="collapse-item {{request()->is('admin-panel/management/permissions*') ? 'active' : ''}}" href="{{route('admin.permissions.index')}}">مجوزها</a>
        </div>
      </div>
    </li>
    @endrole

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span> ابزار ها </span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"> لورم ایپسوم </h6>
          <a class="collapse-item" href="#">Colors</a>
          <a class="collapse-item" href="#">Borders</a>
          <a class="collapse-item" href="#">Animations</a>
          <a class="collapse-item" href="#">Other</a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      لورم
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
        aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span> صفحات </span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"> صفحات ورود : </h6>
          <a class="collapse-item" href="login.html"> ورود </a>
          <a class="collapse-item" href="register.html"> عضویت </a>
          <a class="collapse-item" href="forgot-password.html"> فراموشی رمز عبور </a>
          <div class="collapse-divider"></div>
          <h6 class="collapse-header"> صفحات دیگر : </h6>
          <a class="collapse-item" href="404.html">404 Page</a>
          <a class="collapse-item" href="#">Blank Page</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-chart-area"></i>
        <span> نمودار ها </span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-table"></i>
        <span> جداول </span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
