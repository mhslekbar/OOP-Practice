<?php 

    ob_start();
    session_start();
    
    if(isset($_SESSION['username'])){
        include "init.php";

        echo "<h1 class='text-center mt-2'>Dashboard</h1>";
    
    }else {
        header("Location: index.php");
    }

?>

<?php
    include $tpl . "footer.php";
?>