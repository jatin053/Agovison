@switch($icon ?? '')
    @case('dashboard')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 11.2 12 4l8 7.2V20h-5v-5H9v5H4v-8.8Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
        @break

    @case('crop')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21v-8M12 13c-4.2-.3-6.6-2.7-7.2-7 4.3.5 6.7 2.8 7.2 7ZM12 13c.5-4.2 2.9-6.5 7.2-7-.6 4.3-3 6.7-7.2 7Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('yield')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 16v-5M12 16V7M17 16V4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        @break

    @case('disease')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14M7.4 7.4l9.2 9.2M16.6 7.4l-9.2 9.2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="12" r="7" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
        @break

    @case('fertilizer')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 4h8v4h3v4c0 4-2.9 7.4-7 8-4.1-.6-7-4-7-8V8h3V4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9v6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        @break

    @case('weather')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 18h8a4 4 0 0 0 0-8 5.2 5.2 0 0 0-9.7-1.8A3.8 3.8 0 0 0 8 18Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('weather-full')
        <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="18" cy="18" r="9" fill="#ffc01e"/><path d="M18 3v5M18 30v5M3 18h5M30 18h5M7.4 7.4l3.6 3.6M28.1 7.4 24.6 11" stroke="#ffad00" stroke-width="3" stroke-linecap="round"/><path d="M17 36h19a8 8 0 0 0 0-16 10.5 10.5 0 0 0-20-3.3A8.4 8.4 0 0 0 17 36Z" fill="#f9fbff" stroke="#4c9ff2" stroke-width="2.2" stroke-linejoin="round"/></svg>
        @break

    @case('soil')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 20h14M7 16h10M9 12h6M10 4h4l3 8H7l3-8Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('history')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12a8 8 0 1 0 2.3-5.7L4 8.6M4 4v4.6h4.6M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('reports')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3.8h9l3 3V20H6V3.8Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M15 3.8V7h3M9 12h6M9 16h4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        @break

    @case('saved')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 4.5h11v16L12 17l-5.5 3.5v-16Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
        @break

    @case('profile')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4.8 20c1.8-4.1 4.2-6.2 7.2-6.2s5.4 2.1 7.2 6.2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        @break

    @case('settings')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 15.3a3.3 3.3 0 1 0 0-6.6 3.3 3.3 0 0 0 0 6.6Z" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M19.4 13.5v-3l-2.1-.5c-.2-.6-.5-1.1-.8-1.5l.9-2-2.6-1.5-1.6 1.4c-.6-.1-1.2-.1-1.8 0L9.8 5 7.2 6.5l.9 2c-.4.5-.6 1-.8 1.5l-2.1.5v3l2.1.5c.2.6.5 1.1.8 1.5l-.9 2 2.6 1.5 1.6-1.4c.6.1 1.2.1 1.8 0l1.6 1.4 2.6-1.5-.9-2c.4-.5.6-1 .8-1.5l2.1-.5Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
        @break

    @case('logout')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 5H5v14h5M14 8l4 4-4 4M8 12h10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('bell')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 16h12l-1.4-1.6V10a4.6 4.6 0 1 0-9.2 0v4.4L6 16ZM10.2 18.3a1.8 1.8 0 0 0 3.6 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('calendar')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5.5h14v15H5v-15ZM8 3v4M16 3v4M5 10h14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('arrow')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 12h12M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @case('tip')
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18h6M10 21h4M8.5 14.5c-1.3-1.2-2-2.8-2-4.5a5.5 5.5 0 0 1 11 0c0 1.7-.7 3.3-2 4.5-.9.8-1.3 1.4-1.4 2.5H9.9c-.1-1.1-.5-1.7-1.4-2.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        @break

    @default
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M12 5v14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
@endswitch
