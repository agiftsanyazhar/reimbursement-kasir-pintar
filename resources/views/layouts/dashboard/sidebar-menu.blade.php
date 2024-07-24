<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Profil Organisasi</li>

        <li class="sidebar-item {{ request()->is('admin/profil-organisasi/bio*') ? 'active' : '' }}">
            <a href="{{ route('admin.organization-profile.bio.index') }}" class="sidebar-link">
                <i class="bi bi-info-circle-fill"></i>
                <span>Bio</span>
            </a>
        </li>

        <li class="sidebar-item has-sub {{ request()->is('admin/profil-organisasi/landing-page*') ? 'active' : '' }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-house-fill"></i>
                <span>Landing Page</span>
            </a>

            <ul class="submenu {{ request()->is('admin/profil-organisasi/landing-page*') ? 'active' : '' }}">
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/hero*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.hero.index') }}" class="submenu-link">Hero</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/section*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.section.index') }}" class="submenu-link">Section</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/anggota-tim*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.staff.index') }}" class="submenu-link">Anggota Tim</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/sistematika-instrumen-analisis*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.systematics-analysis-instruments.index') }}" class="submenu-link">Sistematika dan Instrumen Analisis</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/visi-misi*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.vision-mission.index') }}" class="submenu-link">Visi dan Misi</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/ulasan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.testimonial.index') }}" class="submenu-link">Ulasan</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/profil-organisasi/landing-page/vendor*') ? 'active' : '' }}">
                    <a href="{{ route('admin.organization-profile.landing-page.vendor.index') }}" class="submenu-link">Vendor</a>
                </li>
            </ul>
        </li>

        <hr>

        <li class="sidebar-title">Data</li>

        <li class="sidebar-item has-sub {{ request()->is('admin/data/data-master*') ? 'active' : '' }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-database-fill"></i>
                <span>Data Master</span>
            </a>

            <ul class="submenu {{ request()->is('admin/data/data-master*') ? 'active' : '' }}">
                <li class="submenu-item {{ request()->is('admin/data/data-master/kategori-artikel*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data.master-data.article-category.index') }}" class="submenu-link">Kategori Artikel</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/data/data-master/karir*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data.master-data.career.index') }}" class="submenu-link">Karir</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/data/data-master/kategori-karir*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data.master-data.career-category.index') }}" class="submenu-link">Kategori Karir</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/data/data-master/layanan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data.master-data.service.index') }}" class="submenu-link">Layanan</a>
                </li>
                <li class="submenu-item {{ request()->is('admin/data/data-master/program*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data.master-data.program.index') }}" class="submenu-link">Program</a>
                </li>
            </ul>
        </li>

        
        <li class="sidebar-item {{ request()->is('admin/data/pesan*') ? 'active' : '' }}">
            <a href="{{ route('admin.data.message.index') }}" class="sidebar-link">
                <i class="bi bi-chat-left-text-fill"></i>
                <span>Pesan {!! AppHelper::countUnansweredMessage() == 0 ? '' : '<span class="badge ms-1 bg-danger">' . AppHelper::countUnansweredMessage() . '</span>' !!}</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->is('admin/data/peserta*') ? 'active' : '' }}">
            <a href="{{ route('admin.data.participant.index') }}" class="sidebar-link">
                <i class="bi bi-people-fill"></i>
                <span>Peserta {!! AppHelper::countNewParticipant() == 0 ? '' : '<span class="badge ms-1 bg-danger">' . AppHelper::countNewParticipant() . '</span>' !!}</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->is('admin/data/user*') ? 'active' : '' }}">
            <a href="{{ route('admin.data.user.index') }}" class="sidebar-link">
                <i class="bi bi-person-fill"></i>
                <span>User</span>
            </a>
        </li>

        <hr>

        <li class="sidebar-title">Konten</li>

        <li class="sidebar-item {{ request()->is('admin/konten/artikel*') ? 'active' : '' }}">
            <a href="{{ route('admin.content.article.index') }}" class="sidebar-link">
                <i class="bi bi-pencil-fill"></i>
                <span>Artikel</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->is('admin/konten/karir*') ? 'active' : '' }}">
            <a href="{{ route('admin.content.career.index') }}" class="sidebar-link">
                <i class="bi bi-diagram-3-fill"></i>
                <span>Karir</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->is('admin/konten/layanan*') ? 'active' : '' }}">
            <a href="{{ route('admin.content.service.index') }}" class="sidebar-link">
                <i class="bi bi-gear-fill"></i>
                <span>Layanan</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->is('admin/konten/program*') ? 'active' : '' }}">
            <a href="{{ route('admin.content.program.index') }}" class="sidebar-link">
                <i class="bi bi-mortarboard-fill"></i>
                <span>Program</span>
            </a>
        </li>

    </ul>
</div>