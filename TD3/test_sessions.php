<?php
// test_sessions.php - Insertion manuelle de sessions de test
require_once 'db_connect.php';

$test_sessions = [
    ['MATH101', 'G1', 1],
    ['PHYS202', 'G2', 2],
    ['INFO301', 'G1', 1]
];

try {
    $pdo = getDatabaseConnection();
    
    echo "<h2>Inserting Test Sessions</h2>";
    
    $stmt = $pdo->prepare("INSERT INTO attendance_sessions (course_id, group_id, date, opened_by, status) VALUES (?, ?, CURDATE(), ?, 'open')");
    
    foreach ($test_sessions as $session) {
        $stmt->execute($session);
        echo "<p>✅ Session created: {$session[0]} - {$session[1]} (Prof: {$session[2]})</p>";
    }
    
    echo "<h3>All Sessions in Database:</h3>";
    $result = $pdo->query("SELECT * FROM attendance_sessions ORDER BY id");
    $sessions = $result->fetchAll();
    
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Course</th><th>Group</th><th>Date</th><th>Status</th><th>Professor</th></tr>";
    foreach ($sessions as $session) {
        echo "<tr>";
        echo "<td>{$session['id']}</td>";
        echo "<td>{$session['course_id']}</td>";
        echo "<td>{$session['group_id']}</td>";
        echo "<td>{$session['date']}</td>";
        echo "<td>{$session['status']}</td>";
        echo "<td>{$session['opened_by']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>