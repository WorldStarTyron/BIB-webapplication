<?php
// book.php
require_once 'BIB_Connection.php';
session_start();

// Initialize variables
$titel = $auteur = $isbn = $status = 'Beschikbaar'; // Default status

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $titel = $_POST['titel'];
    $auteur = $_POST['auteur'];
    $isbn = $_POST['isbn'];

    // Insert the new book into the database
    $boeken = "INSERT INTO boeken (`titel`, `auteur`, `isbn`, `status`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($boeken);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Failed preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssss", $titel, $auteur, $isbn, $status);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Boek toegevoegd!";
    } else {
        echo "Fout bij toevoegen van boek: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Fetch all books from the database
$boeken = "SELECT * FROM boeken";
$result = $conn->query($boeken);

if (!$result) {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boek Beheer Systeem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Boek Beheer Systeem</h1>

        <h2>Voeg een nieuw boek toe</h2>
        <form method="POST" action=""> <!-- Specify the action URL -->
            <label for="titel">Titel:</label>
            <input type="text" id="titel" name="titel" required>

            <label for="auteur">Auteur:</label>
            <input type="text" id="auteur" name="auteur" required>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>


            <button type="submit" name="submit">Add Boek</button>
        </form>

        <h2>Boekenlijst</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titel</th>
                    <th>Auteur</th>
                    <th>ISBN</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['titel']; ?></td>
                    <td><?php echo $row['auteur']; ?></td>
                    <td><?php echo $row['isbn']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
 <a href="BIB_Delete.php?id=<?php echo $row['id']; ?>"><button type="button">Verwijder</button></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


