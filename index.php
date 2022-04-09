<?php
    session_start();
    ini_set('display_errors', '1');

    function ageCalculator($date) {  
        date_default_timezone_set("Europe/Berlin");  
        $birthDate = new DateTime($date);
        $actualDate = new DateTime();      
        return $actualDate->diff($birthDate)->y;
    } 

    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require_once("db.php");
    
    $con = new DataModel();

    //Customizing
    $query_custom = 'SELECT form_title, datenschutz, pdf_header, pdf_footer FROM custom;';
    $result = $con->select($query_custom);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['form_title'];
        $datenschutz_link = $row['datenschutz'];
        $pdf_header = $row['pdf_header'];
        $pdf_footer = $row['pdf_footer'];
    } else{ //default
        $title = "Anmeldeformular Berufsschule";
        $datenschutz_link = "https://" . $_SERVER['HTTP_HOST'];
        $pdf_header = "Anmeldung Auszubildende(r)";
        $pdf_footer = "Bitte unterschreiben Sie dieses maschinell erstellte Dokument und senden Sie es per E-Mail oder postalisch an die Adresse der zuständigen Schule.";
    }

    $query_berufe = 'SELECT id_ausbildungsberufe, beruf FROM ausbildungsberufe;';
    $result = $con->select($query_berufe);
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result))
        {
            $berufe[] = $row;
        }
    }

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

            $query = 'SELECT beruf FROM ausbildungsberufe WHERE id_ausbildungsberufe = ?';
            $paramType = 's';
            $paramValue = array($ausbildungsberuf);
            $result = $con->select($query, $paramType, $paramValue);

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $beruf = $row['beruf'];
            }

            $anzahlSpalten = 44;

            $query = "INSERT INTO asv (`Name`, Vorname, Geburtsname, Geburtstag, Geburtsort, Geburtsland, Geschlecht, Strasse, HausNr, PLZ, Ort, Teilort, `Telefon 1`, Handy1, email1, Muttersprache, Land, Religion, Vorbildung, Erz1Name, Erz1Vorname, Erz1Art, Erz1Email, Erz1Strasse, Erz1HausNr, Erz1PLZ, Erz1Ort, Erz1Telefon, Erz1Handy, Ausbild_beruf_id, Betrieb, Ausbildungsbetrieb, strasse_btr, hausnr_btr, plz_btr, ort_btr, telefon_btr, telefax_btr, email_btr, ansprechpartner, beginn, ende, bemerkung, datum) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $paramType = "ssssssssssssssssssssssssssssssssssssssssssss";
            $paramValue = array($nachnameAzubi, $vornameAzubi, $geburtsnameAzubi, $geburtsdatumAzubi, $geburtsortAzubi, $geburtslandAzubi, $geschlechtAzubi, $strasseAzubi, $hausnrAzubi, $plzAzubi, $ortAzubi, $ortsteilAzubi, $telefonAzubi, $mobilAzubi, $emailAzubi, $spracheAzubi, $nationalitaetAzubi, $konfessionAzubi, $vorbildungAzubi, $nachnameErz, $vornameErz, $gruppeErz, $emailErz, $strasseErz, $hausnrErz, $plzErz, $ortErz, $telefonErz, $mobilErz, $ausbildungsberuf, $betrieb, $ausbildungsbetrieb, $strasseBetrieb, $hausnrBetrieb, $plzBetrieb, $ortBetrieb, $telefonBetrieb, $telefaxBetrieb, $emailBetrieb, $ansprechpartner, $ausbildungsbeginn, $ausbildungsende, $bemerkung, $datum);

            $result = $con->insert($query, $paramType, $paramValue);

           //Übergabe an print_pdf.php
           $_SESSION['pdf_header'] = $pdf_header;
           $_SESSION['pdf_footer'] = $pdf_footer;
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

           $query_mail = 'SELECT mail_nachricht, mail_address, mail_from, mail_name, mail_subject, mail_host, mail_username,  mail_password, mail_port FROM custom';
           $result_mail = $con->select($query_mail);

           if($result_mail->num_rows > 0) {
                $row = $result_mail->fetch_assoc();
                $nachricht = $row['mail_nachricht'];
                $nachricht = wordwrap($nachricht, 70, "\r\n");
                $mail = new PHPMailer(TRUE);
                $mail->CharSet = "UTF-8"; 
                $mail->setFrom($row['mail_address'], $row['mail_from']);
                $mail->addAddress($row['mail_address'], $row['mail_name']);
                $mail->Subject = $row['mail_subject'];
                $mail->Body = $nachricht;

                $mail->isSMTP();
                $mail->IsHTML(true);
                $mail->Host = $row['mail_host'];
                $mail->SMTPAuth = TRUE;
                $mail->SMTPSecure = 'ssl';
                $mail->Username = $row['mail_username'];
                $mail->Password = $row['mail_password'];
                $mail->Port = $row['mail_port'];

                if(!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
           }

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

   require_once("form.php");

?>

