<?php
$db = @mysqli_connect(
    getenv('DB_HOST') ?: 'db',
    getenv('DB_USER') ?: 'brehak',
    getenv('DB_PASSWORD') ?: '000502414',
    getenv('DB_DATABASE') ?: 'brehak'
) or die('Error connecting to the database');
?>