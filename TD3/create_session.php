<?php
// create_session.php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = trim($_POST['course_id'] ?? '');
    $group_id = trim($_POST['group_id'] ?? '');
    $opened_by = trim($_POST['opened_by'] ?? '');

    $errors = [];

    // Validation
    if (empty($course_id)) $errors[] = "Course ID is required";
    if (empty($group_id)) $errors[] = "Group ID is required";
    if (empty($opened_by)) $errors[] = "Professor ID is required";

    if (empty($errors)) {
        try {
            $pdo = getDatabaseConnection();
            
            // Créer une nouvelle session
            $stmt = $pdo->prepare("INSERT INTO attendance_sessions (course_id, group_id, date, opened_by, status) VALUES (?, ?, CURDATE(), ?, 'open')");
            $stmt->execute([$course_id, $group_id, $opened_by]);
            
            $session_id = $pdo->lastInsertId();
            
            $_SESSION['message'] = "Session created successfully! Session ID: $session_id";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
            
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// Récupérer les sessions ouvertes
try {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->query("SELECT * FROM attendance_sessions ORDER BY created_at DESC");
    $sessions = $stmt->fetchAll();
} catch (Exception $e) {
    $sessions = [];
    $errors[] = "Failed to load sessions: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Session - Rayane Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        .form-container { display: flex; gap: 40px; }
        .form-section, .sessions-section { flex: 1; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-open { color: green; font-weight: bold; }
        .status-closed { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Create Attendance Session</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="form-container">
        <div class="form-section">
            <h2>New Session</h2>

            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="course_id">Course ID:</label>
                    <input type="text" id="course_id" name="course_id" required 
                           value="<?= htmlspecialchars($_POST['course_id'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="group_id">Group ID:</label>
                    <input type="text" id="group_id" name="group_id" required 
                           value="<?= htmlspecialchars($_POST['group_id'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="opened_by">Professor ID:</label>
                    <input type="text" id="opened_by" name="opened_by" required 
                           value="<?= htmlspecialchars($_POST['opened_by'] ?? '') ?>">
                </div>

                <button type="submit">Create Session</button>
            </form>
        </div>

        <div class="sessions-section">
            <h2>Recent Sessions</h2>
            <?php if (!empty($sessions)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>Group</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $session): ?>
                            <tr>
                                <td><?= $session['id'] ?></td>
                                <td><?= htmlspecialchars($session['course_id']) ?></td>
                                <td><?= htmlspecialchars($session['group_id']) ?></td>
                                <td><?= $session['date'] ?></td>
                                <td class="status-<?= $session['status'] ?>">
                                    <?= ucfirst($session['status']) ?>
                                </td>
                                <td>
                                    <?php if ($session['status'] === 'open'): ?>
                                        <a href="close_session.php?id=<?= $session['id'] ?>">Close</a>
                                    <?php else: ?>
                                        <span style="color: #999;">Closed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No sessions found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>