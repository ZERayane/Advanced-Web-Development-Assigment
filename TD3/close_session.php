<?php
// close_session.php
require_once 'db_connect.php';
session_start();

if (!isset($_GET['id'])) {
    header('Location: create_session.php');
    exit;
}

$id = $_GET['id'];

try {
    $pdo = getDatabaseConnection();
    
    // Vérifier si la session existe et est ouverte
    $stmt = $pdo->prepare("SELECT * FROM attendance_sessions WHERE id = ? AND status = 'open'");
    $stmt->execute([$id]);
    $session = $stmt->fetch();
    
    if (!$session) {
        $_SESSION['message'] = "Session not found or already closed";
    } else {
        // Fermer la session
        $stmt = $pdo->prepare("UPDATE attendance_sessions SET status = 'closed', closed_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['message'] = "Session closed successfully!";
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = "Error closing session: " . $e->getMessage();
}

header('Location: create_session.php');
exit;
?>