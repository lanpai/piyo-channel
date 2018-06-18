<?php
session_start();
ignore_user_abort(true);

include 'config.php';

$info[name] = $_POST[name];
$info[title] = $_POST[title];
$info[body] = $_POST[body];

if (empty($info[name]))
  $info[name] = "Anonymous";

$conn = new mysqli($config[dbip], $config[dbusername], $config[dbpassword], $config[dbname]);
$conn->set_charset("utf8");

if ($conn->connect_error)
{
  echo logCh("ERROR", "Could not connect to specified MySQL server: ".$conn->connect_error);
  die();
}

$results = $conn->query("SHOW TABLES LIKE '".$_POST[board]."'");
if (($results !== FALSE) && ($results->num_rows === 0))
  die();

if (trim($info[body]) == "")
{
  $info[error] = "Missing body!";
  $_SESSION[info] = $info;
  redirect();
}

if (trim($info[title]) == "" && $_POST[thread] == 0)
{
  $info[error] = "Missing title!";
  $_SESSION[info] = $info;
  redirect();
}

$tripcode = $_POST[tripcode];
if (!empty($tripcode))
  $tripcode = crc32($tripcode);
else
  $tripcode = "&ltN/A&gt";

$sql = "SELECT * FROM `".$_POST[board]."` ORDER BY `threadID` DESC LIMIT 1";
$result = $conn->query($sql);

if ($_POST[thread] != 0)
{
  $sql = "SELECT * FROM `".$_POST[board]."` WHERE `threadID` = ".mysqli_real_escape_string($conn, $_POST[thread])." LIMIT 1";
  $result = $conn->query($sql);
  if ($result->num_rows == 0)
  {
    header("Location: ./".$_POST[board]."/");
    die();
  }
}

if ($result->num_rows == 0)
  $id = 1;
else
  $id = $result->fetch_assoc()[threadID] + 1;
  
if ($_POST[thread] != 0)
  $sql = "INSERT INTO `".$_POST[board]."` (`id`, `threadID`, `title`, `body`, `username`, `tripcode`, `timestamp`, `isOP`, `isLocked`, `isPinned`) VALUES (NULL, '".mysqli_real_escape_string($conn, $_POST[thread])."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[title]))."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[body]))."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[name]))."', '".mysqli_real_escape_string($conn, $tripcode)."', CURRENT_TIMESTAMP, '0', '0', '0')";
else
  $sql = "INSERT INTO `".$_POST[board]."` (`id`, `threadID`, `title`, `body`, `username`, `tripcode`, `timestamp`, `isOP`, `isLocked`, `isPinned`) VALUES (NULL, '".mysqli_real_escape_string($conn, $id)."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[title]))."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[body]))."', '".mysqli_real_escape_string($conn, htmlspecialchars($info[name]))."', '".mysqli_real_escape_string($conn, $tripcode)."', CURRENT_TIMESTAMP, '1', '0', '0')";

$conn->query($sql);

redirect();

die();

function redirect()
{
  if ($_POST[thread] == 0)
    header("Location: ./".$_POST[board]."/");
  else
    header("Location: ./".$_POST[board]."?thread=".$_POST[thread]);
  die();
}
?>