<?php
require_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO 1 : récupérer les données
    $personne_id = filter_var($_POST['personne_id'] ?? '', FILTER_VALIDATE_INT);
    $poids       = filter_var($_POST['poids'] ?? '', FILTER_VALIDATE_FLOAT);
    $taille      = filter_var($_POST['taille'] ?? '', FILTER_VALIDATE_FLOAT);

    // TODO 2 : validation côté serveur
    if (
        $personne_id !== false && $personne_id > 0 &&
        $poids !== false && $poids >= 20 && $poids <= 300 &&
        $taille !== false && $taille >= 0.5 && $taille <= 2.5
    ) {
        // TODO 3 : calcul de l'IMC et de la catégorie
        $imc = round($poids / ($taille * $taille), 1);

        if ($imc < 18.5) {
            $categorie = "Sous-poids";
        } elseif ($imc < 25) {
            $categorie = "Normal";
        } elseif ($imc < 30) {
            $categorie = "Surpoids";
        } else {
            $categorie = "Obésité";
        }

        // TODO 4 : requête préparée
        $stmt = $pdo->prepare(
            "INSERT INTO mesures (personne_id, poids, taille, imc, categorie)
             VALUES (:personne_id, :poids, :taille, :imc, :categorie)"
        );
        $stmt->execute([
            ':personne_id' => $personne_id,
            ':poids'       => $poids,
            ':taille'      => $taille,
            ':imc'         => $imc,
            ':categorie'   => $categorie,
        ]);
    }
}

// TODO 5 : redirection vers index.php
header("Location: index.php");
exit;