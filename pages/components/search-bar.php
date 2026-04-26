<?php
require_once __DIR__ . '/../../db_connection.php';
?>
<form class="search-bar" method="get" action="#">
    <div>
        <label>DESTINATION</label>
        <input type="text" name="destination" placeholder="Where to, explorer?">
    </div>
    <div>
        <label>DATE SELECTION</label>
        <input type="date" name="date">
    </div>
    <button type="submit">SEARCH &rarr;</button>
</form>
