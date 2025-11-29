<?php
// database/init_sessions.php
require_once '../db_connect.php';

try {
    $pdo = getDatabaseConnection();
    
    // Créer la table attendance_sessions
    $sql = "CREATE TABLE IF NOT EXISTS attendance_sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id VARCHAR(20) NOT NULL,
        group_id VARCHAR(10) NOT NULL,
        date DATE NOT NULL,
        opened_by INT NOT NULL,
        status ENUM('open', 'closed') DEFAULT 'open',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        closed_at TIMESTAMP NULL
    )";
    
    $pdo->exec($sql);
    echo "Table 'attendance_sessions' created successfully!<br>";
    
    echo "<a href='../create_session.php'>Create Session</a><br>";
    echo "<a href='../list_students.php'>Manage Students</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>