<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- En link for å hente font fra google  -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <!-- koble til css fil -->
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- koble til opprett side -->
    <div id="meny">
        <div id="opprett_link_div">
            <a class="a_link_opprett" href="opprett.php">Opprett Ny Ansatte</a>
        </div>
    </div>

    <?php
    // Koble til connection side for å koble til databasen
    include "connection.php";

    //Slett Funksjon//
    if (isset($_POST['slett'])) {
        $ansatteid = $_POST['slett'];
        $sql = "DELETE FROM ansatte WHERE ansatte_id=$ansatteid";
        $resultat = $kobling->query($sql);
    }

    //Endre info Funksjon//
    if (isset($_POST['lagre_knapp']) || isset($_POST['avdeling_rad'])) {
        $ansatteid = $_POST['ansatte_id_rad'];
        $endre_navn = $_POST['navn_rad'];
        $endre_mobil = $_POST['mobil_rad'];
        $endre_jobb = $_POST['jobb_rad'];
        $endre_epost = $_POST['e_post_rad'];
        $endre_stilling = $_POST['stilling_rad'];
        $sql_update = "UPDATE ansatte SET navn='$endre_navn', mobil='$endre_mobil', jobb='$endre_jobb', 
        epost='$endre_epost', stilling='$endre_stilling' WHERE ansatte_id = '$ansatteid'";
        $result = $kobling->query($sql_update);
    }

    //Endre avdeling Funksjon//
    if (isset($_POST['avdeling_rad'])) {
        $ansatteid = $_POST['ansatte_id_rad'];
        $avd = $_POST['avdeling_rad'];
        $sql_update2 = "UPDATE ansatte SET avdeling_id='$avd' WHERE ansatte_id = '$ansatteid'";
        $result2 = $kobling->query($sql_update2);
    }

    // Vis profil bilde Funksjon
    if (isset($_POST['vis_profil_bilde'])) {
        $ansatteid = $_POST['ansatte_id_rad'];
        $sql5 = "SELECT bilder FROM ansatte WHERE ansatte_id='$ansatteid'";
        $result = $kobling->query($sql5);

        while ($rad = $result->fetch_assoc()) {
            $Bilde = $rad["bilder"];
            $vis_bilde = "/img/$Bilde";
            echo "<img id='bilder' src='$vis_bilde' alt=''>";
        }
    }

    // Hente data fra databasen
    $sql = "SELECT * FROM ansatte LEFT JOIN avdelinger ON ansatte.avdeling_id = avdelinger.avdeling_id";
    $resultat = $kobling->query($sql);


    // Lage tabell
    echo "<div id='mother_div'>";
    echo "<table id='info_tabel'>";
    echo "<tr>";
    echo "<th>Navn</th>";
    echo "<th>Mobil</th>";
    echo "<th>Jobb</th>";
    echo "<th>E-post</th>";
    echo "<th>Stilling</th>";
    echo "<th>Avdeling</th>";
    echo "<th>Bilde</th>";
    echo "<th>Lagre Endringer</th>";
    echo "<th>Slett Ansatt</th>";
    echo "</tr>";
    // Fetch all info fra databasen
    while ($rad = $resultat->fetch_assoc()) {
        $Ansatte_id = $rad["ansatte_id"];
        $Navn = $rad["navn"];
        $Mobil = $rad["mobil"];
        $Jobb = $rad["jobb"];
        $Epost = $rad["epost"];
        $Stilling = $rad["stilling"];
        $Avdeling_id = $rad["avdeling_id"];
        $Avdeling_navn = $rad["avdeling_navn"];
        $Bilde = $rad["bilder"];
        $vis_bilde = "/img/$Bilde";

        echo "<form method='POST'>";
        echo "<tr>";
        echo "<td>";
        echo "<input class='data' type='text' name='navn_rad' value='$Navn'>";
        echo "</td>";
        echo "<td>";
        echo "<input class='data' type='text' name='mobil_rad' value='$Mobil'>";
        echo "</td>";
        echo "<td>";
        echo "<input class='data' type='text' name='jobb_rad' value='$Jobb'>";
        echo "</td>";
        echo "<td>";
        echo "<input class='data' type='text' name='e_post_rad' value='$Epost'>";
        echo "</td>";
        echo "<td>";
        echo "<input class='data' type='text' name='stilling_rad' value='$Stilling'>";
        echo "</td>";
        echo "<td style='width:10%'>";
        echo "<select class='data' name='avdeling_rad' onchange='this.form.submit()'>";
        echo "<option value='$Avdeling_id'>$Avdeling_navn</option>";
        $sql2 = "SELECT * FROM avdelinger";
        $resultat2 = $kobling->query($sql2);
        while ($rad = $resultat2->fetch_assoc()) {
            $Avdeling_id2 = $rad["avdeling_id"];
            $Avdeling_navn2 = $rad["avdeling_navn"];
            echo "<option value=$Avdeling_id2>$Avdeling_navn2</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "<td><button name='vis_profil_bilde' value='$Ansatte_id' class='lagre_knapp'>Vis profil bilde</button</td>";
        echo "<td> <button name='lagre_knapp' class='lagre_knapp'>Lagre</button></td>";
        echo "<td>  <button class='slett_knapp' type='button' value='$Ansatte_id'> Slett Ansatte </button>  </td>";
        echo "<td>";
        echo "<input type='hidden' name='ansatte_id_rad' value='$Ansatte_id'>";
        echo "</td>";
        echo "</tr>";
        echo "</form>";
    }
    echo "</table>";
    echo "</div>";
    mysqli_close($kobling);
    ?>

    <!-- Slett Funksjon -->
    <dialog class="modal" id="modal">
        <h2>Bekreft Sletting</h2>
        <form method='POST'>
            <button id="slett_button" class="slett_button" name='slett' value=''> Slett </button>
            <button id="avbryt_button" class="avbryt_button" type='submit' name='avbryt'> Avbryt </button>
        </form>
    </dialog>
    <script>
        var modal = document.querySelector("#modal");
        var open_buttons = document.querySelectorAll(".slett_knapp");
        var close_button = document.querySelector(".slett_button");
        var slett_knapp_value

        open_buttons.forEach(btn => {
            btn.addEventListener("click", () => {
                slett_knapp_value = btn.value;
                document.getElementById("slett_button").value = slett_knapp_value;
                modal.showModal();
            })
        });
        close_button.addEventListener("click", () => {
            modal.close();
        });
    </script>
    <!-- Slett Funksjon -->

    
</body>

</html>