<?php

require_once 'req.php';
$ruser = $_GET['user'];
$rusersan = $mysqli->real_escape_string($ruser);
$rkey = $_GET['key'];
$nrkey = sha1(mcrypt_create_iv(23, MCRYPT_DEV_URANDOM));
$rkeys = $mysqli->real_escape_string($rkey);

$a = "SELECT rkey FROM auth WHERE username='{$rusersan}'";
$b = $mysqli->query($a) or showerror();
$c = mysqli_fetch_assoc($b);

$iv = $c['rkey'];

if ($iv == $rkey) {
    $qr = "UPDATE auth SET valid='1', rkey='{$nrkey}' WHERE username='$rusersan';";
    $rr = $mysqli->query($qr) or showerror();
    require_once('header.php');
    echo "You have successfully activated your account. You may now login (top right)";
    require_once('footer.php');
    die();
} else {
    require_once('header.php');
    echo "The key/username you specified is incorrect.";
    require_once('footer.php');
    die();
}
