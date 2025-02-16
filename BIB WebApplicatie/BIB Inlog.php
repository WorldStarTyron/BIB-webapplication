<!-- Login Formulier -->
<form method="post">
    <select name="login_type">
 
        <option value="credentials">Gebruikersnaam/Wachtwoord</option>
        <option value="id">ID-nummer + Bib-pas</option>
    </select>


    <div id="credentials_section">
        <h4>Gebruiker</h4>
        <input type="text" name="gebruikersnaam" require>
        <input type="password" name="wachtwoord_hash" require>
    </div>

    <div id="id_section">
        <h4>BIB_Nummer</h4>
        <input type="text" name="bib_pasnummer" require>
    </div>

    <button type="submit">Inloggen</button>
</form>

<?php 
session_start(); 

include ("BIB_Connection.php"); 

// Authenticatielogica
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   

//Retrieve form data
$gebruikersnaam = $_POST['gebruikersnaam'];
$wachtwoord_hash = $_POST['wachtwoord_hash'];
$bib_pasummer = $_POST['bib_pasnummer'];



// Validate login Auth
$gebruikers = "SELECT * FROM gebruikers WHERE gebruikersnaam='$gebruikersnaam' AND wachtwoord_hash='$wachtwoord_hash' AND bib_pasnummer='$bib_pasummer'";

$result = $conn->query($gebruikers);



if($result->num_rows == 1 ){
    //Location
    header('Location:BIB_ADD.php');
    exit();
}

else{
    echo "<br>Invalid username or password";
    exit();
}



// Close the database connection
$conn->close();
}
?>



