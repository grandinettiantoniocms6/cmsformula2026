if (typeof window.PublicKeyCredential === 'undefined') {
    window.PublicKeyCredential = function () {};
    window.PublicKeyCredential.isConditionalMediationAvailable = function () {
        return Promise.resolve(false);
    };
    window.PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable = function () {
        return Promise.resolve(false);
    };
}
