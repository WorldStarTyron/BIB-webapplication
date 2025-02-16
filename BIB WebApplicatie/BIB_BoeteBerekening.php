<?php
include 'BIB_Connection.php'; session_start(); 

function berekenBoete($uiterste_datum, $inleverdatum){
    $uiterste = new DateTime($uiterste_datum);
    $inlever = new DateTime($inleverdatum);
    
    if($inlever <= $uiterste) return 0;
    
    $vertraging = $uiterste->diff($inlever)->days;
    
    if($vertraging == 1) return 20.00;
    if($vertraging == 3) return 50.00;
    if($vertraging > 3) return 100.00;
    return 20.00; // Default voor tussenliggende dagen
}
?>