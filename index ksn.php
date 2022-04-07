<?php
    session_start();
    //ini_set('display_errors', '1');

    function ageCalculator($date) {  
        date_default_timezone_set("Europe/Berlin");  
        $birthDate = new DateTime($date);
        $actualDate = new DateTime();      
        return $actualDate->diff($birthDate)->y;
    } 

    require_once("db.php");

    $nachnameAzubi = $vornameAzubi = $geburtsnameAzubi = $geburtsdatumAzubi = $geschlechtAzubi = $geburtsortAzubi = $geburtslandAzubi = $strasseAzubi = $hausnrAzubi = $plzAzubi = $ortAzubi = $ortsteilAzubi = $telefonAzubi = $mobilAzubi = $emailAzubi = $spracheAzubi = $nationalitaetAzubi = $konfessionAzubi = $vorbildungAzubi = $nachnameErz = $vornameErz = $gruppeErz = $emailErz = $strasseErz = $hausnrErz = $plzErz = $ortErz = $telefonErz = $mobilErz = $ausbildungsberuf = $betrieb = $strasseBetrieb = $hausnrBetrieb = $plzBetrieb = $ortBetrieb = $telefonBetrieb = $telefaxBetrieb = $emailBetrieb = $ansprechpartner = $ausbildungsbeginn = $ausbildungsende = $datenschutz = "";
    $age = 18;
    $beruf = "";

    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
       $nachnameAzubi = isset($_POST['tfNachnameAzubi']) ? $_POST['tfNachnameAzubi'] : ""; 
       $vornameAzubi = isset($_POST['tfVornameAzubi']) ? $_POST['tfVornameAzubi'] : ""; 
       $geburtsnameAzubi = isset($_POST['tfGeburtsnameAzubi']) ? $_POST['tfGeburtsnameAzubi'] : ""; 
       $geburtsdatumAzubi = isset($_POST['tfGeburtsdatumAzubi']) ? $_POST['tfGeburtsdatumAzubi'] : "";
       $age = $geburtsdatumAzubi != "" ? ageCalculator($geburtsdatumAzubi) : 18; 
       $geschlechtAzubi = isset($_POST['selectGeschlecht']) ? $_POST['selectGeschlecht'] : ""; 
       $geburtsortAzubi = isset($_POST['tfGeburtsortAzubi']) ? $_POST['tfGeburtsortAzubi'] : ""; 
       $geburtslandAzubi = isset($_POST['selectGeburtslandAzubi']) ? $_POST['selectGeburtslandAzubi'] : ""; 
       $strasseAzubi = isset($_POST['tfStrasseAzubi']) ? $_POST['tfStrasseAzubi'] : ""; 
       $hausnrAzubi = isset($_POST['tfHausnrAzubi']) ? $_POST['tfHausnrAzubi'] : ""; 
       $plzAzubi = isset($_POST['tfPLZAzubi']) ? $_POST['tfPLZAzubi'] : ""; 
       $ortAzubi = isset($_POST['tfOrtAzubi']) ? $_POST['tfOrtAzubi'] : ""; 
       $ortsteilAzubi = isset($_POST['tfOrtsteilAzubi']) ? $_POST['tfOrtsteilAzubi'] : ""; 
       $telefonAzubi = isset($_POST['tfTelefonAzubi']) ? $_POST['tfTelefonAzubi'] : ""; 
       $mobilAzubi = isset($_POST['tfMobilAzubi']) ? $_POST['tfMobilAzubi'] : ""; 
       $emailAzubi = isset($_POST['tfEmailAzubi']) ? $_POST['tfEmailAzubi'] : "";  
       $spracheAzubi = isset($_POST['selectSpracheAzubi']) ? $_POST['selectSpracheAzubi'] : "";
       $nationalitaetAzubi = isset($_POST['selectNationalitaet']) ? $_POST['selectNationalitaet'] : "";
       $konfessionAzubi = isset($_POST['selectKonfession']) ? $_POST['selectKonfession'] : "";
       $vorbildungAzubi = isset($_POST['selectVorbildung']) ? $_POST['selectVorbildung'] : "";

       $nachnameErz = isset($_POST['tfNachnameErz']) ? $_POST['tfNachnameErz'] : ""; 
       $vornameErz = isset($_POST['tfVornameErz']) ? $_POST['tfVornameErz'] : ""; 
       $gruppeErz = isset($_POST['selectGruppeErz']) ? $_POST['selectGruppeErz'] : ""; 
       $emailErz = isset($_POST['tfEmailErz']) ? $_POST['tfEmailErz'] : ""; 
       $strasseErz = isset($_POST['tfStrasseErz']) ? $_POST['tfStrasseErz'] : "";
       $hausnrErz =  isset($_POST['tfHausnrErz']) ? $_POST['tfHausnrErz'] : "";
       $plzErz = isset($_POST['tfPLZErz']) ? $_POST['tfPLZErz'] : ""; 
       $ortErz = isset($_POST['tfOrtErz']) ? $_POST['tfOrtErz'] : ""; 
       $telefonErz = isset($_POST['tfTelefonErz']) ? $_POST['tfTelefonErz'] : "";
       $mobilErz =  isset($_POST['tfMobilErz']) ? $_POST['tfMobilErz'] : "";

       $ausbildungsberuf = isset($_POST['selectAusbildungsberuf']) ? $_POST['selectAusbildungsberuf'] : ""; 
       $betrieb = isset($_POST['tfBetrieb']) ? $_POST['tfBetrieb'] : ""; 
       $ausbildungsbetrieb = "DUMMY";
       $strasseBetrieb = isset($_POST['tfStrasseBetrieb']) ? $_POST['tfStrasseBetrieb'] : ""; 
       $hausnrBetrieb = isset($_POST['tfHausnrBetrieb']) ? $_POST['tfHausnrBetrieb'] : ""; 
       $plzBetrieb = isset($_POST['tfPLZBetrieb']) ? $_POST['tfPLZBetrieb'] : ""; 
       $ortBetrieb = isset($_POST['tfOrtBetrieb']) ? $_POST['tfOrtBetrieb'] : ""; 
       $telefonBetrieb = isset($_POST['tfTelefonBetrieb']) ? $_POST['tfTelefonBetrieb'] : ""; 
       $telefaxBetrieb = isset($_POST['tfTelefaxBetrieb']) ? $_POST['tfTelefaxBetrieb'] : ""; 
       $emailBetrieb = isset($_POST['tfEmailBetrieb']) ? $_POST['tfEmailBetrieb'] : ""; 
       $ansprechpartner = isset($_POST['tfAnsprechpartner']) ? $_POST['tfAnsprechpartner'] : ""; 
       $ausbildungsbeginn = isset($_POST['tfAusbildungsbeginn']) ? $_POST['tfAusbildungsbeginn'] : ""; 
       $ausbildungsende = isset($_POST['tfAusbildungsende']) ? $_POST['tfAusbildungsende'] : ""; 
       $bemerkung = isset($_POST['taBemerkung']) ? $_POST['taBemerkung'] : ""; 

       $datenschutz = isset($_POST['datenschutz']) ? $_POST['datenschutz'] : "";
       
       //Fehlerüberprüfung
       if (!filter_var($emailAzubi, FILTER_VALIDATE_EMAIL)) $errors["emailAzubi"] = "Bitte geben Sie eine gültige Emailadresse ein.";
       if ($emailErz!="" && !filter_var($emailErz, FILTER_VALIDATE_EMAIL)) $errors["emailErz"] = "Bitte geben Sie eine gültige Emailadresse ein.";
       if (!filter_var($emailBetrieb, FILTER_VALIDATE_EMAIL)) $errors["emailBetrieb"] = "Bitte geben Sie eine gültige Emailadresse ein.";

       if(!preg_match("/\A[0-9]{5}\z/",$plzAzubi)) $errors["plzAzubi"] = "Bitte geben Sie eine gültige Postleitzahl ein!";
       if($plzErz!="" && !preg_match("/\A[0-9]{5}\z/",$plzErz)) $errors["plzErz"] = "Bitte geben Sie eine gültige Postleitzahl ein!";
       if(!preg_match("/\A[0-9]{5}\z/",$plzBetrieb)) $errors["plzBetrieb"] = "Bitte geben Sie eine gültige Postleitzahl ein!";

       if($ausbildungsende<$ausbildungsbeginn) $errors["ausbildungsende"] = "Das Ausbildungsende muss nach dem Ausbildungsbeginn liegen!";

       if($age<18 && ($nachnameErz=="" || $vornameErz=="" || $gruppeErz=="" || $strasseErz=="" || $plzErz=="" || $ortErz=="" || $telefonErz=="")) $errors["erziehungsberechtigte"] = "Bei Minderjährigen muss ein Erziehungsberechtigter eingetragen werden.";

        if($datenschutz=="") $errors["datenschutz"] = "Bitte stimmen Sie der Datenschutzerklärung zu!";
       
        if(empty($errors)){
            $datum = date('Y-m-d');

            $con = new DataModel();

            $query = 'SELECT beruf FROM ausbildungsberufe WHERE id_ausbildungsberufe = ?';
            $paramType = 's';
            $paramValue = array($ausbildungsberuf);
            $result = $con->select($query, $paramType, $paramValue);

            $beruf = $result[0]['beruf'];

            $anzahlSpalten = 44;

            $query = "INSERT INTO asv (`Name`, Vorname, Geburtsname, Geburtstag, Geburtsort, Geburtsland, Geschlecht, Strasse, HausNr, PLZ, Ort, Teilort, `Telefon 1`, Handy1, email1, Muttersprache, Land, Religion, Vorbildung, Erz1Name, Erz1Vorname, Erz1Art, Erz1Email, Erz1Strasse, Erz1HausNr, Erz1PLZ, Erz1Ort, Erz1Telefon, Erz1Handy, Ausbild_beruf_id, Betrieb, Ausbildungsbetrieb, strasse_btr, hausnr_btr, plz_btr, ort_btr, telefon_btr, telefax_btr, email_btr, ansprechpartner, beginn, ende, bemerkung, datum) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $paramType = "ssssssssssssssssssssssssssssssssssssssssssss";
            $paramValue = array($nachnameAzubi, $vornameAzubi, $geburtsnameAzubi, $geburtsdatumAzubi, $geburtsortAzubi, $geburtslandAzubi, $geschlechtAzubi, $strasseAzubi, $hausnrAzubi, $plzAzubi, $ortAzubi, $ortsteilAzubi, $telefonAzubi, $mobilAzubi, $emailAzubi, $spracheAzubi, $nationalitaetAzubi, $konfessionAzubi, $vorbildungAzubi, $nachnameErz, $vornameErz, $gruppeErz, $emailErz, $strasseErz, $hausnrErz, $plzErz, $ortErz, $telefonErz, $mobilErz, $ausbildungsberuf, $betrieb, $ausbildungsbetrieb, $strasseBetrieb, $hausnrBetrieb, $plzBetrieb, $ortBetrieb, $telefonBetrieb, $telefaxBetrieb, $emailBetrieb, $ansprechpartner, $ausbildungsbeginn, $ausbildungsende, $bemerkung, $datum);

            $result = $con->insert($query, $paramType, $paramValue);

            //Übergabe an print_pdf.php
            $_SESSION['nachnameAzubi'] = $nachnameAzubi;
            $_SESSION['vornameAzubi'] = $vornameAzubi;
            $_SESSION['geburtsnameAzubi'] = $geburtsnameAzubi;
            $_SESSION['geburtsdatumAzubi'] = $geburtsdatumAzubi;
            $_SESSION['geburtsortAzubi'] = $geburtsortAzubi;
            $_SESSION['geburtslandAzubi'] = $geburtslandAzubi;
            $_SESSION['geschlechtAzubi'] = $geschlechtAzubi;
            $_SESSION['strasseAzubi'] = $strasseAzubi;
            $_SESSION['hausnrAzubi'] = $hausnrAzubi;
            $_SESSION['plzAzubi'] = $plzAzubi;
            $_SESSION['ortAzubi'] = $ortAzubi;
            $_SESSION['ortsteilAzubi'] = $ortsteilAzubi;
            $_SESSION['telefonAzubi'] = $telefonAzubi;
            $_SESSION['emailAzubi'] = $emailAzubi;
            $_SESSION['mobilAzubi'] = $mobilAzubi;
            $_SESSION['spracheAzubi'] = $spracheAzubi;
            $_SESSION['nationalitaetAzubi'] = $nationalitaetAzubi;
            $_SESSION['konfessionAzubi'] = $konfessionAzubi;
            $_SESSION['vorbildungAzubi'] = $vorbildungAzubi;
            $_SESSION['nachnameErz'] = $nachnameErz;
            $_SESSION['vornameErz'] = $vornameErz;
            $_SESSION['gruppeErz'] = $gruppeErz;
            $_SESSION['strasseErz'] = $strasseErz;
            $_SESSION['hausnrErz'] = $hausnrErz;
            $_SESSION['plzErz'] = $plzErz;
            $_SESSION['ortErz'] = $ortErz;
            $_SESSION['telefonErz'] = $telefonErz;
            $_SESSION['mobilErz'] = $mobilErz;
            $_SESSION['emailErz'] = $emailErz;
            $_SESSION['ausbildungsberuf'] = $beruf;
            $_SESSION['betrieb'] = $betrieb;
            $_SESSION['strasseBetrieb'] = $strasseBetrieb;
            $_SESSION['hausnrBetrieb'] = $hausnrBetrieb;
            $_SESSION['plzBetrieb'] = $plzBetrieb;
            $_SESSION['ortBetrieb'] = $ortBetrieb;
            $_SESSION['telefonBetrieb'] = $telefonBetrieb;
            $_SESSION['telefaxBetrieb'] = $telefaxBetrieb;
            $_SESSION['emailBetrieb'] = $emailBetrieb;
            $_SESSION['ansprechpartner'] = $ansprechpartner;
            $_SESSION['ausbildungsbeginn'] = $ausbildungsbeginn;
            $_SESSION['ausbildungsende'] = $ausbildungsende;
            $_SESSION['bemerkung'] = $bemerkung;

            $nachnameAzubi = $vornameAzubi = $geburtsnameAzubi = $geburtsdatumAzubi = $geschlechtAzubi = $geburtsortAzubi = $geburtslandAzubi = $strasseAzubi = $hausnrAzubi = $plzAzubi = $ortAzubi = $mobilAzubi = $telefonAzubi = $emailAzubi = $spracheAzubi = $nationalitaetAzubi = $konfessionAzubi = $vorbildungAzubi = $nachnameErz = $vornameErz = $gruppeErz = $emailErz = $strasseErz = $hausnrErz = $plzErz = $ortErz = $ortsteilAzubi = $telefonErz = $mobilErz = $ausbildungsberuf = $betrieb = $strasseBetrieb = $hausnrBetrieb = $plzBetrieb = $ortBetrieb = $telefonBetrieb = $telefaxBetrieb = $emailBetrieb = $ansprechpartner = $ausbildungsbeginn = $ausbildungsende = $bemerkung = $datenschutz = "";

            $nachricht = "Im Anmeldeportal KBS Schüleranmeldung online wurde eine Anmeldung erfasst.\r\n\r\n" . 
            "Besuchen Sie https://www.ksn-stuttgart.de/berufsschulanmeldung/login.php um sich die aktuell vorliegenden Anmeldungen anzuschauen.\r\n\r\n";

            $nachricht = wordwrap($nachricht, 70, "\r\n");

            $empfaenger = 'berufsschulanmeldung@ksn-stuttgart.de';
            $betreff = 'Neue Anmeldung Berufsschulanmeldung online';
            $header = 'From: berufsschulanmeldung@ksn-stuttgart.de' . "\r\n" .
                'Reply-To: berufsschulanmeldung@ksn-stuttgart.de' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($empfaenger, $betreff, $nachricht, $header);

            header("Refresh: 1; url=print_pdf.php");
            echo "<div class='success'>
                <p><strong>Anmeldung erfolgreich übermittelt.</strong></p>
                <p>Wir erstellen automatisch ein pdf-File für Sie. Bitte drucken Sie dieses aus.</p>
                <p>Sie können dieses Fenster danach schließen.</p></div>";
            exit();

       }else{
           echo "<p style='color:#C00C00;'>";
           echo "Die Angaben sind unvollständig. Bitte überprüfen Sie Ihre Eingaben.";
           echo "</p>";
       }
   }
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Anmeldeformular Berufsschule der KSN Stuttgart</title>
    <script src="modernizr-inputs.js"></script>
    <script src="jquery-datepicker/external/jquery/jquery.js"></script>
    <script src="jquery-datepicker/jquery-ui.min.js"></script>
