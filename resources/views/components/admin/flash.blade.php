@if (session('success'))
    <div class="admin-alert admin-alert--success" role="status">
        <x-admin.icon name="check" />
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="admin-alert admin-alert--error" role="alert">
        <x-admin.icon name="x" />
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="admin-alert admin-alert--error" role="alert">
        <x-admin.icon name="x" />
        <div>
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
