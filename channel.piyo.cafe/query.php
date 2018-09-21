<?php
function query($queryAll, $threadID)
{
  include 'logger.php';
  include '../config.php';
  include 'config.php';

  $conn = new mysqli($config[dbip], $config[dbusername], $config[dbpassword], $config[dbname]);
  $conn->set_charset("utf8");

  if ($conn->connect_error)
  {
    echo logCh("ERROR", "Could not connect to specified MySQL server: ".$conn->connect_error);
    die();
  }
  
  $sql = 'CREATE TABLE `'.$config[dbname].'`.`'.$config[board].'` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `threadID` INT(6) NULL DEFAULT NULL , `title` TEXT NULL DEFAULT NULL , `body` TEXT NULL DEFAULT NULL , `username` TEXT NULL DEFAULT NULL , `tripcode` TEXT NULL DEFAULT NULL , `timestamp` TIMESTAMP NULL DEFAULT NULL , `isOP` BOOLEAN NULL DEFAULT NULL , `isLocked` BOOLEAN NULL DEFAULT NULL , `isPinned` BOOLEAN NULL DEFAULT NULL , PRIMARY KEY (`id`));';
  $results = $conn->query("SHOW TABLES LIKE '".$config[board]."'");
  if ($results !== FALSE)
    if (($results !== FALSE) && ($results->num_rows === 0))
      $conn->query($sql);
  
  $sql = 'SELECT * FROM `'.$config[board].'` WHERE `isOP` = 1 ORDER BY `threadID` DESC';

  if (!$queryAll)
    $sql = 'SELECT * FROM `'.$config[board].'` WHERE `isOP` = 1 AND `threadID` = '.$threadID.' LIMIT 1';

  $result = $conn->query($sql);

  $boardQuery[rows] = 0;

  if ($result->num_rows > 0)
  {
    $boardQuery[rows] = $result->num_rows;
    $i = 0;
    while($thread = $result->fetch_assoc())
    {
      $boardQuery[$i][title] = $thread[title];
      if ($thread[tripcode] === "")
        $boardQuery[$i][user] = $thread[username];
      else
        $boardQuery[$i][user] = $thread[username]."/".$thread[tripcode];
      $boardQuery[$i][timestamp] = $thread[timestamp];
      $boardQuery[$i][id] = $thread[id];
      $boardQuery[$i][threadID] = $thread[threadID];
      $body = $thread[body];
      if ($queryAll) { $body = substr($thread[body], 0, 205); if (strlen($body) === 205) { $body .= "..."; } }
      $boardQuery[$i][body] = str_replace("\n", "<br>", $body);
      
      $sql = 'SELECT * FROM (SELECT * FROM `'.$config[board].'` WHERE `isOP` = 0 AND `threadID` = '.$boardQuery[$i][threadID].' ORDER BY `timestamp` DESC LIMIT 3) as alias ORDER BY `timestamp`';
      
      if (!$queryAll)
        $sql = 'SELECT * FROM `'.$config[board].'` WHERE `isOP` = 0 AND `threadID` = '.$boardQuery[$i][threadID].' ORDER BY `timestamp`';
        
      
      $resultReplies = $conn->query($sql);
      
      $boardQuery[$i][replies] = 0;
      if ($resultReplies->num_rows > 0)
      {
        $boardQuery[$i][replies] = $resultReplies->num_rows;
        $j = 0;
        while($replies = $resultReplies->fetch_assoc())
        {
          if ($replies[tripcode] === "")
            $boardQuery[$i][$j][user] = $replies[username];
          else
            $boardQuery[$i][$j][user] = $replies[username]."/".$replies[tripcode];
          $boardQuery[$i][$j][timestamp] = $replies[timestamp];
          $boardQuery[$i][$j][id] = $replies[id];
          $boardQuery[$i][$j][threadID] = $replies[threadID];
          $body = $replies[body];
          if ($queryAll) { $body = substr($replies[body], 0, 205); if (strlen($body) === 205) { $body .= "..."; } }
          $boardQuery[$i][$j][body] = str_replace("\n", "<br>", $body);
          $j++;
        }
      }
      $i++;
    }
  }
  
  $conn->close();
  
  return $boardQuery;
}
?>