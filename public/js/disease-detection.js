(function () {
    const input = document.getElementById('leafImageInput');
    const preview = document.getElementById('diseaseImagePreview');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];

        if (!file) {
            preview.removeAttribute('src');
            preview.style.display = 'none';
            return;
        }

        const reader = new FileReader();

        reader.onload = () => {
            preview.src = String(reader.result);
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    });
})();
