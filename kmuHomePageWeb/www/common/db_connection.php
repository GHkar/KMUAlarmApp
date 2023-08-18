<?php 
	header("Content-Type: text/html; charset=UTF-8");
	
	if($CORERIVER!="CORERIVER"){
		echo "해당 페이지에 직접 접근할 수 없음";
		exit;
	}else{
		//$mysql_host = 'localhost';
		$mysql_host = 'gogotech.iptime.org';
		$mysql_user = 'namgang5995';
		$mysql_password = 'dasol6801*';
		//$mysql_db = 'namgang5995';
		$mysql_db = 'Namgang';
		$port = '3307';
		//echo "DB open...";
		$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db, $port);
		if(mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit;
		}
		//$dbconn = mysqli_select_db($mysql_db, $conn);
		mysqli_query("set session character_set_connection=utf8;");
		mysqli_query("set session character_set_results=utf8;");
		mysqli_query("set session character_set_client=utf8;");
	}
	
	function a2json($array){
		if(!is_array($array)){ return false; }
		$associative = count(array_diff(array_keys($array),array_keys(array_keys($array))));
		if($associative){
			$construct = array();
			foreach($array as $key => $value){
				if(is_numeric($key)){
					$key = "key_$key";
				}
				$key = '"'.addslashes($key).'"';
				if(is_array($value)){
					$value = a2json($value); 
				}else if(!is_numeric($value)||is_string($value)){
					$value = '"'.addslashes($value).'"';
				}
				$construct[] = "$key: $value";
			}
			$result = "{".implode(", ",$construct)."}";
		}else{
			$construct = array();
			foreach($array as $value){
				if(is_array($value)){
					$value = a2json($value);
				}else if(!is_numeric($value)||is_string($value)){
					$value = '"'.addslashes($value).'"';
				}
				$construct[] = $value;
			}
			$result = "[".implode(",",$construct)."]";
		}
		return $result;
	}
?>