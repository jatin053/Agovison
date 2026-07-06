@auth
    @php
        $publicAuthUser = auth()->user();
        $publicAuthName = $publicAuthUser?->name ?? 'User';
        $publicAuthEmail = $publicAuthUser?->email ?? 'No email available';
        $publicAuthInitial = strtoupper(substr($publicAuthName, 0, 1));
    @endphp

    <div class="site-profile-menu" data-nav-dropdown>
        <button class="site-profile-menu__button" type="button" aria-expanded="false" data-nav-dropdown-toggle>
            <span class="site-profile-menu__avatar">{{ $publicAuthInitial }}</span>
            <span class="site-profile-menu__name">{{ $publicAuthName }}</span>
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m7 10 5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="site-profile-menu__panel" data-nav-dropdown-menu>
            <div class="site-profile-menu__card">
                <span class="site-profile-menu__avatar site-profile-menu__avatar--large">{{ $publicAuthInitial }}</span>
                <strong>{{ $publicAuthName }}</strong>
                <small>{{ $publicAuthEmail }}</small>
            </div>

            <div class="site-profile-menu__list">
                <a href="{{ route('dashboard') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13h7V4H4v9Zm9 7h7V4h-7v16ZM4 20h7v-5H4v5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.profile') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4.8 20c1.8-4.1 4.2-6.2 7.2-6.2s5.4 2.1 7.2 6.2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    <span>Profile settings</span>
                </a>
                <a href="{{ route('dashboard.reports') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3.5h10v17H7zM10 8h4M10 12h4M10 16h2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Farm reports</span>
                </a>
            </div>

            <div class="site-profile-menu__footer">
                @if ($publicAuthUser?->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5 19 7v5c0 4.2-2.8 7.2-7 8.5-4.2-1.3-7-4.3-7-8.5V7l7-3.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                        <span>Admin panel</span>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 6H6v12h4M14 8l4 4-4 4M8 12h10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <a class="site-button site-button--ghost" href="{{ route('login') }}">Login</a>
    <a class="site-button" href="{{ route('register') }}">Register</a>
@endauth
