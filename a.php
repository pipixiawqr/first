<?php
//挑选VIP
//CURL模拟GET请求
function _curl($url){
	$curl=curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$res=curl_exec($curl);
	return iconv('gbk','utf-8',$res);
	curl_close($curl);
}
function _timeout($url){
	try{
		return _curl($url);
	}catch(Exception $e){
		return _timeout($url);
	}
}

//连接数据库，将数据导入数据库中
function _mysql($sql){
	$host="localhost";
	$user="******";
	$passwd="**********";
	$dbname="****";
	$charset="utf8";
	$link=mysql_connect($host,$user,$passwd);
	mysql_select_db($dbname);
	mysql_set_charset($charset);
	mysql_query($sql);	
}

//正则匹配，筛选出用户名，用户组，同时输出uid,将用户名和用户组插入数据库

for ($i=110058; $i <110080 ; $i++) 
{ 
	$url="http://www.*********.com/home.php?mod=space&uid=$i&do=profile&from=space";
	$res=_timeout($url);
	preg_match_all("/<h2 class=\"mt\">(.*?)<\/h2>.*?<a.*?ac=usergroup.*?target=\"_blank\">.*?(VIP).*?<\/a>/is", $res,$matchs);		
		if (!empty($matchs[1])) {
			echo $i."\r\n";
			$username=$matchs[1][0];
			//$usergroup=$matchs[2][0];
			$sql="insert into test(uid,username) values('$i','$username');";
			_mysql($sql);
		}


}

?>
