<?php
header("Content-Type: text/html; charset=UTF-8");
//phpfastcache::setup("storage","auto");
for($i=4;$i>=0;$i-=1){
	$data[$i]=get(date("Y/m/d",strtotime("-${i} day")));
}
//デバッグ用
//$data[$i]=get("2014/05/03");
$alldata=explode("\n",implode('',$data));
$number=count($alldata);
for($n=0;$n<$number;$n++){
	if(strpos($alldata[$n],'QUA')===false||substr($alldata[$n],33,33)!=4){
		$alldata[$n]='';
	}
}
$alldata=array_values(array_filter($alldata));
$number=count($alldata);
for($m=0;$m<$number;$m++){
	$shingen[]=mb_substr($alldata[$m],29,mb_strpos(mb_substr($alldata[$m],29),'/'));
}
$shingenD[]=array_filter(array_count_values($shingen),'filter');
//デバッグ用
print_r($shingenD);
print_r($shingen);
print_r($alldata);
function get($day){
	$url = "http://api.p2pquake.com/v1/userquake?date=${day}";
	try {
		$html="";
		//$html = file_get_contents($url, false, NULL);
		//curlにしますか
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,FALSE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
		$html=curl_exec($ch);
		curl_close($ch);
		//curlにしたぞ
		$html= mb_convert_encoding($html, "UTF-8", "SJIS");
	} catch (Exception $e) {
		die("ERROR地震情報APIへの接続に失敗しました。<br>"); 
	}
	return $html;
}
function filter($var){
    return ($var>=12)? TRUE : FALSE;
}
?>