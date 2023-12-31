<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/common_header.html 000005229 */ ?>
<script>
	$(document).on("click","#logout",function(){
		$.ajax({
			type:"POST",
			url:"/process/logout",
			success:function(){
				location.href = "./login";
			},
			error: function(request, status, error) {
			}
		});
	});
	
	$(document).on("click","#change",function(){
		var password = prompt("현재 비밀번호를 입력해주세요.");
		if(password!=null&&password!=""){
			$.ajax({
				type:"POST",
				url:"/process/selectPassword",
				data:"password="+password,
				dataType:"json",
				success:function(data){
					if(data=="fail"){
						alert("현재 비밀번호가 일치하지 않습니다.");
					}else{
						var password2 = prompt("변경하실 비밀번호를 입력해주세요.");
						if(password2!=null&&password2!=""){
							if(confirm(password2+"로 변경하시겠습니까?")){
								$.ajax({
									type:"POST",
									url:"/process/updatePassword",
									data:"password="+password2,
									success:function(){
										alert("비밀번호가 변경되었습니다.");
									},
									error: function(request, status, error) {
									}
								});
							}
						}
					}
				},
				error: function(request, status, error) {
				}
			});
		}
	});
</script>
<style>
	.menubar {
		min-width:728px;
		border:none;
		border:0px;
		margin:0px;
		padding:0px;
		font-size:16px;
		font-weight:bold;
	}
	.menubar ul	{
		background:#333333;
		height:50px;
		list-style:none;
		margin:0;
		padding:0;
	}
	.menubar li {
		float:left;
		padding:0px;
	}
	.menubar li a {
		background:#333333;
		color:white;
		display:block;
		font-weight:normal;
		line-height:50px;
		margin:0px;
		padding:0px 25px;
		text-align:center;
		text-decoration:none;
	}
	.menubar li a:hover, .menubar ul li:hover a {
		background:#999999;
		color:white;
		text-decoration:none;
	}
	.menubar li ul {
		background:#999999;
		display:none;
		height:auto;
		padding:0px;
		margin:0px;
		border:0px;
		position:absolute;
		width:200px;
		z-index:200;
	}
	.menubar li:hover ul {
		display:block;
	}
	.menubar li li {
		background:#333333;
		display:block;
		float:none;
		margin:0px;
		padding:0px;
		width:200px;
	}
	.menubar li:hover li a {
		background:none;
	}
	.menubar li ul a {
		display:block;
		height:50px;
		font-size:15px;
		font-style:normal;
		margin:0px;
		padding:0px 10px 0px 15px;
		text-align:left;
	}
	.menubar li ul a:hover, .menubar li ul li:hover a {
		background:#999999;
		border:0px;
		color:#ffffff;
		text-decoration:none;
	}
	.menubar p {
		clear:left;
	}
</style>
<div class="menubar">
	<ul>
		<li><a href="./country_map?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">지도화면</a></li>
		<li><a href="./naver_map?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">지도화면(네이버)</a></li>
		<li><a href="./forecast_tree?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">예찰좌표</a></li>
		<!--<li><a href="./damage_tree">피해목 조사_원래</a></li>-->
		<li><a href="./probe_damage?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">피해목 조사</a></li>
		<li><a href="./probe_smoke?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">훈증더미 조사</a></li>
		<li><a href="./probe_prevent?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">예방나무주사 조사</a></li>
		<li><a href="./design_damage?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">피해목 설계</a></li>
		<li><a href="./design_smoke?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">훈증더미 설계</a></li>
		<li><a href="./design_prevent?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">예방나무주사 설계</a></li>
	</ul>
	<ul>
		<!--<li><a href="./fumi_dummy_research">훈증무더기 조사_원래</a></li>-->
		<!--<li><a href="./control_tree">피해목제거 및 감리확인</a></li>-->
		<li><a href="./control_damage?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">피해목제거</a></li>
		<li><a href="./control_smoke?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">훈증더미 제거</a></li>
		<li><a href="./control_prevent?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">예방나무주사 실행</a></li>
		<!--<li><a href="./fumi_dummy">훈증무더기입력 및 감리확인</a></li>-->
		<li><a href="./supervision_damage?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">피해목 방제/감리</a></li>
		<li><a href="./supervision_smoke?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">훈증더미 방제/감리</a></li>
		<li><a href="./supervision_prevent?id_project=<?php echo $TPL_VAR["params"]["id_project"]?>&page=1">예방나무주사 방제/감리</a></li>
		<li style="float:right;"><a id="logout" class="pointer">종료</a></li>
		<li style="float:right;"><a id="change" class="pointer">비밀번호 변경</a></li>
		<li style="float:right;"><a href="./s_work_assign.php" target="_blank">작업 할당</a></li>
		<!--li style="float:right;"><a href="./work_assign">작업 할당</a></li-->
	</ul>
</div>