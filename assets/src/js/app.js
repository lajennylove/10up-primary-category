/**
 * Verify if the DOM is ready
 * @param {function} fn
 * @return {void}
 */
function domReady(fn)
{
    // If we're early to the party
    document.addEventListener("DOMContentLoaded", fn);
    // If late; I mean on time.
    if (document.readyState === "interactive" || document.readyState === "complete" ) {
        fn();
    }
}

/**
 * Application entrypoint
 */
domReady(() => {
    console.log('The Dom is ready! 🚀');
});