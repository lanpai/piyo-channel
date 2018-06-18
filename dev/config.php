<?php
/*
piyo-channel rev. 2
*/

include '../config.php';

// General Config
$config[board] = "dev";

$config[newThreadText] = "New Thread";
$config[replyText] = "Reply";

// Editable index page info
$config[extraDivs][0][header] = "<h3>Boards</h3>";
$config[extraDivs][0][body] = '<a href="../dev/">/dev/</a>';
$config[extraDivs][1][header] = "<h3>About</h3>";
$config[extraDivs][1][body] = '<p>a configurable, easy-to-use, light-weight message board.</p>';
$config[extraDivs][2][header] = "<h3>About Tripcodes</h3>";
$config[extraDivs][2][body] = '<p>Tripcodes:</p><a href="https://en.wikipedia.org/wiki/Imageboard#Tripcodes">https://en.wikipedia.org/wiki/Imageboard#Tripcodes</a>';

$config[stylesheetSrc] = "../styleblue.php"; // Path relative to this file

// $config[postsPerPage] = "20"; // Not yet implemented. . .
?>