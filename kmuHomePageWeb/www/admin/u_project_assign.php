

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

	$_id_project = trim($_POST[_id_project]);
	$_id_project_change = trim($_POST[_id_project_change]);
	$_id_device = trim($_POST[_id_device]);	
	$_team = trim($_POST[_team]);
	$_workType = trim($_POST[_work_type]);
	echo $_id_project_change." /// ".$_id_project." / ".$_id_device." / ".$_team." / ".$_workType;
	
	if( !$_id_project || !$_id_project_change || !$_id_device || !$_team || !$_workType )
	{
		echo "누락된 데이타 있음";
	}
	else
	{
		// $query = "INSERT INTO tbl_work_assign ";
		// $query .= "(id_project, team, work_type, changed_datetime) ";
		// $query .= "VALUES($_id_project_change, '$_team', '$_workType', now());";
		$query  = "UPDATE tbl_work_assign ";
		$query .= "SET id_project = $_id_project_change ";
		$query .= ", team = '{$_team}' ";
		$query .= ", work_type = '{$_workType}' ";
		$query .= ", changed_datetime = now() ";
		$query .= "WHERE id_device = '{$_id_device}' ";
		echo "</br>".$query;

		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		//mysql_query($query, $connect);
	}

?>

<script>
	var url = "s_project_assign.php";
	location.href = url;
</script>