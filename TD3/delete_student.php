<?php
// delete_student.php
require_once 'db_connect.php';
session_start();

if (!isset($_GET['id'])) {
    header('Location: list_students.php');
    exit;
}

$id = $_GET['id'];

try {
    $pdo = getDatabaseConnection();
    
    // Vérifier si l'étudiant existe
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        $_SESSION['message'] = "Student not found";
    } else {
        // Supprimer l'étudiant
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['message'] = "Student deleted successfully!";
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = "Error deleting student: " . $e->getMessage();
}

header('Location: list_students.php');
exit;
?>