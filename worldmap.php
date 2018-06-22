<?php
    include("config.php");
    $irpg_page_title = "World Map";
    include("header.php");
?>

<h1>World Map</h1>
<p>[offline users are <font color="red">red</font>, online users are <font color="blue">blue</font>, normal items are <font color="orange">orange</font>, unique items are <font color="green">green</font>]</p>


<div id="map">
    <img src="makeworldmap.php" usemap="#world" border="0" />
    <map id="world" name="world">
<?php
    $file = fopen($irpg_db,"r");
    fgets($file,1024);
    $itemfile = fopen($irpg_itemdb,"r");
    fgets($itemfile,1024);
    while($location=fgets($file,1024)) {
        list($who,,,,,,,,,,$x,$y) = explode("\t",trim($location));
        print "        <area shape=\"circle\" coords=\"".$x.",".$y.",".$crosssize."\" alt=\"".htmlentities($who).
              "\" href=\"playerview.php?player=".urlencode($who)."\" title=\"".htmlentities($who)."\" />\n";
    }
    while ($line=fgets($itemfile,1024)) {
        list($xy,$type,$level) = explode("\t",trim($line));
	list($x,$y) = explode(':',$xy);
		print "        <area shape=\"circle\" coords=\"".$x.",".$y.",".$crosssize."\" alt=\"".htmlentities($type." [".$level."]").
              "\" title=\"".htmlentities(($type=='0'?"Ring":($type=='1'?"Amulet":($type=='2'?"Charm":($type=='3'?"Weapon":($type=='4'?"Helm":($type=='5'?"Tunic":($type=='6'?"Gloves":($type=='7'?"Shield":($type=='8'?"Leggings":"Boots")))))))))." [".$level."]")."\" />\n";
    }
    fclose($file);
?>
    </map>
</div>
<br></br>
<?php include("footer.php");?>
