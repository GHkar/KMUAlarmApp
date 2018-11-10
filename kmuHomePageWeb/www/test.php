<?php
include "Snoopy.class.php";
$snoopy = new Snoopy;

$o="";


// $snoopy->maxframes = 1;

// 파싱 주소 입력.
if($snoopy->fetch("http://www.kmu.ac.kr/uni/main/page.jsp?mnu_uid=143&"))
{
//  echo "<PRE>".htmlspecialchars($snoopy->results[0])."</PRE>\n";
//  echo "<PRE>".htmlspecialchars($snoopy->results[1])."</PRE>\n";
//  echo "<PRE>".htmlspecialchars($snoopy->results[2])."</PRE>\n";



$txt=$snoopy->results;
// $rex="/\<div class=\"u_skip.+\"\>(.*)\<\/td\>/";
// $rex = "/\<a href=\"(.*)\"\<\/a>/";
// foreach($var as $arr < 25 )
// {
    $rex="/\<td class=\"writer+\"\>(.*)\<\/td\>/";
    preg_match_all($rex,$txt,$o);
    print_r($o[0][0]);
// }



// echo print_r($snoopy->results);
}
else
 echo "error fetching document: ".$snoopy->error."\n";

?>

