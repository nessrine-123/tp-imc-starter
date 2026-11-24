<?php
require_once 'connexion.php';

// TODO 1 : vérifier que id existe et est un entier valide
$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);

if ($id !== false && $id > 0) {
    // TODO 2 : requête préparée
    $stmt = $pdo->prepare("DELETE FROM mesures WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// TODO 3 : redirection vers index.php
header("Location: index.php");
exit;