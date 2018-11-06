
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="#">
	<link rel="stylesheet" href="./js/jquery/jquery-ui.css">
	<script src="./js/jquery/jquery.min.js"></script>
	<script src="./js/jquery/jquery-ui.min.js"></script>
	<script src="./js/!ryan.js"></script>
	<link rel="stylesheet" href="./css/!ryan.css">
	<script src="./js/common.js"></script>
	<link rel="stylesheet" href="./css/common.css">
	<script src="./js/sheetjs.all.min.js"></script>
	<script src="./js/excelplus-2.4.min.js"></script>
	<script src="./js/simple-excel.js"></script>

	<title>생산 이력</title>
	<style>
		#header{min-width:1725px;}
		#title-area{min-width:1725px;max-width:1925px;}
		#table{min-width:1725px;max-width:1925px;}
	</style>
</head>

<body style="text-align: center;">

<script>
//var _cusid = <? if(strlen($_GET[_cusid])) echo $_GET[_cusid]; else echo "0";?>;
//var _team = "";
var _workType = "";

function changeSave(obj)
{
	alert("_row_num : " + obj);
	//var _row_num = document
	var _id_project = document.getElementById("_id_project").value;
	var _id_device = document.getElementById("_id_device").value;
	var _work_type = document.getElementById("_work_type").value;
	
	var _objTeam = document.getElementById("_team");
	//alert(_objTeam.value);
	_team = _objTeam.options[_objTeam.selectedIndex].text;
	
	alert(_id_project + " / " + _id_device + " / " + _work_type + " / " + _team);
	// _team = obj[obj.selectedIndex].value;
	//var _id_device = document.getElementById("_id_device").value;
	//var _team = document.getElementById("_team").value;
	//alert(_id_device + " / " + _team);
	// alert( document.form['id_device'].value);
	// var url = "models.php?_cusid=" + _cusid;
	// location.href = url;
}

function changeWorkType(obj)
{
	_workType = obj[obj.selectedIndex].value;
	alert(_workType);
	// var url = "models.php?_cusid=" + _cusid;
	// location.href = url;
}
</script>

<?php 
	// -----------------------------------------------
	// 방제 - 대상목인식
	// -----------------------------------------------
	//include("db_open.php");
	$CORERIVER = "CORERIVER";
	include("../common/db_connection.php");

	$queryProject = "SELECT * FROM tbl_project ORDER BY name;";
	$resultProject = mysqli_query($conn, $queryProject);
	$arrProject = array();
	while( $rowProject = mysqli_fetch_array($resultProject) )
	{
		array_push($arrProject, $rowProject);
	}


	$query = "SELECT * FROM view_project_assign	ORDER BY name, team;";
	echo $query;
	// 쿼리실행
	$result = mysqli_query($conn,$query);
	// $result = mysql_query($query, $connect);
	// 쿼리결과 갯수
	//$count = mysqli_num_rows($result);
?>

	<table id="table" class="table reset margin-all-auto">
		<tr id="table-header">
	        <th align="center" valign="middle" colspan="15">작업 할당</th>
	    </tr>

	    <tr>
	    	<th align="center" valign="middle">번호</th>
	    	<th align="center" valign="middle">프로젝트명</th>
	        <th align="center" valign="middle">수행 기관</th>
	        <th align="center" valign="middle">생성 일자</th>
	        <th align="center" valign="middle">디바이스 번호</th>
	        <th align="center" valign="middle">팀</th>
	        <th align="center" valign="middle">할당 업무</th>
	    </tr>

	<?php
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result)
		{
			$rows = array();
			$row_count = 1;
			//while ($row = mysqli_fetch_assoc($result))
			while ($row = mysqli_fetch_array($result))
			{
				// array_push($rows, $row);
	?>				
				<tr>
					<form method='POST' id="_form" name="myForm" action="u_project_assign.php">
						<input type='hidden' id="_row_num" value=<?=$row_count?>>
						<input type='hidden' name="_id_project" id="_id_project" value=<?=$row[id_project]?>>
						<input type='hidden' name="_id_device" id="_id_device" value=<?=$row[id_device]?>>
					<td align="center" valign="middle"><?=$row_count?></td>
			    	<td align="center" valign="middle">
			    		<select name="_id_project_change">
			    		<?
			    			foreach($arrProject as $project)
			    			{
			    				echo "<option value=".$project[id]." ".($row[id_project] == $project[id] ? 'selected' : '').">".$project[name]."</option>";
			    			}
			    		?>
			    		</select>
			    	</td>
			    	<td align="center" valign="middle"><?=$row[organ]?></td>
			    	<td align="center" valign="middle"><?=$row[create_date]?></td>
			    	<td align="center" valign="middle"><?=$row[id_device]?></td>
			    	<td align="center" valign="middle">
						<select name="_team" id="_team">
							<option value="A" <?=$row[team] == "A" ? "selected" : "" ?>>A</option>
							<option value="B" <?=$row[team] == "B" ? "selected" : "" ?>>B</option>
							<option value="C" <?=$row[team] == "C" ? "selected" : "" ?>>C</option>
							<option value="D" <?=$row[team] == "D" ? "selected" : "" ?>>D</option>
							<option value="E" <?=$row[team] == "E" ? "selected" : "" ?>>E</option>
							<option value="F" <?=$row[team] == "F" ? "selected" : "" ?>>F</option>
							<option value="G" <?=$row[team] == "G" ? "selected" : "" ?>>G</option>
							<option value="H" <?=$row[team] == "H" ? "selected" : "" ?>>H</option>
							<option value="I" <?=$row[team] == "I" ? "selected" : "" ?>>I</option>
							<option value="J" <?=$row[team] == "J" ? "selected" : "" ?>>J</option>
						</select>
					</td>
			    	<td align="center" valign="middle">
						<select name="_work_type" id="_work_type" onchange="changeWorkType(this)">
							<option value="WORK_TYPE_PROBE" <?=$row[work_type] == "WORK_TYPE_PROBE" ? "selected" : "" ?>>WORK_TYPE_PROBE
							<option value="WORK_TYPE_CONTROL" <?=$row[work_type] == "WORK_TYPE_CONTROL" ? "selected" : "" ?>>WORK_TYPE_CONTROL
							<option value="WORK_TYPE_SUPERVISION" <?=$row[work_type] == "WORK_TYPE_SUPERVISION" ? "selected" : "" ?>>WORK_TYPE_SUPERVISION
						</select>
					</td>
					<td>
						<input type='submit' value='저장'>
					</td>
					</form>
			    </tr>
	<?php
				$row_count++;
			}
		}
		else // DB 연결에 실패했을 경우
		{
			$row = "DBCF";
		}
		//echo "NEW : ";
		//echo a2json($rows);

	?>

	</table>
<!-- =========================================================================================== -->
</body>
</html>