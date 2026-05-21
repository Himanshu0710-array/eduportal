<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

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
    var hideLoader = function() {
        var loader = document.getElementById('page-loader');
        if (loader) {
            setTimeout(function() { loader.classList.add('hidden'); }, 300);
        }
    };
    if (document.readyState === 'complete') {
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader);
    }
    
    document.addEventListener('click', function(e) {
        var target = e.target.closest('a');
        if (!target) return;
        var rawHref = target.getAttribute('href');
        if (!rawHref) return;
        if (rawHref === '#' || rawHref.startsWith('#')) return;
        if (rawHref.startsWith('javascript')) return;
        if (target.hasAttribute('data-bs-toggle') || target.hasAttribute('data-bs-dismiss')) return;
        if (target.hasAttribute('download') || rawHref.includes('download')) return;
        if (target.target === '_blank') return;
        
        var loader = document.getElementById('page-loader');
        if (loader) loader.classList.remove('hidden');
    });
})();
</script>

</body>
</html>
