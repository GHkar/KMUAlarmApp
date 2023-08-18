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
        //echo "alksdjflkajsldf";
        $dataArray = json_decode($postdata,true);

        $id_project = isset($dataArray["id_project"]) ? $dataArray["id_project"] : 0;

        $team = isset($dataArray["team"])?$dataArray["team"]:"#";
        $team = strtoupper($team);
        
        $id_serial = isset($dataArray["id_serial"]) ? $dataArray["id_serial"] : "";
        $worker = isset($dataArray["worker"])?$dataArray["worker"]:"";
        $agency = isset($dataArray["agency"])?$dataArray["agency"]:"";
       
        
        $coord_x = isset($dataArray["coord_x"]) ? $dataArray["coord_x"] : 0;
        $coord_y = isset($dataArray["coord_y"]) ? $dataArray["coord_y"] : 0;
        $coord_x2 = isset($dataArray["coord_x2"]) ? $dataArray["coord_x2"] : 0;
        $coord_y2 = isset($dataArray["coord_y2"]) ? $dataArray["coord_y2"] : 0;

        $work_datetime = isset($dataArray["work_datetime"])?$dataArray["work_datetime"]:"";
        $sync_datetime = isset($dataArray["sync_datetime"])?$dataArray["sync_datetime"]:"";

        $control_type = isset($dataArray["control_type"])?$dataArray["control_type"]:"";
        
        $position = isset($dataArray["position"]) ? $dataArray["position"] : "";
        $state = isset($dataArray["state"]) ? $dataArray["state"] : "";
        
        $length = isset($dataArray["length"]) ? $dataArray["length"] : 0;
        $height = isset($dataArray["height"]) ? $dataArray["height"] : 0;
        $width = isset($dataArray["width"]) ? $dataArray["width"] : 0;
        
        $collection_type = isset($dataArray["collection_type"])?$dataArray["collection_type"]:"";
        $collection_direction = isset($dataArray["collection_direction"])?$dataArray["collection_direction"]:"";
        $collection_distance = isset($dataArray["collection_distance"])?$dataArray["collection_distance"]:0;
        
        $memo = isset($dataArray["memo"])?$dataArray["memo"]:"";


        // echo $id_project."/".$team."/".$id_serial."/".$worker."/".$agency."/".$coord_x."/".$coord_y."/".$work_datetime."/".$damage_type."/".$control_type."/".$position."/".$state."/".$length."/".$height."/".$width."/".$tree_risk."/".$memo;

        //------------------------------------------------------------------------------------------
        $query  = "SELECT * FROM tbl_probe_smoke ";
        $query .= "WHERE id_project = {$id_project} AND id_serial = '{$id_serial}' ";
        // echo " //// ".$query;

        $result = mysqli_query($conn,$query);
        $count = mysqli_num_rows($result);
        
        if( $result && $count > 0 )
        {
            $query  = "UPDATE tbl_probe_smoke SET ";
            $query .= "coord_x = {$coord_x} ";
            $query .= ", coord_y = {$coord_y} ";
            $query .= ", coord_x2 = {$coord_x2} ";
            $query .= ", coord_y2 = {$coord_y2} ";
            $query .= ", tree_type = '{$tree_type}' ";
            $query .= ", control_type = '{$control_type}' ";
            $query .= ", position = '{$position}' ";
            $query .= ", state = '{$state}' ";
            $query .= ", height = {$height} ";
            $query .= ", length = {$length} ";
            $query .= ", width = {$width} ";
            $query .= ", collection_type = '{$collection_type}' ";
            $query .= ", collection_direction = '{$collection_direction}' ";
            $query .= ", collection_distance = {$collection_distance} ";
            $query .= ", memo = '{$memo}' ";
            $query .= ", sync_datetime = now() ";
            $query .= "WHERE id_project = {$id_project} AND id_serial = '{$id_serial}' ";
            //echo $query;
        
            // // 쿼리실행
            $result = mysqli_query($conn,$query);
            
            if($result)
            {
                $return = array("result"=>"SUCCESS", "operation"=>"UPDATE", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                                "sync_datetime"=>date("Y-m-d H:i:s"));

                echo a2json($return);
            }
            else
            {
                $return = array("result"=>"FAIL", "operation"=>"UPDATE", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                        "sync_datetime"=>"");            
                echo a2json($return);
            }
        }
        else
        {
            $query  = "INSERT INTO tbl_probe_smoke ";
            $query .= "(id_project, id_serial, coord_x, coord_y, coord_x2, coord_y2, worker, agency ";
            $query .= ", work_datetime, sync_datetime, control_type ";
            $query .= ", position, state, length, height, width ";
            $query .= ", collection_type, collection_direction, collection_distance ";
            $query .= ", memo) ";
            $query .= "VALUES({$id_project}, '{$id_serial}', {$coord_x}, {$coord_y}, {$coord_x2}, {$coord_y2}, '{$worker}', '{$agency}' ";
            $query .= ", '{$work_datetime}', now(), '{$control_type}'"; 
            $query .= ", '{$position}', '{$state}', {$length}, {$height}, {$width} ";
            $query .= ", '{$collection_type}', '{$collection_direction}', {$collection_distance} ";
            $query .= ", '{$memo}')";
			//echo $query;	
			
			$result = mysqli_query($conn,$query);
			// // 업데이트 쿼리에 영향을 받은 갯수
			$count = mysqli_affected_rows($conn);
			
			// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
            if($result)
            {				
                if($count==1)
                {
                    $return = array("result"=>"SUCCESS", "operation"=>"INSERT", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                            "sync_datetime"=>date("Y-m-d H:i:s"));            
                    echo a2json($return);
                }					
				
                else
                {
                    $return = array("result"=>"FAIL", "operation"=>"INSERT", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                            "sync_datetime"=>"");            
                    echo a2json($return);		
                }
            }
            else
            {
				echo "DBCF";
			}
        }
    }

?>