<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/login.html 000002555 */ ?>
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
<script>
	$(document).ready(function(){
		$(window).on("resize",function(){
			$("#login-table").center();
		}).resize();
		
		$("#login-password").on("keyup",function(e){
			if(e.keyCode==13) $("#login-submit").trigger("click");
		});
		
		$("#login-submit").on("click",function(){
			var password = $("#login-password").val();			
			if(password!=null&&password!=""){
				var data = new Object();
				data.password = password;
				data = JSON.stringify(data);
				$.ajax({
					type:"POST",
					url:"/process/login",
					data:"data="+data,
					dataType:"text",
					success:function(res){
						if(res=="success"){
							nextPage();
						}else if(res=="fail"){
							alert("비밀번호가 일치하지 않습니다.");
						}else{
							alert("DB서버 연결에 실패하였습니다.");
						}
					},
					error:function(request,status,error){
					}
				});
			}
		});
		
		function nextPage(){
			location.href = "./country_map";
		}
	});
</script>
<style>
	body{padding:0;margin:0;border:0;}
	#login-table{width:400px;height:475px;}
	#login-header{height:150px;font-size:36px;text-align:center;}
	#login-contents{height:75px;font-size:24px;text-align:center;vertical-align:top;}
	#login-form{height:50px;font-size:18px;text-align:center;}
	#login-password{width:200px;height:30px;}
	#login-submit{width:75px;height:30px;background:black;color:white;border:none;cursor:pointer;}
	#login-blank{height:200px;visibility:hidden;}
</style>
</head>
<body>
	<table id="login-table" class="table reset">
		<tr id="login-header">
			<td>산림조사 관리자페이지</td>
		</tr>
		<tr id="login-contents">
			<td>관리자 비밀번호를 입력해주세요.</td>
		</tr>
		<tr id="login-form">
			<td>
				<input id="login-password" type="password" placeholder="비밀번호 입력">
				<input id="login-submit" type="button" value="확인" readonly>
			</td>
		</tr>
		<tr id="login-blank">
			<td></td>
		</tr>
	</table>
</body>
</html>