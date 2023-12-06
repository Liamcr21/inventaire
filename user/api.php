<?php

$apiUrl = 'http://vps-a47222b1.vps.ovh.net:4242student';

$response = file_get_contents($apiUrl);

$students = json_decode($response, true);

if (!$students) {
    die('Erreur lors de la récupération des données depuis l\'API.');
}

$dsn = 'mysql:host=;dbname=student_ids_db;charset=utf8';
$username = '';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

$pdo->exec("
    CREATE TABLE IF NOT EXISTS student_ids (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INTEGER NOT NULL UNIQUE
    )
");

$stmt = $pdo->prepare("INSERT IGNORE INTO student_ids (student_id) VALUES (:student_id)");

foreach ($students as $student) {
    $stmt->bindParam(':student_id', $student['id']);
    $stmt->execute();
}

echo 'Les identifiants des étudiants ont été insérés dans la base de données.';

?>
