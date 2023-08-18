<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/country_map.html 000008346 */ ?>
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
<link rel="stylesheet" href="./css/common.css">
<script>
	$(document).ready(function(){
		$("#header").load("./common_header");
	});
</script>
<style>
	#contents{height:calc(100% - 50px);}
	#control{background:black;color:white;border:1px solid #999999;border-radius:5px;}
</style>
</head>
<body>
	<div id="header"></div>
	<div id="contents">
		<canvas id='textCanvas'></canvas>
	</div>
	<script>
		var tCtx = document.getElementById('textCanvas').getContext('2d');
		
		var loadingCnt = 0;
		function getMarker(list){
			for(i=0; i<list.length; i++){
				
				var markerData = {
					lat:parseFloat(list[i]["lat"]),
					lng:parseFloat(list[i]["lng"])
				};
				
				var marker = new google.maps.Marker({
					position: markerData,
					icon: icon[list[i]["mcolor"]],
					map: map,
				});
							
				var status;
				switch(list[i]["mcolor"]){
					case "blue": status = "감리확인"; break;//감리일
					case "yellow": status = "시공완료"; break;//방제일
					case "red": status = "시공대상"; break;//등록일
					case "beige": status = "예찰좌표"; break;
				}

				var message = list[i]["idfy"];
				if(list[i]["ctype"]!=""&&list[i]["ctype"]!=null){
					var cx = parseFloat(list[i]["cx"]).toFixed(1);
					var cy = parseFloat(list[i]["cy"]).toFixed(1);
					message += '<p class="reset">'+cx;
					message += ' '+cy+'</p>';
				}else{
					var lat = parseFloat(list[i]["lat"]).toFixed(6);
					var lng = parseFloat(list[i]["lng"]).toFixed(6);
					message += '<p class="reset">'+lat;
					message += ' '+lng+'</p>';
				}
				
				if(status!="예찰좌표"){
					if(list[i]["do"]!=0 && list[i]["do"]!=null){
						message += '<p class="reset">경급';
						if(list[i]["do"]>0){
							message += list[i]["do"];
							if(list[i]["d1"]>0) message += ","+list[i]["d1"];
							if(list[i]["d2"]>0) message += ","+list[i]["d2"];
						}else{
							message += "X";
						}
						message += " ";
					}
					if(status=="시공대상"&&list[i]["reg_date"]!=null){
						message += replaceAll(list[i]["reg_date"],"-","").substring(2);
					}else if(status=="시공완료"&&list[i]["cdate"]!=null){
						message += replaceAll(list[i]["cdate"],"-","").substring(2);
					}else if(list[i]["bdate"]!=null){
						message += replaceAll(list[i]["bdate"],"-","").substring(2);
					}
					message += '</p>';
				}
				addInfoWindow(marker,message);
				
				// 식별번호
				tCtx.canvas.width = tCtx.measureText(list[i]["idfy"]).width;
				//roundRect(tCtx, 100, 100, 200, 200, 10);
				//console.log(tCtx.canvas.width);
				tCtx.fillText(list[i]["idfy"], 0, 16);
				var marker = new google.maps.Marker({
					position: markerData,
					icon: new google.maps.MarkerImage(
							tCtx.canvas.toDataURL(),				
							new google.maps.Size(tCtx.canvas.width,32),
							new google.maps.Point(0,0),
							new google.maps.Point(-5,20)
						),
					map: map,
				});
			}
			loadingCnt++;
			setTimeout(function(){
				if(loadingCnt==1){
					damage_loading();
				}else if(loadingCnt==2){
					forecast_loading();
				}
			},100);
		}

		function roundRect(context, x, y, width, height, radius) {
			if(width < 1) return;
			context.beginPath();
				context.moveTo(x + radius, y); //오른쪽 상단 모서리를 그리기 위한 시작점으로 이동
				context.arcTo((x+width), y, (x+width), (y+height), radius);  //오른쪽 상단 모서리
				context.arcTo((x+width), (y+height), x, (y+height), radius); //오른쪽 하단 모서리
				context.arcTo(x, (y+height), x, y, radius); //왼쪽 하단 모서리
				context.arcTo(x, y, (x+radius), y, radius); //왼쪽 상단 모서리
			context.stroke();
		}

		var targetInfo;
		function addInfoWindow(marker,message){
			var infoWindow = new google.maps.InfoWindow({
				content: message
			});
			google.maps.event.addListener(marker,'click',function(){
				infoWindow.open(map, marker);
				if(targetInfo!=null) targetInfo.close();
				targetInfo = infoWindow;
			});
			google.maps.event.addListener(map, 'click', function() {
				infoWindow.close();
			});
			
		}

		// 지도 전역변수 선언
		var map, icon = new Object();
		// 지도 로딩이 끝난후 호출하는 함수
		function initMap(){
			// 맵세팅
			map = new google.maps.Map(document.getElementById('contents'), {
				zoom: 8,
				maxZoom: 22,
				minZoom: 8,
				panControl: false,
				zoomControl: false,
				mapTypeControl: true,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					mapTypeIds: ['roadmap', 'satellite', 'terrain']
				},
				overviewMapControl: false,
				fullscreenControl: false,
				streetViewControlOptions:{
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				center:{
					lat: 36.316,
					lng: 127.6342
				}
			});
			// 아이콘 세팅
			icon.red = new google.maps.MarkerImage(
				//"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|"+"FE7569",
				"http://175.207.12.252:603/admin/image/marker_red_6.png",
				new google.maps.Size(16,16),
				new google.maps.Point(0,0),
				new google.maps.Point(16,16)
			);
			icon.blue = new google.maps.MarkerImage(
				//"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|"+"3366FF",
				"http://175.207.12.252:603/admin/image/marker_blue_6.png",				
				new google.maps.Size(16,16),
				new google.maps.Point(0,0),
				new google.maps.Point(16,16)
			);
			icon.yellow = new google.maps.MarkerImage(
				//"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|"+"FFFF66",
				"http://175.207.12.252:603/admin/image/marker_yellow_6.png",
				new google.maps.Size(16,16),
				new google.maps.Point(0,0),
				new google.maps.Point(16,16)
			);
			icon.beige = new google.maps.MarkerImage(
				//"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|"+"FFFF66",
				"http://175.207.12.252:603/admin/image/marker_beige_6.png",
				new google.maps.Size(16,16),
				new google.maps.Point(0,0),
				new google.maps.Point(16,16)
			);

			$.ajax({
				type:"POST",
				url:"/process/get_All_Marker",
				dataType:"json",
				success:function(res){
					if(res=="undefined data"||res=="undefined table"){
						alert("오류가 발생하여 마커데이터를 불러올 수 없습니다.");
					}else if(res=="no data"){
						alert("등록된 피해목이 없습니다.");
					}else{
						getMarker(res);
					}
				},
				error:function(request,status,error){
				}
			});
		}
		
		function damage_loading(){
			$.ajax({
				type:"POST",
				url:"/process/get_All_Marker2",
				dataType:"json",
				success:function(res){
					if(res=="undefined data"||res=="undefined table"){
						alert("오류가 발생하여 마커데이터를 불러올 수 없습니다.");
					}else if(res=="no data"){
						alert("등록된 예찰좌표가 없습니다.");
					}else{
						getMarker(res);
					}
				},
				error:function(request,status,error){
				}
			});
		}
		
		function forecast_loading(){
			$.ajax({
				type:"POST",
				url:"/process/get_All_Marker3",
				dataType:"json",
				success:function(res){
					if(res=="undefined data"||res=="undefined table"){
						alert("오류가 발생하여 마커데이터를 불러올 수 없습니다.");
					}else if(res=="no data"){
						alert("등록된 예찰좌표가 없습니다.");
					}else{
						getMarker(res);
					}
				},
				error:function(request,status,error){
				}
			});
		}
    </script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYCL0H_J1_4yWmmRz8Zus3p-YQs73XQ9g&callback=initMap"></script>
	<div style="z-index:1001;position:absolute;left:10;top:60;display:none;">
		<button id="control" class="reset none-select outline pointer padding-all-5">테스트</button>
	</div>
</body>
</html>