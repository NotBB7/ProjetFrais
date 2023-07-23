<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de frais avec TVA</title>
</head>
<body>
    <h1>Formulaire de frais</h1>
    <form method="post" action="enregistrer_frais.php" enctype="multipart/form-data">
        <label for="type">Type de frais :</label>
        <select name="type" id="type">
            <option value="1">Frais de repas</option>
            <option value="2">Frais de déplacement</option>
            <option value="3">Frais de logement</option>
            <option value="4">Frais kilométrique</option>
            <option value="5">Frais d'habillage</option>
        </select><br><br>
        <label for="montantHT">Montant HT :</label>
        <input type="text" name="montantHT" id="montantHT"><br><br>
        <label for="motif">Motif :</label>
        <input type="text" name="motif" id="motif"><br><br>
        <label for="date_payement">Date de paiement :</label>
        <input type="date" name="date_payement" id="date_payement"><br><br>
        <label for="prixTTC">Prix TTC (TVA incluse) :</label>
        <input type="text" name="prixTTC" id="prixTTC" readonly><br><br>
        <label for="montantTTC">Montant HT + TVA :</label>
        <input type="text" name="montantTTC" id="montantTTC" readonly><br><br>
        <label for="justificatif">Justificatif (image ou PDF) :</label>
        <input type="file" name="justificatif" id="justificatif"><br><br>
        <input type="submit" value="Enregistrer">
    </form>

    <script>
        // Fonction pour calculer la TVA et afficher le résultat
        function calculerTVA() {
            var montantHT = parseFloat(document.getElementById("montantHT").value);
            var typeFrais = parseInt(document.getElementById("type").value);
            var tauxTVA = 0.0;

            switch (typeFrais) {
                case 1:
                case 2:
                    tauxTVA = 0.10; // 10% de TVA pour frais de repas et déplacement
                    break;
                case 3:
                case 4:
                case 5:
                    tauxTVA = 0.20; // 20% de TVA pour frais de logement, kilométrique et habillage
                    break;
                default:
                    alert("Type de frais invalide !");
                    return;
            }

            var tva = montantHT * tauxTVA;
            var montantTTC = montantHT + tva;

            document.getElementById("prixTTC").value = tva.toFixed(2); // Affiche la TVA avec 2 décimales
            document.getElementById("montantTTC").value = montantTTC.toFixed(2); // Affiche le montant TTC avec 2 décimales
        }

        // Écouteur d'événement pour appeler la fonction de calcul lors de la saisie dans le champ montantHT ou lors du changement de type de frais
        document.getElementById("montantHT").addEventListener("input", calculerTVA);
        document.getElementById("type").addEventListener("change", calculerTVA);
    </script>
</body>
</html>
