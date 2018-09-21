<?php
session_start();
ignore_user_abort(true);

include 'config.php';
include '../query.php';

if (empty($_GET[thread]))
{
  $boardQuery = query(true, NULL);
} else
{
  $boardQuery = query(false, $_GET[thread]);
}

$info = $_SESSION[info];
$_SESSION = array();
?>

<html lang="en">
  <head>
    <title><?php echo $config[name]; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="utf-8">

    <link rel="stylesheet" href="<?php echo $config[stylesheetSrc]; ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/script.js"></script>
  </head>

  <body>
    <div class="top">
      <div class="header">
        <a href="<?php echo $config[homeURL]; ?>" title="Home">
          <img class="largeLogo" alt="<?php echo $config[name]; ?>" src="<?php echo $config[largeLogoSrc]; ?>">
        </a>
      </div>
      <div class="body">
        <?php if (empty($_GET[thread])) { ?>
          <div class="extra-divs">
            <?php for($i = 0; $i < count($config[extraDivs]); $i++) { ?>
              <div class="box">
                <div class="box-header">
                  <?php echo $config[extraDivs][$i][header]; ?>
                </div>
                <div class="box-body">
                  <?php echo $config[extraDivs][$i][body]; ?>
                </div>
              </div>
              <br>
            <?php } ?>
          </div>
        <?php } ?>
        <hr>
        <div class="box post">
          <div class="box-header">
            <h3>Post</h3>
          </div>
          <div class="box-body">
            <form action="../post.php" method="post">
              <label class="label">Name</label><br>
              <input type="hidden" name="board" value="<?php echo $config[board]; ?>">
              <input type="hidden" name="thread" value="<?php if (empty($_GET[thread])) echo 0; else echo $_GET[thread]; ?>">
              <input type="text" name="name" class="input" value="<?php if (empty($info[name])) echo "Anonymous"; else echo $info[name]; ?>"><br>
              <label class="label">Tripcode (optional)</label><br>
              <input type="text" name="tripcode" class="input"><br>
              <?php if (empty($_GET[thread])) { ?>
                <label class="label">Title</label><br>
                <input type="text" name="title" class="input" value="<?php if (empty($_GET[thread])) echo $info[title]; ?>"><br>
              <?php } ?>
              <label class="label">Body</label><br>
              <textarea name="body" class="input"><?php echo $info[body]; ?></textarea><br>
              <p class="post-error"><?php echo $info[error]; ?></p>
              <?php if (empty($info[error])) { ?>
                <br>
              <?php } ?>
              <input type="submit" class="input" value="Post">
            </form>
          </div>
        </div>
        <br>
        <hr>
        <div class="thread-list">
          <?php if ($boardQuery[rows] === 0) { ?>
            <hr>
            <div class="box">
              <div class="box-header">
                <?php if (empty($_GET[thread])) { ?>
                  <p>There are no threads. Why don't you make your own?</p>
                <?php } else { ?>
                  <p>Thread does not exist!</p>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
          <?php for($i = 0; $i < $boardQuery[rows]; $i++) { ?>
            <span class="threads">
              <div class="box">
                <div class="box-header">
                  <a class="thread-expand">-</a> <a class="thread-title" href="?thread=<?php echo $boardQuery[$i][threadID]; ?>"><?php echo $boardQuery[$i][title]; ?></a>
                  <br>
                  <p class="thread-user"><?php echo $boardQuery[$i][user]; ?></p>
                  <p class="thread-timestamp"><?php echo $boardQuery[$i][timestamp]; ?></p>

                  <br>
                  <p class="thread-numReplies"><?php echo $boardQuery[$i][replies]." Replies"; ?></p>
                </div>
                <div class="box-body">
                  <p class="thread-body">> <?php echo $boardQuery[$i][body]; ?></p>
                  <div class="thread-postID-div"><p class="thread-postID">#</p><a class="thread-postID threadID"><?php echo $boardQuery[$i][threadID]; ?></a><p class="thread-postID">/</p><a class="thread-postID postID"><?php echo $boardQuery[$i][id]; ?></a></div>
                </div>
              </div>
              <br>
              <?php for($j = 0; $j < $boardQuery[$i][replies]; $j++) { ?>
                <div class="box replies">
                  <div class="box-body">
                    <p class="thread-user"><?php echo $boardQuery[$i][$j][user]; ?></p>
                    <p class="thread-timestamp"><?php echo $boardQuery[$i][$j][timestamp]; ?></p>
                    <p class="thread-body">> <?php echo $boardQuery[$i][$j][body]; ?></p>
                    <div class="thread-postID-div"><p class="thread-postID">#</p><a class="thread-postID"><?php echo $boardQuery[$i][$j][threadID]; ?></a><p class="thread-postID">/</p><a class="thread-postID"><?php echo $boardQuery[$i][$j][id]; ?></a></div>
                  </div>
                </div>
                <br>
              <?php } ?>
            </span>
            <hr>
          <?php } ?>
        </div>
      </div>
    </div>
  </body>
</html>

<script>
$(".thread-expand").click(function() {
  if ($(this).html() == "-") $(this).html("+"); else $(this).html("-");
  $(this).parent().parent().children(".box-body").slideToggle();
  $(this).parent().parent().parent().children(".replies").slideToggle();
  $(this).parent().parent().parent().children("br").slideToggle();
});
</script>
