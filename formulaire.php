<!DOCTYPE html>
<html>

<head>
  <title>Formulaire de frais</title>
  <link rel="stylesheet" href="formulaire.css">
</head>

<body>
  <h1>Formulaire de frais</h1>

  <?php
  // Vérifier si le formulaire a été soumis
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    // Récupérer les données du formulaire
    $typeFrais = $_POST["type_frais"];
    $montant_paiement = $_POST["montant_paiement"];
    $motif = $_POST['motif'];
    $date_paiement = $_POST['date_paiement'];
    $montant_final = $_POST['montant_final'];
    $justificatif = $_POST['justificatif'];

    // Valider et enregistrer les données dans la base de données
    if (!empty($typeFrais) && !empty($montant)) {
      // Connexion à la base de données
      $servername = "localhost";
      $username = "root";
      $password = "1234";
      $dbname = "projeta";

      // Créer une connexion
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Vérifier la connexion
      if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      // Validation du fichier joint (image ou PDF)
      if ($_FILES['justificatif']['error'] === UPLOAD_ERR_OK) {
        $allowedFileTypes = '/\.(jpg|jpeg|png|gif|pdf)$/i';
        $uploadedFileType = $_FILES['justificatif']['type'];

        if (!preg_match($allowedFileTypes, $uploadedFileType)) {
          die("Le type de fichier n'est pas autorisé. Seules les images (JPG, JPEG, PNG, GIF) et les fichiers PDF sont acceptés.");
        }

        // Déplacer le fichier vers le dossier de destination souhaité
        $destination = 'chemin/vers/dossier_destination/' . $_FILES['justificatif']['name'];
        move_uploaded_file($_FILES['justificatif']['tmp_name'], $destination);
      }




      // Préparer et exécuter la requête SQL pour insérer les données avec le type ID récupéré
      $sql = "INSERT INTO expense_report (typ_id, exp_amount_ht, exp_description, exp_date, exp_amount_ttc, exp_proof) VALUES ('$type_frais', '$montant_paiement', '$motif', '$date_paiement', '$montant_final' , '$justificatif')";

      if ($conn->query($sql) === TRUE) {
        echo "Les frais ont été enregistrés avec succès.";
      } else {
        echo "Erreur lors de l'enregistrement des frais : " . $conn->error;
      }
    } else {
      echo "Type de frais invalide.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
  } else {
    echo "Veuillez remplir tous les champs du formulaire.";
  }

  ?>

  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="type_frais">Type de frais :</label>
    <select name="type_frais" id="type_frais" onchange="calculerTVA()">>
      <option value="4">Frais de repas</option>
      <option value="5">Frais de déplacement</option>
      <option value="2">Frais de logement</option>
      <option value="3">Frais kilométrique</option>
      <option value="1">Frais d'habillage</option>
    </select>

    <label for="date_paiement">Date du paiement :</label>
    <input type="date" name="date_paiement" id="date_paiement"><br>

    <label for="motif">Motif de l'opération :</label>
    <input type="text" name="motif" id="motif"><br><br>

    <label for="montant_paiement">Montant du paiement HT :</label>
    <input type="text" name="montant_paiement" id="montant_paiement" onkeyup="calculerTVA()"><br><br>

    <label for="montant_tva">Montant de la TVA :</label><span id="montant_tva"></span><br><br>

    <label for="montant_final">Montant final TTC :</label>
    <span  name="montant_final" id="montant_final"></span><br><br>

    <label for="justificatif" style="justify-content: center;">Justificatif :</label>
    <input type="file" name="justificatif" id="justificatif"><br>

    <input type="submit" value="Soumettre">
  </form>


  <script>
    function calculerTVA() {
      var typeFrais = document.getElementById('type_frais').value;
      var montantPaiement = parseFloat(document.getElementById('montant_paiement').value);
      var tva = 0;
      var montantFinal = 0;

      if (typeFrais === '4' || typeFrais === '5') {
        tva = 0.1; // 10% de TVA
      } else if (typeFrais === '2' || typeFrais === '3' || typeFrais === '1') {
        tva = 0.2; // 20% de TVA
      }

      var montantTVA = montantPaiement * tva;
      montantFinal = montantPaiement + montantTVA;

      document.getElementById('montant_tva').textContent = montantTVA.toFixed(2);
      document.getElementById('montant_final').textContent = montantFinal.toFixed(2);
    }
  </script>

</body>

</html>