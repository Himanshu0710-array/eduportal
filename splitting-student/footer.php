</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false 
    });
</script>

<style>
    #page-loader {
        position: fixed; inset: 0;
        background: rgba(255,255,255,0.85);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 14px;
        opacity: 1;
        transition: opacity 0.35s ease;
        pointer-events: none;
    }
    #page-loader.hidden { opacity: 0; }
    .loader-ring {
        width: 52px; height: 52px;
        border: 5px solid #e2e8f0;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 0.75s linear infinite;
    }
    .loader-text { color: #64748b; font-size: 0.9rem; font-weight: 500; font-family: 'Outfit', sans-serif; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<!-- Page Loader -->
<div id="page-loader">
    <div class="loader-ring"></div>
    <span class="loader-text">Loading...</span>
</div>

<script>
(function() {
    // Hide the loader once page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('page-loader').classList.add('hidden');
        }, 300);
    });
    // Show loader only for real page navigations
    document.addEventListener('click', function(e) {
        var target = e.target.closest('a');
        if (!target) return;

        var rawHref = target.getAttribute('href');

        // Skip if: no href, just "#", starts with "#", javascript:, has data-bs-toggle (dropdown/modal), or opens in new tab
        if (!rawHref) return;
        if (rawHref === '#' || rawHref.startsWith('#')) return;
        if (rawHref.startsWith('javascript')) return;
        if (target.hasAttribute('data-bs-toggle')) return;
        if (target.hasAttribute('data-bs-dismiss')) return;
        if (target.hasAttribute('download')) return;
        if (rawHref.includes('download')) return;
        if (target.target === '_blank') return;

        document.getElementById('page-loader').classList.remove('hidden');
    });
})();
</script>
