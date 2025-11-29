<?php
// add_student.php
session_start();

// Fonction pour charger les étudiants depuis le fichier JSON
function loadStudents() {
    if (file_exists('students.json')) {
        $data = file_get_contents('students.json');
        return json_decode($data, true) ?: [];
    }
    return [];
}

// Fonction pour sauvegarder les étudiants
function saveStudents($students) {
    file_put_contents('students.json', json_encode($students, JSON_PRETTY_PRINT));
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $group = trim($_POST['group'] ?? '');

    $errors = [];

    // Validation
    if (empty($student_id)) {
        $errors[] = "Student ID is required";
    }
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($group)) {
        $errors[] = "Group is required";
    }

    if (empty($errors)) {
        // Charger les étudiants existants
        $students = loadStudents();

        // Vérifier si l'ID existe déjà
        foreach ($students as $student) {
            if ($student['student_id'] === $student_id) {
                $errors[] = "Student ID already exists";
                break;
            }
        }

        if (empty($errors)) {
            // Ajouter le nouvel étudiant
            $newStudent = [
                'student_id' => $student_id,
                'name' => $name,
                'group' => $group
            ];

            $students[] = $newStudent;
            saveStudents($students);

            $_SESSION['message'] = "Student added successfully!";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$students = loadStudents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Rayane Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        .student-list { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Add New Student</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required 
                   value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required 
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="group">Group:</label>
            <input type="text" id="group" name="group" required 
                   value="<?= htmlspecialchars($_POST['group'] ?? '') ?>">
        </div>

        <button type="submit">Add Student</button>
    </form>

    <div class="student-list">
        <h2>Existing Students (<?= count($students) ?>)</h2>
        <?php if (!empty($students)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['student_id']) ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['group']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found.</p>
        <?php endif; ?>
    </div>
</body>
</html>