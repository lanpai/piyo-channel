<?php
function logCh($errorLevel, $string)
{
  include 'config.php';
  if ($config[enableLogs])
  {
    date_default_timezone_set($config[timezone]);
    $string = "[".date("H:i:s")."] [".$errorLevel."] ".$string."\n";
    $dir = "../logs/log-".date("Y-m-d").".log";
    $file = fopen($dir, "a");
    fwrite($file, $string);
    fclose($file);
    
    return $string;
  }
}
?>