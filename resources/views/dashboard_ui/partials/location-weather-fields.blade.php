<label class="dash-field dash-field--full">
    <span>Location</span>
    <input class="dash-input" type="text" name="location_name" value="{{ old('location_name') }}" placeholder="Type city, village, or farm location" data-google-location required>
    <input type="hidden" name="latitude" value="{{ old('latitude') }}">
    <input type="hidden" name="longitude" value="{{ old('longitude') }}">
</label>

<div class="dash-field dash-field--full">
    <div class="weather-location-actions">
        <button class="dash-button dash-button--ghost" type="button"
                data-use-live-location
                data-location-target="location_name"
                data-reverse-location="{{ route('dashboard.location.reverse') }}">
            Use My Current Location
        </button>
        <span>GPS will fill the nearest city or district automatically.</span>
    </div>
    <p class="dash-note" data-location-status>You can also type the location manually.</p>
</div>

@if (! empty($includeWeather ?? true))
    <div class="dash-field dash-field--full">
        <button class="dash-button dash-button--ghost" type="button" data-weather-lookup="{{ route('dashboard.location.weather') }}">Fetch Live Weather</button>
        <p class="dash-note" data-weather-message>Enter a location, then fetch to automatically fill the live weather fields below.</p>
    </div>

    <label class="dash-field">
        <span>Temperature (&deg;C)</span>
        <input class="dash-input" type="number" step="0.01" name="temperature" value="{{ old('temperature') }}" data-weather-output>
    </label>
    <label class="dash-field">
        <span>Humidity (%)</span>
        <input class="dash-input" type="number" step="0.01" name="humidity" value="{{ old('humidity') }}" data-weather-output>
    </label>
    <label class="dash-field">
        <span>Rainfall / Precipitation</span>
        <input class="dash-input" type="number" step="0.01" name="rainfall" value="{{ old('rainfall') }}" data-weather-output>
    </label>
    <input type="hidden" name="weather_condition" value="{{ old('weather_condition') }}">
@endif
