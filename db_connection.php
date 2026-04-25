<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "guid_me";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connection Interrupted - GUID ME</title>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body { 
                margin: 0; 
                padding: 0; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                height: 100vh; 
                background: #FDF8F0; 
                font-family: "Inter", sans-serif;
                color: #1A1A1A;
            }
            .error-container { 
                text-align: center; 
                padding: 40px;
                max-width: 400px;
            }
            .icon { 
                font-size: 64px; 
                margin-bottom: 24px; 
                display: block;
            }
            h1 { 
                font-family: "Playfair Display", serif; 
                font-size: 2.5rem; 
                margin: 0 0 16px 0; 
            }
            p { 
                color: #666; 
                line-height: 1.6; 
                margin-bottom: 32px; 
            }
            .btn-retry {
                background: #E9C46A;
                color: #1A1A1A;
                padding: 16px 32px;
                border-radius: 12px;
                text-decoration: none;
                font-weight: 600;
                display: inline-block;
                transition: transform 0.2s;
                border: none;
                cursor: pointer;
            }
            .btn-retry:hover { 
                transform: scale(1.02); 
                background: #e6c15c;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <span class="icon">🏛️</span>
            <h1>Sanctuary Offline</h1>
            <p>Our digital archives are currently unreachable. Please ensure your connection to the local site is active.</p>
            <button onclick="window.location.reload()" class="btn-retry">Attempt Reconnection</button>
        </div>
    </body>
    </html>';
    exit;
}

$conn->set_charset("utf8mb4");

?>