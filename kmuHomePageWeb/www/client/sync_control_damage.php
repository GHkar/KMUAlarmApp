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
        $id_serial = isset($dataArray["id_serial"]) ? $dataArray["id_serial"] : "";

        $worker = isset($dataArray["worker"])?$dataArray["worker"]:"";        
        $agency = isset($dataArray["agency"])?$dataArray["agency"]:"";
        $work_datetime = isset($dataArray["work_datetime"]) ? $dataArray["work_datetime"] : "";
        $sync_datetime = isset($dataArray["sync_datetime"])?$dataArray["sync_datetime"]:"";

        $wrong_reason = isset($dataArray["wrong_reason"]) ? $dataArray["wrong_reason"] : "";
        $control_type = isset($dataArray["control_type"])?$dataArray["control_type"]:"";
        
        $processing_type = isset($dataArray["processing_type"])?$dataArray["processing_type"]:"";
        $processing = isset($dataArray["processing"])?$dataArray["processing"]:0;
        $omission = isset($dataArray["omission"])?$dataArray["omission"]:0;
        $picture_path = isset($dataArray["picture_path"])?$dataArray["picture_path"]:"";
        
        $memo = isset($dataArray["memo"]) ? $dataArray["memo"] : "";

        // $strLog  = $id_project."/".$id_serial."/".$worker."/".$agency."/".$work_datetime."/".$wrong_reason;
        // $strLog .= "/".$control_type."/".$processing_type."/".$processing."/".$picture_path."/".$memo;
        //echo $strLog;
        

        //------------------------------------------------------------------------------------------
        $query  = "SELECT * FROM tbl_control_damage ";
        $query .= "WHERE id_project = {$id_project} AND id_serial = '{$id_serial}' ";
        //echo " //// ".$query;

        $result = mysqli_query($conn,$query);
        $count = mysqli_num_rows($result);
        
        if( $result && $count > 0 )
        {            
            $query  = "UPDATE tbl_control_damage SET ";
            $query .= "worker = '{$worker}' ";
            $query .= ", agency = '{$agency}' ";
            $query .= ", work_datetime = '{$work_datetime}' ";
            $query .= ", wrong_reason = '{$wrong_reason}' ";
            $query .= ", control_type = '{$control_type}' ";
            $query .= ", processing_type = '{$processing_type}' ";
            $query .= ", processing = {$processing} ";
            $query .= ", omission = {$omission} ";
            $query .= ", picture_path = '{$picture_path}' ";
            $query .= ", memo = '{$memo}' ";
            $query .= ", sync_datetime = now() ";
            $query .= "WHERE id_project = {$id_project} AND id_serial = '{$id_serial}' ";
            // echo $query;
        
            // 쿼리실행
            $result = mysqli_query($conn,$query);
            
            if($result)
            {
                $return = array("result"=>"UPDATE", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                                "sync_datetime"=>date("Y-m-d H:i:s"));

                echo a2json($return);
            }
            else
            {
                $return = array("result"=>"FAIL", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                        "sync_datetime"=>"");            
                echo a2json($return);
            }
        }
        else
        {
            $query  = "INSERT INTO tbl_control_damage ";
            $query .= "(id_project, id_serial, worker, agency, work_datetime, sync_datetime ";
            $query .= ", wrong_reason, control_type, processing_type, processing, omission, picture_path, memo ";
            $query .= ") ";
            $query .= "VALUES({$id_project}, '{$id_serial}', '{$worker}', '{$agency}', '{$work_datetime}', now() ";
            $query .= ", '{$wrong_reason}', '{$control_type}', '{$processing_type}', {$processing}, {$omission}, '{$picture_path}', '{$memo}'";             
            $query .= ")";
			//echo $query;	
			
			$result = mysqli_query($conn,$query);
			// // 업데이트 쿼리에 영향을 받은 갯수
			$count = mysqli_affected_rows($conn);
			
			// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
            if($result)
            {				
                if($count==1)
                {
                    $return = array("result"=>"INSERT", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
                            "sync_datetime"=>date("Y-m-d H:i:s"));            
                    echo a2json($return);
                }					
				
                else
                {
                    $return = array("result"=>"FAIL", "id_project"=>$id_project, "team"=>$team, "id_serial"=>$id_serial,
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