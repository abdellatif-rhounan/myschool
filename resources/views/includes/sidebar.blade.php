<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="javascript:;" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8" />

        <span class="brand-text">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
            </div>

            <div class="info">
                <a href="javascript:;" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if (request()->segment(1) == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>Dashboard</p>
                    </a>
                </li>

                @php
                    $user_type = Auth::user()->user_type;
                @endphp

                @if ($user_type == 1)
                    {{-- Admin --}}
                    <li class="nav-item">
                        <a href="{{ route('admins.index') }}"
                            class="nav-link @if (request()->segment(1) == 'admins') active @endif">
                            <i class="nav-icon fas fa-user-tie"></i>

                            <p>Admins</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}"
                            class="nav-link @if (request()->segment(1) == 'classes') active @endif">
                            <i class="nav-icon fas fa-graduation-cap"></i>

                            <p>Classes</p>
                        </a>
                    </li>
                @elseif ($user_type == 2)
                    {{-- Teacher --}}
                @elseif ($user_type == 3)
                    {{-- Student --}}
                @elseif ($user_type == 4)
                    {{-- Parent --}}
                @endif
            </ul>
        </nav>
    </div>

</aside>
