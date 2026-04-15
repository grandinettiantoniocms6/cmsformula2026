<style>
    .bexo-lite-preloader {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.96);
        z-index: 99999;
        opacity: 1;
        visibility: visible;
        transition: opacity .22s ease, visibility .22s ease;
    }
    .bexo-lite-preloader.is-hidden {
        opacity: 0;
        visibility: hidden;
    }
    .bexo-lite-preloader__spinner {
        width: 46px;
        height: 46px;
        border: 3px solid #dfe5eb;
        border-top-color: #0d6efd;
        border-radius: 50%;
        animation: bexoLiteSpin .7s linear infinite;
    }
    @keyframes bexoLiteSpin {
        to { transform: rotate(360deg); }
    }
</style>
<div id="bexo-lite-preloader" class="bexo-lite-preloader" aria-hidden="true">
    <div class="bexo-lite-preloader__spinner"></div>
</div>
<script>
    (function () {
        function hideLitePreloader() {
            var preloader = document.getElementById('bexo-lite-preloader');
            if (!preloader) {
                return;
            }
            preloader.classList.add('is-hidden');
            setTimeout(function () {
                if (preloader && preloader.parentNode) {
                    preloader.parentNode.removeChild(preloader);
                }
            }, 260);
        }

        if (document.readyState === 'complete') {
            hideLitePreloader();
        } else {
            window.addEventListener('load', function () {
                setTimeout(hideLitePreloader, 120);
            });
        }
    })();
</script>
