(() => {
    const root = document.getElementById('qrScanner');

    if (!root) {
        return;
    }

    const fileInput = root.querySelector('[data-qr-file]');
    const image = root.querySelector('[data-qr-image]');
    const video = root.querySelector('[data-qr-video]');
    const actions = root.querySelector('[data-qr-actions]');
    const message = root.querySelector('[data-qr-message]');
    const result = root.querySelector('[data-qr-result]');
    const textarea = root.querySelector('[data-qr-text]');
    const uploadButton = root.querySelector('[data-qr-upload]');
    const cameraButton = root.querySelector('[data-qr-camera]');
    const stopButton = root.querySelector('[data-qr-stop]');
    const copyButton = root.querySelector('[data-qr-copy]');
    const closeButton = root.querySelector('[data-qr-close]');
    let scanner = null;

    // Mantiene el estado visual de la pagina en un solo lugar.
    const resetReader = () => {
        if (scanner) {
            scanner.stop();
            scanner = null;
        }

        message.textContent = 'Sube una imagen o usa la camara para leer un codigo QR.';
        actions.classList.remove('d-none');
        image.classList.remove('is-visible');
        video.classList.remove('is-visible');
        result.classList.add('d-none');
        stopButton.classList.add('d-none');
        textarea.value = '';
        fileInput.value = '';
        image.removeAttribute('src');
    };

    const showResult = (text, previewSrc = null) => {
        if (!text) {
            message.textContent = 'No se pudo leer el codigo QR.';
            return;
        }

        // Si el QR contiene una URL, abre directamente la pagina asignada.
        if (isValidUrl(text)) {
            window.location.href = text;
            return;
        }

        actions.classList.add('d-none');
        result.classList.remove('d-none');
        video.classList.remove('is-visible');
        stopButton.classList.add('d-none');
        textarea.value = text;

        if (previewSrc) {
            image.src = previewSrc;
            image.classList.add('is-visible');
        }
    };

    const isValidUrl = (text) => {
        try {
            const url = new URL(text);
            return url.protocol === 'http:' || url.protocol === 'https:';
        } catch {
            return false;
        }
    };

    const readImageQr = (file) => {
        const formData = new FormData();
        formData.append('file', file);

        message.textContent = 'Leyendo codigo QR...';

        // Se conserva la API externa del ejemplo original para procesar imagenes subidas.
        fetch('https://api.qrserver.com/v1/read-qr-code/', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                const text = data?.[0]?.symbol?.[0]?.data;
                showResult(text, URL.createObjectURL(file));
            })
            .catch(() => {
                message.textContent = 'No se pudo conectar con el lector QR.';
            });
    };

    const startCameraScan = () => {
        if (!window.Instascan) {
            message.textContent = 'No se pudo cargar la libreria de camara.';
            return;
        }

        scanner = new Instascan.Scanner({ video, captureImage: true });
        message.textContent = 'Cargando camara. Espera un momento...';

        Instascan.Camera.getCameras()
            .then((cameras) => {
                if (!cameras.length) {
                    message.textContent = 'No se encontro una camara disponible.';
                    return;
                }

                scanner.start(cameras[0]);
                actions.classList.add('d-none');
                video.classList.add('is-visible');
                stopButton.classList.remove('d-none');
            })
            .catch(() => {
                message.textContent = 'No se pudo acceder a la camara. Revisa los permisos.';
            });

        scanner.addListener('scan', (text, capturedImage) => {
            scanner.stop();
            scanner = null;
            showResult(text, capturedImage);
        });
    };

    uploadButton.addEventListener('click', () => fileInput.click());
    cameraButton.addEventListener('click', startCameraScan);
    stopButton.addEventListener('click', resetReader);
    closeButton.addEventListener('click', resetReader);

    copyButton.addEventListener('click', () => {
        navigator.clipboard.writeText(textarea.value);
    });

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (file) {
            readImageQr(file);
        }
    });
})();
