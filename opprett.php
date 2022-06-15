<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Koble til connection side for å koble til databasen
    include "connection.php";

    // Opprette en ny ansatte
    if (isset($_POST["lagre"])) {
        $get_navn = $_REQUEST['navn'];
        $get_mobil = $_REQUEST['mobil'];
        $get_jobb = $_REQUEST['jobb'];
        $get_epost = $_REQUEST['epost'];
        $get_stilling = $_REQUEST['stilling'];
        $get_avdeling = $_REQUEST['avdeling'];
        $get_bilde = $_FILES['bilde']['name'];

        $new_sql = "INSERT INTO ansatte (navn, mobil, jobb, epost, stilling, avdeling_id, bilder) 
        VALUES ('$get_navn', '$get_mobil', '$get_jobb', '$get_epost', '$get_stilling', '$get_avdeling', '$get_bilde')";
        if ($kobling->query($new_sql) === TRUE) {
            header('location: index.php');
        }
    }

    // Opprette en ny avdeling
    if (isset($_POST["lagre_ny_avdeling"])) {
        if (!empty($_POST['ny_avdeling'])) {
            $get_ny_avdeling = $_REQUEST['ny_avdeling'];

            $new_sql2 = "INSERT INTO avdelinger (avdeling_navn) VALUES ('$get_ny_avdeling')";
            if ($kobling->query($new_sql2) === TRUE) {
                header('location: index.php');
            }
        }
    }


    // Slette avdeling
    if (isset($_POST['slett_avdeling_knapp'])) {
        $selected_avdeling = $_POST['slett_avdeling'];
        $sql_slett = "DELETE FROM avdelinger WHERE avdeling_id ='$selected_avdeling'";
        $resultat = $kobling->query($sql_slett);
        header('location: index.php');
    }
    ?>

    <!-- Input felt som fylles med data -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="navn" class='data' placeholder="Navn">
        <input type="number" name="mobil" class='data' placeholder="Mobil Nummer">
        <input type="number" name="jobb" class='data' placeholder="Jobb mobil Nummer">
        <input type="text" name="epost" class='data' placeholder="E-post">
        <input type="text" name="stilling" class='data' placeholder="Stilling">
        <input type="file" name="bilde" class='data' placeholder="Bilde navn.jpg eller png">

        <!-- Velg en avdeling -->
        <?php
        echo "<select class='data' name='avdeling'>";
        echo "<option value=''>Velg avdeling</option>";
        $sql2 = "SELECT * FROM avdelinger";
        $resultat2 = $kobling->query($sql2);
        while ($rad = $resultat2->fetch_assoc()) {
            $Avdeling_id2 = $rad["avdeling_id"];
            $Avdeling_navn2 = $rad["avdeling_navn"];
            echo "<option value=$Avdeling_id2>$Avdeling_navn2</option>";
        }
        echo "</select>";
        ?>
        <!-- Knapp for å lagre data i databasen -->
        <button name="lagre" class="lagre">Lagre</button>
        <br>
        <br>
        <br>
        <!-- input felt og knapp for å lage ny avdeling -->
        <input type="text" name="ny_avdeling" class='data' placeholder="Ny avdeling">
        <button name="lagre_ny_avdeling" class="lagre">Lagre</button>
        <br>
        <br>
        <br>
        <!-- input felt og knapp for å slette avdeling -->
        <?php
        echo "<select class='data' name='slett_avdeling'>";
        echo "<option value=''>Velg avdeling</option>";
        $sql3 = "SELECT * FROM avdelinger";
        $resultat3 = $kobling->query($sql3);
        while ($rad = $resultat3->fetch_assoc()) {
            $Avdeling_id3 = $rad["avdeling_id"];
            $Avdeling_navn3 = $rad["avdeling_navn"];
            echo "<option value=$Avdeling_id3>$Avdeling_navn3</option>";
        }
        echo "</select>";
        ?>
        <button name="slett_avdeling_knapp" class="slett_avdeling_knapp">Slett avdeling</button>

    </form>

</body>

</html>