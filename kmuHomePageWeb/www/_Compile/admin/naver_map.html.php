<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/naver_map.html 000013395 */ ?>
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

<script src="map_naver/docs/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="map_naver/docs/js/examples-base.js"></script>
<script type="text/javascript" src="map_naver/docs/js/highlight.min.js"></script>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=ndc3brCAMBNOUfUZoDbN&amp;submodules=panorama"></script>
<link rel="stylesheet" type="text/css" href="map_naver/docs/css/examples-base.css" />

<!--script>
	$(document).ready(function(){
		$("#header").load("./common_header");
	});
</script-->
<style>
		#header{min-width:1725px;}
		#title-area{min-width:1725px;max-width:1925px;}
		#table{min-width:1725px;max-width:1925px;}
	</style>
	
<!--style>
	#contents{height:calc(100% - 50px);}
	#control{background:black;color:white;border:1px solid #999999;border-radius:5px;}
</style-->
</head>
<body onload="initMap();">

	<div id="header"></div>
	<div id="contents">
			<?php echo $TPL_VAR["sc"]["project_select"]?>

			<div id="map" style="width:100%;height:100%;">
					<!--div id="wrap2">
						<h2>미니맵 표시하기</h2>
						<a id="code-folder" href="#">코드 펼치기 ▽</a><br />
						<code id="snippet" class="snippet" style="display:none;"></code>
					</div-->
				</div>
			
				<!-- 미니맵div id="minimap" style="border-left:solid 5px #333;border-top:solid 5px #333;width:300px;height:300px;"></div-->			
	</div>
		
	
	<style type="text/css">
		html, body { height:100%; }
		#wrap2 { position:absolute;top:0px;left:0px;padding:20px;z-index:1001;width:100%;height:0;overflow:visible;color:#fff;pointer-events:none; }
		#back-link { margin-top:-10px;color:#333;font-weight:bold;color:#fff;pointer-events:auto; }
		#code-folder { margin-top:-10px;color:#333;font-weight:bold;color:#fff;pointer-events:auto; }
		#origin-marker { position:absolute;top:50%;left:50%;z-index:1000;background-color:#f00; width:10px;height:10px;border-radius:5px;pointer-events:none; }
		#snippet { width:700px;height:600px;overflow:hidden;overflow-y:auto;pointer-events:auto; }
		.buttons { position:absolute;top:0;left:100px;padding:5px; }
		.buttons .control-btn { pointer-events:auto; }
	</style>



	<script id="code">
	// size 옵션이 생략되면 map DOM 요소의 HTML 렌더링 크기로 자동 리사이즈 됩니다.
	var map = new naver.maps.Map('map', {
		// center: new naver.maps.LatLng(36.5666805, 127.9784147),
		// zoom: 8,
		zoom: 4,
		center: new naver.maps.LatLng(36, 127.8),

		minZoom: 1,
		mapTypeId: naver.maps.MapTypeId.HYBRID,
		zoomControl: true,
		zoomControlOptions: {
			position: naver.maps.Position.TOP_RIGHT
		},
		disableKineticPan: false
	});

	map.setOptions({
		mapTypeControl: true,
		scaleControl: false,
		logoControl: false
	});

	// 미니맵이 들어갈 HTML 엘리먼트를 controls 객체에 추가합니다. 가장 우하단에 위치하기 위해서 다른 옵션들을 잠시 끕니다.
	map.controls[naver.maps.Position.BOTTOM_RIGHT].push($("#minimap")[0]);
	map.setOptions({
		scaleControl: true,
		logoControl: true,
	});

	var minimap = new naver.maps.Map('minimap', { //미니맵 지도를 생성합니다.
		bounds: map.getBounds(),
		scrollWheel: false,
		scaleControl: false,
		mapDataControl: false,
		logoControl: false
	});


	var semaphore = false;
	naver.maps.Event.addListener(map, 'bounds_changed', function(bounds) {
		if (semaphore) return;

		minimap.fitBounds(bounds);
	});
	naver.maps.Event.addListener(map, 'mapTypeId_changed', function(mapTypeId) {
		var toTypes = {
			"normal": "hybrid",
			"terrain": "satellite",
			"satellite": "terrain",
			"hybrid": "normal"
		};

		minimap.setMapTypeId(toTypes[mapTypeId]);
	});
	naver.maps.Event.addListener(minimap, 'drag', function() {
		semaphore = true;
		map.panTo(minimap.getCenter());
		naver.maps.Event.once(map, 'idle', function() {
			semaphore = false;
		});

	});
	</script>

	<script>
	var wrap2 = $("#wrap2"),
		snippet = $("#snippet"),
		folder = $("#code-folder");

	folder.on("click", function(e) {
		e.preventDefault();

		if (snippet.is(":visible")) {
			snippet.slideUp();
			folder.text("코드 펼치기 ▽");
		} else {
			snippet.slideDown();
			folder.text("코드 접기 △");
		}
	});

	naver.maps.Event.addListener(map, "mapTypeId_changed", function(mapTypeId) {
		var els = wrap2.add(folder);
		if (mapTypeId === naver.maps.MapTypeId.SATELLITE || mapTypeId === naver.maps.MapTypeId.HYBRID) {
			els.css("color", "#fff");
		} else {
			els.css("color", "#000");
		}
	});

	// var marker = new naver.maps.Marker({
	//     position: new naver.maps.LatLng(37.3595704, 127.105399),
	//     map: map
	// });

	// var latlngs = [
	// 	new naver.maps.LatLng(37.3633324, 129.1054988),
	// 	new naver.maps.LatLng(37.3632916, 129.1085015),
	// 	new naver.maps.LatLng(37.3632507, 129.1115043),
	// 	new naver.maps.LatLng(37.3632097, 129.114507),
	// 	new naver.maps.LatLng(37.3631687, 129.1175097),
	// 	new naver.maps.LatLng(37.3597282, 129.105422),
	// 	new naver.maps.LatLng(37.3596874, 129.1084246),
	// 	new naver.maps.LatLng(37.3596465, 129.1114272),
	// 	new naver.maps.LatLng(37.3596056, 129.1144298),
	// 	new naver.maps.LatLng(37.3595646, 129.1174323)
	// ];

	var markerList = [];
	var infowindowListForecast = [];
	var infowindowListProbeDamage = [];

	// for (var i=0, ii=latlngs.length; i<ii; i++) {
	// 	var icon = {
	// 			url: "./map_naver/images/marker_red_16.png",
	// 			size: new naver.maps.Size(24, 37),
	// 			// anchor: new naver.maps.Point(12, 37),
	// 			// origin: new naver.maps.Point(i * 29, 0)
	// 		},
	// 		marker = new naver.maps.Marker({
	// 			position: latlngs[i],
	// 			map: map,
	// 			icon: icon
	// 		});

	// 	marker.set('seq', i);

	// 	markerList.push(marker);
	// 	//alert("index : " + i + "/" + latlngs[i]);

	// 	marker.addListener('mouseover', onMouseOver);
	// 	marker.addListener('mouseout', onMouseOut);

	// 	icon = null;
	// 	marker = null;
	// }

	function onMouseOver(e) {
		var marker = e.overlay;
		var seq = marker.get('seq');

		marker.setIcon({
			url: HOME_PATH +'/img/example/sp_pins_spot_v3.png',
			size: new naver.maps.Size(24, 37),
			anchor: new naver.maps.Point(12, 37),
			origin: new naver.maps.Point(seq * 29, 0)
		});
	}

	function onMouseOut(e) {
		var marker = e.overlay,
			seq = marker.get('seq');

		marker.setIcon({
			url: HOME_PATH +'/img/example/sp_pins_spot_v3.png',
			size: new naver.maps.Size(24, 37),
			anchor: new naver.maps.Point(12, 37),
			origin: new naver.maps.Point(seq * 29, 0)
		});
	}

	function initMap()
	{
		var url = new URL(window.location.href);
		var id_project = url.searchParams.get("id_project");
		
		getForcastInfo(id_project);
		getProbeDamageInfo(id_project);
	}

	function getForcastInfo(id_project)
	{
		$.ajax({
			type:"POST",
			url:"/process/getForecastInfo",
			data:"id_project=" + id_project,
			dataType:"json",
			success:function(res){
				if(res=="undefined data"||res=="undefined table"){
					alert("오류가 발생하여 마커데이터를 불러올 수 없습니다.");
				}else if(res=="no data"){
					alert("등록된 피해목이 없습니다.");
				}
				else
				{
					showForecastMarker(res);
				}
			},
			error:function(request,status,error){
				alert(request);
				alert(status);
				alert(error);
			}
		});
	}

	function showForecastMarker(list)
	{
		for(i=0; i < list.length; i++)
		{
			var markerData = 
			{
				coord_x:parseFloat(list[i]["coord_x"]),
				coord_y:parseFloat(list[i]["coord_y"])
			}

			var position = new naver.maps.LatLng(parseFloat(list[i]["coord_y"]), parseFloat(list[i]["coord_x"]));

			// YELLOW : 예찰 필요
			// PIN10 : 예찰 완료
			var pinUrl = "./map_naver/images/marker_yellow_8.png";

			if( list[i]["completed"] == "1" || list[i]["deleted"] == "1")
				pinUrl = "./map_naver/images/pin10_8.png";
				
			var icon = {
				url: pinUrl,
				size: new naver.maps.Size(12, 12),
				// anchor: new naver.maps.Point(12, 37),
				// origin: new naver.maps.Point(i * 29, 0)
			},
			marker = new naver.maps.Marker({
				position: position,
				map: map,
				icon: icon
			});

			marker.set('seq', i);

			var contentString = [
				'<div class="iw_inner">',
				'   [' + list[i]["id_serial"] + '] ',
				'   ' + list[i]["coord_x2"] + ', ' + list[i]["coord_y2"] + '</br>',
				'   ' + list[i]["worker"] + ', ' + list[i]["agency"] + '</br>',
				'   ' + list[i]["work_datetime"] + '</br>',
				'</div>'
			].join('');

			var infowindow = new naver.maps.InfoWindow({
				content: contentString
			});

			infowindowListForecast.push(infowindow);

			naver.maps.Event.addListener(marker, "click", function(e) 
			{
				//alert("CLICK");
				var marker = e.overlay;
				var seq = marker.get('seq');
				//alert(" " + seq);
				
				if (infowindowListForecast[seq].getMap()) {
					//alert("닫기");
					infowindowListForecast[seq].close();
				} else {
					//alert("열기");
					infowindowListForecast[seq].open(map, marker);
				}
			});

			//infowindow.open(map, marker);

			markerList.push(marker);
			//alert("index : " + i + "/" + latlngs[i]);

			marker.addListener('mouseover', onMouseOver);
			marker.addListener('mouseout', onMouseOut);

			icon = null;
			marker = null;

		}
	}

	function getProbeDamageInfo(id_project)
	{
		$.ajax({
			type:"POST",
			url:"/process/getProbeDamageInfo",
			data:"id_project=" + id_project,
			dataType:"json",
			success:function(res){
				if(res=="undefined data"||res=="undefined table"){
					alert("오류가 발생하여 마커데이터를 불러올 수 없습니다.");
				}else if(res=="no data"){
					alert("등록된 피해목이 없습니다.");
				}
				else
				{
					showProbeDamageMarker(res);
				}
			},
			error:function(request,status,error){
				alert(request);
				alert(status);
				alert(error);
			}
		});
	}

	function showProbeDamageMarker(list)
	{
		for(i=0; i < list.length; i++)
		{
			var markerData = 
			{
				coord_x:parseFloat(list[i]["coord_x"]),
				coord_y:parseFloat(list[i]["coord_y"])
			}

			var position = new naver.maps.LatLng(parseFloat(list[i]["coord_y"]), parseFloat(list[i]["coord_x"]));

			// alert(markerData.coord_x + "/" + markerData.coord_y);

			// PIN01 : 피해목, 피해고사, 피해, 
			// PIN02 : 의심목, 비병징목
			// PIN04 : 고사목, 자연고사
			// PIN05 : 기타 또는 직접 일력
			// PIN06 : 기상피해, 기상피해(풍해), 기상피해(설해) 
			
			var pinUrl = "./map_naver/images/pin05_8.png";

			if( list[i]["damage_type"] == "피해목" || list[i]["damage_type"] == "피해고사" || list[i]["damage_type"] == "피해" )
				pinUrl = "./map_naver/images/pin01_8.png";
			else if( list[i]["damage_type"] == "의심목" || list[i]["damage_type"] == "비병징목" )
				pinUrl = "./map_naver/images/pin02_8.png";
			else if( list[i]["damage_type"] == "고사목" || list[i]["damage_type"] == "자연고사" )
				pinUrl = "./map_naver/images/pin04_8.png";
			else if( list[i]["damage_type"] == "기상피해" || list[i]["damage_type"] == "기상피해(풍해)" || list[i]["damage_type"] == "기상피해(설해)" )
				pinUrl = "./map_naver/images/pin06_8.png";

			var icon = {
				//url : pinUrl,
				content : '<img src="' + pinUrl + '"><font color="yellow">' + list[i]["id_serial"] + '</font>',
				size: new naver.maps.Size(12, 12),
				// anchor: new naver.maps.Point(12, 37),
				// origin: new naver.maps.Point(i * 29, 0)
			},
			marker = new naver.maps.Marker({
				position: position,
				map: map,
				icon: icon
			});

			marker.set('seq', i);

			

			marker.addListener('mouseover', onMouseOver);
			marker.addListener('mouseout', onMouseOut);

			var contentString = [
				'<div class="iw_inner">',
				'   [' + list[i]["id_serial"] + '] ',
				'   ' + list[i]["coord_x2"] + ', ' + list[i]["coord_y2"] + '</br>',
				'   ' + list[i]["worker"] + ', ' + list[i]["agency"] + '</br>',
				'   ' + list[i]["work_datetime"] + '</br>',
				'   ' + list[i]["tree_type"] + ', ',
				'   ' + list[i]["damage_type"] + ', ' + list[i]["control_type"] + '</br>',
				'</div>'
			].join('');

			var infowindow = new naver.maps.InfoWindow({
				content: contentString
			});

			infowindowListProbeDamage.push(infowindow);

			naver.maps.Event.addListener(marker, "click", function(e) 
			{
				//alert("CLICK");
				var marker = e.overlay;
				var seq = marker.get('seq');
				//alert(" " + seq);
				
				if (infowindowListProbeDamage[seq].getMap()) {
					//alert("닫기");
					infowindowListProbeDamage[seq].close();
				} else {
					//alert("열기");
					infowindowListProbeDamage[seq].open(map, marker);
				}
			});

			//infowindow.open(map, marker);

			markerList.push(marker);
			//alert("index : " + i + "/" + latlngs[i]);

			icon = null;
			marker = null;

		}
	}
	</script>

</body>
</html>