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

    <script>
        document.addEventListener('click', e => {
            const link = e.target.closest('[data-link]');
            if (link) {
                e.preventDefault();
                const url = link.href;
                
                // Start fade out
                const mainContent = document.getElementById('main-content');
                mainContent.style.opacity = '0';
                mainContent.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContent = doc.getElementById('main-content').innerHTML;
                            const newTitle = doc.title;

                            // Update content and title
                            mainContent.innerHTML = newContent;
                            document.title = newTitle;

                            // Update active link
                            document.querySelectorAll('.nav-link').forEach(nl => {
                                nl.classList.remove('active');
                                if (nl.href === url) nl.classList.add('active');
                            });

                            // Update URL
                            history.pushState(null, null, url);

                            // Fade back in
                            mainContent.style.opacity = '1';
                            mainContent.style.transform = 'translateY(0)';
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                }, 300);
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', () => {
            location.reload(); // Simple way to handle back/forward for this demo
        });
    </script>
</body>
</html>
