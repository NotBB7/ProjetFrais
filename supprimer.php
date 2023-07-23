<?php
// Vérification si l'ID de l'enregistrement à supprimer est présent dans l'URL
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

    // Supprimer l'enregistrement de la table des frais
    $requete = "DELETE FROM table_frais WHERE id = '$id'";
    if (mysqli_query($connexion, $requete)) {
        echo "L'enregistrement avec l'ID $id a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'enregistrement : " . mysqli_error($connexion);
    }

    // Fermer la connexion à la base de données
    mysqli_close($connexion);
} else {
    echo "L'ID de l'enregistrement à supprimer n'a pas été spécifié.";
}
?>
