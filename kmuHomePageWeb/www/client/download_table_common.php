<?php 
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("../common/db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata))
	{
		$return = array("result"=>"INVALID DATA");            
        echo a2json($return);
        exit;
	}
	else
	{
        //echo "alksdjflkajsldf";
        $dataArray = json_decode($postdata,true);

        $id_project = isset($dataArray["id_project"]) ? $dataArray["id_project"] : 0;
        $row_count = isset($dataArray["row_count"]) ? $dataArray["row_count"] : "";
        $table_name = isset($dataArray["table_name"]) ? $dataArray["table_name"] : "";   
        $last_download = isset($dataArray["last_download"]) ? $dataArray["last_download"] : "";       

        //------------------------------------------------------------------------------------------
        $query  = "SELECT * FROM {$table_name} ";
        $query .= "WHERE id_project = {$id_project} ";
        $query .= "AND ";
        if( $table_name == "tbl_forecast")
        {
            $query .= "deleted = 0 AND ";
        }
        $query .= "(";
        $query .= "(work_datetime > '{$last_download}') ";
        $query .= "OR ";
        $query .= "(sync_datetime IS NULL OR sync_datetime > '{$last_download}')  ";
        $query .= ")  ";
        $query .= ";";
        //echo " //// ".$query;

        $result = mysqli_query($conn,$query);
        $count = mysqli_num_rows($result);

        //echo $count."/".$row_count;

        //if($count != $row_count )
        {
            if($count>=1)
            {
				while($row = mysqli_fetch_assoc($result)){
					$return[] = $row;
                }
                
                //echo a2json($return);
                echo "{ {$table_name}:".a2json($return)."}";
            }
            
            // $return = array("result"=>"다름", "table_name"=>$table_name, "id_project"=>$id_project, "count"=>$count);

            // echo a2json($return);
        }
        // else
        // {
        //     $return = array("result"=>"같음", "table_name"=>$table_name, "id_project"=>$id_project, "count"=>$count);            
        //     echo a2json($return);
        // }
    }
?>