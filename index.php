<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <?php
  // Variables pour la connexion à la base de données
  $servername = "localhost";
  $username = "root";
  $password = "1234";
  $database = "projeta";

  // Création d'une connexion à la base de données
  $conn = new mysqli($servername, $username, $password, $database);

  // Vérification de la connexion
  if ($conn->connect_error) {
    die("La connexion à la base de données a échoué: " . $conn->connect_error);
  }

  // Fonction pour valider une adresse email avec une expression régulière
  function validateEmail($email)
  {
    // L'expression régulière pour valider l'adresse email
    $pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    return preg_match($pattern, $email);
  }

  // Fonction pour valider le nom avec une expression régulière
  function validateNom($nom)
  {
    // L'expression régulière pour valider le nom
    $pattern = "/^[a-zA-Z]{3,}$/";
    return preg_match($pattern, $nom);
  }

  // Fonction pour valider le prenom avec une expression régulière
  function validatePrenom($prenom)
  {
    // L'expression régulière pour valider le prenom
    $pattern = "/^[a-zA-Z]{3,}$/";
    return preg_match($pattern, $prenom);
  }

  // Fonction pour valider le mot de passe avec une expression régulière
  function validateMotDePasse($mot_de_passe)
  {
    // L'expression régulière pour valider le mot de passe
    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
    return preg_match($pattern, $mot_de_passe);
  }

  // Fonction pour valider le numéro de téléphone avec une expression régulière
  function validatePhone($phone)
  {
    // L'expression régulière pour valider le numéro de téléphone
    $pattern = "/^[0-9]{10}$/";
    return preg_match($pattern, $phone);
  }

  // Vérification si le formulaire est soumis
  if (isset($_POST['inscription'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($phone) || empty($mot_de_passe)) {
      echo "Veuillez remplir tous les champs.";
    } elseif (!validateEmail($email)) {
      echo "Veuillez entrer une adresse email valide.";
    } elseif (!validatePhone($phone)) {
      echo "Veuillez entrer un numéro de téléphone valide (10 chiffres).";
    } elseif ($mot_de_passe !== $confirm_mot_de_passe) {
      echo "Les mots de passe ne correspondent pas.";
    } else {
      // Vérification si l'email existe déjà dans la base de données
      $query = "SELECT * FROM employees WHERE emp_mail = '$email'";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
      } else {
        // Insertion de l'utilisateur dans la base de données
        $insertQuery = "INSERT INTO employees (emp_lastname, emp_firstname, emp_mail, emp_phonenumber, emp_password) VALUES ('$nom', '$prenom', '$email', '$phone', '$mot_de_passe')";
        if ($conn->query($insertQuery) === TRUE) {
          echo "Inscription réussie.";
        } else {
          echo "Erreur lors de l'inscription: " . $conn->error;
        }
      }
    }
  }

  // Fermeture de la connexion à la base de données
  $conn->close();
  ?>

  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1>Créer son compte</h1>
        <hr />
        <div class="group-input">
          <i class="fas fa-user"></i>
          <input type="text" name="nom" placeholder="Nom" pattern="[a-zA-Z]{3,}" title="Veuillez entrer un nom valide (minimum 3 caractères, pas de chiffres ni de caractères spéciaux)." />
        </div>
        <div class="group-input">
          <i class="fas fa-user"></i>
          <input type="text" name="prenom" placeholder="Prenom" pattern="[a-zA-Z]{3,}" title="Veuillez entrer un prenom valide (minimum 3 caractères, pas de chiffres ni de caractères spéciaux)." />
        </div>
        <div class="group-input">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" placeholder="email" />
        </div>
        <div class="group-input">
        <i class="fas fa-phone"></i>
          <input type="tel" name="phone" placeholder="Numéro-de-telephone" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide (10 chiffres)." />
        </div>
        <div class="group-input">
          <i class="fa fa-lock"></i>
          <input type="password" name="mot_de_passe" placeholder="Mot-de-passe" pattern="(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}" title="Veuillez entrer un mot de passe valide (minimum 8 caractères, au moins 1 chiffre et 1 caractère spécial)." />
        </div>
        <div class="group-input">
          <i class="fa fa-lock"></i>
          <input type="password" name="confirm_mot_de_passe" placeholder="Confirme-MDP" pattern="(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}" title="Veuillez entrer un mot de passe valide (minimum 8 caractères, au moins 1 chiffre et 1 caractère spécial)." />
        </div>
        <button type="inscription" name="inscription">Inscription</button>
      </form>
    </div>

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

      // Créer une connexion à la base de données
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Vérifier s'il y a une erreur de connexion
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      // Préparer la requête pour vérifier les identifiants
      $stmt = $conn->prepare("SELECT * FROM employees WHERE emp_mail = ? AND emp_password = ?");
      $stmt->bind_param("ss", $inputemail, $inputpassword);
      $stmt->execute();

      // Récupérer les résultats de la requête
      $result = $stmt->get_result();

      // Vérifier s'il y a une correspondance dans la base de données
      if ($result->num_rows == 1) {
        // Identifiants corrects, rediriger vers la page d'accueil
        header("Location: accueil.php");
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

    <div class="form-container sign-in-container">
      <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <h1>Se connecter</h1>
        <hr />
        <div class="group-input">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" />
        </div>

        <div class="group-input">
          <i class="fa fa-lock"></i>
          <input type="password" name="mot_de_passe" placeholder="Mot de passe" />
        </div>
        <button type="submit" name="submit">Connection</button>

        <div class="social-login">
          <a href="#"><i class="fab fa-google"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
        <a href="#">Mot de passe oublié ?</a>
      </form>
    </div>

    <div class="side-element-container">
      <div class="side-element">
        <div class="side-element-panel side-element-left">
          <h1>Bonjour!</h1>
          <p>Saisissez vos données personnelles.</p>
          <button class="ghost" id="signIn">Connection</button>
        </div>
        <div class="side-element-panel side-element-right">
          <h1>Bienvenue!</h1>
          <p>
            Heureux de vous revoir, connectez-vous et amusez-vous avec nous.
          </p>
          <button class="ghost" id="signUp">Inscription</button>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
  <script src="https://kit.fontawesome.com/66c63b4ed2.js"></script>
</body>

</html>