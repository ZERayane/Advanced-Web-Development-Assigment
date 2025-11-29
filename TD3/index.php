<?php
// index.php - Page d'accueil du projet
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RayaneProject - Système de Gestion de Présence</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .modules {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 40px;
        }
        
        .module-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
            text-decoration: none;
            color: inherit;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: white;
        }
        
        .module-icon {
            font-size: 3rem;
            color: #4361ee;
            margin-bottom: 15px;
        }
        
        .module-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d3748;
        }
        
        .module-desc {
            color: #718096;
            line-height: 1.5;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        
        .exercises {
            background: #f1f3f4;
            padding: 30px;
            margin: 20px;
            border-radius: 10px;
        }
        
        .exercises h3 {
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        .exercise-list {
            list-style: none;
        }
        
        .exercise-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .exercise-list li:before {
            content: "✅ ";
            margin-right: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-complete {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .status-test {
            background: #fed7d7;
            color: #742a2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 RayaneProject</h1>
            <p>Système de Gestion de Présence des Étudiants</p>
        </div>
        
        <div class="modules">
            <a href="add_student.php" class="module-card">
                <div class="module-icon">👨‍🎓</div>
                <div class="module-title">Gestion des Étudiants</div>
                <div class="module-desc">Ajouter, modifier et supprimer des étudiants</div>
            </a>
            
            <a href="take_attendance.php" class="module-card">
                <div class="module-icon">📋</div>
                <div class="module-title">Prise de Présence</div>
                <div class="module-desc">Gérer les présences des étudiants</div>
            </a>
            
            <a href="create_session.php" class="module-card">
                <div class="module-icon">🕐</div>
                <div class="module-title">Sessions de Cours</div>
                <div class="module-desc">Créer et fermer les sessions</div>
            </a>
            
            <a href="list_students.php" class="module-card">
                <div class="module-icon">📊</div>
                <div class="module-title">Rapports</div>
                <div class="module-desc">Voir les statistiques et listes</div>
            </a>
            
            <a href="test_connection.php" class="module-card">
                <div class="module-icon">🔗</div>
                <div class="module-title">Test Connexion DB</div>
                <div class="module-desc">Vérifier la connexion base de données</div>
            </a>
            
            <a href="test_sessions.php" class="module-card">
                <div class="module-icon">🧪</div>
                <div class="module-title">Tests Sessions</div>
                <div class="module-desc">Insérer des sessions de test</div>
            </a>
        </div>
        
        <div class="exercises">
            <h3>📚 Progression des Exercices TD</h3>
            <ul class="exercise-list">
                <li>Exercice 1: add_student.php avec JSON <span class="status-badge status-complete">Terminé</span></li>
                <li>Exercice 2: take_attendance.php avec fichiers JSON <span class="status-badge status-complete">Terminé</span></li>
                <li>Exercice 3: Configuration et connexion DB <span class="status-badge status-complete">Terminé</span></li>
                <li>Exercice 4: CRUD Students avec MySQL <span class="status-badge status-complete">Terminé</span></li>
                <li>Exercice 5: Gestion des sessions de présence <span class="status-badge status-complete">Terminé</span></li>
                <li>Exercice 5: Tests sessions (2-3 sessions) <span class="status-badge status-test">À tester</span></li>
            </ul>
        </div>
        
        <div class="footer">
            <p>Développé avec PHP, MySQL et ❤️ | RayaneProject © 2024</p>
        </div>
    </div>
</body>
</html>