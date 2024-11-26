<?php
// Connexion à la base de données
$host = 'basededonnee.mysql.database.azure.com';  // Remplacez par l'hôte de votre base de données
$dbname = 'societe';
$username = 'sqluser';
$password = 'Pa$$w0rd1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $id_region = $_POST['id_region'];

    // Insertion des données dans la table client
    $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, age, ID_region) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $age, $id_region]);

    echo "<div class='success-message'>Client ajouté avec succès !</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2em;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1em;
        }

        input:focus, select:focus {
            border-color: #5b9bd5;
            outline: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4CAF50;
            background-color: #dff0d8;
            border: 1px solid #d0e9c6;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }

        .error-message {
            color: #f44336;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Ajouter un Client</h1>

    <form method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" required>

        <label for="id_region">Région:</label>
        <select name="id_region" id="id_region">
            <?php
            // Récupérer les régions depuis la table 'region'
            $regions = $pdo->query("SELECT ID_region, libelle FROM region")->fetchAll();
            foreach ($regions as $region) {
                echo "<option value='{$region['ID_region']}'>{$region['libelle']}</option>";
            }
            ?>
        </select>

        <button type="submit">Ajouter</button>
    </form>
</div>

</body>
</html>
