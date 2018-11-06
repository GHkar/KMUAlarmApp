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

        $table_name = isset($dataArray["table_name"]) ? $dataArray["table_name"] : "";
        $id_project = isset($dataArray["id_project"]) ? $dataArray["id_project"] : 0;

        $table_name = "tbl_probe_damage";
        $id_project = 1;

        //------------------------------------------------------------------------------------------
        $query  = "SELECT * FROM {$table_name} ";
        $query .= "WHERE id_project = {$id_project} ";
        $query .= ";";
        echo " //// ".$query;

        $result = mysqli_query($conn,$query);
        $count = mysqli_num_rows($result);

        if($result)
        {
            $return = array("result"=>"COUNT", "table_name"=>$table_name, "id_project"=>$id_project, "count"=>$count);

            echo a2json($return);
        }
        else
        {
            $return = array("result"=>"FAIL", "table_name"=>$table_name, "id_project"=>$id_project, "count"=>$count);            
            echo a2json($return);
        }
    }
?>