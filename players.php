<?php
    include("config.php");
    include("commonfunctions.php");
    $irpg_page_title = "Player Info";
    include("header.php");
?>

  <h2>Pick a player to view</h2>
  <p class="small">[red=offline]</p>
  <ol>
<?php
    $file = file($irpg_db);
    unset($file[0]);
    usort($file, 'cmp_level_desc');
    foreach ($file as $line) {
        list($user,,,$level,$class,$secs,,,$online) = explode("\t",trim($line));

        $class = htmlentities($class);
        $next_level = duration($secs);

        print "    <li".(!$online?" class=\"offline\"":"")."><a".
              (!$online?" class=\"offline\"":"").
              " href=\"playerview.php?player=".urlencode($user).
              "\">".htmlentities($user).
              "</a>, the level $level $class. Next level in $next_level.</li>\n";

    }
?>
  </ol>

  <p>See player stats in <a href="db.php">table format</a>.</p>

<?php include("footer.php")?>
