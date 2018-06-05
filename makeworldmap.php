<?php
    include("config.php");
    $file = fopen($irpg_db,"r");
    fgets($file,1024);
    $itemfile = fopen($irpg_itemdb,"r");
    fgets($itemfile,1024);

    session_start(); // sessions to generate only one map / person / 3s
    if (isset($_SESSION['time']) && time()-$_SESSION['time'] < 3) {
        header("Location: maperror.png");
        exit(0);
    }
    $_SESSION['time']=time();

    $map = imageCreate(500,500);
    $magenta = ImageColorAllocate($map, 255, 0, 255);
    $blue = imageColorAllocate($map, 0, 128, 255);
    $red = imageColorAllocate($map, 211, 0, 0);
    $orange = imageColorAllocate($map, 255, 128, 0);
    $yellow = imageColorAllocate($map, 255, 192, 0);
    ImageColorTransparent($map, $magenta);
    while ($line=fgets($file,1024)) {
        list(,,,,,,,,$online,,$x,$y) = explode("\t",trim($line));
        if ($online == 1) $color = $blue;
        else $color = $red;
        imageFilledEllipse($map, $x, $y, 8, 8, $color);
    }
    while ($line=fgets($itemfile,1024)) {
        list($xy,,$level) = explode("\t",trim($line));
	list($x,$y) = explode(':',$xy);
        if (is_numeric($level)) $color = $orange;
        else $color = $yellow;
        imageFilledEllipse($map, $x, $y, 6, 6, $color);
    }
    header("Content-type: image/png");
    imagePNG($map);
    imageDestroy($map);
?>
