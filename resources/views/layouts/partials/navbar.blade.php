<a href="{{ url('/') }}" class="brand-link">
    <span class="brand-image">{{ config('app.name') }}</span>
    <span class="brand-text font-weight-light">{{ config('app.display_name') }}</span>
</a>

<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link {{ isHome() }}" rel="page-content">
                    <i class="nav-icon fa fa-home"></i>
                    <p>Home</p>
                </a>
            </li>
            {!! Navbar::render() !!}
        </ul>
    </nav>
</div>