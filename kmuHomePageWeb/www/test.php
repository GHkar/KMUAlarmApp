<?php
//Snoopy.class.php를 불러옵니다
//require($_SERVER['DOCUMENT_ROOT'].'/Volumes/Data/Users/hs.go/Work/kmuHomePage/kmuHomePage/www/Snoopy.class.php');

//스누피를 생성해줍시다
//$snoopy = new Snoopy;

//스누피의 fetch함수로 제 웹페이지를 긁어볼까요? :)
//$snoopy->fetch('http://dovetail.tistory.com/38');

//결과는 $snoopy->results에 저장되어 있습니다
//preg_match 정규식을 사용해서 이제 본문인 article 요소만을 추출해보도록 하죠
//preg_match('/<div class="article">(.*?)<\/div>/is', $snoopy->results, $text);

//이제 결과를 보면...?
//echo "asdf";
//echo $text[1];

include "Snoopy.class.php";
$snoopy = new Snoopy;

$snoopy->maxframes = 5;

//네이버 파싱하니까 네이버 주소
if($snoopy->fetch("http://www.kmu.ac.kr/"))
{
//  echo "<PRE>".htmlspecialchars($snoopy->results[0])."</PRE>\n";
//  echo "<PRE>".htmlspecialchars($snoopy->results[1])."</PRE>\n";
//  echo "<PRE>".htmlspecialchars($snoopy->results[2])."</PRE>\n";
 echo print_r($snoopy->results);
}
else
 echo "error fetching document: ".$snoopy->error."\n";

?>

