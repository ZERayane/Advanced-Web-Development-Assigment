<?php
// take_attendance.php
session_start();

// Fonction pour charger les étudiants
function loadStudents() {
    if (file_exists('students.json')) {
        $data = file_get_contents('students.json');
        return json_decode($data, true) ?: [];
    }
    return [];
}

// Vérifier si l'appel de présence d'aujourd'hui existe déjà
$today = date('Y-m-d');
$attendanceFile = "attendance_$today.json";

if (file_exists($attendanceFile)) {
    $message = "Attendance for today has already been taken.";
} else {
    $message = '';
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !file_exists($attendanceFile)) {
    $attendance = [];

    foreach ($_POST['attendance'] as $student_id => $status) {
        $attendance[] = [
            'student_id' => $student_id,
            'status' => $status,
            'date' => $today
        ];
    }

    // Sauvegarder l'appel de présence
    file_put_contents($attendanceFile, json_encode($attendance, JSON_PRETTY_PRINT));
    $message = "Attendance for $today has been saved successfully!";
    $attendanceFile = "attendance_$today.json"; // Mettre à jour pour afficher le message
}

$students = loadStudents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance - Rayane Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .attendance-form { margin-top: 20px; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        select { padding: 5px; border-radius: 4px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Take Attendance - <?= date('F j, Y') ?></h1>

    <?php if ($message): ?>
        <div class="message <?= file_exists($attendanceFile) ? 'warning' : 'success' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if (!file_exists($attendanceFile)): ?>
        <?php if (!empty($students)): ?>
            <form method="POST" class="attendance-form">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Group</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['student_id']) ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= htmlspecialchars($student['group']) ?></td>
                                <td>
                                    <select name="attendance[<?= $student['student_id'] ?>]" required>
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="excused">Excused</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">Save Attendance</button>
            </form>
        <?php else: ?>
            <p>No students found. Please <a href="add_student.php">add students</a> first.</p>
        <?php endif; ?>
    <?php else: ?>
        <p><a href="add_student.php">Add more students</a> or check existing attendance files.</p>
    <?php endif; ?>
</body>
</html>