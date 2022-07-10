<?php
if (isset($_GET['spalte'])){
    $sort = $_GET['spalte'] . " " . $_GET['sort'];
} else {
    $sort = "download ASC, id_asv DESC";
}

$sql = "SELECT id_asv as id, beruf as Beruf, `Name`, Vorname, Geburtsname, Geburtstag, Geburtsort, Geburtsland, Geschlecht, Religion, Land, Strasse, HausNr, PLZ, Ort, Teilort, `Telefon 1` as Telefon, Handy1 as Mobil, email1 as Email, Muttersprache, Erz1Name, Erz1Vorname, Erz1Strasse, Erz1HausNr, Erz1PLZ, Erz1Ort, Erz1Telefon, Erz1Handy, Erz1Email, Erz1Art, AbgebendeSchule, Betrieb, Vorbildung, strasse_btr, hausnr_btr, plz_btr, ort_btr, telefon_btr, telefax_btr, email_btr, ansprechpartner, beginn, ende, bemerkung, datum, download FROM asv, ausbildungsberufe WHERE asv.Ausbild_beruf_id = ausbildungsberufe.id_ausbildungsberufe ORDER BY " . $sort . ";";

?>