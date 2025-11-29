<?php
// database/init_database.php
require_once '../db_connect.php';

try {
    $pdo = getDatabaseConnection();
    
    // Créer la table students
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        matricule VARCHAR(20) UNIQUE NOT NULL,
        group_id VARCHAR(10) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table 'students' created successfully!<br>";
    
    // Insérer des données d'exemple
    $sampleData = [
        ['John Doe', 'STD001', 'G1'],
        ['Jane Smith', 'STD002', 'G1'],
        ['Mike Johnson', 'STD003', 'G2']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO students (fullname, matricule, group_id) VALUES (?, ?, ?)");
    
    foreach ($sampleData as $data) {
        $stmt->execute($data);
    }
    
    echo "Sample data inserted successfully!<br>";
    echo "<a href='../list_students.php'>View Students</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>