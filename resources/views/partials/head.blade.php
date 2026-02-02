<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<link rel="manifest" href="/site.webmanifest" />

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2325602220062401"
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('start-story-download', (event) => {
            const data = event[0] || event;
            const htmlContent = data.html;
            const fileName = data.fileName;

            generateInvisibleStory(htmlContent, fileName);
        });
    });

    function generateInvisibleStory(html, fileName) {
        const iframe = document.createElement('iframe');
        iframe.style.cssText =
            'position:fixed; left:-10000px; top:0; width:1080px; height:1920px; border:none; z-index:-50;';
        document.body.appendChild(iframe);

        const doc = iframe.contentWindow.document;
        doc.open();
        doc.write(html);
        doc.close();

        iframe.onload = function() {
            setTimeout(() => {
                const body = iframe.contentDocument.body;

                if (!body.style.backgroundColor) body.style.backgroundColor = '#0f172a';

                htmlToImage.toJpeg(body, {
                        quality: 0.95,
                        width: 1080,
                        height: 1920,
                        pixelRatio: 1,
                    })
                    .then((dataUrl) => {
                        window.saveAs(dataUrl, fileName);
                        document.body.removeChild(iframe);
                    })
                    .catch((error) => {
                        console.error('Gagal:', error);
                        alert('Gagal membuat gambar.');
                        document.body.removeChild(iframe);
                    });
            }, 1500);
        };
    }
</script>

@filamentStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
