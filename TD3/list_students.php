<?php
// list_students.php
require_once 'db_connect.php';
session_start();

try {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->query("SELECT * FROM students ORDER BY fullname");
    $students = $stmt->fetchAll();
} catch (Exception $e) {
    $students = [];
    $error = "Failed to load students: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Students - Rayane Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        .success { color: green; margin-bottom: 10px; }
        .error { color: red; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .actions a { margin-right: 10px; text-decoration: none; }
        .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; 
               text-decoration: none; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Student List</h1>
    
    <a href="add_student.php" class="btn">Add New Student</a>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($students)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Matricule</th>
                    <th>Group</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><?= htmlspecialchars($student['fullname']) ?></td>
                        <td><?= htmlspecialchars($student['matricule']) ?></td>
                        <td><?= htmlspecialchars($student['group_id']) ?></td>
                        <td><?= date('M j, Y', strtotime($student['created_at'])) ?></td>
                        <td class="actions">
                            <a href="update_student.php?id=<?= $student['id'] ?>">Edit</a>
                            <a href="delete_student.php?id=<?= $student['id'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students found. <a href="add_student.php">Add the first student</a></p>
    <?php endif; ?>
</body>
</html>