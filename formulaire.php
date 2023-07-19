<!DOCTYPE html>
<html>
<head>
  <title>Formulaire de frais</title>
  <link rel="stylesheet" href="formulaire.css">
</head>
<body>
  <h1>Formulaire de frais</h1>
  <form action="traitement.php" method="post" enctype="multipart/form-data">
    <label for="type_frais">Type de frais :</label>
    <select name="type_frais" id="type_frais" onchange="calculerTVA()">
      <option value="frais_repas">Frais de repas</option>
      <option value="frais_deplacement">Frais de déplacement</option>
      <option value="frais_logement">Frais de logement</option>
      <option value="frais_kilometrique">Frais kilométrique</option>
      <option value="frais_habilage">Frais d'habillage</option>
    </select><br>

    <label for="date_paiement">Date du paiement :</label>
    <input type="date" name="date_paiement" id="date_paiement"><br>

    <label for="motif">Motif de l'opération :</label>
    <input type="text" name="motif" id="motif"><br><br>

    <label for="montant_paiement">Montant du paiement HT :</label>
    <input type="text" name="montant_paiement" id="montant_paiement" onkeyup="calculerTVA()"><br><br>

    <label for="montant_tva">Montant de la TVA :</label><span id="montant_tva"></span><br><br>

    <label for="montant_final">Montant final TTC :</label>
    <span id="montant_final"></span><br><br>

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

      if (typeFrais === 'frais_repas' || typeFrais === 'frais_deplacement') {
        tva = 0.1; // 10% de TVA
      } else if (typeFrais === 'frais_logement' || typeFrais === 'frais_kilometrique' || typeFrais === 'frais_habilage') {
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
