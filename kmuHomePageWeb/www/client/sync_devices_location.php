<?php 
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("../common/db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata))
	{
		echo "undefined data"; exit;
	}
	else
	{
        $data = json_decode($postdata,true);
        $id_project = isset($data["id_project"])?$data["id_project"]:"";
        $work_datetime = isset($data["work_datetime"])?$data["work_datetime"]:"";

        
		// 쿼리생성
        $query = "SELECT id_project, team FROM tbl_track ";
        $query .= "WHERE id_project={$id_project} AND work_datetime >= '{$work_datetime}' ";
        $query .= "GROUP BY team;";
		//echo $query."</br>";
        
        // 쿼리실행
		$result_team = mysqli_query($conn, $query);
		// 쿼리결과 갯수
		//$count_team = mysqli_num_rows($result_team);
		
		if( $result_team )
		{
			$arrLocation = array();
			
			while ($row_team = mysqli_fetch_assoc($result_team))
			{
				//echo " / ".$row["team"]." / ";
				
				$query  = "SELECT id_project, team, worker, agency, id_device, coord_x, coord_y, work_datetime ";
				$query .= "FROM tbl_track WHERE id_project={$row_team["id_project"]} AND team='{$row_team["team"]}' ORDER BY work_datetime DESC LIMIT 1 ";
				//echo $query."</br>";

				$result_location = mysqli_query($conn, $query);

				if( $result_location )				{
					

					while ($row_location = mysqli_fetch_assoc($result_location))
					{
						array_push($arrLocation, $row_location);						
					}
					
				}
			}
		}

		echo a2json($arrLocation);

		// if($result)
		// {
		// 	$rows = array();

		// 	while ($row = mysqli_fetch_assoc($result))
		// 	{
		// 		array_push($rows, $row);
		// 	}
		// }
		// else // DB 연결에 실패했을 경우
		// {
		// 	$row = "DBCF";
		// }
		// //echo "NEW : ";
		// echo "{WorkAssign:".a2json($rows)."}";
	}
	exit;
?>