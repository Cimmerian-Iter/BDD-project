<?php

function sendQuery($query) {
    global $db;
    $req = $db->query($query);

    if ($req) return $req;
    else return false;
}

function nbRand() {
    $result = "";
    for ($i=0; $i < 8; $i++) { 
        $result .= intval(rand()&9);
    }

    return $result;
}

function formatDate($date){
    $annee = substr($date, 0, 4);
    $m = substr($date, 5, 2);
    $jour = substr($date, 8, 2);

    switch ($m) {
        case "01":
            $mois = "janvier";
            break;

        case "02":
            $mois = "février";
            break;

        case "03":
            $mois = "mars";
            break;
        
        case "04":
            $mois = "avril";
            break;

        case "05":
            $mois = "mai";
            break;

        case "06":
            $mois = "juin";
            break;
        
        case "07":
            $mois = "juillet";
            break;

        case "08":
            $mois = "août";
            break;

        case "09":
            $mois = "septembre";
            break;

        case "10":
            $mois = "octobre";
            break;

        case "11":
            $mois = "novembre";
            break;
            
        default:
            $mois = "décembre";
            break;
    }

    $formated_date = $jour." ".$mois." ".$annee;

    return $formated_date;
}

function formatHour($hour){
    $h = substr($hour, 0, 2);
    $m = substr($hour, 3, 2);
    $s = substr($hour, 6, 2);

    $formated_hour = $h."h ".$m."m ".$s."s";
    return $formated_hour;
}