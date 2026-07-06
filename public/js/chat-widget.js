document.addEventListener('DOMContentLoaded', () => {
    const widget = document.querySelector('[data-agro-chat]');

    if (!widget) {
        return;
    }

    const toggle = widget.querySelector('[data-agro-chat-toggle]');
    const close = widget.querySelector('[data-agro-chat-close]');
    const form = widget.querySelector('[data-agro-chat-form]');
    const input = widget.querySelector('[data-agro-chat-input]');
    const messages = widget.querySelector('[data-agro-chat-messages]');
    const quickButtons = widget.querySelectorAll('[data-agro-chat-question]');

    const answers = [
        {
            keywords: ['api', 'google', 'maps', 'places', 'geocoding', 'weather'],
            answer: 'You need Google Maps JavaScript API, Places API, Geocoding API, and Google Weather API. Air Quality API is optional. Soil, disease, yield, fertilizer logic, and reports do not need Google APIs.',
        },
        {
            keywords: ['disease', 'detect', 'leaf', 'image', 'photo'],
            answer: 'Disease Detection currently works through image upload plus Laravel demo/rule logic. Later you can connect a Python ML API that returns disease name, severity, confidence, treatment, prevention, and product suggestions.',
        },
        {
            keywords: ['soil', 'profile', 'loamy', 'clay', 'sandy', 'ph', 'npk'],
            answer: 'Soil works through manual soil profiles. The farmer enters soil type, pH, NPK, moisture, organic carbon, and notes. Saved soil profiles can auto-fill yield and fertilizer forms.',
        },
        {
            keywords: ['yield', 'prediction', 'production', 'area'],
            answer: 'Yield Prediction uses the crop, land area, area unit, season, soil type, irrigation, previous crop, and weather context to estimate expected yield and advice. It does not need a Google API for the prediction logic.',
        },
        {
            keywords: ['fertilizer', 'dosage', 'nutrient', 'nitrogen', 'phosphorus', 'potassium'],
            answer: 'Fertilizer Recommendation uses AgroVision’s own fertilizer database and rule engine. It checks crop, soil, season, growth stage, pH, NPK, symptoms, and optional weather timing.',
        },
        {
            keywords: ['report', 'reports', 'admin', 'history', 'csv', 'pdf'],
            answer: 'Farm Reports come only from your MySQL database. Users see their own records. Admin can see all user inputs and the results generated for crop, yield, disease, fertilizer, weather, and soil.',
        },
        {
            keywords: ['contact', 'phone', 'number', 'support', 'himachal'],
            answer: 'You can contact AgroVision at +91 70187 41392. The project location is Himachal Pradesh, India.',
        },
        {
            keywords: ['weather', 'rain', 'temperature', 'humidity', 'wind', 'cloud'],
            answer: 'Weather uses the selected latitude and longitude to fetch temperature, humidity, rainfall, wind speed, cloud cover, and weather condition. This supports crop, yield, fertilizer timing, and weather forecast.',
        },
    ];

    const fallback = 'I can help with AgroVision modules, APIs, disease detection, soil profiles, fertilizer, yield, weather, reports, or admin panel. For personal support, call +91 70187 41392 or use the contact form.';

    const setOpen = (open) => {
        widget.classList.toggle('is-open', open);
        toggle?.setAttribute('aria-expanded', open ? 'true' : 'false');

        if (open) {
            setTimeout(() => input?.focus(), 120);
        }
    };

    const addMessage = (text, type = 'bot') => {
        const message = document.createElement('div');
        message.className = `agro-chat__message agro-chat__message--${type}`;
        message.innerHTML = `<p>${escapeHtml(text)}</p>`;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    };

    const escapeHtml = (text) => text
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const getAnswer = (question) => {
        const normalized = question.toLowerCase();
        const match = answers.find((item) => item.keywords.some((keyword) => normalized.includes(keyword)));

        return match?.answer || fallback;
    };

    const submitQuestion = (question) => {
        const cleanQuestion = question.trim();

        if (!cleanQuestion) {
            return;
        }

        addMessage(cleanQuestion, 'user');
        input.value = '';

        window.setTimeout(() => {
            addMessage(getAnswer(cleanQuestion), 'bot');
        }, 250);
    };

    toggle?.addEventListener('click', () => setOpen(!widget.classList.contains('is-open')));
    close?.addEventListener('click', () => setOpen(false));

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        submitQuestion(input.value);
    });

    quickButtons.forEach((button) => {
        button.addEventListener('click', () => {
            setOpen(true);
            submitQuestion(button.dataset.agroChatQuestion || button.textContent || '');
        });
    });
});
