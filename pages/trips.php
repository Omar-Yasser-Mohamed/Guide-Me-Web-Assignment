<?php
require_once __DIR__ . '/../db_connection.php';
    $pageTitle = "Trips";
    include 'header.php'; 
?>

<div class="trips-container">
    <!-- Sidebar Filters -->
    <aside class="filters-sidebar" id="filters-sidebar">
        <button class="filter-close" id="filter-close">&times;</button>
        <div class="sidebar-subtitle">CURATOR FILTERS</div>
        <h3>Refine Journey</h3>
        
        <form action="trips.php" method="GET">
            <div class="filter-group">
                <span class="filter-label">Destination</span>
                <div class="custom-select" id="destination-select">
                    <div class="select-trigger">
                        <span id="selected-destination"><?php echo isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : 'All Sacred Sites'; ?></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div class="select-options">
                        <div class="option <?php echo (empty($_GET['destination']) || $_GET['destination'] == 'All Sacred Sites') ? 'active' : ''; ?>" data-value="All Sacred Sites">All Sacred Sites</div>
                        <?php
                            $locSql = "SELECT name FROM locations";
                            $locResult = $conn->query($locSql);
                            if ($locResult->num_rows > 0) {
                                while($loc = $locResult->fetch_assoc()) {
                                    $selected = (isset($_GET['destination']) && $_GET['destination'] == $loc['name']) ? 'active' : '';
                                    echo '<div class="option ' . $selected . '" data-value="' . htmlspecialchars($loc['name']) . '">' . htmlspecialchars($loc['name']) . '</div>';
                                }
                            }
                        ?>
                    </div>
                    <input type="hidden" name="destination" id="destination-input" value="<?php echo (!empty($_GET['destination'])) ? htmlspecialchars($_GET['destination']) : 'All Sacred Sites'; ?>">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-header">
                    <span class="filter-label">Max Budget</span>
                    <span class="price-pill" id="price-display">$<?php echo isset($_GET['budget']) ? number_format($_GET['budget']) : '500'; ?></span>
                </div>
                <div class="range-container">
                    <input type="range" name="budget" class="range-slider" id="budget-slider" min="50" max="1000" step="10" value="<?php echo isset($_GET['budget']) ? htmlspecialchars($_GET['budget']) : '500'; ?>">
                </div>
            </div>

            <div class="filter-group">
                <span class="filter-label">Departure Period</span>
                <input type="date" name="date" class="filter-input" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>" style="box-sizing: border-box; max-width: 100%;">
            </div>

            <button type="submit" class="btn-apply">Apply Filter</button>
            <a href="trips.php" style="display: block; text-align: center; margin-top: 15px; color: var(--gold); text-decoration: none; font-size: 0.8rem; letter-spacing: 1px;">CLEAR ALL</a>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="catalog-main">
        <header class="catalog-header">
            <div class="catalog-title-group">
                <div class="subtitle">DISCOVERY CATALOGUE</div>
                <h2>The Eternal Collection</h2>
                <?php
                    // Fetch count with filters
                    $whereClauses = ["t.status = 'active'"];
                    if (!empty($_GET['destination']) && $_GET['destination'] !== 'All Sacred Sites') {
                        $dest = $conn->real_escape_string($_GET['destination']);
                        $whereClauses[] = "l.name = '$dest'";
                    }
                    if (isset($_GET['budget'])) {
                        $budget = (float)$_GET['budget'];
                        $whereClauses[] = "(t.base_price + t.logistics_price) <= $budget";
                    }
                    if (isset($_GET['date']) && !empty($_GET['date'])) {
                        $date = $conn->real_escape_string($_GET['date']);
                        $whereClauses[] = "DATE(t.date) = '$date'";
                    }
                    $whereSqlCount = implode(' AND ', $whereClauses);

                    $countSql = "SELECT COUNT(*) as total FROM trips t LEFT JOIN locations l ON t.location_id = l.id WHERE $whereSqlCount";
                    $countResult = $conn->query($countSql);
                    $totalCount = $countResult->fetch_assoc()['total'];
                ?>
                <div class="results-count">Showing <?php echo min($totalCount, 6); ?> of <?php echo $totalCount; ?> curated experiences</div>
            </div>
            <button class="filter-toggle-btn" id="filter-toggle">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                Filters
            </button>
        </header>

        <div class="journeys">
            <?php
                // Build Filter Query
                $whereClauses = ["t.status = 'active'"];
                
                if (!empty($_GET['destination']) && $_GET['destination'] !== 'All Sacred Sites') {
                    $dest = $conn->real_escape_string($_GET['destination']);
                    $whereClauses[] = "l.name = '$dest'";
                }
                
                if (isset($_GET['budget'])) {
                    $budget = (float)$_GET['budget'];
                    $whereClauses[] = "(t.base_price + t.logistics_price) <= $budget";
                }

                if (isset($_GET['date']) && !empty($_GET['date'])) {
                    $date = $conn->real_escape_string($_GET['date']);
                    $whereClauses[] = "DATE(t.date) = '$date'";
                }

                $whereSql = implode(' AND ', $whereClauses);

                // Pagination logic
                $itemsPerPage = 6;
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($currentPage < 1) $currentPage = 1;
                $offset = ($currentPage - 1) * $itemsPerPage;

                // Fetch trips with location name, average rating, and pagination
                $sql = "SELECT t.*, l.name as location_name, 
                       (SELECT AVG(rating) FROM reviews r 
                        JOIN bookings b ON r.booking_id = b.id 
                        WHERE b.trip_id = t.id) as avg_rating
                        FROM trips t
                        LEFT JOIN locations l ON t.location_id = l.id
                        WHERE $whereSql 
                        LIMIT $itemsPerPage OFFSET $offset";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($trip = $result->fetch_assoc()) {
                        $id = $trip['id'];
                        $title = $trip['title'];
                        $image = $trip['image'];
                        $location = $trip['location_name'];
                        $price = $trip['base_price'] + $trip['logistics_price'];
                        $description = $trip['description'];
                        $rating = number_format($trip['avg_rating'], 1);
                        if ($rating == 0) $rating = 'New';
                        include 'components/trip-card.php';
                    }
                } else {
                    echo "<p>No trips found matching your criteria.</p>";
                }
            ?>
        </div>

        <div class="pagination">
            <?php
                $totalPages = ceil($totalCount / $itemsPerPage);
                
                // Helper to build page URL
                function getPageUrl($pageNum) {
                    $params = $_GET;
                    $params['page'] = $pageNum;
                    return 'trips.php?' . http_build_query($params);
                }

                if ($totalPages > 1):
                    // Previous Arrow
                    if ($currentPage > 1) {
                        echo '<a href="' . getPageUrl($currentPage - 1) . '" class="page-arrow" data-link>&lsaquo;</a>';
                    } else {
                        echo '<a href="#" class="page-arrow disabled" style="opacity: 0.5; pointer-events: none;">&lsaquo;</a>';
                    }

                    // Page Numbers
                    for ($p = 1; $p <= $totalPages; $p++) {
                        $active = ($p == $currentPage) ? 'active' : '';
                        echo '<a href="' . getPageUrl($p) . '" class="page-num ' . $active . '" data-link>' . sprintf("%02d", $p) . '</a>';
                    }

                    // Next Arrow
                    if ($currentPage < $totalPages) {
                        echo '<a href="' . getPageUrl($currentPage + 1) . '" class="page-arrow" data-link>&rsaquo;</a>';
                    } else {
                        echo '<a href="#" class="page-arrow disabled" style="opacity: 0.5; pointer-events: none;">&rsaquo;</a>';
                    }
                endif;
            ?>
        </div>
    </main>
</div>

<script>
    window.initFilters = function() {
        // Dynamic Budget Slider Update
        const slider = document.getElementById('budget-slider');
        const display = document.getElementById('price-display');

        if (slider && display) {
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
                const display = document.getElementById('selected-destination');

                // Initialize display and active option based on current input value
                const currentDestination = input.value;
                display.textContent = currentDestination;
                options.forEach(opt => {
                    opt.classList.remove('active');
                    if (opt.getAttribute('data-value') === currentDestination) {
                        opt.classList.add('active');
                    }
                });

                // Remove existing listeners to prevent duplicates
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
    }

    // Call it immediately since this script executes on load/navigation
    initFilters();
</script>

<?php include 'footer.php'; ?>
