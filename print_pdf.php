<?php
session_start();

require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->getOptions()->setChroot(realpath(__DIR__ . '/img'));
$date = date('d.m.Y \u\m H:i:s');
$html = "
    <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-size: 8pt;
                    font-family: DejaVu Sans, sans-serif;
                }

                img{
                    float: right;
                }

                table {
                    margin: 0 0 10px 30px;
                    width: 85%;
                    border-collapse: collapse;
                }

                td, th{
                    padding: 1px 4px;
                    color: #282828;
                    border: 1px solid #aaa;
                }
                td:nth-child(1) { 
                    width: 40%; 
                }
                
                h1 {
                    margin: 0;
                    font-size: 14pt;
                }
                
                h2 {
                    margin: 4px 0 2px 0; 
                    font-size: 9pt;
                }

                h5 {
                    margin: 4px 0 4px 0; 
                }

                .bemerkung {
                    font-size: 7pt;
                }

            </style>
        </head>
    <body>
        <h1>Anmeldung Auszubildende(r) an der Johann-Philipp-Palm-Schule Schorndorf</h1>
        <h5>Formular maschinell erstellt am " . $date . " Uhr.</h5>

        <h2>Auszubildende(r)</h2>
        <table>
            <tr>
                <td>Nachname:</td>
                <td>" . $_SESSION['nachnameAzubi'] . "</td>
            </tr>
            <tr>
                <td>Vorname:</td>
                <td>" . $_SESSION['vornameAzubi'] . "</td>
            </tr>
            <tr>
                <td>Geburtsname:</td>
                <td>" . $_SESSION['geburtsnameAzubi'] . "</td>
            </tr>
            <tr>   
                <td>Geburtsdatum:</td>
                <td>" . $_SESSION['geburtsdatumAzubi'] . "</td>
            </tr>
            <tr>
                <td>Geburtsort:</td>
                <td>" . $_SESSION['geburtsortAzubi'] . "</td>
            </tr>
            <tr>
            <td>Geburtsland:</td>
            <td>" . $_SESSION['geburtslandAzubi'] . "</td>
            </tr>
            <tr>
                <td>Geschlecht:</td>
                <td>" . $_SESSION['geschlechtAzubi'] . "</td>
            </tr>
            <tr>
                <td>Strasse und Hausnummer:</td>
                <td>" . $_SESSION['strasseAzubi'] . " " . $_SESSION['hausnrAzubi'] . "</td>
            </tr>
            <tr>
            <td>Postleitzahl, Ort (, Ortsteil):</td>
            <td>" . $_SESSION['plzAzubi'] ." " . $_SESSION['ortAzubi'];

if($_SESSION['ortsteilAzubi'] != "") $html .=  " - " .  $_SESSION['ortsteilAzubi'];

$html .= "</td>
            </tr>
            <tr>
                <td>Telefon:</td>
                <td>" . $_SESSION['telefonAzubi'] . "</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>" . $_SESSION['emailAzubi'] . "</td>
            </tr>
            <tr>
                <td>Mobil:</td>
                <td>" . $_SESSION['mobilAzubi'] . "</td>
            </tr>
            <tr>
                <td>Zuhause gesprochene Sprache:</td>
                <td>" . $_SESSION['spracheAzubi'] . "</td>
            </tr>
            <tr>
                    <td>Nationalität:</td>
                    <td>" . $_SESSION['nationalitaetAzubi'] . "</td>
                </tr>
            <tr>
                <td>Konfession:</td>
                <td>" . $_SESSION['konfessionAzubi'] . "</td>
            </tr>
            <tr>
                <td>Schulische Vorbildung:</td>
                <td>" . $_SESSION['vorbildungAzubi'] . "</td>
            </tr>
        </table>";
if($_SESSION['nachnameErz']!=""){ 
    $html .= "
    <h2>Erziehungsberechtigte(r)</h2>
    <table>
        <tr>
            <td>Nachname:</td>
            <td>" . $_SESSION['nachnameErz'] . "</td>
        </tr>
        <tr>
            <td>Vorname:</td>
            <td>" . $_SESSION['vornameErz'] . "</td>
        </tr>
        <tr>
            <td>Bezugsperson:</td>
            <td>" . $_SESSION['gruppeErz'] . "</td>
        </tr>
        <tr>
            <td>Strasse und Hausnummer:</td>
            <td>" . $_SESSION['strasseErz'] . " " . $_SESSION['hausnrErz'] . "</td>
        </tr>
        <tr>
            <td>Postleitzahl, Ort:</td>
            <td>" . $_SESSION['plzErz'] ." " . $_SESSION['ortErz'] . "</td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td>" . $_SESSION['telefonErz'] . "</td>
        </tr>
        <tr>
            <td>Mobil:</td>
            <td>" . $_SESSION['mobilErz'] . "</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>" . $_SESSION['emailErz'] . "</td>
        </tr>
    </table>";
}

$html .= "
<h2>Ausbildungsberuf/ -betrieb</h2>
    <table>
        <tr>
            <td>Ausbildungsberuf:</td>
            <td>" . $_SESSION['ausbildungsberuf'] . "</td>
        </tr>
        <tr>
            <td>Betrieb:</td>
            <td>" . $_SESSION['betrieb'] . "</td>
        </tr>
        <tr>
            <td>Strasse und Hausnummer:</td>
            <td>" . $_SESSION['strasseBetrieb'] . " " . $_SESSION['hausnrBetrieb'] . "</td>
            
        </tr>
        <tr>
            <td>Postleitzahl, Ort:</td>
            <td>" . $_SESSION['plzBetrieb'] . " " . $_SESSION['ortBetrieb'] . "</td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td>" . $_SESSION['telefonBetrieb'] . "</td>
        </tr>
        <tr>
            <td>Telefax:</td>
            <td>" . $_SESSION['telefaxBetrieb'] . "</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>" . $_SESSION['emailBetrieb'] . "</td>
        </tr>
        <tr>
            <td>Ansprechpartner:</td>
            <td>" . $_SESSION['ansprechpartner'] . "</td>
        </tr>
        <tr>
            <td>Ausbildungsbeginn:</td>
            <td>" . $_SESSION['ausbildungsbeginn'] . "</td>
        </tr>
        <tr>
            <td>Ausbildungsende:</td>
            <td>" . $_SESSION['ausbildungsende'] . "</td>
        </tr>
        <tr>
            <td>Bemerkung:</td>
            <td class='bemerkung'>" . $_SESSION['bemerkung'] . "</td>
        </tr>
    </table>
    <p>Bitte unterschreiben Sie dieses maschinell erstellte Dokument und senden Sie es per E-Mail an info@jpp-schule.de oder postalisch an die Adresse der Johann-Philipp-Palm-Schule Schorndorf, Grabenstr. 10, 73614 Schorndorf.
    </p>
    <p class='bottom'>
        <span>Unterschrift: _____________________________________ </span>
        <span>Firmenstempel: _____________________________________ </span>
    </p>

    </body></html>";

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('anmeldedaten.pdf', array('Attachment'=>false));
    return $dompdf;
?>
