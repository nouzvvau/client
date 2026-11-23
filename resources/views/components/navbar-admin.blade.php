@php
$adminMenu = [
['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'dashboard'],
['label' => 'Galeri Acara', 'route' => 'admin.gallery.index', 'active' => 'admin.gallery.*', 'icon' => 'image'],
['label' => 'Program & Kegiatan', 'route' => 'admin.program.index', 'active' => 'admin.program.*', 'icon' => 'book'],
['label' => 'Daftar Murid', 'route' => 'admin.nama-murid', 'active' => 'admin.nama-murid*', 'icon' => 'graduation'],
['label' => 'Pengaturan WhatsApp', 'route' => 'admin.whatsapp.edit', 'active' => 'admin.whatsapp.*', 'icon' => 'settings'],
];
@endphp

<aside class="admin-sidebar" data-admin-sidebar>
    <div class="admin-sidebar__head">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <img src="{{ asset('assets/images/logo-navbar.png') }}" alt="Logo Sanggar Seni Cakra Aji" class="admin-brand__logo">
            <span class="admin-brand__text">
                <strong>Sanggar Seni</strong>
                <em>Cakra Aji</em>
                <small>Panel Admin</small>
            </span>
        </a>

        <button type="button" class="admin-sidebar__close" data-admin-menu-close aria-label="Tutup menu">
            <x-admin.icon name="close" />
        </button>
    </div>

    <nav class="admin-nav" aria-label="Navigasi panel admin">
        <span class="admin-nav__label">Menu Utama</span>

        @foreach ($adminMenu as $item)
        @php($isActive = request()->routeIs($item['active']))
        <a href="{{ route($item['route']) }}"
            class="admin-nav__link @if ($isActive) is-active @endif"
            @if ($isActive) aria-current="page" @endif>
            <x-admin.icon :name="$item['icon']" />
            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <div class="admin-sidebar__foot">
        <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="admin-sidebar__website">
            <x-admin.icon name="external" />
            <span>Lihat website</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="admin-sidebar__logout">
            @csrf
            <button type="submit">
                <x-admin.icon name="logout" />
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>