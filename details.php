<?php

require_once 'req.php';
require_once 'headerpage.php';
require_once 'kyaauth.php';

function getvisits($lstart = 0, $lend = 50) {
    global $userinfo;
    global $mysqli;
    $sqr = "SELECT `ip`,`ua`,`timestamp`,`vid` FROM `stats` WHERE LIMIT {$lstart} , {$lend};";
    $res = $mysqli->query($sqr);
    $visits = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $vsttable = '<table class="table table-hover"><tr><th>IP</th><th>User-Agent</th><th>Referer</th><th>Date</th><th>Visit ID</th></tr>';
    foreach ($visits as $visit) {
        $vsttable = $vsttable . "<tr><td>" . $visit['ip'] . '</td>';
        $vsttable = $vsttable . "<td>" . substr($visit['ua'], 0, 100) . '</td>';
        $vsttable = $vsttable . "<td>" . substr($visit['ref'], 0, 120) . '</td>';
        $vsttable = $vsttable . "<td>" . $visit['timestamp'] . '</td>';
        $vsttable = $vsttable . "<td>" . $visit['vid'] . '</td></tr>';
    }
    $vsttable = $vsttable . "</tr></table>";
    return $vsttable;
}

$kyaauth = new kyaauth();
if (is_array($kyaauth->islogged())) {
    echo "<h2>Visitor Details:</h2>";
    if (!$_GET['ls'] && !$_GET['le']) {
        $table = getvisits();
        echo "<br>" . $table;
    } else if (($_GET['ls'] !== "") && ($_GET['le'] !== "")) {
        if (is_numeric($_GET['ls']) && is_numeric($_GET['le'])) {
            $ls = $mysqli->real_escape_string($_GET['ls']);
            $le = $mysqli->real_escape_string($_GET['le']);
        } else {
            echo "Range is not numerical.";
            require_once 'footer.php';
            die();
        }
        if(!($ls<$le)) {
            echo "Range end must be higher than range start.";
            require_once 'footer.php';
            die();
        }
        $qr = "SELECT MAX(vid) AS vid FROM stats";
        $re = $mysqli->query(qr);
        $re = mysqli_fetch_assoc($re);
        if($re['vid']<$ls) {
            echo "Start of range is over the amount of visits logged ({$re['vid']}<$ls)";
            require_once 'footer.php';
            die();
        }
        if($re['vid']<$le) {
            $le = $re['vid']+1;
        }
        
        //if parameters are passed (start and end of chart)
        $table = getvisits($ls,$le);
        echo "<h2>Visitor Details : $ls to $le</h2><br>".$table;
    } else {
        echo "Unknown selection, try clearing all URL Parameters and try again.";
        require_once 'footerpage.php';
        die();
    }
} else {
    //if not logged in
    echo "<h2>Sorry, but you are not authorized to view this page. You must be <a href='login.php'>logged in</a>.";
    require_once 'footerpage.php';
    die();
}


require_once 'footerpage.php';
