<?php
// update_student.php
require_once 'db_connect.php';
session_start();

if (!isset($_GET['id'])) {
    header('Location: list_students.php');
    exit;
}

$id = $_GET['id'];
$errors = [];

try {
    $pdo = getDatabaseConnection();
    
    // Récupérer l'étudiant actuel
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        $_SESSION['message'] = "Student not found";
        header('Location: list_students.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = trim($_POST['fullname'] ?? '');
        $matricule = trim($_POST['matricule'] ?? '');
        $group_id = trim($_POST['group_id'] ?? '');

        // Validation
        if (empty($fullname)) $errors[] = "Full name is required";
        if (empty($matricule)) $errors[] = "Matricule is required";
        if (empty($group_id)) $errors[] = "Group is required";

        if (empty($errors)) {
            // Vérifier si le matricule existe déjà (pour un autre étudiant)
            $stmt = $pdo->prepare("SELECT id FROM students WHERE matricule = ? AND id != ?");
            $stmt->execute([$matricule, $id]);
            
            if ($stmt->fetch()) {
                $errors[] = "Matricule already exists for another student";
            } else {
                // Mettre à jour l'étudiant
                $stmt = $pdo->prepare("UPDATE students SET fullname = ?, matricule = ?, group_id = ? WHERE id = ?");
                $stmt->execute([$fullname, $matricule, $group_id, $id]);
                
                $_SESSION['message'] = "Student updated successfully!";
                header('Location: list_students.php');
                exit;
            }
        }
    }
    
} catch (Exception $e) {
    $errors[] = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student - Rayane Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .error { color: red; margin-bottom: 10px; }
        .btn-cancel { background: #6c757d; }
    </style>
</head>
<body>
    <h1>Update Student</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required 
                   value="<?= htmlspecialchars($_POST['fullname'] ?? $student['fullname']) ?>">
        </div>

        <div class="form-group">
            <label for="matricule">Matricule:</label>
            <input type="text" id="matricule" name="matricule" required 
                   value="<?= htmlspecialchars($_POST['matricule'] ?? $student['matricule']) ?>">
        </div>

        <div class="form-group">
            <label for="group_id">Group:</label>
            <input type="text" id="group_id" name="group_id" required 
                   value="<?= htmlspecialchars($_POST['group_id'] ?? $student['group_id']) ?>">
        </div>

        <button type="submit">Update Student</button>
        <a href="list_students.php" class="btn btn-cancel" style="text-decoration: none;">Cancel</a>
    </form>
</body>
</html>