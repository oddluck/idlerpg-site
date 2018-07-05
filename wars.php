<?php 
include("config.php"); 

$irpg_page_title = "War Report"; 

include("header.php"); 
include("commonfunctions.php"); 

   echo "<h1>War Report:</h1>\n"; 
   function array_csort() {  //coded by Ichier2003 
   $args = func_get_args(); 
   $marray = array_shift($args); 

   $msortline = "return(array_multisort("; 
   foreach ($args as $arg) { 
       $i++; 
       if (is_string($arg)) { 
           foreach ($marray as $row) { 
               $a = strtoupper($row[$arg]); 
               $sortarr[$i][] = $a; 
           } 
       } else { 
           $sortarr[$i] = $arg; 
       } 
       $msortline .= "\$sortarr[".$i."],"; 
   } 
   $msortline .= "\$marray));"; 

   eval($msortline); 
   return $marray; 
} 

$file = fopen($irpg_mod,"r"); 
$temp = array(); 
$z=0; 
while ($line=fgets($file)) { 
   if (strstr($line," war")) { 
      $first = strpos($line,"] "); 
      $last = strpos($line," admirable"); 
      $first += 2; 
      $name = substr($line,$first,$last-$first); 
      $found=0; 
      for ($i=0;$i<count($temp);$i++) { 
         if ($temp[$i]["Name"] == $name) { 
            $temp[$i]["Count"]++; 
            $found=1; 
         } 
      } 
      if ($found==0) { 
         $temp[$z] = array("Name" => $name, "Count" => 1); 
         $z++; 
      } 
   } 
} 
fclose($file); 
$temp = array_csort($temp, "Count", SORT_DESC, "Name", SORT_ASC); 
reset($temp); 
$countcheck = 0; 
for ($i=0;$i<count($temp);$i++) { 
   $reportname = $temp[$i]["Name"]; 
   $count = $temp[$i]["Count"]; 
   $file = file($irpg_db); 
    unset($file[0]); 
    usort($file, 'cmp_level_desc'); 
    $found2=0; 
    foreach ($file as $line) { 
            list($user,,,$level,$class,$secs,,,$online,,,,,,,,,,,,, 
                 $item['amulet'], 
                 $item['charm'], 
                 $item['helm'], 
                 $item['boots'], 
                 $item['gloves'], 
                 $item['ring'], 
                 $item['leggings'], 
                 $item['shield'], 
                 $item['tunic'], 
                 $item['weapon'], 
                 $alignment, 
            ) = explode("\t",trim($line)); 
        if ($user == $reportname) { 
           /* why not HTML_entity? tb */ 
           $userclass = str_replace("<","<",$class); 
           $userclass = str_replace(">",">",$userclass); 
           $user2 = str_replace("<","<",$user); 
           $user2 = str_replace(">",">",$user2); 
           $user_encode = htmlentities(urlencode($user)); 
           $next_level = duration($secs); 
           $userlevel = $level; 
           $useronline = $online; 
           $found2=1; 
        $sum = 0; 
        foreach ($item as $key => $val) { 
            $sum += $val; 
        } 
       } 
   } 
   if ($found2==1) { 
      $found2=0; 
      if ($count == $countcheck) { 
         print "<BR> <a".(!$useronline?" class=\"offline\"":"")." href=\"playerview.php?player=$user_encode\">$user2</a>, the level $userlevel $userclass.[$sum] Next level in $next_level.</li>\n"; 
      } else { 
         echo "<P><span class='contentheading'>$count win".($count>1?"s":"")."</span>\n"; 
         print "<BR> <a".(!$useronline?" class=\"offline\"":"")." href=\"playerview.php?player=$user_encode\">$user2</a>, the level $userlevel $userclass.[Total sum: $sum] Next level in $next_level.</li>\n"; 
         $countcheck = $count; 
      } 
   } 
} 
echo "<BR><BR>\n"; 
?> 
<? 
    include("footer.php"); 
?> 

