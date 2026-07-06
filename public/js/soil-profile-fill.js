document.addEventListener('DOMContentLoaded', () => {
    const select = document.querySelector('[data-soil-profile-select]');

    if (!(select instanceof HTMLSelectElement)) {
        return;
    }

    const fields = {
        location: document.querySelector('[data-profile-location]'),
        soilType: document.querySelector('[data-profile-soil-type]'),
        ph: document.querySelector('[data-profile-ph]'),
        nitrogen: document.querySelector('[data-profile-nitrogen]'),
        phosphorus: document.querySelector('[data-profile-phosphorus]'),
        potassium: document.querySelector('[data-profile-potassium]'),
        organicCarbon: document.querySelector('[data-profile-organic-carbon]'),
        moisture: document.querySelector('[data-profile-moisture]'),
    };

    const setField = (field, value) => {
        if (field instanceof HTMLInputElement || field instanceof HTMLSelectElement) {
            field.value = value || '';
        }
    };

    const fillProfile = () => {
        const option = select.selectedOptions[0];

        if (!option || !option.value) {
            return;
        }

        setField(fields.location, option.dataset.location);
        setField(fields.soilType, option.dataset.soilType);
        setField(fields.ph, option.dataset.ph);
        setField(fields.nitrogen, option.dataset.nitrogen);
        setField(fields.phosphorus, option.dataset.phosphorus);
        setField(fields.potassium, option.dataset.potassium);
        setField(fields.organicCarbon, option.dataset.organicCarbon);
        setField(fields.moisture, option.dataset.moisture);

        const preview = document.querySelector('[data-fertilizer-preview-soil]');

        if (preview) {
            const soilType = option.dataset.soilType || 'Saved profile';
            const ph = option.dataset.ph ? `pH ${option.dataset.ph}` : 'pH N/A';

            preview.textContent = `${soilType} | ${ph}`;
        }
    };

    select.addEventListener('change', fillProfile);
    fillProfile();
});
