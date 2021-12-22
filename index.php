<?php 
    ob_start();
    session_start();
    $noNav = "";
    require "init.php";
    
    if(isset($_SESSION['username'])) {
        header("Location: homepage.php");
    }

    if( isset($_POST['btnlogin']) ) {
        $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $pass  = filter_var($_POST['password'],FILTER_SANITIZE_STRING); 
        $obj = new Test;
        $check = $obj->getUsers($user,$pass);
        if($check) :
            $_SESSION['username'] = $user; 
            header("Location: homepage.php");
        elseif($check !== null):
            $error = "<div class='alert alert-danger msg'>Username or password is Wrong</div>";
        endif;
    }   

?>

    <div class="container mt-5">
    <div class="row">
            <div class="col-md-6 offset-md-3">
                <?= $error ?? null; ?>
                <h2 id="msgDisplay"></h2>
                <div class="login-form bg-primary mt-4 p-4">
                    <form action="" id="login-form" method="POST" class="row g-3">
                        <h4 class="text-center">Login Administration</h4>
                        <div class="col-12">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="col-12">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="col-12">
                            <button type="submit" name="btnlogin" id="btnlogin" class="btn btn-dark float-end">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
    include $tpl . "footer.php";
    ob_end_flush();
?>


