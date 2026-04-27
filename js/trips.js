window.initFilters = function() {
    // Dynamic Budget Slider Update
    const slider = document.getElementById('budget-slider');
    const display = document.getElementById('price-display');

    if (slider && display) {
        // Use 'input' for real-time update
        slider.addEventListener('input', function() {
            const val = parseInt(this.value).toLocaleString();
            display.textContent = `$${val}`;
        });
    }

    // Custom Select Logic
    const customSelect = document.getElementById('destination-select');
    if (customSelect) {
        const trigger = customSelect.querySelector('.select-trigger');
        const options = customSelect.querySelectorAll('.option');
        const input = document.getElementById('destination-input');
        const displaySelected = document.getElementById('selected-destination');

        // Initialize display and active option based on current input value
        const currentDestination = input.value;
        displaySelected.textContent = currentDestination;
        options.forEach(opt => {
            opt.classList.remove('active');
            if (opt.getAttribute('data-value') === currentDestination) {
                opt.classList.add('active');
            }
        });

        // Remove existing listeners to prevent duplicates (important for AJAX navigation)
        const newTrigger = trigger.cloneNode(true);
        trigger.parentNode.replaceChild(newTrigger, trigger);
        
        const newDisplay = newTrigger.querySelector('#selected-destination');

        newTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            customSelect.classList.toggle('open');
        });

        options.forEach(opt => {
            opt.addEventListener('click', (e) => {
                e.stopPropagation();
                const val = opt.getAttribute('data-value');
                newDisplay.textContent = val;
                input.value = val;
                
                options.forEach(o => o.classList.remove('active'));
                opt.classList.add('active');
                
                customSelect.classList.remove('open');
            });
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!customSelect.contains(e.target)) {
                customSelect.classList.remove('open');
            }
        });
    }

    // Mobile Filter Toggle
    const filterToggle = document.getElementById('filter-toggle');
    const filterClose = document.getElementById('filter-close');
    const sidebar = document.getElementById('filters-sidebar');

    if (filterToggle && sidebar) {
        filterToggle.onclick = () => {
            sidebar.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
    }

    if (filterClose && sidebar) {
        filterClose.onclick = () => {
            sidebar.classList.remove('active');
            document.body.style.overflow = '';
        };
    }
};

// Call it immediately if we are on the trips page
if (document.getElementById('filters-sidebar')) {
    initFilters();
}
