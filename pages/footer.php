<?php
require_once __DIR__ . '/../db_connection.php';
?>
            </main>
        </div>

        <div class="footer">
            <div class="footer-content">
                <div>
                    <div class="logo" style="color:#ffe082;">GUID ME</div>
                    <div style="font-size:0.9rem; color:#bbb; margin-top:4px;">© 2024 GUID ME. CURATING HISTORY WITH PRECISION.</div>
                </div>
                <div class="footer-links">
                    <a href="#">PRIVACY POLICY</a>
                    <a href="#">TERMS OF SERVICE</a>
                    <a href="#">CONTACT CURATOR</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" style="position: fixed; top: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;"></div>

    <script>
        // Move initFilters logic here as a fallback or if it's called globally
        window.initFilters = function() {
            // Check if we have the necessary elements
            if (!document.getElementById('budget-slider')) return;
            
            // Re-run the slider logic
            const slider = document.getElementById('budget-slider');
            const display = document.getElementById('price-display');
            if (slider && display) {
                slider.oninput = function() {
                    display.textContent = `$${parseInt(this.value).toLocaleString()}`;
                };
            }
        };

        // Global Toast Function
        window.showToast = function(message, type = 'error') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? '#10B981' : '#EF4444';
            const icon = type === 'success' ? '✅' : '⚠️';
            
            toast.style.cssText = `
                background: white;
                color: #1A1A1A;
                padding: 16px 24px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                border-left: 4px solid ${bgColor};
                display: flex;
                align-items: center;
                gap: 12px;
                font-family: 'Inter', sans-serif;
                font-size: 0.95rem;
                min-width: 300px;
                transform: translateX(120%);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            `;
            
            toast.innerHTML = `<span style="font-size: 1.2rem;">${icon}</span> <span>${message}</span>`;
            container.appendChild(toast);
            
            // Animate in
            setTimeout(() => toast.style.transform = 'translateX(0)', 10);
            
            // Auto remove
            setTimeout(() => {
                toast.style.transform = 'translateX(120%)';
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        };

        // Reusable Navigation Function
        function navigateTo(url, options = {}) {
            const mainContent = document.getElementById('main-content');
            if (!mainContent) {
                window.location.href = url;
                return;
            }

            // Start fade out
            mainContent.style.opacity = '0';
            mainContent.style.transform = 'translateY(10px)';

            const fetchOptions = {
                method: options.method || 'GET',
                body: options.body || null
            };

            setTimeout(() => {
                fetch(url, fetchOptions)
                    .then(response => {
                        if (!response.ok && options.method === 'POST') {
                            return response.text().then(text => { throw new Error(text) });
                        }
                        
                        if (options.method === 'POST' && response.redirected) {
                            return navigateTo(response.url);
                        }
                        return response.text();
                    })
                    .then(html => {
                        if (!html) return;

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContentElement = doc.getElementById('main-content');
                        
                        if (!newContentElement && options.method === 'POST') {
                            const cleanText = html.replace(/<[^>]*>/g, '').trim();
                            if (cleanText.length < 200) {
                                window.showToast(cleanText, 'error');
                                mainContent.style.opacity = '1';
                                mainContent.style.transform = 'translateY(0)';
                                return;
                            }
                        }

                        if (!newContentElement) {
                            window.location.href = url;
                            return;
                        }

                        const newContent = newContentElement.innerHTML;
                        const newTitle = doc.title;

                        mainContent.innerHTML = newContent;
                        document.title = newTitle;
                        document.body.style.overflow = '';

                        document.querySelectorAll('.nav-link').forEach(nl => {
                            nl.classList.remove('active');
                            try {
                                const nlUrl = new URL(nl.href);
                                const targetUrl = new URL(url, window.location.origin);
                                if (nlUrl.pathname === targetUrl.pathname) nl.classList.add('active');
                            } catch(e) {}
                        });

                        if (!options.method || options.method === 'GET') {
                            history.pushState(null, null, url);
                        }

                        const scripts = mainContent.querySelectorAll('script');
                        scripts.forEach(oldScript => {
                            const newScript = document.createElement('script');
                            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                            if (oldScript.src) {
                                newScript.src = oldScript.src;
                            } else {
                                newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                            }
                            document.body.appendChild(newScript);
                            newScript.parentNode.removeChild(newScript);
                        });

                        mainContent.style.opacity = '1';
                        mainContent.style.transform = 'translateY(0)';
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    })
                    .catch(err => {
                        console.error('Navigation failed:', err);
                        window.showToast(err.message || 'Something went wrong', 'error');
                        mainContent.style.opacity = '1';
                        mainContent.style.transform = 'translateY(0)';
                    });
            }, 300);
        }

        document.addEventListener('click', e => {
            const link = e.target.closest('[data-link]');
            if (link) {
                e.preventDefault();
                navigateTo(link.href);
            }
        });

        document.addEventListener('submit', e => {
            const form = e.target;
            const method = form.method.toUpperCase();
            const action = form.action || window.location.href;

            if (form.hasAttribute('data-no-ajax')) return;

            e.preventDefault();
            const formData = new FormData(form);

            if (method === 'GET') {
                const params = new URLSearchParams(formData);
                navigateTo(action.split('?')[0] + '?' + params.toString());
            } else {
                navigateTo(action, {
                    method: 'POST',
                    body: formData
                });
            }
        });

        window.addEventListener('popstate', () => {
            location.reload(); 
        });

        if (window.location.href.includes('trips.php')) {
            window.initFilters();
        }

        // Global Success/Error/Msg Handler
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('msg')) {
            window.showToast(urlParams.get('msg'), 'success');
        } else if (urlParams.has('success')) {
            window.showToast('Action completed successfully!', 'success');
        } else if (urlParams.has('error')) {
            const errorMsg = urlParams.get('error');
            const errorMap = {
                'invalid_guests': 'Guest count exceeds capacity.',
                'db_error': 'A database error occurred.',
                'auth_required': 'Please login to continue.',
                'invalid_id': 'Invalid trip ID selected.'
            };
            window.showToast(errorMap[errorMsg] || errorMsg, 'error');
        }
    </script>
</body>
</html>
