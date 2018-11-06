<?
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("../common/db_connection.php");

	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata))
	{
		echo "undefined data"; 
		exit;
	}

    $_project_name = trim($_GET[project_name]);
    $_organ_name = trim($_GET[organ_name]);
	echo $_project_name." / ".$_organ_name;
	
	if( !$_project_name || !$_organ_name )
	{
		echo "누락된 데이타 있음";
	}
	else
	{
		$query = "INSERT INTO tbl_project ";
		$query .= "(name, organ, create_date) ";
		$query .= "VALUES('$_project_name', '$_organ_name', now());";

		echo "</br>".$query;

		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
	}

?>

<script>
	var url = "s_work_assign.php";
	location.href = url;
</script>