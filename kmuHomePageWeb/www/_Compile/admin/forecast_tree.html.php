<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/forecast_tree.html 000004842 */ 
$TPL_forecast_tree_1=empty($TPL_VAR["forecast_tree"])||!is_array($TPL_VAR["forecast_tree"])?0:count($TPL_VAR["forecast_tree"]);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<title>Ryan</title>
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
<script>
	var excelTable = "forecast_tree";
	var tableName = "예찰좌표";
</script>
<style>
	#header{min-width:1725px;}
	#title-area{min-width:1725px;max-width:1925px;}
	#table{min-width:1725px;max-width:1925px;}
</style>
</head>
<body>
	<div id="header"></div>
	<div id="contents">
		<div id="title-area" class="reset margin-all-auto">
			<div id="title"></div>
			<div id="excel" class="right">
				<form id="excel-form" class="reset po-a" method="POST" ENCTYPE="multipart/form-data">
					<a class="none" href="/admin/form/forecast_tree.xlsx" target="_blank">양식 다운로드</a>
					<input type="button" class="excel-download excel-button reset button pointer" value="양식 다운로드">
					<input type="file" id="excel-select" name="excelFile" class="none" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
					<input type="button" id="excel-upload" class="excel-button reset button pointer" value="엑셀업로드(DB)">
					<input type="button" id="excel-download" class="excel-button reset button pointer" value="엑셀저장(현재)">
					<a id="excel-download-link" class="none" href="#" download="">&nbsp;</a>
					<input type="button" id="all-download" class="excel-button reset button pointer" value="엑셀저장(전체)">
					<a id="all-download-link" class="none" href="#" download="">&nbsp;</a>
				</form>
			</div>
		</div>
		<?php echo $TPL_VAR["sc"]["project_select"]?>	총 : <?php echo $TPL_VAR["sc"]["count"]?>개 검색 됨.
		<table id="table" class="table reset margin-all-auto">
			<tr id="table-header">
				<!--<td width="50"><input class="check-all" type="checkbox"></td>-->
				<td width="100">식별번호</td>
				<td width="100">등록자</td>
				<td width="175">등록업체</td>
				<td width="175">조사일시</td>
				<td width="150">경도</td>
				<td width="150">위도</td>
				<!--td width="150">
					<select class="where-select" data-type="cvt_type">
						<option value="" <?php if($TPL_VAR["sc"]["cvt_type"]==""){?>selected<?php }?>><?php if($TPL_VAR["sc"]["cvt_type"]==""){?>타원체<?php }else{?>전체<?php }?></option>
						<option value="WGS84 TM" <?php if($TPL_VAR["sc"]["cvt_type"]=="WGS84 TM"){?>selected<?php }?>>WGS84 TM</option>
						<option value="GRS80 TM" <?php if($TPL_VAR["sc"]["cvt_type"]=="GRS80 TM"){?>selected<?php }?>>GRS80 TM</option>
						<option value="BESSEL TM" <?php if($TPL_VAR["sc"]["cvt_type"]=="BESSEL TM"){?>selected<?php }?>>BESSEL TM</option>
					</select>
				</td>
				<td width="100">원점</td-->
				<td width="150">X좌표</td>
				<td width="150">Y좌표</td>
				<!--td width="100px">완료</td-->
				<td width="80px">완료</td>
			</tr>
<?php if($TPL_forecast_tree_1){foreach($TPL_VAR["forecast_tree"] as $TPL_V1){?>
			<tr>
				<!--<td><input class="select-check" type="checkbox" data-seq="<?php echo $TPL_V1["seq"]?>"></td>-->
				<td>P<?php echo $TPL_V1["id_serial"]?></td>
				<td><?php echo $TPL_V1["worker"]?></td>
				<td><?php echo $TPL_V1["agency"]?></td>
				<td><?php echo $TPL_V1["work_datetime"]?></td>
				<td><?php echo $TPL_V1["coord_x"]?></td>
				<td><?php echo $TPL_V1["coord_y"]?></td>
				<!--td></td>
				<td></td-->
				<td><?php echo $TPL_V1["coord_x2"]?></td>
				<td><?php echo $TPL_V1["coord_y2"]?></td>
				<!--td><?php echo $TPL_V1["completed"]?></td-->
				<td>
					<? 
						if( strcmp($TPL_V1["completed"], "1") == 0 )
							echo "조사완료";
						else
							echo "";
					
					?>					
				</td>				
			</tr>
<?php }}else{?>
			<tr><td colspan="9">조회된 데이터가 없습니다.</td></tr>
<?php }?>
		</table>
		<?php echo $TPL_VAR["sc"]["paging"]?>

	</div>
	<div id="spinner" class="loader spinner"></div>
	<div id="spinner-text" class="bg-black c-white none">엑셀DB 업로드중...</div>
	<div id="spinner-mask" class="spinner none"></div>
</body>
</html>