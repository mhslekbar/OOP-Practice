<?php 


    // includes files 

    $func       = "includes/functions/";
    $tpl        = "includes/templates/";
    $class      = "classes/";

    // includes Classes
    include $class . "allClasses.php"; 


    // layout files

    $css    = "layout/css/";
    $fonts  = "layout/fonts";
    $js     = "layout/js/"; 
    $img    = "layout/images/";

    // includes 
    include $func . "functions.php";
    include $func . "query_functions.php";
    include $tpl . "header.php";



    if(!isset($noNav))
        include $tpl . "navbar.php";





?>