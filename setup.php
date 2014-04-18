<!DOCTYPE html>
<!--
 * Kyanite setup page.
 * The Kyanite Project - https://github.com/Cydrobolt/kyanite
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kyanite Setup</title>
        <link rel="stylesheet" href="bootstrap.css"/>
        <link rel="stylesheet" href="main.css"/>
    </head>
    <body style="padding-top:60px">
        <div class="navbar navbar-default navbar-fixed-top">
            <a class="navbar-brand" href="//github.com/Cydrobolt/kyanite">Kyanite</a>
        </div>
        <div class='container-fluid push pushtop' style="text-align: left">
            <span><h1>Kyanite Setup</h1></span><br>
            <?php
            @(include('config.php'));
            include ('version.php');
            require_once 'password.php';

            function rstr($length = 34) {
                return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
            }

            if (isset($ppass)) {
                if (!isset($_POST['pw'])) {
                    echo "<h2>Enter setup password to proceed:</h2>";
                    echo "<form action='setup.php' method='post'><br><input class='form-control' type='password' name='pw' /><br><input type='submit' class='form-control' value='Log in' /></form>";
                    die();
                } else if ($pwf = password_verify($_POST['pw'], $ppass)) {
                    echo "";
                } else {
                    echo "Wrong password<br>";
                    echo "<h2>Enter setup password to proceed:</h2>";
                    echo "<form action='setup.php' method='post'><br><input type='password' class='form-control' name='pw' /><br><input type='submit' class='form-control' value='Log in' /></form>";

                    die();
                }
            }
            if (isset($_POST['dbserver'])) {
                $rstr = rstr(50);

                function hashpass($pass,$salt="") {
                    if(!$salt) {
                        $salt = rstr(60);
                    }
                    $opts = [
                        'cost' => 10,
                        'salt' => $salt
                    ];
                    $hashed = password_hash($pass, PASSWORD_BCRYPT, $opts);
                    return $hashed;
                }
                $nowdate = date('F d Y');
                $data = '<?php
			$host="' . $_POST['dbserver'] . '";' .
                        '$user="' . $_POST['dbuser'] . '";' .
                        '$passwd="' . $_POST['dbpass'] . '";' .
                        '$db="' . $_POST['dbname'] . '";' .
                        '$wsa = "' . $_POST['appurl'] . '";' .
                        '$wsn = "' . $_POST['appname'] . '";' .
                        '$wsb = "' . $nowdate . '";' .
                        '$ppass = \'' . hashpass($_POST['protpass']) . '\';' .
                        '$ip = $_SERVER[\'REMOTE_ADDR\'];' .
                        '$unstr = "' . $rstr . '";
			?>';
                $file = "config.php";

                $handle = fopen($file, 'a');
                if (fwrite($handle, $data) === FALSE) {
                    echo "Can not write to (" . $file . ")";
                }
                echo "Succesfully created config. ";
                fclose($handle);
                require_once('req.php');

                //Create Tables
                sqlrun("CREATE TABLE auth"
                        . "("
                        . "uid INT NOT NULL AUTO_INCREMENT,"
                        . "PRIMARY KEY(uid),"
                        . "username VARCHAR(50),"
                        . "password TEXT(450),"
                        . "rkey VARCHAR(65),"
                        . "role VARCHAR(40),"
                        . "valid TINYINT(1),"
                        . "email VARCHAR(65)"
                        . ");");
                sqlrun("CREATE TABLE stats"
                        . "("
                        . "vid INT NOT NULL,"
                        . "PRIMARY KEY(vid),"
                        . "ua VARCHAR(100),"
                        . "ip VARCHAR(100),"
                        . "timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP()"
                        . ");");

                sqlrun("CREATE INDEX ti ON stats (ip);");
                sqlrun("CREATE INDEX ati ON auth (valid,email,username);");
                $acctpass = hashpass($_POST['acctpass']);
                $nr = sha1(rstr(50));
                sqlrun("INSERT INTO auth (username,email,password,rkey,valid) VALUES ('{$_POST['acct']}','kyanite@admin.none','{$acctpass}','{$nr}','1') ");
                echo "You are now finished Kyanite Setup. You can now close this window, and login to your account <a href='index.php'>here</a> (login form @ top right). <br><br>If you need help, click <a href=\"http://webchat.freenode.net/?channels=##cydrobolt\">here</a><br>"
                . "<br><br><b>Clueless? Read the docs. <a href='https://github.com/Cydrobolt/kyanite/tree/master/docs'>https://github.com/Cydrobolt/kyanite/tree/master/docs</a></b>";
            } else {
                include('version.php');
                echo "<form name=\"Config Creation\" method=\"post\" action=\"" . 'setup.php' . "\">";
                echo "Database Host: <input type=\"text\" class='form-control' name=\"dbserver\" value=\"localhost\"><br>";
                echo "Database User: <input type=\"text\" class='form-control' name=\"dbuser\" value=\"root\"><br>";
                echo "Database Pass: <input type=\"password\" class='form-control' name=\"dbpass\" value=\"password\"><br>";
                echo "Database Name: <input type=\"text\" class='form-control' name=\"dbname\" value=\"kyanite\"><br>";
                echo "Application Name: <input type=\"text\" class='form-control' name=\"appname\" value=\"kyanite\"><br>";
                echo "Application URL (path to Kyanite, no http:// or www.) : <input type=\"text\" class='form-control' name=\"appurl\" value=\"yoursite.com\"><br>";
                echo "Setup Access Password: <input type=\"text\" class='form-control' name=\"protpass\" value=\"password123\"><br>";
                echo "Admin Account: <input type=\"text\" class='form-control' name=\"acct\" value=\"kyanite\"><br>";
                echo "Admin Password: <input type=\"password\" class='form-control' name=\"acctpass\" value=\"kyanite\"><br>";


                if (isset($_POST['pw'])) {
                    echo "<input type='hidden' value='{$_POST['pw']}' name='pw' />";
                }
                echo "<input type=\"submit\" value=\"Create/Update config\"><input type=\"reset\" value=\"Clear Fields\">";
                echo "</form>";
                echo "<br><br></div><div class='container'>"
                . "Requirements:<br><br>"
                        . "<dl>"
                        . "<dt>MySQL >= 5.6"
                        . "<dt>PHP >= 5.4"
                        . "</dl><br>"
                        . "<b>Make sure the databse you specify is already created. The database user also needs to"
                . "be pre-created. If you enter the wrong information, go in the installation "
                . "directory and delete config.php.<br>Please grant the mysql user all privileges"
                . "during the setup, and then restrict the user to only CREATE, UPDATE, INSERT, DELETE, and SELECT.</b>";
                echo "<br><br>Kyanite is <a href='http://en.wikipedia.org/wiki/Open-source_software'>Open-Source software</a> licensed under the <a href='//opensource.org/licenses/MIT'>MIT License</a>. By continuing to use Kyanite, you agree to the terms of the MIT License.";
                echo "<div class='pushbottom pushtop'>Kyanite Version $version released $reldate - <a href='//github.com/cydrobolt/kyanite'>Github</a><br>&copy; Copyright $relyear Cydrobolt & Other Kyanite Contributors</div>";
            }
            ?>
        </div>
    </body>
</html>