<!--IUB-COOKIE-BLOCK-SKIP-START-->
<script data-cmp-ab="2">
    if (typeof window.PublicKeyCredential === 'undefined') {
        window.PublicKeyCredential = function () {};
        window.PublicKeyCredential.isConditionalMediationAvailable = function () {
            return Promise.resolve(false);
        };
        window.PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable = function () {
            return Promise.resolve(false);
        };
    }
</script>
<script src="{{ url('js_common/public-key-credential-fallback.js') }}" data-cmp-ab="2"></script>
<!--IUB-COOKIE-BLOCK-SKIP-END-->
