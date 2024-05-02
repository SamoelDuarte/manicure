<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15"></div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#agenda" aria-expanded="true"
            aria-controls="agenda">
            <i class="fas fa-mail-bulk"></i>
            <span>Agenda</span>
        </a>

        <div id="agenda" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.schedule.index') }}">
                    Horários de Atendimento
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    @forelse($admin_side_menu as $link)
        @can($link->permission_title)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapse{{ $link->as }}" aria-expanded="true"
                    aria-controls="collapse{{ $link->as }}">
                    <i class="{{ $link->icon }}"></i>
                    <span>{{ $link->title }}</span>
                </a>
                <div id="collapse{{ $link->as }}" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @if (in_array($link->to, $routes_name))
                            <a class="collapse-item" href="{{ route($link->to) }}">
                                {{ $link->title }}
                            </a>
                        @endif
                    </div>
                </div>
            </li>
        @endcan
    @empty
    @endforelse

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#integration"
            aria-expanded="true" aria-controls="integration">
            <i class="fas fa-mail-bulk"></i>
            <span>Integrações</span>
        </a>

        <div id="integration" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/mercadolibre/">
                    Mercado Livre
                </a>
                <a class="collapse-item" href="/admin/bling">
                    Bling
                </a>

            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#post" aria-expanded="true"
            aria-controls="post">
            <i class="fas fa-mail-bulk"></i>
            <span>Post</span>
        </a>

        <div id="post" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.posts.index') }}">
                    Novo Post
                </a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading"></div>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
