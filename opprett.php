<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- En link for å hente font fra google  -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="css\opprett.css">
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
    <div id="mother_div">
        <form id="form_en" method="POST" enctype="multipart/form-data">
            <div id="lage_ny_ansatte_felt">
                <h1 class="tittel">Lag ny ansatte</h1>
                <input type="text" name="navn" class='lage_ny_ansatte' placeholder="Navn">
                <input type="number" name="mobil" class='lage_ny_ansatte' placeholder="Mobil Nummer">
                <input type="number" name="jobb" class='lage_ny_ansatte' placeholder="Jobb mobil Nummer">
                <input type="text" name="epost" class='lage_ny_ansatte' placeholder="E-post">
                <input type="text" name="stilling" class='lage_ny_ansatte' placeholder="Stilling">
                <input type="file" name="bilde" class='lage_ny_ansatte' placeholder="Bilde navn.jpg eller png">

                <!-- Velg en avdeling -->
                <?php
                echo "<select class='lage_ny_ansatte' name='avdeling'>";
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
                <button name="lagre" class="lagre_ny_ansatte">Lagre</button>
            </div>
            <div id="lage_ny_avdeling">
                <!-- input felt og knapp for å lage ny avdeling -->
                <h1 class="avdeling_tittel">Lag ny avdeling</h1>
                <input type="text" name="ny_avdeling" class='lage_ny_avdeling' placeholder="Ny avdeling">
                <button name="lagre_ny_avdeling" class="lagre_ny_avdeling">Lagre</button>
            </div>
            <div id="slett_avdeling">
                <!-- input felt og knapp for å slette avdeling -->
                <h1 class="slett_avdeling_tittel">Slett avdeling</h1>
                <?php
                echo "<select class='slett_avdeling' name='slett_avdeling'>";
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
            </div>
        </form>
    </div>

</body>

</html>