<script src="{{ asset('js/google-location.js') }}" defer></script>
@if (config('services.google.maps_key'))
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places&callback=agroVisionInitPlaces" async defer></script>
@endif
