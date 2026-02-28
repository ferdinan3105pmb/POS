<aside id="sidebar" class="sidebar d-flex">
    <ul class="sidebar-nav list-inline mx-auto justify-content-center " id="sidebar-nav">
        @foreach (getMenus() as $key => $menu)
        <li class="nav-item text-center">
            <a style="width:50px;margin-left:auto;margin-right:auto;margin-bottom:1vh;padding-bottom:1vh" class="nav-link" href="{{ url($menu->route) }}">
                <img src="{{ asset('assets/img/' . $menu->name . '.png') }}" alt="" width="24" height="24">
            </a>
            <span @if (Request::segment(1) !==$menu->route) style="color: #000;" @else style="color: #4C3D3D;" @endif
                class="text-menu">{{ $menu->name }}</span>
        </li>
        @endforeach
    </ul>
</aside>