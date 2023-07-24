
<aside class="main-sidebar elevation-4" style="background-color: #32c6c3;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="https://majoo.putrirembulan.com/assets/img/{{Session::get('id_lokasi') == '1' ? 'takemori.jpg' : 'soondobu.jpg'}}" alt="AdminLTE Logo"
            class="brand-image image-center elevation-3" style="opacity: .8">
        <h5 class="text-light text-lg">{{Session::get('id_lokasi') == '1' ? 'Takemori' : 'Soondobu'}}</h5>
    </a>

    <!-- Sidebar -->
    <div class="sidebar btn-custome">

        <!-- Sidebar Menu -->
        <nav class="mt-2 text-light">
            <ul class="nav nav-pills nav-sidebar flex-column text-light" data-widget="treeview" role="menu" data-accordion="false">           
                @php
                    $menu = DB::table('tb_menu')->get();
                    $sub_menu = DB::table('tb_sub_menu')->get();
                @endphp

                @foreach ($menu as $m)
                    @if (in_array($m->id_menu, Session::get('dt_menu')))
                    <li class="nav-item">
                        <a href="#" class="nav-link text-light">
                            <i class="nav-icon <?= $m->icon ?> majoo"></i>
                            <p>
                                {{ $m->menu }}
                                <i class="right fas fa-angle-left majoo"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                        @foreach ($sub_menu as $sm)
                        @if (in_array($sm->id_sub_menu, Session::get('permission')))
                           @if ($m->id_menu == $sm->id_menu)
                            <li class="nav-item {{ Request::is($sm->url) ? 'active' : '' }}">
                                    <a href="{{ route($sm->url) }}"
                                        class="nav-link">
                                        <p class="majoo">{{ $sm->sub_menu }}</p>
                                    </a>
                                </li>
                           @endif
                        @endif
                              
                        @endforeach   
                    </ul>
                </li>
                    @endif
                @endforeach
                
                        
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
