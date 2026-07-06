document.addEventListener('DOMContentLoaded', () => {
    const estimateButton = document.querySelector('[data-soil-estimate-url]');

    if (!(estimateButton instanceof HTMLButtonElement)) {
        return;
    }

    const form = estimateButton.closest('form');
    const message = document.querySelector('[data-soil-estimate-message]');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const setValue = (selector, value) => {
        const field = document.querySelector(selector);

        if (field instanceof HTMLInputElement || field instanceof HTMLSelectElement) {
            field.value = value === null || value === undefined ? '' : String(value);
        }
    };

    estimateButton.addEventListener('click', async () => {
        const latitude = form?.querySelector('[data-soil-latitude]')?.value;
        const longitude = form?.querySelector('[data-soil-longitude]')?.value;

        if (!latitude || !longitude) {
            if (message) {
                message.textContent = 'Enter latitude and longitude before estimating soil data.';
            }
            return;
        }

        estimateButton.disabled = true;
        if (message) {
            message.textContent = 'Estimating soil data...';
        }

        try {
            const response = await fetch(estimateButton.dataset.soilEstimateUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ latitude, longitude }),
            });
            const payload = await response.json();

            if (!payload.ok) {
                if (message) {
                    message.textContent = payload.message || 'Soil estimation unavailable. Continue manually.';
                }
                return;
            }

            const data = payload.data || {};
            setValue('[data-soil-type]', data.soil_type);
            setValue('[data-soil-ph]', data.ph_value);
            setValue('[data-soil-organic-carbon]', data.organic_carbon);
            setValue('[data-soil-moisture]', data.soil_moisture);
            setValue('[data-soil-sand]', data.sand_percentage);
            setValue('[data-soil-clay]', data.clay_percentage);
            setValue('[data-soil-silt]', data.silt_percentage);
            setValue('[data-soil-source]', 'Estimated From Location');
            setValue('[data-soil-api-provider]', data.api_provider);

            if (message) {
                message.textContent = payload.message || 'Estimated soil data loaded. Please verify before saving.';
            }
        } catch (error) {
            if (message) {
                message.textContent = 'Soil estimation failed. Continue with manual soil entry.';
            }
        } finally {
            estimateButton.disabled = false;
        }
    });
});
