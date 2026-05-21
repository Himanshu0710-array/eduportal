<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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

<!-- Global Table Scroll Fix -->
<style>
    .table-responsive {
        max-height: 65vh;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
    /* Sticky header for all tables inside table-responsive */
    .table-responsive .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        box-shadow: 0 2px 2px -1px rgba(0,0,0,0.4);
    }
    .table-responsive .table-dark th {
        background-color: #212529 !important;
    }
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var tables = document.querySelectorAll('table.table');
    tables.forEach(function(table) {
        // If the table isn't already inside a table-responsive div, wrap it
        if (!table.parentElement.classList.contains('table-responsive')) {
            var wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        } else {
            // If it is, just ensure it has the max-height styling
            table.parentElement.style.maxHeight = '65vh';
            table.parentElement.style.overflowY = 'auto';
        }
    });
});
</script>

</body>
</html>
