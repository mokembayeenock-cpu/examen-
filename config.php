<?php
// Configuration pour Render
error_reporting(0);
ini_set('display_errors', 0);

// Récupérer les variables d'environnement Render
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'plateforme_examens');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// URL du site
$protocol = 'https';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('SITE_URL', $protocol . '://' . $host . '/');
define('SITE_NAME', 'Plateforme Examens');
define('ADMIN_EMAIL', 'administrateur@gmail.com');

// Chemins
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('PHOTO_DIR', UPLOAD_DIR . 'photos/');
define('MAX_PHOTO_SIZE', 2048);

// Créer dossiers si nécessaire
if (!is_dir(UPLOAD_DIR)) @mkdir(UPLOAD_DIR, 0777, true);
if (!is_dir(PHOTO_DIR)) @mkdir(PHOTO_DIR, 0777, true);

// Timezone
date_default_timezone_set('Africa/Porto-Novo');

// Connexion MySQL
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4;port=3306",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // En production sur Render, ne pas afficher l'erreur
    error_log("Erreur BDD: " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
