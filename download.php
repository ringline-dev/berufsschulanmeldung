<?php
    session_start();
    //ini_set('display_errors', '1');
    $logout_time = 60*30;


    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }
    
    $now = time();
    if(isset($_SESSION['logout_time']) && $now > $_SESSION['logout_time']){
        unset($_SESSION['login']);
        unset($_SESSION['logout_time']);
        $_SESSION["errorMessage"] = "Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.";
        session_write_close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["logout_time"] = $now + $logout_time;
    }

    require_once("db.php");
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xls;

    $sql = "SELECT Klasse,`Name`,Vorname,Rufname,Geburtsname,Geburtstag,Geburtsort,Geburtsland,Geschlecht,Religion,RU,Land,Land2,Strasse,HausNr,PLZ,Ort,Staat,Teilort,`Telefon 1`,`Telefon 2`,Handy1,Handy2,email1,Muttersprache,Schuleintrittam,Einschulungam,`Anmeldung am`,`im Schriftverkehrverteiler`,auskunftsberechtigt,Erz1Name,Erz1Vorname,Erz1Geschlecht,Erz1Strasse,Erz1HausNr,Erz1PLZ,Erz1Ort,Erz1Teilort,Erz1Telefon,Erz1Telefon2,Erz1Handy,Erz1Email,Erz1Schriftverkehrverteiler,Erz1auskunftsberechtigt,Erz1Hauptansprechpartner,Erz1Art,Erz2Name,Erz2Vorname,Erz2Geschlecht,Erz2Strasse,Erz2HausNr,Erz2PLZ,Erz2Ort,Erz2Teilort,Erz2Telefon,Erz2Telefon2,Erz2Handy,Erz2Email,Erz2Schriftverkehrverteiler,Erz2auskunftsberechtigt,Erz2Hauptansprechpartner,Erz2Art,Fremdsprache1,Fremdsprache2,Fremdsprache3,Fremdsprache4,Profil1,Profil1von,Profil1bis,Profil2,Profil2von,Profil2bis,Zuzugsart,AbgebendeSchule,Ausbildungsbetrieb,Ausbilder,Ausbild_beruf_id,Vorbildung FROM asv ";

    $con = new DataModel();
    $c=0;
    if(isset($_SESSION['ids'])){
        $c = count($_SESSION['ids']);
        $sql .= "WHERE id_asv = ";
        for($i=0; $i < $c-1; $i++){
            $sql .= $_SESSION['ids'][$i];
            $sql .= " OR id_asv = ";
        }
        $sql .= $_SESSION['ids'][$c-1];
    } else {
        header("Location: admin.php");
        exit();
    }
    $sql .= ";";

    $res = $con->select($sql);
    if(!empty($res)){
        
        for($i=0; $i < $c; $i++){
            $con->execute("UPDATE asv SET download = 1 WHERE id_asv =" . $_SESSION['ids'][$i]);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $properties = array();
        $c = 1;
        $geburtsdatumIndex = 70;
        while($property= mysqli_fetch_field($res)){
            if($property->name == "Geburtsdatum") $geburtsdatumIndex = 64+$c;
            $sheet->setCellValueByColumnAndRow($c++, 1, $property->name);
        }

        $dateRange = chr($geburtsdatumIndex).':'.chr($geburtsdatumIndex);
        
        $spreadsheet->getActiveSheet()->getStyle($dateRange)
        ->getNumberFormat()
        ->setFormatCode(
            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
        );

        $r = 2;
        while ($ds = mysqli_fetch_assoc($res)){
            $ds['Geburtstag'] = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($ds['Geburtstag']); 
            $addr = "A".$r++;
            $sheet->fromArray($ds,NULL,$addr);
        }


        $writer = new Xls($spreadsheet);
        $fileName = "Anmeldedaten.xls";

        header('Content-Type: applica tion/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
             
    } else {
        echo "<p style='color:#C00C00';>
            Es ist ein Fehler aufgetreten! Es wurden keine Datensätze gefunden.
            </p>";
    }

?>
    

    

    