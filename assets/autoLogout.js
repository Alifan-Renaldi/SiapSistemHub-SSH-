(function(global) {
    global.enableAutoLogout = function(timeoutSeconds = 7200, redirectUrl = "/login") {
        let logoutTimer;
        const timeout = timeoutSeconds * 1000;

        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(() => {
                window.location.href = redirectUrl;
            }, timeout);
        }

        ['click','mousemove','keydown','scroll','touchstart'].forEach(evt => {
            document.addEventListener(evt, resetTimer, false);
        });

        resetTimer();
    };
})(window);
