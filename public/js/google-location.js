(function () {
    function setField(form, name, value) {
        const field = form.querySelector(`[name="${name}"]`);

        if (field && value !== null && value !== undefined) {
            field.value = value;
        }
    }

    function wireWeatherButtons() {
        document.querySelectorAll('[data-weather-lookup]').forEach((button) => {
            button.addEventListener('click', async () => {
                const form = button.closest('form');
                const token = document.querySelector('meta[name="csrf-token"]')?.content;
                const message = form?.querySelector('[data-weather-message]');
                const locationName = form?.querySelector('[name="location_name"]')?.value?.trim();

                if (!form || !token) {
                    return;
                }

                if (!locationName) {
                    if (message) {
                        message.textContent = 'Enter a city, village, district, or farm location first.';
                        message.classList.add('is-error');
                    }
                    form.querySelector('[name="location_name"]')?.focus();
                    return;
                }

                button.disabled = true;
                button.textContent = 'Fetching...';
                if (message) {
                    message.textContent = 'Finding the location and loading live weather...';
                    message.classList.remove('is-error', 'is-success');
                }

                try {
                    const response = await fetch(button.dataset.weatherLookup, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            location_name: locationName,
                            latitude: form.querySelector('[name="latitude"]')?.value,
                            longitude: form.querySelector('[name="longitude"]')?.value,
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const validationMessage = data.errors
                            ? Object.values(data.errors).flat()[0]
                            : data.message;
                        throw new Error(validationMessage || 'Live weather could not be fetched.');
                    }

                    ['location_name', 'latitude', 'longitude', 'temperature', 'humidity', 'rainfall', 'wind_speed', 'cloud_cover', 'weather_condition'].forEach((name) => {
                        setField(form, name, data[name]);
                    });
                    form.querySelectorAll('[data-weather-output]').forEach((field) => {
                        field.classList.remove('is-autofilled');
                        void field.offsetWidth;
                        field.classList.add('is-autofilled');
                    });
                    if (message) {
                        message.textContent = `Live weather loaded for ${data.location_name}. Temperature, humidity, and rainfall were filled automatically.`;
                        message.classList.add('is-success');
                    }
                } catch (error) {
                    if (message) {
                        message.textContent = error.message || 'Live weather could not be fetched. Check the location and try again.';
                        message.classList.add('is-error');
                    }
                } finally {
                    button.disabled = false;
                    button.textContent = 'Fetch Live Weather';
                }
            });
        });
    }

    function wireManualLocationInputs() {
        document.querySelectorAll('[data-google-location]').forEach((input) => {
            input.addEventListener('input', () => {
                const form = input.closest('form');
                if (!form) return;
                setField(form, 'latitude', '');
                setField(form, 'longitude', '');
                const message = form.querySelector('[data-weather-message]');
                if (message) {
                    message.textContent = 'Location changed. Fetch live weather again to refresh the values.';
                    message.classList.remove('is-error', 'is-success');
                }
            });
        });
    }

    function wireLiveLocationButtons() {
        document.querySelectorAll('[data-use-live-location]').forEach((button) => {
            button.addEventListener('click', () => {
                const form = button.closest('form');
                const status = form?.querySelector('[data-location-status]');
                const targetName = button.dataset.locationTarget || 'location_name';
                const reverseUrl = button.dataset.reverseLocation;
                const token = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!form || !navigator.geolocation) {
                    if (status) status.textContent = 'Live location is not supported by this browser.';
                    return;
                }

                button.disabled = true;
                button.textContent = 'Finding your location...';
                if (status) {
                    status.textContent = 'Waiting for location permission...';
                    status.classList.remove('is-error', 'is-success');
                }

                navigator.geolocation.getCurrentPosition(async (position) => {
                    const latitude = position.coords.latitude.toFixed(7);
                    const longitude = position.coords.longitude.toFixed(7);
                    setField(form, 'latitude', latitude);
                    setField(form, 'longitude', longitude);
                    setField(form, targetName, `Current location (${latitude}, ${longitude})`);

                    try {
                        if (!reverseUrl || !token) {
                            throw new Error('Place-name service is unavailable.');
                        }

                        if (status) status.textContent = 'Coordinates found. Looking up the nearest place name...';
                        const response = await fetch(reverseUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ latitude, longitude }),
                        });
                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Nearby place name could not be found.');
                        }

                        setField(form, targetName, data.name);
                        if (status) {
                            status.textContent = `${data.name} selected with approximately ${Math.round(position.coords.accuracy)} m GPS accuracy.`;
                            status.classList.remove('is-error');
                            status.classList.add('is-success');
                        }
                    } catch (error) {
                        if (status) {
                            status.textContent = `${error.message} Coordinates were filled and can still be used.`;
                            status.classList.remove('is-success');
                            status.classList.add('is-error');
                        }
                    } finally {
                        button.disabled = false;
                        button.textContent = 'Refresh My Current Location';
                    }
                }, (error) => {
                    if (status) {
                        status.textContent = error.code === 1
                            ? 'Location permission was denied. Enter your location manually instead.'
                            : 'Your live location could not be detected. Enter it manually instead.';
                    }
                    button.disabled = false;
                    button.textContent = 'Use My Live Location';
                }, {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 60000,
                });
            });
        });
    }

    window.agroVisionInitPlaces = function () {
        document.querySelectorAll('[data-google-location]').forEach((input) => {
            if (!window.google?.maps?.places) {
                return;
            }

            const autocomplete = new google.maps.places.Autocomplete(input, {
                fields: ['formatted_address', 'geometry', 'name'],
                types: ['geocode'],
            });

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                const form = input.closest('form');
                const location = place.geometry?.location;

                if (!form || !location) {
                    return;
                }

                input.value = place.formatted_address || place.name || input.value;
                setField(form, 'latitude', location.lat());
                setField(form, 'longitude', location.lng());
            });
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        wireWeatherButtons();
        wireLiveLocationButtons();
        wireManualLocationInputs();
        window.agroVisionInitPlaces();
    });
})();
