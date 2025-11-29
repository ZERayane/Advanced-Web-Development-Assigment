<?php
// test_connection.php
require_once 'db_connect.php';

try {
    $pdo = getDatabaseConnection();
    echo "<h1 style='color: green;'>Connection successful! ✅</h1>";
    echo "<p>Database: " . DB_NAME . "</p>";
    echo "<p>Host: " . DB_HOST . "</p>";
    
    // Test supplémentaire : lister les tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Tables in database:</h3>";
    if (empty($tables)) {
        echo "<p>No tables found.</p>";
    } else {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<h1 style='color: red;'>Connection failed! ❌</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>