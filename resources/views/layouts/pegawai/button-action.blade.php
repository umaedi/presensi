<div class="appBottomMenu">
    <a href="/user/dashboard" class="item {{ Request::is('user/dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon><strong>Beranda</strong>
        </div>
    </a>
    <a href="/user/izin" class="item {{ Request::is('user/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon><strong>Cuti</strong>
        </div>
    </a>
    <a href="javascript:void()" onclick="openCamera({{ Request::is('user/dl') ? '1' : '' }})"  class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="finger-print-outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/user/histories" class="item {{ Request::is('user/histories') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon><strong>Riwayat</strong>
        </div>
    </a>
    <a href="/user/profile" class="item {{ Request::is('user/profile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="person-outline"></ion-icon><strong>Profil</strong>
        </div>
    </a>
</div>
    <!-- * App Bottom Menu -->
{{-- </div> --}}