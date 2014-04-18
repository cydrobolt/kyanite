<?php
@(include('config.php')) or header('Location:setup.php');
?>
<!--
 * Kyanite main page.
 * The Kyanite Project - https://github.com/Cydrobolt/kyanite
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Kyanite</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="bootstrap.css"/>
        <link rel="stylesheet" href="main.css"/>
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <script>
            $(function() {
                // Setup drop down menu
                $('.dropdown-toggle').dropdown();

                // Fix input element click problem
                $('.dropdown input, .dropdown label').click(function(e) {
                    e.stopPropagation();
                });
            });
        </script>
    </head>
    <body style="padding-top:60px">
        <div class="container-fluid">
            <div class="navbar navbar-default navbar-fixed-top"><div class="navbar-header"><a class="navbar-brand" href="index.php">Kyanite</a></div>
                <!--<a class="btn btn-navbar btn-default" data-toggle="collapse" data-target="#nbc">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>-->

                <ul class="nav navbar-collapse navbar-nav" id="nbc">
                    <li><a href="//github.com/Cydrobolt/kyanite">Github</a></li>
                </ul>
                <ul class="nav pull-right navbar-nav">
                    <?php
                    require_once('kyaauth.php');
                    $kyaauth = new kyaauth();
                    $kyaauth->headblock();
                    ?>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
                        <div class="dropdown-menu pull-right" id="dropdown" style="padding: 15px; padding-bottom: 0px; color:white;">
                            <h2 style='color:black'>Login</h2>
                            <form action="loginproc.php" method="post" accept-charset="UTF-8">
                                <input id="user_username" style="margin-bottom: 15px;" type="text" name="username" placeholder='Username' size="30" class="form-control">
                                <input id="user_password" style="margin-bottom: 15px;" type="password" name="password" placeholder='Password' size="30" class="form-control">

                                <input class="btn btn-success form-control" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="login" value="Sign In">
                                <br><br>
                            </form>
                        </div>
                    </li>
                    <?php $kyaauth->headendblock(); ?>

                </ul>
            </div>
        </div>
        <!--END NAVBAR-->
        <div class="container-fluid push">
            <?php
            require_once 'kyaauth.php';
            require_once 'req.php';
            $kyaauth = new kyaauth();
            if (is_array($kyaauth->islogged())) {
                $today = date('m/d/Y');
                echo "<h1>Dashboard</h1><br>";
                echo "<br>";
                $qur = "SELECT MAX(vid) AS vid FROM stats";
                $res = $mysqli->query($qur);
                $row = mysqli_fetch_assoc($res);
                $allvisits = $row['vid'];
                $qur = "SELECT vid FROM stats WHERE date='$today'";
                $res = $mysqli->query($qur);
                $row = mysqli_fetch_assoc($res);
                $todayvisits = count($row);
                $allunique = "TBD";
                $todayunique = "TBD";
                
                echo "<dt>Statistics:"
                . "<dl>Number of visits (total): $allvisits"
                . "<dl>Number of visitors today: $todayvisits"
                        . "<dl>Unique Visitors (total): $allunique"
                        . "<dl>Unique Visitors (today): $todayunique"
                        . "<dl><a href='details.php'>Details</a>"
                        . "</dt>";
            } else {
                echo "<div class='jumbotron' style=\"text-align:center;padding-top:80px; background-color: rgba(0,0,0,0);\"><h1>Welcome to Kyanite</h1><br>"
                . '<a href="login.php" class="btn btn-success btn-lg">Login</a>
                    <a href="about.php" class="btn btn-warning btn-lg">About Kyanite</a></div>';
            }
            ?>
            <!--END CONTENT-->
            <footer>
                <p id="footer-pad">&copy; Copyright 2014 Cydrobolt & <a href='//github.com/cydrobolt/kyanite'>The Kyanite Project</a></p>
            </footer>
        </div>
    </body>
</html>
