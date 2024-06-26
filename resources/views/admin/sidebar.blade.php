<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('img/core-img/logo_sma_3_pasundan_bandung.png')}}" alt="sma3pasundan Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SMA Pasundan 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        =
        <div class="info">
          <a href="#" class="d-block">{user.name}</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(auth()->user()->role == 'siswa')
          <li class="nav-item">
            <a href="/student" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard (student)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('student.show')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Detail Student
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Registration (for student)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('student.check-registration.view')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('student.check-remaining-amount')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>History Payment</p>
                </a>
              </li>
            </ul>
          </li>

          @else
          <li class="nav-item">
            <a href="{{route('admin.unverified_user_data')}}" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard (admin)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <li class="nav-item treeview">
              <a href="{{route('admin.verified_students')}}" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Verified Students
                </p>
              </a>
            </li>
          </li>
          <li class="nav-item">
            <li class="nav-item treeview">
              <a href="{{route('admin.list_accept_students')}}" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Accept Students
                </p>
              </a>
            </li>
          </li>
          
          <li class="nav-item">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.register_student')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Register</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/teachers/')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data Teacher
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/posts/')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                News
              </p>
            </a>
          </li>
          @endif
         
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>