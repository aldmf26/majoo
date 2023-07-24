<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed" >
    <div class="wrapper">


        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-costume" style="background-color: #00B7B5">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars majoo"></i></a>
              </li>
      
            </ul>
      
            
      
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
              
              <li class="nav-item dropdown majoo">
                <a class="majoo text-light" data-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="fas fa-user majoo"></i> <span class="mr-2 ml-1">{{ Session::get('nama') }}</span></a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                  <div class="dropdown-divider"></div>
                  <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="fas fa-power-off"></i> Logout
                  </a>
      
                </div>
              </li>

            </ul>
          </nav>
        <!-- /.navbar -->