</head>

<body>
    <header>
        <nav>
            <div class="logo"><img src="img/logo-ksn.png" width="400"/></div>
            <a href="login.php" id="admin-button">Zum Administrations-Bereich</a>
        </nav>
    </header>
    <main>
        <form class="formular" action="index.php" method="post" onSubmit="return confirm('Anmeldung mit diesen Daten ausführen?')">
            <fieldset>
                <legend>1. Auszubildende/r</legend>
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfNachnameAzubi">*Nachname</label>
                        <input type="text" placeholder="Nachname" name="tfNachnameAzubi" id="tfNachnameAzubi" 
                        value="<?php if (isset($nachnameAzubi)) echo $nachnameAzubi;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfVornameAzubi">*Vorname</label>
                        <input type="text" placeholder="Vorname" name="tfVornameAzubi" id="tfVornameAzubi" 
                        value="<?php if (isset($vornameAzubi)) echo $vornameAzubi;?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfGeburtsnameAzubi">Geburtsname</label>
                        <input type="text" placeholder="Geburtsname" name="tfGeburtsnameAzubi" id="tfGeburtsnameAzubi"
                        value="<?php if (isset($geburtsnameAzubi)) echo $geburtsnameAzubi;?>">
                    </div>
                    <div class="form-col">
                        <label for="tfGeburtsdatumAzubi">*Geburtsdatum</label>
                        <input type="date" placeholder="tt.mm.jjjj" name="tfGeburtsdatumAzubi"
                            id="tfGeburtsdatumAzubi" value="<?php if (isset($geburtsdatumAzubi)) echo $geburtsdatumAzubi;?>" required>
                            <small>Bei Minderjährigen bitte im nächsten Abschnitt einen Erziehungsberechtigten angeben!</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="selectGeschlecht">*Geschlecht</label>
                        <span class="error"><?php if(isset($errors["geschlecht"])) echo $errors["geschlecht"]; ?></span>
                        <select name="selectGeschlecht" id="selectGeschlecht" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>    
                            <option value="männlich" <?php if($geschlechtAzubi == 'männlich') echo 'selected';?>>männlich</option>
                            <option value="weiblich" <?php if($geschlechtAzubi == 'weiblich') echo 'selected';?>>weiblich</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="tfGeburtsortAzubi">*Geburtsort</label>
                        <input type="text" placeholder="Geburtsort" name="tfGeburtsortAzubi" id="tfGeburtsortAzubi"
                        value="<?php if (isset($geburtsortAzubi)) echo $geburtsortAzubi;?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="selectGeburtslandAzubi">*Geburtsland</label>
                        <select name="selectGeburtslandAzubi" id="selectGeburtslandAzubi" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="D" <?php if($geburtslandAzubi == 'D') echo 'selected';?>>Deutschland</option>
                            <option disabled>--------------</option>

                            <!-- A -->
                            <option value="AFG" <?php if($geburtslandAzubi == 'AFG') echo 'selected';?>>Afghanistan</option>
                            <option value="ET" <?php if($geburtslandAzubi=="ET") echo "selected"; ?>>Ägypten</option>
                            <option value="AL" <?php if($geburtslandAzubi=="AL") echo "selected"; ?>>Albanien</option>
                            <option value="DZ" <?php if($geburtslandAzubi=="DZ") echo "selected"; ?>>Algerien</option>
                            <option value="AND" <?php if($geburtslandAzubi=="\AND") echo "selected"; ?>>Andorra</option>
                            <option value="ANG" <?php if($geburtslandAzubi=="ANG") echo "selected"; ?>>Angola</option>
                            <option value="AG" <?php if($geburtslandAzubi=="AG") echo "selected"; ?>>Antigua und Barbuda</option>
                            <option value="GQ" <?php if($geburtslandAzubi=="GQ") echo "selected"; ?>>Äquatorialguinea</option>
                            <option value="RA" <?php if($geburtslandAzubi=="RA") echo "selected"; ?>>Argentinien</option>
                            <option value="AM" <?php if($geburtslandAzubi=="AM") echo "selected"; ?>>Armenien</option>
                            <option value="AZ" <?php if($geburtslandAzubi=="AZ") echo "selected"; ?>>Aserbaidschan</option>
                            <option value="ETH" <?php if($geburtslandAzubi=="ETH") echo "selected"; ?>>Äthiopien</option>
                            <option value="AUS" <?php if($geburtslandAzubi=="AUS") echo "selected"; ?>>Australien</option>

                            <!-- B -->
                            <option value="BS" <?php if($geburtslandAzubi=="BS") echo "selected"; ?>>Bahamas</option>
                            <option value="BRN" <?php if($geburtslandAzubi=="BRN") echo "selected"; ?>>Bahrain</option>
                            <option value="BD" <?php if($geburtslandAzubi=="BD") echo "selected"; ?>>Bangladesch</option>
                            <option value="B" <?php if($geburtslandAzubi=="B") echo "selected"; ?>>Belgien</option>
                            <option value="BH" <?php if($geburtslandAzubi=="BH") echo "selected"; ?>>Belize</option>
                            <option value="DY" <?php if($geburtslandAzubi=="DY") echo "selected"; ?>>Benin</option>
                            <option value="BHT" <?php if($geburtslandAzubi=="BHT") echo "selected"; ?>>Bhutan</option>
                            <option value="BOL" <?php if($geburtslandAzubi=="BOL") echo "selected"; ?>>Bolivien</option>
                            <option value="BIH" <?php if($geburtslandAzubi=="BIH") echo "selected"; ?>>Bosnien-Herzegowina</option>
                            <option value="BW" <?php if($geburtslandAzubi=="BW") echo "selected"; ?>>Botsuana</option>
                            <option value="BR" <?php if($geburtslandAzubi=="BR") echo "selected"; ?>>Brasilien</option>
                            <option value="GB3" <?php if($geburtslandAzubi=="GB3") echo "selected"; ?>>Brit. Geb. in Amerika</option>
                            <option value="GB1" <?php if($geburtslandAzubi=="GB1") echo "selected"; ?>>Brit. Geb. in Europa</option>
                            <option value="GB5" <?php if($geburtslandAzubi=="GB5") echo "selected"; ?>>Brit. Geb. in Ozeanien</option>
                            <option value="BRU" <?php if($geburtslandAzubi=="BRU") echo "selected"; ?>>Brunei Darussalam</option>
                            <option value="BG" <?php if($geburtslandAzubi=="BG") echo "selected"; ?>>Bulgarien</option>
                            <option value="BF" <?php if($geburtslandAzubi=="B") echo "selected"; ?>>Burkina Faso</option>
                            <option value="RU" <?php if($geburtslandAzubi=="RU") echo "selected"; ?>>Burundi</option>

                            <!-- C -->
                            <option value="RCH" <?php if($geburtslandAzubi=="RCH") echo "selected"; ?>>Chile</option>
                            <option value="RC" <?php if($geburtslandAzubi=="RC") echo "selected"; ?>>China VR</option>
                            <option value="CR" <?php if($geburtslandAzubi=="CR") echo "selected"; ?>>Costa Rica</option>
                            <option value="CI" <?php if($geburtslandAzubi=="CI") echo "selected"; ?>>C&#244;te d'Ivoire</option>

                            <!-- D -->
                            <option value="DK" <?php if($geburtslandAzubi=="DK") echo "selected"; ?>>Dänemark</option>
                            <option value="WD" <?php if($geburtslandAzubi=="WD") echo "selected"; ?>>Dominica</option>
                            <option value="DOM" <?php if($geburtslandAzubi=="DOM") echo "selected"; ?>>Dominikanische Rep.</option>
                            <option value="DJI" <?php if($geburtslandAzubi=="DJI") echo "selected"; ?>>Dschibuti</option>

                            <!-- E -->
                            <option value="EC" <?php if($geburtslandAzubi=="EC") echo "selected"; ?>>Ecuador</option>
                            <option value="ES" <?php if($geburtslandAzubi=="ES") echo "selected"; ?>>El Salvador</option>
                            <option value="ER" <?php if($geburtslandAzubi=="ER") echo "selected"; ?>>Eritrea</option>
                            <option value="EST" <?php if($geburtslandAzubi=="EST") echo "selected"; ?>>Estland</option>
                            <option value="SD" <?php if($geburtslandAzubi=="SD") echo "selected"; ?>>Eswatini</option>

                            <!-- F -->
                            <option value="FJI" <?php if($geburtslandAzubi=="FJI") echo "selected"; ?>>Fidschi</option>
                            <option value="FIN" <?php if($geburtslandAzubi=="FIN") echo "selected"; ?>>Finnland</option>
                            <option value="F" <?php if($geburtslandAzubi=="F") echo "selected"; ?>>Frankreich</option>

                            <!-- G -->
                            <option value="G" <?php if($geburtslandAzubi=="G") echo "selected"; ?>>Gabub</option>
                            <option value="WAG" <?php if($geburtslandAzubi=="WAG") echo "selected"; ?>>Gambia</option>
                            <option value="GE" <?php if($geburtslandAzubi=="GE") echo "selected"; ?>>Georgien</option>
                            <option value="GH" <?php if($geburtslandAzubi=="GH") echo "selected"; ?>>Ghana</option>
                            <option value="WG" <?php if($geburtslandAzubi=="WG") echo "selected"; ?>>Grenada</option>
                            <option value="GR" <?php if($geburtslandAzubi=="GR") echo "selected"; ?>>Griechenland</option>
                            <option value="GB" <?php if($geburtslandAzubi=="GB") echo "selected"; ?>>Großbritanien</option>
                            <option value="GCA" <?php if($geburtslandAzubi=="GCA") echo "selected"; ?>>Guatemala</option>
                            <option value="RG" <?php if($geburtslandAzubi=="RG") echo "selected"; ?>>Guinea</option>
                            <option value="GUB" <?php if($geburtslandAzubi=="GUB") echo "selected"; ?>>Guinea-Bissau</option>
                            <option value="GUY" <?php if($geburtslandAzubi=="GUY") echo "selected"; ?>>Guyana</option>

                            <!-- H -->
                            <option value="RH" <?php if($geburtslandAzubi=="RH") echo "selected"; ?>>Haiti</option>
                            <option value="HN" <?php if($geburtslandAzubi=="HN") echo "selected"; ?>>Honduras</option>
                            <option value="HOK" <?php if($geburtslandAzubi=="HOK") echo "selected"; ?>>Honkong (VR China)</option>

                            <!-- I -->
                            <option value="IND" <?php if($geburtslandAzubi=="IND") echo "selected"; ?>>Indien</option>
                            <option value="RI" <?php if($geburtslandAzubi=="RI") echo "selected"; ?>>Indonesien</option>
                            <option value="IRQ" <?php if($geburtslandAzubi=="IRQ") echo "selected"; ?>>Irak</option>
                            <option value="IR" <?php if($geburtslandAzubi=="IR") echo "selected"; ?>>Iran Islam. Rep.</option>
                            <option value="IRL" <?php if($geburtslandAzubi=="IRL") echo "selected"; ?>>Irland</option>
                            <option value="IS" <?php if($geburtslandAzubi=="IS") echo "selected"; ?>>Island</option>
                            <option value="IL" <?php if($geburtslandAzubi=="IL") echo "selected"; ?>>Israel</option>
                            <option value="I" <?php if($geburtslandAzubi=="I") echo "selected"; ?>>Italien</option>

                            <!-- J -->
                            <option value="JA" <?php if($geburtslandAzubi=="JA") echo "selected"; ?>>Jamaika</option>
                            <option value="J" <?php if($geburtslandAzubi=="J") echo "selected"; ?>>Japan</option>
                            <option value="YAR" <?php if($geburtslandAzubi=="YAR") echo "selected"; ?>>Jemen</option>
                            <option value="HKJ" <?php if($geburtslandAzubi=="HKJ") echo "selected"; ?>>Jordanien</option>

                            <!-- K -->
                            <option value="K" <?php if($geburtslandAzubi=="K") echo "selected"; ?>>Kambodscha Königr.</option>
                            <option value="CAM" <?php if($geburtslandAzubi=="CAM") echo "selected"; ?>>Kamerun</option>
                            <option value="CDN" <?php if($geburtslandAzubi=="CDN") echo "selected"; ?>>Kanada</option>
                            <option value="CV" <?php if($geburtslandAzubi=="CV") echo "selected"; ?>>Kap Verde</option>
                            <option value="KZ" <?php if($geburtslandAzubi=="KZ") echo "selected"; ?>>Kasachstan</option>
                            <option value="Q" <?php if($geburtslandAzubi=="Q") echo "selected"; ?>>Katar</option>
                            <option value="EAK" <?php if($geburtslandAzubi=="EAK") echo "selected"; ?>>Kenia</option>
                            <option value="KS" <?php if($geburtslandAzubi=="KS") echo "selected"; ?>>Kirgisistan</option>
                            <option value="KIR" <?php if($geburtslandAzubi=="KIR") echo "selected"; ?>>Kiribati</option>
                            <option value="CO" <?php if($geburtslandAzubi=="CO") echo "selected"; ?>>Kolumbien</option>
                            <option value="COM" <?php if($geburtslandAzubi=="COM") echo "selected"; ?>>Komoren</option>
                            <option value="COD" <?php if($geburtslandAzubi=="COD") echo "selected"; ?>>Kongo Dem. Rep.</option>
                            <option value="RCB" <?php if($geburtslandAzubi=="RCB") echo "selected"; ?>>Kongo Republik</option>
                            <option value="PRK" <?php if($geburtslandAzubi=="PRK") echo "selected"; ?>>Korea Dem. VR</option>
                            <option value="ROK" <?php if($geburtslandAzubi=="ROK") echo "selected"; ?>>Korea Republik</option>
                            <option value="XK" <?php if($geburtslandAzubi=="XK") echo "selected"; ?>>Kosovo</option>
                            <option value="HR" <?php if($geburtslandAzubi=="HR") echo "selected"; ?>>Kroatien</option>
                            <option value="CU" <?php if($geburtslandAzubi=="CU") echo "selected"; ?>>Kuba</option>
                            <option value="KWT" <?php if($geburtslandAzubi=="KWT") echo "selected"; ?>>Kuwait</option>

                            <!-- L -->
                            <option value="LAO" <?php if($geburtslandAzubi=="LAO") echo "selected"; ?>>Laos</option>
                            <option value="LS" <?php if($geburtslandAzubi=="LS") echo "selected"; ?>>Lesotho</option>
                            <option value="LV" <?php if($geburtslandAzubi=="LV") echo "selected"; ?>>Lettland</option>
                            <option value="RL" <?php if($geburtslandAzubi=="RL") echo "selected"; ?>>Libanon</option>
                            <option value="LB" <?php if($geburtslandAzubi=="LB") echo "selected"; ?>>Liberia</option>
                            <option value="LAR" <?php if($geburtslandAzubi=="LAR") echo "selected"; ?>>Libyen</option>
                            <option value="FL" <?php if($geburtslandAzubi=="FL") echo "selected"; ?>>Liechtenstein</option>
                            <option value="LT" <?php if($geburtslandAzubi=="LT") echo "selected"; ?>>Litauen</option>
                            <option value="L" <?php if($geburtslandAzubi=="L") echo "selected"; ?>>Luxemburg</option>

                            <!-- M -->
                            <option value="MAC" <?php if($geburtslandAzubi=="MAC") echo "selected"; ?>>Macau (VR China)</option>
                            <option value="RM" <?php if($geburtslandAzubi=="RM") echo "selected"; ?>>Madagaskar</option>
                            <option value="MW" <?php if($geburtslandAzubi=="MW") echo "selected"; ?>>Malawi</option>
                            <option value="MAL" <?php if($geburtslandAzubi=="MAL") echo "selected"; ?>>Malaysia</option>
                            <option value="MV" <?php if($geburtslandAzubi=="MV") echo "selected"; ?>>Malediven</option>
                            <option value="RMM" <?php if($geburtslandAzubi=="RMM") echo "selected"; ?>>Mali</option>
                            <option value="M" <?php if($geburtslandAzubi=="M") echo "selected"; ?>>Malta</option>
                            <option value="MA" <?php if($geburtslandAzubi=="MA") echo "selected"; ?>>Marokko</option>
                            <option value="MH" <?php if($geburtslandAzubi=="MH") echo "selected"; ?>>Marshallinseln</option>
                            <option value="RIM" <?php if($geburtslandAzubi=="RIM") echo "selected"; ?>>Mauretanien</option>
                            <option value="MS" <?php if($geburtslandAzubi=="MS") echo "selected"; ?>>Mauritius</option>
                            <option value="MEX" <?php if($geburtslandAzubi=="MEX") echo "selected"; ?>>Mexiko</option>
                            <option value="FSM" <?php if($geburtslandAzubi=="FSM") echo "selected"; ?>>Mikronesien Föd. St.</option>
                            <option value="MD" <?php if($geburtslandAzubi=="MD") echo "selected"; ?>>Moldau Republik</option>
                            <option value="MC" <?php if($geburtslandAzubi=="MC") echo "selected"; ?>>Monaco</option>
                            <option value="MGL" <?php if($geburtslandAzubi=="MGL") echo "selected"; ?>>Mongolei</option>
                            <option value="MNE" <?php if($geburtslandAzubi=="MNE") echo "selected"; ?>>Montenegro</option>
                            <option value="MOC" <?php if($geburtslandAzubi=="MOC") echo "selected"; ?>>Mosambik</option>
                            <option value="BUR" <?php if($geburtslandAzubi=="BUR") echo "selected"; ?>>Myanmar</option>

                            <!-- N -->
                            <option value="NAM" <?php if($geburtslandAzubi=="NAM") echo "selected"; ?>>Namibia</option>
                            <option value="NEP" <?php if($geburtslandAzubi=="NEP") echo "selected"; ?>>Nepal</option>
                            <option value="NZ" <?php if($geburtslandAzubi=="NZ") echo "selected"; ?>>Neuseeland</option>
                            <option value="NIC" <?php if($geburtslandAzubi=="NIC") echo "selected"; ?>>Nicaragua</option>
                            <option value="NL" <?php if($geburtslandAzubi=="NL") echo "selected"; ?>>Niederlande</option>
                            <option value="RN" <?php if($geburtslandAzubi=="RN") echo "selected"; ?>>Niger</option>
                            <option value="WAN" <?php if($geburtslandAzubi=="WAN") echo "selected"; ?>>Nigeria</option>
                            <option value="MP" <?php if($geburtslandAzubi=="MP") echo "selected"; ?>>Nördliche Marianen</option>
                            <option value="MK" <?php if($geburtslandAzubi=="MK") echo "selected"; ?>>Nordmazedonien</option>
                            <option value="N" <?php if($geburtslandAzubi=="N") echo "selected"; ?>>Norwegen</option>

                            <!-- O -->
                            <option value="OM" <?php if($geburtslandAzubi=="OM") echo "selected"; ?>>Oman</option>
                            <option value="A" <?php if($geburtslandAzubi=="A") echo "selected"; ?>>Österreich</option>

                            <!-- P -->
                            <option value="PK" <?php if($geburtslandAzubi=="PK") echo "selected"; ?>>Pakistan</option>
                            <option value="AUT" <?php if($geburtslandAzubi=="AUT") echo "selected"; ?>>Palästina</option>
                            <option value="PA" <?php if($geburtslandAzubi=="PA") echo "selected"; ?>>Panama</option>
                            <option value="PNG" <?php if($geburtslandAzubi=="PNG") echo "selected"; ?>>Papua-Neuguinea</option>
                            <option value="PY" <?php if($geburtslandAzubi=="PY") echo "selected"; ?>>Paraguay</option>
                            <option value="PE" <?php if($geburtslandAzubi=="PE") echo "selected"; ?>>Peru</option>
                            <option value="RP" <?php if($geburtslandAzubi=="RP") echo "selected"; ?>>Philippinen</option>
                            <option value="PL" <?php if($geburtslandAzubi=="PL") echo "selected"; ?>>Polen</option>
                            <option value="P" <?php if($geburtslandAzubi=="P") echo "selected"; ?>>Portugal</option>

                            <!-- R -->
                            <option value="SDN" <?php if($geburtslandAzubi=="SDN") echo "selected"; ?>>Republik Sudan</option>
                            <option value="RWA" <?php if($geburtslandAzubi=="RWA") echo "selected"; ?>>Ruanda</option>
                            <option value="R" <?php if($geburtslandAzubi=="R") echo "selected"; ?>>Rumänien</option>
                            <option value="RUS" <?php if($geburtslandAzubi=="RUS") echo "selected"; ?>>Russische Föderation</option>

                            <!-- S -->
                            <option value="RNR" <?php if($geburtslandAzubi=="RNR") echo "selected"; ?>>Sambia</option>
                            <option value="RSM" <?php if($geburtslandAzubi=="RSM") echo "selected"; ?>>San Marino</option>
                            <option value="STP" <?php if($geburtslandAzubi=="STP") echo "selected"; ?>>S&atilde;o Tom&eacute; und Principe</option>
                            <option value="SA" <?php if($geburtslandAzubi=="SA") echo "selected"; ?>>Saudi-Arabien</option>
                            <option value="S" <?php if($geburtslandAzubi=="S") echo "selected"; ?>>Schweden</option>
                            <option value="CH" <?php if($geburtslandAzubi=="CH") echo "selected"; ?>>Schweiz</option>
                            <option value="SN" <?php if($geburtslandAzubi=="SN") echo "selected"; ?>>Senegal</option>
                            <option value="SRB" <?php if($geburtslandAzubi=="SRB") echo "selected"; ?>>Serbien</option>
                            <option value="SY" <?php if($geburtslandAzubi=="SY") echo "selected"; ?>>Seychellen</option>
                            <option value="WAL" <?php if($geburtslandAzubi=="WAL") echo "selected"; ?>>Sierra Leone</option>
                            <option value="ZW" <?php if($geburtslandAzubi=="ZW") echo "selected"; ?>>Simbabwe</option>
                            <option value="SGP" <?php if($geburtslandAzubi=="SGP") echo "selected"; ?>>Singapur</option>
                            <option value="SK" <?php if($geburtslandAzubi=="SK") echo "selected"; ?>>Slowakei</option>
                            <option value="SLO" <?php if($geburtslandAzubi=="SLO") echo "selected"; ?>>Slowenien</option>
                            <option value="SO" <?php if($geburtslandAzubi=="SO") echo "selected"; ?>>Somalia</option>
                            <option value="E" <?php if($geburtslandAzubi=="E") echo "selected"; ?>>Spanien</option>
                            <option value="CL" <?php if($geburtslandAzubi=="CL") echo "selected"; ?>>Sri Lanka</option>
                            <option value="KAN" <?php if($geburtslandAzubi=="KAN") echo "selected"; ?>>St. Kitts und Nevis</option>
                            <option value="WL" <?php if($geburtslandAzubi=="WL") echo "selected"; ?>>St. Lucia</option>
                            <option value="WV" <?php if($geburtslandAzubi=="WV") echo "selected"; ?>>St. Vincent u. Grenad.</option>
                            <option value="ZA" <?php if($geburtslandAzubi=="ZA") echo "selected"; ?>>Südafrika</option>
                            <option value="SSDN" <?php if($geburtslandAzubi=="SSDN") echo "selected"; ?>>Südsudan</option>
                            <option value="SME" <?php if($geburtslandAzubi=="SME") echo "selected"; ?>>Suriname</option>
                            <option value="SYR" <?php if($geburtslandAzubi=="SYR") echo "selected"; ?>>Syrien</option>

                            <!-- T -->
                            <option value="TJ" <?php if($geburtslandAzubi=="TJ") echo "selected"; ?>>Tadschikistan</option>
                            <option value="TW" <?php if($geburtslandAzubi=="TW") echo "selected"; ?>>Taiwan</option>
                            <option value="EAT" <?php if($geburtslandAzubi=="EAT") echo "selected"; ?>>Tansania Ver. Rep.</option>
                            <option value="T" <?php if($geburtslandAzubi=="T") echo "selected"; ?>>Thailand</option>
                            <option value="TL" <?php if($geburtslandAzubi=="TL") echo "selected"; ?>>Timor-Leste</option>
                            <option value="TG" <?php if($geburtslandAzubi=="TG") echo "selected"; ?>>Togo</option>
                            <option value="TT" <?php if($geburtslandAzubi=="TT") echo "selected"; ?>>Trinidad und Tobago</option>
                            <option value="TD" <?php if($geburtslandAzubi=="TD") echo "selected"; ?>>Tschad</option>
                            <option value="CZ" <?php if($geburtslandAzubi=="CZ") echo "selected"; ?>>Tschechische Repbulik</option>
                            <option value="TN" <?php if($geburtslandAzubi=="TN") echo "selected"; ?>>Tunesien</option>
                            <option value="TR" <?php if($geburtslandAzubi=="TR") echo "selected"; ?>>Türkei</option>
                            <option value="TM" <?php if($geburtslandAzubi=="ggTMggg") echo "selected"; ?>>Turkmenistan</option>

                            <!-- U -->
                            <option value="UG" <?php if($geburtslandAzubi=="UG") echo "selected"; ?>>Uganda</option>
                            <option value="UA" <?php if($geburtslandAzubi=="UA") echo "selected"; ?>>Ukraine</option>
                            <option value="H" <?php if($geburtslandAzubi=="H") echo "selected"; ?>>Ungarn</option>
                            <option value="UAF" <?php if($geburtslandAzubi=="UAF") echo "selected"; ?>>Unselbst. Geb. i. Afrika</option>
                            <option value="ROU" <?php if($geburtslandAzubi=="ROU") echo "selected"; ?>>Uruguay</option>
                            <option value="USA" <?php if($geburtslandAzubi=="USA") echo "selected"; ?>>USA</option>
                            <option value="UZ" <?php if($geburtslandAzubi=="UZ") echo "selected"; ?>>Usbekistan</option>

                            <!-- V -->
                            <option value="V" <?php if($geburtslandAzubi=="V") echo "selected"; ?>>Vatikanstadt</option>
                            <option value="YV" <?php if($geburtslandAzubi=="YV") echo "selected"; ?>>Venezuela</option>
                            <option value="UAE" <?php if($geburtslandAzubi=="UAE") echo "selected"; ?>>Ver. Arab. Emirate</option>
                            <option value="VN" <?php if($geburtslandAzubi=="VN") echo "selected"; ?>>Vietnam</option>

                            <!-- W -->
                            <option value="BY" <?php if($geburtslandAzubi=="BY") echo "selected"; ?>>Weißrussland</option>

                            <!-- Z -->
                            <option value="RCA" <?php if($geburtslandAzubi=="RCA") echo "selected"; ?>>Zentralafrikan. Republik</option>
                            <option value="CY" <?php if($geburtslandAzubi=="CY") echo "selected"; ?>>Zypern</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfStrasseAzubi">*Straße</label>
                        <input type="text" placeholder="Straße" name="tfStrasseAzubi" id="tfStrasseAzubi" value="<?php if (isset($strasseAzubi)) echo $strasseAzubi;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfHausnrAzubi">*Hausnummer</label>
                        <input type="text" placeholder="Hausnummer" name="tfHausnrAzubi" id="tfHausnrAzubi" value="<?php if (isset($hausnrAzubi)) echo $hausnrAzubi;?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfPLZAzubi">*Postleitzahl</label>
                        <span class="error"><?php if(isset($errors["plzAzubi"])) echo $errors["plzAzubi"]; ?></span>
                        <input type="text" placeholder="Postleitzahl" name="tfPLZAzubi" id="tfPLZAzubi" value="<?php if (isset($plzAzubi)) echo $plzAzubi;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfOrtAzubi">*Ort</label>
                        <input type="text" placeholder="Ort" name="tfOrtAzubi" id="tfOrtAzubi" value="<?php if (isset($ortAzubi)) echo $ortAzubi;?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfOrtsteilAzubi">Ortsteil</label>
                        <input type="text" placeholder="Ortsteil" name="tfOrtsteilAzubi" id="tfOrtsteilAzubi" value="<?php if (isset($ortsteilAzubi)) echo $ortsteilAzubi;?>">
                    </div>
                    <div class="form-col">
                        <label for="tfTelefonAzubi">Telefon</label>
                        <input type="text" placeholder="Telefon" name="tfTelefonAzubi" id="tfTelefonAzubi" value="<?php if (isset($telefonAzubi)) echo $telefonAzubi;?>">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfEmailAzubi">*E-Mail</label>
                        <span class="error"><?php if(isset($errors["emailAzubi"])) echo $errors["emailAzubi"]; ?></span>
                        <input type="text" placeholder="E-Mail" name="tfEmailAzubi" id="tfEmailAzubi" value="<?php if (isset($emailAzubi)) echo $emailAzubi;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfMobilAzubi">*Mobil</label>
                        <input type="text" placeholder="Mobil" name="tfMobilAzubi" id="tfMobilAzubi" value="<?php if (isset($mobilAzubi)) echo $mobilAzubi;?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="selectSpracheAzubi">*Zuhause gesprochene Sprache</label>
                        <select name="selectSpracheAzubi" id="selectSpracheAzubi" required>
                            <option value="" selected disabled hidden>Bitte wählen:</option>
                            <option value="D" <?php if($spracheAzubi == 'D') echo 'selected';?>>deutsch</option>
                            <option disabled>--------------</option>
                            <option value="ALB"<?php if($spracheAzubi == 'ALB') echo 'selected';?>>albanisch</option>
                            <option value="ARA"<?php if($spracheAzubi == 'ARA') echo 'selected';?>>arabisch</option>
                            <option value="BOS"<?php if($spracheAzubi == 'BOS') echo 'selected';?>>bosnisch</option>
                            <option value="BUL"<?php if($spracheAzubi == 'BUL') echo 'selected';?>>bulgarisch</option>
                            <option value="CHIN"<?php if($spracheAzubi == 'CHIN') echo 'selected';?>>chinesisch</option>
                            <option value="DK"<?php if($spracheAzubi == 'DK') echo 'selected';?>>dänisch</option>
                            <option value="E"<?php if($spracheAzubi == 'E') echo 'selected';?>>englisch</option>
                            <option value="EST"<?php if($spracheAzubi == 'EST') echo 'selected';?>>estnisch</option>
                            <option value="F"<?php if($spracheAzubi == 'F') echo 'selected';?>>französisch</option>
                            <option value="GR-N"<?php if($spracheAzubi == 'GR-N') echo 'selected';?>>griechisch</option>
                            <option value="I"<?php if($spracheAzubi == 'I') echo 'selected';?>>italienisch</option>
                            <option value="JAP"<?php if($spracheAzubi == 'JAP') echo 'selected';?>>japanisch</option>
                            <option value="KAS"<?php if($spracheAzubi == 'KAS') echo 'selected';?>>kasachisch</option>
                            <option value="K_A"<?php if($spracheAzubi == 'K_A') echo 'selected';?>>Keine Angabe</option>
                            <option value="KRO"<?php if($spracheAzubi == 'KRO') echo 'selected';?>>kroatisch</option>
                            <option value="KUR"<?php if($spracheAzubi == 'KUR') echo 'selected';?>>kurdisch</option>
                            <option value="LET"<?php if($spracheAzubi == 'LET') echo 'selected';?>>lettisch</option>
                            <option value="LIT"<?php if($spracheAzubi == 'LIT') echo 'selected';?>>litauisch</option>
                            <option value="MAZ"<?php if($spracheAzubi == 'MAZ') echo 'selected';?>>mazedonisch</option>
                            <option value="NL"<?php if($spracheAzubi == 'NL') echo 'selected';?>>niederländisch</option>
                            <option value="PS"<?php if($spracheAzubi == 'PS') echo 'selected';?>>persisch</option>
                            <option value="POL"<?php if($spracheAzubi == 'POL') echo 'selected';?>>polnisch</option>
                            <option value="POR"<?php if($spracheAzubi == 'POR') echo 'selected';?>>portugiesisch</option>
                            <option value="RUM"<?php if($spracheAzubi == 'RUM') echo 'selected';?>>rumänisch</option>
                            <option value="RU"<?php if($spracheAzubi == 'RU') echo 'selected';?>>russisch</option>
                            <option value="S"<?php if($spracheAzubi == 'S') echo 'selected';?>>schwedisch</option>
                            <option value="SER"<?php if($spracheAzubi == 'SER') echo 'selected';?>>serbisch</option>
                            <option value="SL"<?php if($spracheAzubi == 'SL') echo 'selected';?>>slowakisch</option>
                            <option value="SLO"<?php if($spracheAzubi == 'SLO') echo 'selected';?>>slowenisch</option>
                            <option value="SOF"<?php if($spracheAzubi == 'SOF') echo 'selected';?>>Sonstige Sprache</option>
                            <option value="SP"<?php if($spracheAzubi == 'SP') echo 'selected';?>>spanisch</option>
                            <option value="T"<?php if($spracheAzubi == 'T') echo 'selected';?>>tschechisch</option>
                            <option value="TÜ"<?php if($spracheAzubi == 'TÜ') echo 'selected';?>>türkisch</option>
                            <option value="UKR"<?php if($spracheAzubi == 'UKR') echo 'selected';?>>ukrainisch</option>
                            <option value="U"<?php if($spracheAzubi == 'U') echo 'selected';?>>ungarisch</option>
                            <option value="V"<?php if($spracheAzubi == 'V') echo 'selected';?>>vietnamesisch</option>
                            <option value="WR"<?php if($spracheAzubi == 'WR') echo 'selected';?>>weißrussisch</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="selectNationalitaet">*Nationalität</label>
                        <select name="selectNationalitaet" id="selectNationalitaet" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="D" <?php if($nationalitaetAzubi == 'D') echo 'selected';?>>Deutschland</option>
                            <option disabled>--------------</option>

                            <!-- A -->
                            <option value="AFG" <?php if($nationalitaetAzubi == 'AFG') echo 'selected';?>>Afghanistan</option>
                            <option value="ET" <?php if($nationalitaetAzubi=="ET") echo "selected"; ?>>Ägypten</option>
                            <option value="AL" <?php if($nationalitaetAzubi=="AL") echo "selected"; ?>>Albanien</option>
                            <option value="DZ" <?php if($nationalitaetAzubi=="DZ") echo "selected"; ?>>Algerien</option>
                            <option value="AND" <?php if($nationalitaetAzubi=="\AND") echo "selected"; ?>>Andorra</option>
                            <option value="ANG" <?php if($nationalitaetAzubi=="ANG") echo "selected"; ?>>Angola</option>
                            <option value="AG" <?php if($nationalitaetAzubi=="AG") echo "selected"; ?>>Antigua und Barbuda</option>
                            <option value="GQ" <?php if($nationalitaetAzubi=="GQ") echo "selected"; ?>>Äquatorialguinea</option>
                            <option value="RA" <?php if($nationalitaetAzubi=="RA") echo "selected"; ?>>Argentinien</option>
                            <option value="AM" <?php if($nationalitaetAzubi=="AM") echo "selected"; ?>>Armenien</option>
                            <option value="AZ" <?php if($nationalitaetAzubi=="AZ") echo "selected"; ?>>Aserbaidschan</option>
                            <option value="ETH" <?php if($nationalitaetAzubi=="ETH") echo "selected"; ?>>Äthiopien</option>
                            <option value="AUS" <?php if($nationalitaetAzubi=="AUS") echo "selected"; ?>>Australien</option>

                            <!-- B -->
                            <option value="BS" <?php if($nationalitaetAzubi=="BS") echo "selected"; ?>>Bahamas</option>
                            <option value="BRN" <?php if($nationalitaetAzubi=="BRN") echo "selected"; ?>>Bahrain</option>
                            <option value="BD" <?php if($nationalitaetAzubi=="BD") echo "selected"; ?>>Bangladesch</option>
                            <option value="B" <?php if($nationalitaetAzubi=="B") echo "selected"; ?>>Belgien</option>
                            <option value="BH" <?php if($nationalitaetAzubi=="BH") echo "selected"; ?>>Belize</option>
                            <option value="DY" <?php if($nationalitaetAzubi=="DY") echo "selected"; ?>>Benin</option>
                            <option value="BHT" <?php if($nationalitaetAzubi=="BHT") echo "selected"; ?>>Bhutan</option>
                            <option value="BOL" <?php if($nationalitaetAzubi=="BOL") echo "selected"; ?>>Bolivien</option>
                            <option value="BIH" <?php if($nationalitaetAzubi=="BIH") echo "selected"; ?>>Bosnien-Herzegowina</option>
                            <option value="BW" <?php if($nationalitaetAzubi=="BW") echo "selected"; ?>>Botsuana</option>
                            <option value="BR" <?php if($nationalitaetAzubi=="BR") echo "selected"; ?>>Brasilien</option>
                            <option value="GB3" <?php if($nationalitaetAzubi=="GB3") echo "selected"; ?>>Brit. Geb. in Amerika</option>
                            <option value="GB1" <?php if($nationalitaetAzubi=="GB1") echo "selected"; ?>>Brit. Geb. in Europa</option>
                            <option value="GB5" <?php if($nationalitaetAzubi=="GB5") echo "selected"; ?>>Brit. Geb. in Ozeanien</option>
                            <option value="BRU" <?php if($nationalitaetAzubi=="BRU") echo "selected"; ?>>Brunei Darussalam</option>
                            <option value="BG" <?php if($nationalitaetAzubi=="BG") echo "selected"; ?>>Bulgarien</option>
                            <option value="BF" <?php if($nationalitaetAzubi=="B") echo "selected"; ?>>Burkina Faso</option>
                            <option value="RU" <?php if($nationalitaetAzubi=="RU") echo "selected"; ?>>Burundi</option>

                            <!-- C -->
                            <option value="RCH" <?php if($nationalitaetAzubi=="RCH") echo "selected"; ?>>Chile</option>
                            <option value="RC" <?php if($nationalitaetAzubi=="RC") echo "selected"; ?>>China VR</option>
                            <option value="CR" <?php if($nationalitaetAzubi=="CR") echo "selected"; ?>>Costa Rica</option>
                            <option value="CI" <?php if($nationalitaetAzubi=="CI") echo "selected"; ?>>C&#244;te d'Ivoire</option>

                            <!-- D -->
                            <option value="DK" <?php if($nationalitaetAzubi=="DK") echo "selected"; ?>>Dänemark</option>
                            <option value="WD" <?php if($nationalitaetAzubi=="WD") echo "selected"; ?>>Dominica</option>
                            <option value="DOM" <?php if($nationalitaetAzubi=="DOM") echo "selected"; ?>>Dominikanische Rep.</option>
                            <option value="DJI" <?php if($nationalitaetAzubi=="DJI") echo "selected"; ?>>Dschibuti</option>

                            <!-- E -->
                            <option value="EC" <?php if($nationalitaetAzubi=="EC") echo "selected"; ?>>Ecuador</option>
                            <option value="ES" <?php if($nationalitaetAzubi=="ES") echo "selected"; ?>>El Salvador</option>
                            <option value="ER" <?php if($nationalitaetAzubi=="ER") echo "selected"; ?>>Eritrea</option>
                            <option value="EST" <?php if($nationalitaetAzubi=="EST") echo "selected"; ?>>Estland</option>
                            <option value="SD" <?php if($nationalitaetAzubi=="SD") echo "selected"; ?>>Eswatini</option>

                            <!-- F -->
                            <option value="FJI" <?php if($nationalitaetAzubi=="FJI") echo "selected"; ?>>Fidschi</option>
                            <option value="FIN" <?php if($nationalitaetAzubi=="FIN") echo "selected"; ?>>Finnland</option>
                            <option value="F" <?php if($nationalitaetAzubi=="F") echo "selected"; ?>>Frankreich</option>

                            <!-- G -->
                            <option value="G" <?php if($nationalitaetAzubi=="G") echo "selected"; ?>>Gabub</option>
                            <option value="WAG" <?php if($nationalitaetAzubi=="WAG") echo "selected"; ?>>Gambia</option>
                            <option value="GE" <?php if($nationalitaetAzubi=="GE") echo "selected"; ?>>Georgien</option>
                            <option value="GH" <?php if($nationalitaetAzubi=="GH") echo "selected"; ?>>Ghana</option>
                            <option value="WG" <?php if($nationalitaetAzubi=="WG") echo "selected"; ?>>Grenada</option>
                            <option value="GR" <?php if($nationalitaetAzubi=="GR") echo "selected"; ?>>Griechenland</option>
                            <option value="GB" <?php if($nationalitaetAzubi=="GB") echo "selected"; ?>>Großbritanien</option>
                            <option value="GCA" <?php if($nationalitaetAzubi=="GCA") echo "selected"; ?>>Guatemala</option>
                            <option value="RG" <?php if($nationalitaetAzubi=="RG") echo "selected"; ?>>Guinea</option>
                            <option value="GUB" <?php if($nationalitaetAzubi=="GUB") echo "selected"; ?>>Guinea-Bissau</option>
                            <option value="GUY" <?php if($nationalitaetAzubi=="GUY") echo "selected"; ?>>Guyana</option>

                            <!-- H -->
                            <option value="RH" <?php if($nationalitaetAzubi=="RH") echo "selected"; ?>>Haiti</option>
                            <option value="HN" <?php if($nationalitaetAzubi=="HN") echo "selected"; ?>>Honduras</option>
                            <option value="HOK" <?php if($nationalitaetAzubi=="HOK") echo "selected"; ?>>Honkong (VR China)</option>

                            <!-- I -->
                            <option value="IND" <?php if($nationalitaetAzubi=="IND") echo "selected"; ?>>Indien</option>
                            <option value="RI" <?php if($nationalitaetAzubi=="RI") echo "selected"; ?>>Indonesien</option>
                            <option value="IRQ" <?php if($nationalitaetAzubi=="IRQ") echo "selected"; ?>>Irak</option>
                            <option value="IR" <?php if($nationalitaetAzubi=="IR") echo "selected"; ?>>Iran Islam. Rep.</option>
                            <option value="IRL" <?php if($nationalitaetAzubi=="IRL") echo "selected"; ?>>Irland</option>
                            <option value="IS" <?php if($nationalitaetAzubi=="IS") echo "selected"; ?>>Island</option>
                            <option value="IL" <?php if($nationalitaetAzubi=="IL") echo "selected"; ?>>Israel</option>
                            <option value="I" <?php if($nationalitaetAzubi=="I") echo "selected"; ?>>Italien</option>

                            <!-- J -->
                            <option value="JA" <?php if($nationalitaetAzubi=="JA") echo "selected"; ?>>Jamaika</option>
                            <option value="J" <?php if($nationalitaetAzubi=="J") echo "selected"; ?>>Japan</option>
                            <option value="YAR" <?php if($nationalitaetAzubi=="YAR") echo "selected"; ?>>Jemen</option>
                            <option value="HKJ" <?php if($nationalitaetAzubi=="HKJ") echo "selected"; ?>>Jordanien</option>

                            <!-- K -->
                            <option value="K" <?php if($nationalitaetAzubi=="K") echo "selected"; ?>>Kambodscha Königr.</option>
                            <option value="CAM" <?php if($nationalitaetAzubi=="CAM") echo "selected"; ?>>Kamerun</option>
                            <option value="CDN" <?php if($nationalitaetAzubi=="CDN") echo "selected"; ?>>Kanada</option>
                            <option value="CV" <?php if($nationalitaetAzubi=="CV") echo "selected"; ?>>Kap Verde</option>
                            <option value="KZ" <?php if($nationalitaetAzubi=="KZ") echo "selected"; ?>>Kasachstan</option>
                            <option value="Q" <?php if($nationalitaetAzubi=="Q") echo "selected"; ?>>Katar</option>
                            <option value="EAK" <?php if($nationalitaetAzubi=="EAK") echo "selected"; ?>>Kenia</option>
                            <option value="KS" <?php if($nationalitaetAzubi=="KS") echo "selected"; ?>>Kirgisistan</option>
                            <option value="KIR" <?php if($nationalitaetAzubi=="KIR") echo "selected"; ?>>Kiribati</option>
                            <option value="CO" <?php if($nationalitaetAzubi=="CO") echo "selected"; ?>>Kolumbien</option>
                            <option value="COM" <?php if($nationalitaetAzubi=="COM") echo "selected"; ?>>Komoren</option>
                            <option value="COD" <?php if($nationalitaetAzubi=="COD") echo "selected"; ?>>Kongo Dem. Rep.</option>
                            <option value="RCB" <?php if($nationalitaetAzubi=="RCB") echo "selected"; ?>>Kongo Republik</option>
                            <option value="PRK" <?php if($nationalitaetAzubi=="PRK") echo "selected"; ?>>Korea Dem. VR</option>
                            <option value="ROK" <?php if($nationalitaetAzubi=="ROK") echo "selected"; ?>>Korea Republik</option>
                            <option value="XK" <?php if($nationalitaetAzubi=="XK") echo "selected"; ?>>Kosovo</option>
                            <option value="HR" <?php if($nationalitaetAzubi=="HR") echo "selected"; ?>>Kroatien</option>
                            <option value="CU" <?php if($nationalitaetAzubi=="CU") echo "selected"; ?>>Kuba</option>
                            <option value="KWT" <?php if($nationalitaetAzubi=="KWT") echo "selected"; ?>>Kuwait</option>

                            <!-- L -->
                            <option value="LAO" <?php if($nationalitaetAzubi=="LAO") echo "selected"; ?>>Laos</option>
                            <option value="LS" <?php if($nationalitaetAzubi=="LS") echo "selected"; ?>>Lesotho</option>
                            <option value="LV" <?php if($nationalitaetAzubi=="LV") echo "selected"; ?>>Lettland</option>
                            <option value="RL" <?php if($nationalitaetAzubi=="RL") echo "selected"; ?>>Libanon</option>
                            <option value="LB" <?php if($nationalitaetAzubi=="LB") echo "selected"; ?>>Liberia</option>
                            <option value="LAR" <?php if($nationalitaetAzubi=="LAR") echo "selected"; ?>>Libyen</option>
                            <option value="FL" <?php if($nationalitaetAzubi=="FL") echo "selected"; ?>>Liechtenstein</option>
                            <option value="LT" <?php if($nationalitaetAzubi=="LT") echo "selected"; ?>>Litauen</option>
                            <option value="L" <?php if($nationalitaetAzubi=="L") echo "selected"; ?>>Luxemburg</option>

                            <!-- M -->
                            <option value="MAC" <?php if($nationalitaetAzubi=="MAC") echo "selected"; ?>>Macau (VR China)</option>
                            <option value="RM" <?php if($nationalitaetAzubi=="RM") echo "selected"; ?>>Madagaskar</option>
                            <option value="MW" <?php if($nationalitaetAzubi=="MW") echo "selected"; ?>>Malawi</option>
                            <option value="MAL" <?php if($nationalitaetAzubi=="MAL") echo "selected"; ?>>Malaysia</option>
                            <option value="MV" <?php if($nationalitaetAzubi=="MV") echo "selected"; ?>>Malediven</option>
                            <option value="RMM" <?php if($nationalitaetAzubi=="RMM") echo "selected"; ?>>Mali</option>
                            <option value="M" <?php if($nationalitaetAzubi=="M") echo "selected"; ?>>Malta</option>
                            <option value="MA" <?php if($nationalitaetAzubi=="MA") echo "selected"; ?>>Marokko</option>
                            <option value="MH" <?php if($nationalitaetAzubi=="MH") echo "selected"; ?>>Marshallinseln</option>
                            <option value="RIM" <?php if($nationalitaetAzubi=="RIM") echo "selected"; ?>>Mauretanien</option>
                            <option value="MS" <?php if($nationalitaetAzubi=="MS") echo "selected"; ?>>Mauritius</option>
                            <option value="MEX" <?php if($nationalitaetAzubi=="MEX") echo "selected"; ?>>Mexiko</option>
                            <option value="FSM" <?php if($nationalitaetAzubi=="FSM") echo "selected"; ?>>Mikronesien Föd. St.</option>
                            <option value="MD" <?php if($nationalitaetAzubi=="MD") echo "selected"; ?>>Moldau Republik</option>
                            <option value="MC" <?php if($nationalitaetAzubi=="MC") echo "selected"; ?>>Monaco</option>
                            <option value="MGL" <?php if($nationalitaetAzubi=="MGL") echo "selected"; ?>>Mongolei</option>
                            <option value="MNE" <?php if($nationalitaetAzubi=="MNE") echo "selected"; ?>>Montenegro</option>
                            <option value="MOC" <?php if($nationalitaetAzubi=="MOC") echo "selected"; ?>>Mosambik</option>
                            <option value="BUR" <?php if($nationalitaetAzubi=="BUR") echo "selected"; ?>>Myanmar</option>

                            <!-- N -->
                            <option value="NAM" <?php if($nationalitaetAzubi=="NAM") echo "selected"; ?>>Namibia</option>
                            <option value="NEP" <?php if($nationalitaetAzubi=="NEP") echo "selected"; ?>>Nepal</option>
                            <option value="NZ" <?php if($nationalitaetAzubi=="NZ") echo "selected"; ?>>Neuseeland</option>
                            <option value="NIC" <?php if($nationalitaetAzubi=="NIC") echo "selected"; ?>>Nicaragua</option>
                            <option value="NL" <?php if($nationalitaetAzubi=="NL") echo "selected"; ?>>Niederlande</option>
                            <option value="RN" <?php if($nationalitaetAzubi=="RN") echo "selected"; ?>>Niger</option>
                            <option value="WAN" <?php if($nationalitaetAzubi=="WAN") echo "selected"; ?>>Nigeria</option>
                            <option value="MP" <?php if($nationalitaetAzubi=="MP") echo "selected"; ?>>Nördliche Marianen</option>
                            <option value="MK" <?php if($nationalitaetAzubi=="MK") echo "selected"; ?>>Nordmazedonien</option>
                            <option value="N" <?php if($nationalitaetAzubi=="N") echo "selected"; ?>>Norwegen</option>

                            <!-- O -->
                            <option value="OM" <?php if($nationalitaetAzubi=="OM") echo "selected"; ?>>Oman</option>
                            <option value="A" <?php if($nationalitaetAzubi=="A") echo "selected"; ?>>Österreich</option>

                            <!-- P -->
                            <option value="PK" <?php if($nationalitaetAzubi=="PK") echo "selected"; ?>>Pakistan</option>
                            <option value="AUT" <?php if($nationalitaetAzubi=="AUT") echo "selected"; ?>>Palästina</option>
                            <option value="PA" <?php if($nationalitaetAzubi=="PA") echo "selected"; ?>>Panama</option>
                            <option value="PNG" <?php if($nationalitaetAzubi=="PNG") echo "selected"; ?>>Papua-Neuguinea</option>
                            <option value="PY" <?php if($nationalitaetAzubi=="PY") echo "selected"; ?>>Paraguay</option>
                            <option value="PE" <?php if($nationalitaetAzubi=="PE") echo "selected"; ?>>Peru</option>
                            <option value="RP" <?php if($nationalitaetAzubi=="RP") echo "selected"; ?>>Philippinen</option>
                            <option value="PL" <?php if($nationalitaetAzubi=="PL") echo "selected"; ?>>Polen</option>
                            <option value="P" <?php if($nationalitaetAzubi=="P") echo "selected"; ?>>Portugal</option>

                            <!-- R -->
                            <option value="SDN" <?php if($nationalitaetAzubi=="SDN") echo "selected"; ?>>Republik Sudan</option>
                            <option value="RWA" <?php if($nationalitaetAzubi=="RWA") echo "selected"; ?>>Ruanda</option>
                            <option value="R" <?php if($nationalitaetAzubi=="R") echo "selected"; ?>>Rumänien</option>
                            <option value="RUS" <?php if($nationalitaetAzubi=="RUS") echo "selected"; ?>>Russische Föderation</option>

                            <!-- S -->
                            <option value="RNR" <?php if($nationalitaetAzubi=="RNR") echo "selected"; ?>>Sambia</option>
                            <option value="RSM" <?php if($nationalitaetAzubi=="RSM") echo "selected"; ?>>San Marino</option>
                            <option value="STP" <?php if($nationalitaetAzubi=="STP") echo "selected"; ?>>S&atilde;o Tom&eacute; und Principe</option>
                            <option value="SA" <?php if($nationalitaetAzubi=="SA") echo "selected"; ?>>Saudi-Arabien</option>
                            <option value="S" <?php if($nationalitaetAzubi=="S") echo "selected"; ?>>Schweden</option>
                            <option value="CH" <?php if($nationalitaetAzubi=="CH") echo "selected"; ?>>Schweiz</option>
                            <option value="SN" <?php if($nationalitaetAzubi=="SN") echo "selected"; ?>>Senegal</option>
                            <option value="SRB" <?php if($nationalitaetAzubi=="SRB") echo "selected"; ?>>Serbien</option>
                            <option value="SY" <?php if($nationalitaetAzubi=="SY") echo "selected"; ?>>Seychellen</option>
                            <option value="WAL" <?php if($nationalitaetAzubi=="WAL") echo "selected"; ?>>Sierra Leone</option>
                            <option value="ZW" <?php if($nationalitaetAzubi=="ZW") echo "selected"; ?>>Simbabwe</option>
                            <option value="SGP" <?php if($nationalitaetAzubi=="SGP") echo "selected"; ?>>Singapur</option>
                            <option value="SK" <?php if($nationalitaetAzubi=="SK") echo "selected"; ?>>Slowakei</option>
                            <option value="SLO" <?php if($nationalitaetAzubi=="SLO") echo "selected"; ?>>Slowenien</option>
                            <option value="SO" <?php if($nationalitaetAzubi=="SO") echo "selected"; ?>>Somalia</option>
                            <option value="E" <?php if($nationalitaetAzubi=="E") echo "selected"; ?>>Spanien</option>
                            <option value="CL" <?php if($nationalitaetAzubi=="CL") echo "selected"; ?>>Sri Lanka</option>
                            <option value="KAN" <?php if($nationalitaetAzubi=="KAN") echo "selected"; ?>>St. Kitts und Nevis</option>
                            <option value="WL" <?php if($nationalitaetAzubi=="WL") echo "selected"; ?>>St. Lucia</option>
                            <option value="WV" <?php if($nationalitaetAzubi=="WV") echo "selected"; ?>>St. Vincent u. Grenad.</option>
                            <option value="ZA" <?php if($nationalitaetAzubi=="ZA") echo "selected"; ?>>Südafrika</option>
                            <option value="SSDN" <?php if($nationalitaetAzubi=="SSDN") echo "selected"; ?>>Südsudan</option>
                            <option value="SME" <?php if($nationalitaetAzubi=="SME") echo "selected"; ?>>Suriname</option>
                            <option value="SYR" <?php if($nationalitaetAzubi=="SYR") echo "selected"; ?>>Syrien</option>

                            <!-- T -->
                            <option value="TJ" <?php if($nationalitaetAzubi=="TJ") echo "selected"; ?>>Tadschikistan</option>
                            <option value="TW" <?php if($nationalitaetAzubi=="TW") echo "selected"; ?>>Taiwan</option>
                            <option value="EAT" <?php if($nationalitaetAzubi=="EAT") echo "selected"; ?>>Tansania Ver. Rep.</option>
                            <option value="T" <?php if($nationalitaetAzubi=="T") echo "selected"; ?>>Thailand</option>
                            <option value="TL" <?php if($nationalitaetAzubi=="TL") echo "selected"; ?>>Timor-Leste</option>
                            <option value="TG" <?php if($nationalitaetAzubi=="TG") echo "selected"; ?>>Togo</option>
                            <option value="TT" <?php if($nationalitaetAzubi=="TT") echo "selected"; ?>>Trinidad und Tobago</option>
                            <option value="TD" <?php if($nationalitaetAzubi=="TD") echo "selected"; ?>>Tschad</option>
                            <option value="CZ" <?php if($nationalitaetAzubi=="CZ") echo "selected"; ?>>Tschechische Repbulik</option>
                            <option value="TN" <?php if($nationalitaetAzubi=="TN") echo "selected"; ?>>Tunesien</option>
                            <option value="TR" <?php if($nationalitaetAzubi=="TR") echo "selected"; ?>>Türkei</option>
                            <option value="TM" <?php if($nationalitaetAzubi=="ggTMggg") echo "selected"; ?>>Turkmenistan</option>

                            <!-- U -->
                            <option value="UG" <?php if($nationalitaetAzubi=="UG") echo "selected"; ?>>Uganda</option>
                            <option value="UA" <?php if($nationalitaetAzubi=="UA") echo "selected"; ?>>Ukraine</option>
                            <option value="H" <?php if($nationalitaetAzubi=="H") echo "selected"; ?>>Ungarn</option>
                            <option value="UAF" <?php if($nationalitaetAzubi=="UAF") echo "selected"; ?>>Unselbst. Geb. i. Afrika</option>
                            <option value="ROU" <?php if($nationalitaetAzubi=="ROU") echo "selected"; ?>>Uruguay</option>
                            <option value="USA" <?php if($nationalitaetAzubi=="USA") echo "selected"; ?>>USA</option>
                            <option value="UZ" <?php if($nationalitaetAzubi=="UZ") echo "selected"; ?>>Usbekistan</option>

                            <!-- V -->
                            <option value="V" <?php if($nationalitaetAzubi=="V") echo "selected"; ?>>Vatikanstadt</option>
                            <option value="YV" <?php if($nationalitaetAzubi=="YV") echo "selected"; ?>>Venezuela</option>
                            <option value="UAE" <?php if($nationalitaetAzubi=="UAE") echo "selected"; ?>>Ver. Arab. Emirate</option>
                            <option value="VN" <?php if($nationalitaetAzubi=="VN") echo "selected"; ?>>Vietnam</option>

                            <!-- W -->
                            <option value="BY" <?php if($nationalitaetAzubi=="BY") echo "selected"; ?>>Weißrussland</option>

                            <!-- Z -->
                            <option value="RCA" <?php if($nationalitaetAzubi=="RCA") echo "selected"; ?>>Zentralafrikan. Republik</option>
                            <option value="CY" <?php if($nationalitaetAzubi=="CY") echo "selected"; ?>>Zypern</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="selectKonfession">*Konfession</label>
                        <select name="selectKonfession" id="selectKonfession" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="ALE" <?php if($konfessionAzubi == 'ALE') echo 'selected';?>>Alevitisch</option>
                            <option value="AK" <?php if($konfessionAzubi == 'AK') echo 'selected';?>>Alt-Katholisch</option>
                            <option value="EV" <?php if($konfessionAzubi == 'EV') echo 'selected';?>>Evangelisch</option>
                            <option value="SYR" <?php if($konfessionAzubi == 'SYR') echo 'selected';?>>Syrisch-Orthodox</option>
                            <option value="ISL" <?php if($konfessionAzubi == 'ISL') echo 'selected';?>>Islamisch</option>
                            <option value="RK" <?php if($konfessionAzubi == 'RK') echo 'selected';?>>Römisch-Katholisch</option>
                            <option value="JÜD" <?php if($konfessionAzubi == 'JÜD') echo 'selected';?>>Jüdisch</option>
                            <option value="OTX" <?php if($konfessionAzubi == 'OTX') echo 'selected';?>>Orthodox</option>
                            <option value="SON-KEIN" <?php if($konfessionAzubi == 'SON-KEIN') echo 'selected';?>>Sonstige-keine Religionszugehörigkeit</option>
                            <option value="K_A" <?php if($konfessionAzubi == 'K_A') echo 'selected';?>>keine Angabe</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="selectVorbildung">*Schulische Vorbildung</label>
                        <select name="selectVorbildung" id="selectVorbildung" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="oA"<?php if($vorbildungAzubi == 'oA') echo 'selected';?>>ohne Abschluss</option>
                            <option value="oHA"<?php if($vorbildungAzubi == 'oHA') echo 'selected';?>>Hauptschule ohne Abschluss</option>
                            <option value="HSA"<?php if($vorbildungAzubi == 'HSA') echo 'selected';?>>Hauptschulabschluss</option>
                            <option value="RSA-WRS"<?php if($vorbildungAzubi == 'RSA-WRS') echo 'selected';?>>Realschulabschluss an Werkrealschule</option>
                            <option value="RSA-RS"<?php if($vorbildungAzubi == 'RSA-RS') echo 'selected';?>>Realschulabschluss an Realschule</option>
                            <option value="RSA-GYM"<?php if($vorbildungAzubi == 'RSA-GYM') echo 'selected';?>>Realschulabschluss am Gymnasium</option>
                            <option value="FSR-mBABS"<?php if($vorbildungAzubi == 'FSR-mBABS') echo 'selected';?>>Mittlerer Bildungsabschluss einer beruflichen Schule</option>
                            <option value="FSR"<?php if($vorbildungAzubi == 'FSR') echo 'selected';?>>Fachschulreife</option>
                            <option value="FHR"<?php if($vorbildungAzubi == 'FHR') echo 'selected';?>>Fachhochschulreife</option>
                            <option value="HRa"<?php if($vorbildungAzubi == 'HRa') echo 'selected';?>>Hochschulreife</option>
                            <option value="Sonst (AS)"<?php if($vorbildungAzubi == 'Sonst (AS)') echo 'selected';?>>Sonstige</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>2. Erziehungsberechtigte/r</legend>
                <div class="error"><?php if(isset($errors["erziehungsberechtigte"])) echo $errors["erziehungsberechtigte"]; ?></div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfNachnameErz">Nachname</label>
                        <input type="text" placeholder="Nachname" name="tfNachnameErz" id="tfNachnameErz" value="<?php if (isset($nachnameErz)) echo $nachnameErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                    <div class="form-col">
                        <label for="tfVornameErz">Vorname</label>
                        <input type="text" placeholder="Vorname" name="tfVornameErz" id="tfVornameErz" value="<?php if (isset($vornameErz)) echo $vornameErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="selectGruppeErz">Erziehungsberechtige/r</label>
                        <select name="selectGruppeErz" id="selectGruppeErz" <?php if($age<18) echo "required" ?>>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="Mu" <?php if($gruppeErz == 'Mu') echo 'selected';?>>Mutter</option>
                            <option value="Va" <?php if($gruppeErz == 'Va') echo 'selected';?>>Vater</option>
                            <option value="Pf" <?php if($gruppeErz == 'Pf') echo 'selected';?>>Pflegeeltern</option>
                            <option value="Vm" <?php if($gruppeErz == 'Vm') echo 'selected';?>>Vormund</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="tfEmailErz">E-Mail</label>
                        <span class="error"><?php if(isset($errors["emailErz"])) echo $errors["emailErz"]; ?></span>
                        <input type="text" placeholder="E-Mail" name="tfEmailErz" id="tfEmailErz" value="<?php if (isset($emailErz)) echo $emailErz;?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfStrasseErz">Straße</label>
                        <input type="text" placeholder="Straße" name="tfStrasseErz" id="tfStrasseErz" value="<?php if (isset($strasseErz)) echo $strasseErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                    <div class="form-col">
                        <label for="tfHausnrErz">Hausnummer</label>
                        <input type="text" placeholder="Hausnummer" name="tfHausnrErz" id="tfHausnrErz" value="<?php if (isset($hausnrErz)) echo $hausnrErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfPLZErz">Postleitzahl</label>
                        <span class="error"><?php if(isset($errors["plzErz"])) echo $errors["plzErz"]; ?></span>
                        <input type="text" placeholder="Postleitzahl" name="tfPLZErz" id="tfPLZErz" value="<?php if (isset($plzErz)) echo $plzErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                    <div class="form-col">
                        <label for="tfOrtErz">Ort</label>
                        <input type="text" placeholder="Ort" name="tfOrtErz" id="tfOrtErz" value="<?php if (isset($ortErz)) echo $ortErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfTelefonErz">Telefon</label>
                        <input type="text" placeholder="Telefon" name="tfTelefonErz" id="tfTelefonErz" value="<?php if (isset($telefonErz)) echo $telefonErz;?>" <?php if($age<18) echo "required" ?>>
                    </div>
                    <div class="form-col">
                        <label for="tfMobilErz">Mobil</label>
                        <input type="text" placeholder="Mobil" name="tfMobilErz" id="tfMobilErz" value="<?php if (isset($mobilErz)) echo $mobilErz;?>">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>3. Ausbildungsberuf</legend>
                <div class="form-row">
                    <div class="form-col">
                        <label for="selectAusbildungsberuf">*Ausbildungsberuf</label>
                        <select name="selectAusbildungsberuf" id="selectAusbildungsberuf" required>
                            <option value="" selected disabled hidden> 
                                Bitte wählen:
                            </option>
                            <option value="67350" <?php if($ausbildungsberuf == '67350') echo 'selected';?>>Automobilkaufmann/-kauffrau</option>
                            <option value="68110" <?php if($ausbildungsberuf == '68110') echo 'selected';?>>Kaufmann/-frau im Groß- und Außenhandelsmanagement</option>
                            <option value="75351" <?php if($ausbildungsberuf == '75351') echo 'selected';?>>Steuerfachangestellte/r</option>
                            <option value="78112" <?php if($ausbildungsberuf == '78112') echo 'selected';?>>Justizfachangestellte/r</option>
                            <option value="78152" <?php if($ausbildungsberuf == '78152') echo 'selected';?>>Rechtsanwaltsfachangestellte/r</option>
                            <option value="78153" <?php if($ausbildungsberuf == '78153') echo 'selected';?>>Notarfachangestellte/r</option>
                            <option value="78154" <?php if($ausbildungsberuf == '78154') echo 'selected';?>>Patentanwaltsfachangestellte/r</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="tfBetrieb">*Betrieb</label>
                        <input type="text" placeholder="Betrieb" name="tfBetrieb" id="tfBetrieb" value="<?php if (isset($betrieb)) echo $betrieb;?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfStrasseBetrieb">*Straße</label>
                        <input type="text" placeholder="Straße" name="tfStrasseBetrieb" id="tfStrasseBetrieb" value="<?php if (isset($strasseBetrieb)) echo $strasseBetrieb;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfHausnrBetrieb">*Hausnummer</label>
                        <input type="text" placeholder="Hausnummer" name="tfHausnrBetrieb" id="tfHausnrBetrieb" value="<?php if (isset($hausnrBetrieb)) echo $hausnrBetrieb;?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfPLZBetrieb">*Postleitzahl</label>
                        <span class="error"><?php if(isset($errors["plzBetrieb"])) echo $errors["plzBetrieb"]; ?></span>
                        <input type="text" placeholder="Postleitzahl" name="tfPLZBetrieb" id="tfPLZBetrieb" value="<?php if (isset($plzBetrieb)) echo $plzBetrieb;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfOrtBetrieb">*Ort</label>
                        <input type="text" placeholder="Ort" name="tfOrtBetrieb" id="tfOrtBetrieb" value="<?php if (isset($ortBetrieb)) echo $ortBetrieb;?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfTelefonBetrieb">*Telefon</label>
                        <input type="text" placeholder="Telefon" name="tfTelefonBetrieb" id="tfTelefonBetrieb" value="<?php if (isset($telefonBetrieb)) echo $telefonBetrieb;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfTelefaxBetrieb">Telefax</label>
                        <input type="text" placeholder="Telefax" name="tfTelefaxBetrieb" id="tfTelefaxBetrieb" value="<?php if (isset($telefaxBetrieb)) echo $telefaxBetrieb;?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="tfEmailBetrieb">*E-Mail</label>
                        <span class="error"><?php if(isset($errors["emailBetrieb"])) echo $errors["emailBetrieb"]; ?></span>
                        <input type="text" placeholder="E-Mail" name="tfEmailBetrieb" id="tfEmailBetrieb" value="<?php if (isset($emailBetrieb)) echo $emailBetrieb;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfAnsprechpartner">*Ansprechpartner/Durchwahl/E-Mail</label>
                        <input type="text" placeholder="Ansprechpartner/Durchwahl/E-Mail" name="tfAnsprechpartner" id="tfAnsprechpartner" value="<?php if (isset($ansprechpartner)) echo $ansprechpartner;?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label for="tfAusbildungsbeginn">*Ausbildungsbeginn</label>
                        <input type="date" placeholder="tt.mm.jjjj" name="tfAusbildungsbeginn" id="tfAusbildungsbeginn" value="<?php if (isset($ausbildungsbeginn)) echo $ausbildungsbeginn;?>" required>
                    </div>
                    <div class="form-col">
                        <label for="tfAusbildungsende">*Ausbildungsende</label>
                        <span class="error"><?php if(isset($errors["ausbildungsende"])) echo $errors["ausbildungsende"]; ?></span>
                        <input type="date" placeholder="tt.mm.jjjj" name="tfAusbildungsende" id="tfAusbildungsende" value="<?php if (isset($ausbildungsende)) echo $ausbildungsende;?>" required>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-col">
                    <label for="taBemerkung">Bemerkung</label>
                    <textarea rows="4" cols="50" placeholder="Bemerkung" name="taBemerkung" id="taBemerkung"><?php if (isset($bemerkung)) echo $bemerkung;?></textarea>
                </div>
            </fieldset>
            <div class="datenschutz">
                <div class="error"><?php if(isset($errors["datenschutz"])) echo $errors["datenschutz"]; ?></div>
                <label><input type="checkbox" name="datenschutz" value="yes"> Ich stimme der <a href="https://www.ksn-stuttgart.de/kontakt/impressum/" target="_blank" rel="noopener">Datenschutzerklärung</a> zu.</label>
            </div>
            <div class="submit"> 
                <input type="submit" name="submit" id="submit" value="Schüler anmelden">
            </div>
        </form>
    </main>
    <script>
        if (!Modernizr.inputtypes.date) {
            $('input[type=date]').keydown(function() { return false });
            $('input[type=date]').datepicker({
            yearRange: "-40:+5",
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            //defaultDate: "-18y",
            firstDay: 1,
            onSelect: function (selectedDate) {
                $('#ui-datepicker-div table td a').attr('href', 'javascript:void(0);');
                $(this).blur();
                }
            });
        }
    </script>
</body>

</html>