<?php
/*
 * Kyanite sample configuration. 
 * The Kyanite Project - https://github.com/Cydrobolt/kyanite
*/

$host = "localhost"; //Enter Mysql host address
$user = "root"; //Mysql user
$passwd = ""; //Mysql user password
$db = "kyanite"; //Mysql DB name
$wsa = "somesite.com"; //Address of website : e.g website.com - do not include http://
$ip = $_SERVER['REMOTE_ADDR']; //How should Kyanite fetch the users' IP?

/*
 * Tip : Some hosts may require you to fetch IPs through 
 * the X-Forwarded-For header, or a similar header.
 * Because the X-Forwarded-For header can be spoofed, please treat it as
 * user input.
 */