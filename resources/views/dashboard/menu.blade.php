<ul class="navbar-nav bg-image sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">{{env("APP_NAME")}} </div>
    </a>
    <hr class="sidebar-divider my-0">
    <div class="row mt-2 mb-2">
        <div class="col-sm-12 text-center">
        </div>
        <div class="col-sm-12 text-center ">
            <div style="color: white;font-size: 14px" class="mt-2 "> {{auth()->user()->name}}</div>
            <div style="color: rgba(255, 255, 255, 0.7);font-size: 12px"> {{auth()->user()->email}}</div>
        </div>
    </div>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ strpos(Route::currentRouteName(), 'dashboard.stock.') !== false ? 'active' : ''  }}">
        <a class="nav-link " href="{{route('dashboard.stock.index')}}">
            <i class="fas fa-fw fa-tag"></i>
            <span>Ações</span>
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="{{route('dashboard.auth.signout')}}">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span></a>
    </li>
</ul>
