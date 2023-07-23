<?php
// Vérification si l'ID de l'enregistrement à modifier est présent dans l'URL
if (isset($_GET['id'])) {
    // Récupération de l'ID de l'enregistrement
    $id = $_GET['id'];

    // Connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "nom_utilisateur";
    $motDePasse = "mot_de_passe";
    $nomBaseDeDonnees = "nom_base_de_donnees";

    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

    // Vérification de la connexion
    if (!$connexion) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Récupérer les données de l'enregistrement à modifier
    $requete = "SELECT * FROM table_frais WHERE id = '$id'";
    $resultat = mysqli_query($connexion, $requete);

    // Vérifier si l'enregistrement existe
    if (mysqli_num_rows($resultat) > 0) {
        $ligne = mysqli_fetch_assoc($resultat);
        // Maintenant, vous pouvez utiliser les valeurs de $ligne pour pré-remplir le formulaire de modification
        // Afficher le formulaire ici et pré-remplir les champs avec les valeurs actuelles
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un enregistrement</title>
</head>
<body>
    <h1>Modifier un enregistrement</h1>
    <form action="traitement_modifier.php" method="post">
        <!-- Champ caché pour conserver l'ID de l'enregistrement à modifier -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <!-- Affichez les autres champs du formulaire ici et pré-remplissez-les avec les valeurs actuelles -->
        <!-- Exemple : -->
        <label for="type">Type de frais :</label>
        <input type="text" name="type" value="<?php echo $ligne['id_type']; ?>"><br>

        <label for="montantHT">Montant HT :</label>
        <input type="text" name="montantHT" value="<?php echo $ligne['montant']; ?>"><br>

        <label for="motif">Motif :</label>
        <input type="text" name="motif" value="<?php echo $ligne['motif']; ?>"><br>

        <label for="date_payement">Date de paiement :</label>
        <input type="date" name="date_payement" value="<?php echo $ligne['date_payement']; ?>"><br>

        <input type="submit" value="Modifier">
    </form>
</body>
</html>

<?php
    } else {
        echo "L'enregistrement avec l'ID $id n'existe pas.";
    }

    // Fermer la connexion à la base de données
    mysqli_close($connexion);
} else {
    echo "L'ID de l'enregistrement à modifier n'a pas été spécifié.";
}
?>
