@switch($icon)
    @case('dashboard')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 12.5 12 4l8 8.5"/>
            <path d="M6.5 10.5V20h11v-9.5"/>
        </svg>
        @break
    @case('crop')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20V9"/>
            <path d="M12 11c-4.6 0-7.4-2.9-7.8-7.1 4.4.4 7.4 3.1 7.8 7.1Z"/>
            <path d="M12 13c4.6 0 7.4-2.9 7.8-7.1-4.4.4-7.4 3.1-7.8 7.1Z"/>
        </svg>
        @break
    @case('yield')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 20V10"/>
            <path d="M10 20V6"/>
            <path d="M15 20v-8"/>
            <path d="M20 20V4"/>
            <path d="M3 20h18"/>
        </svg>
        @break
    @case('disease')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 21c4.6-2.2 7-6.2 7-11.1V5.5L12 3 5 5.5v4.4c0 4.9 2.4 8.9 7 11.1Z"/>
            <path d="m9.5 12 1.6 1.6 3.4-3.8"/>
        </svg>
        @break
    @case('fertilizer')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 6h10l1.5 4.5L17 20H7l-1.5-9.5L7 6Z"/>
            <path d="M9 6V4h6v2"/>
            <path d="M12 10v6"/>
            <path d="M9.5 13h5"/>
        </svg>
        @break
    @case('weather')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 18h10a4 4 0 0 0 .3-8A5.5 5.5 0 0 0 6.7 8.3 3.8 3.8 0 0 0 7 18Z"/>
            <path d="M12 4v2"/>
        </svg>
        @break
    @case('weather-sun')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17.5 17.5H8a4 4 0 0 1-.2-8 5 5 0 0 1 9.5-.8A3.3 3.3 0 0 1 17.5 17.5Z"/>
            <path d="M15 5.2V3"/>
            <path d="m18.4 6.6 1.6-1.6"/>
            <path d="M19.8 10h2.2"/>
        </svg>
        @break
    @case('soil')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 16c1.2-1.4 2.7-2 4.5-2s3.1.6 4.3 1.8c1.4-1.3 3-1.8 4.9-1.8 1 0 1.9.2 2.8.5"/>
            <path d="M4 20h16"/>
            <path d="M12 5v6"/>
            <path d="M12 7c-2.8 0-4.7-1.9-4.9-4.7C9.9 2.5 11.8 4.2 12 7Z"/>
            <path d="M12 8.5c2.8 0 4.7-1.9 4.9-4.7-2.8.2-4.7 1.9-4.9 4.7Z"/>
        </svg>
        @break
    @case('history')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3.5 12a8.5 8.5 0 1 0 2.5-6"/>
            <path d="M3 5v4h4"/>
            <path d="M12 7v5l3 2"/>
        </svg>
        @break
    @case('reports')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 3h7l5 5v13H7z"/>
            <path d="M14 3v6h6"/>
            <path d="M10 13h6"/>
            <path d="M10 17h6"/>
        </svg>
        @break
    @case('saved')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 4h10a2 2 0 0 1 2 2v14l-7-4-7 4V6a2 2 0 0 1 2-2Z"/>
        </svg>
        @break
    @case('profile')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
            <path d="M5 20a7 7 0 0 1 14 0"/>
        </svg>
        @break
    @case('settings')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 15.5A3.5 3.5 0 1 0 12 8.5a3.5 3.5 0 0 0 0 7Z"/>
            <path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.4-2.4 1a8.1 8.1 0 0 0-1.8-1L14.5 3h-5l-.2 2.1a8.1 8.1 0 0 0-1.8 1l-2.4-1-2 3.4 2 1.5a7 7 0 0 0 0 2l-2 1.5 2 3.4 2.4-1a8.1 8.1 0 0 0 1.8 1l.2 2.1h5l.2-2.1a8.1 8.1 0 0 0 1.8-1l2.4 1 2-3.4-2-1.5c.1-.3.1-.7.1-1Z"/>
        </svg>
        @break
    @case('support')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 18h.01"/>
            <path d="M9.5 9.5a2.5 2.5 0 1 1 4.4 1.6c-.7.8-1.4 1.2-1.9 1.9-.3.4-.5.8-.5 1.5"/>
            <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"/>
        </svg>
        @break
    @case('logout')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10 17l-5-5 5-5"/>
            <path d="M5 12h10"/>
            <path d="M14 4h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4"/>
        </svg>
        @break
    @case('search')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="6.5"/>
            <path d="m20 20-3.5-3.5"/>
        </svg>
        @break
    @case('bell')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6.5 9.5a5.5 5.5 0 1 1 11 0c0 6 2.5 6 2.5 8H4c0-2 2.5-2 2.5-8"/>
            <path d="M10 20a2 2 0 0 0 4 0"/>
        </svg>
        @break
    @case('chevron')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="m7 10 5 5 5-5"/>
        </svg>
        @break
    @case('calendar')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 3v4"/>
            <path d="M17 3v4"/>
            <path d="M4 9h16"/>
            <rect x="4" y="5" width="16" height="15" rx="2"/>
        </svg>
        @break
    @case('download')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 4v11"/>
            <path d="m8 11 4 4 4-4"/>
            <path d="M5 20h14"/>
        </svg>
        @break
    @case('upload')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 20V9"/>
            <path d="m8 13 4-4 4 4"/>
            <path d="M5 4h14"/>
        </svg>
        @break
    @case('map')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18 3 20V6l6-2 6 2 6-2v14l-6 2-6-2Z"/>
            <path d="M9 4v14"/>
            <path d="M15 6v14"/>
        </svg>
        @break
    @case('spark')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Z"/>
        </svg>
        @break
    @case('website')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9"/>
            <path d="M3 12h18"/>
            <path d="M12 3a15 15 0 0 1 0 18"/>
            <path d="M12 3a15 15 0 0 0 0 18"/>
        </svg>
        @break
    @default
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="8"/>
        </svg>
@endswitch
