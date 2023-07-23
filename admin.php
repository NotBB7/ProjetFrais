<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        .tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .tag-blue {
            background-color: blue;
            color: white;
        }
        .tag-green {
            background-color: green;
            color: white;
        }
        .tag-red {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Admin Panel - Table des frais</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Type de frais</th>
            <th>Montant HT</th>
            <th>Motif</th>
            <th>Date de paiement</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>

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

        // Récupérer les données de la table des frais
        $requete = "SELECT * FROM expense_report";
        $resultat = mysqli_query($connexion, $requete);

// ... (le code précédent)

// Afficher les données dans le tableau
while ($ligne = mysqli_fetch_assoc($resultat)) {
    echo "<tr>";
    echo "<td>" . $ligne['exp_id'] . "</td>";
    echo "<td>" . $ligne['typ_id'] . "</td>";
    echo "<td>" . $ligne['exp_amount_ttc'] . "</td>";
    echo "<td>" . $ligne['exp_description'] . "</td>";
    echo "<td>" . $ligne['exp_date'] . "</td>";

    // Vérifier le statut et afficher le tag approprié
    $statut = $ligne['sta_id'];
    if ($statut == "En attente") {
        echo "<td class='tag tag-blue'>" . $statut . "</td>";
    } elseif ($statut == "Accepter") {
        echo "<td class='tag tag-green'>" . $statut . "</td>";
    } elseif ($statut == "Supprimer") {
        echo "<td class='tag tag-red'>" . $statut . "</td>";
    } else {
        echo "<td class='tag'>" . $statut . "</td>"; // Si le statut est inconnu ou non spécifié, affiche le statut tel quel
    }

    echo "<td>";
    echo "<a href='modifier.php?id=" . $ligne['id'] . "'>Modifier</a> ";
    echo "<a href='supprimer.php?id=" . $ligne['id'] . "'>Supprimer</a>";
    echo "</td>";
    echo "</tr>";
}

// ... (le reste du code)


        // Fermer la connexion à la base de données
        mysqli_close($connexion);
        ?>
    </table>
</body>
</html>
