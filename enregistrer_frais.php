<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "1234";
$nomBaseDeDonnees = "projeta";

$connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

// Vérification de la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupération des données du formulaire
$type = $_POST['type'];
$montantHT = floatval($_POST['montantHT']); // Convertit en nombre décimal pour éviter les problèmes de format
$montantTTC = floatval($_POST['montantTTC']); // Récupère le montant TTC depuis le formulaire (calculé en JavaScript)
$motif = $_POST['motif'];
$date_payement = $_POST['date_payement'];

// Vérification du fichier joint (justificatif)
if ($_FILES['justificatif']['error'] === UPLOAD_ERR_OK) {
    $allowedFileTypes = '/\.(jpg|jpeg|png|gif|pdf)$/i';
    $uploadedFileType = $_FILES['justificatif']['type'];

    if (!preg_match($allowedFileTypes, $uploadedFileType)) {
        die("Le type de fichier n'est pas autorisé. Seules les images (JPG, JPEG, PNG, GIF) et les fichiers PDF sont acceptés.");
    }

    // Déplacer le fichier vers le dossier de destination souhaité
    $destination = 'chemin/vers/dossier_destination/' . $_FILES['justificatif']['name'];
    move_uploaded_file($_FILES['justificatif']['tmp_name'], $destination);
} else {
    $destination = ''; // Affecter une valeur par défaut si aucun fichier n'a été joint
}

// Échapper les caractères spéciaux pour éviter les attaques d'injection SQL
$type = mysqli_real_escape_string($connexion, $type);
$montantHT = mysqli_real_escape_string($connexion, $montantHT);
$montantTTC = mysqli_real_escape_string($connexion, $montantTTC);
$motif = mysqli_real_escape_string($connexion, $motif);
$date_payement = mysqli_real_escape_string($connexion, $date_payement);
$destination = mysqli_real_escape_string($connexion, $destination);

// Insérer les données dans la table des frais
$requete = "INSERT INTO expense_report (typ_id, exp_amount_ht, exp_amount_ttc, exp_description, exp_date, exp_proof, emp_id) 
            VALUES ('$type', '$montantHT', '$montantTTC', '$motif', '$date_payement', '$destination')";

// Exécution de la requête
if (mysqli_query($connexion, $requete)) {
    echo "Les frais ont été enregistrés avec succès.";
} else {
    echo "Erreur lors de l'enregistrement des frais : " . mysqli_error($connexion);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
