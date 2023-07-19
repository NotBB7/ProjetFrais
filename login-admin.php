<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-admin.css">
    <title>Login-Admin</title>
</head>

<body>
    <?php
    // Vos identifiants de connexion MySQL
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "projeta";

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les valeurs du formulaire
        $inputemail = $_POST["email"];
        $inputpassword = $_POST["mot_de_passe"];
        echo 'test';

        // Créer une connexion à la base de données
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier s'il y a une erreur de connexion
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Préparer la requête pour vérifier les identifiants
        $stmt = $conn->prepare("SELECT * FROM administrators WHERE adm_mail = ? AND adm_password = ?");
        $stmt->bind_param("ss", $inputemail, $inputpassword);
        $stmt->execute();

        // Récupérer les résultats de la requête
        $result = $stmt->get_result();

        // Vérifier s'il y a une correspondance dans la base de données
        if ($result->num_rows == 1) {
            // Identifiants corrects, rediriger vers la page d'accueil
            header("Location: admin.php");
            exit();
        } else {
            // Identifiants incorrects
            echo "Identifiants incorrects.";
        }

        // Fermer la connexion à la base de données
        $stmt->close();
        $conn->close();
    }
    ?>

    <div class="login-box">
        <h2>Panel Admin</h2>
        <form method="POST" action="">
            <div class="user-box">
                <input type="email" name="email">
                <label>Adresse-Mail</label>
            </div>
            <div class="user-box">
                <input type="password" name="mot_de_passe">
                <label>Mot-de-passe</label>
            </div>
            <button type="submit" name="submit" value="connexion">Submit
      <span></span>
      <span></span>
      <span></span>
      <span></span>
        </form>
    </div>


</body>

</html>