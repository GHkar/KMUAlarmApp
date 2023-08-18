$(document).on('scroll',function(){
	var right = $(window).scrollLeft();
	$('#excel-form').css('right',-right+'px');
});

$(window).on('resize',function(){
	var w_width = $(window).width();
	var t_width = $('#table').width();
	if(w_width>t_width){
		var r_width = (w_width - t_width) * 0.5;
		$('#excel-form').css('right',r_width+'px');
	}else{
		var r_width = w_width - 1100;
		$('#excel-form').css('right',r_width<=0?r_width:'0'+'px');
	}
});
	
$(function(){
	$("#header").load("./common_header");
	$("#title").html(tableName);
	
	var w_width = $(window).width();
	var t_width = $('#table').width();
	if(w_width>t_width){
		var r_width = (w_width - t_width) * 0.5;
		$('#excel-form').css('right',r_width+'px');
	}else{
		var r_width = w_width - 1100;
		$('#excel-form').css('right',r_width<=0?r_width:'0'+'px');
	}
	
	// 현재페이지의 체크박스 갯수
	var checkLength = $(".select-check").length;
	// 현재 체크된 박스갯수
	var nowCheck = 0;
	
	// 체크박스 단일선택
	$(".select-check").on("click",function(){
		var check = $(this).prop("checked");
		check==true?nowCheck++:nowCheck--;
		// 전체체크 됐는지 체크
		$(".check-all").prop("checked",nowCheck==10?true:false);
	});
	// 체크박스 전체선택 이벤트
	$(".check-all").on("click",function(){
		var check = $(this).prop("checked");
		$(".select-check").prop("checked",check==true?true:false);
	});
	
	// 현재페이지 체크 및 페이징 색입히기
	var urlCheck = location.href;
	var getParameter = urlCheck.split("?");
	var nowPage = 0;
	if(getParameter[1]!=null&getParameter[1]!=""){
		var resultPage = getParameter[1].split("=");
		nowPage = parseInt(resultPage[1]);
	}else{
		nowPage = 1;
	}
	$(".paging-number").eq(nowPage-1).css({
		"color":"white",
		"background":"#333333"
	});

	// 페이징 클릭이벤트
	$(".paging-button").on("click",function(){
		// 페이징버튼에서 값을 가져옴
		var urlData = $(this).attr("data-value");
			urlData = urlData.split("=");
		// 이동해야 할 페이지의 주소
		var type = urlData[0];
		var data = urlData[1];
		// 현재 URL의 모든 파라메터를 저장
		var params = getParams(location.href);
		// 기본주소를 저장
		var url = location.href.split("?")[0];
		
		// 결과를 저장할 변수
		var result = "";
		if(params=="no data"){
			result = type+"="+data;
		}else{
			var setArray = new Array();
			params = setParams(params,type,data);
			if(params=="not parameter"||params=="undefined data"||params=="different length"){
				alert("정상적인 접근이 아닙니다.");
			}else{
				var len = params[0].length;
				for(i=0; i<len; i++){
					result += params[0][i]+"="+params[1][i];
					if(i!=(len-1)) result += "&";
				}
			}
		}
		location.replace(url+"?"+result);
	});
	
	$(".where-select").on("change",function(){
		// 현재 변경한 값의 컬럼
		var type = $(this).attr("data-type");
		// 변경한 값을 저장
		var data = $(this).val();
		// 현재 URL의 모든 파라메터를 저장
		var params = getParams(location.href);
		// 기본주소를 저장
		var url = location.href.split("?")[0];
		
		// 결과를 저장할 변수
		var resultArray = new Array();
		if(params=="no data"){
			resultArray.push("page=1");
			resultArray.push(type+"="+data);
		}else{
			var setArray = new Array();
			params = setParams(params,type,data);
			if(params=="not parameter"||params=="undefined data"||params=="different length"){
				alert("정상적인 접근이 아닙니다.");
			}else{
				var check = false;
				var len = params[0].length;
				var resultArray = new Array();
				for(i=0; i<len; i++){
					// 이전 파라메터에 값이 포함되어있는지 체크
					if(params[0][i]==type && check==false) check = true;
					if(params[0][i]==type && data==""){
						// 파라미터는 있지만 값이 없을경우 배열에서 제외함
					}else{
						var result = params[0][i]+"=";
							result += params[0][i]!="page"?params[1][i]:"1";
						resultArray.push(result);
					}
				}
				// 이전 파라메터에 값이 없을 경우에는 추가해준다.
				if(check==false){
					resultArray.push(type+"="+data);
				}
			}
		}
		var paramsUrl = "";
		for(i=0; i<resultArray.length; i++){
			paramsUrl += resultArray[i] + ((i!=resultArray.length-1)?"&":"");
		}
		location.replace(url+"?"+paramsUrl);
	});
	
	$(".excel-download").on("click",function(){
		$(this).prev().get(0).click();
	});
	
	$("#excel-download").on("click",function(){
		var params = getParams(location.href);
		var data = new Object();
		if(params=="no data"){
			data.pname = ["page"];
			data.pvalue = ["1"];
		}else{
			data.pname = params[0];
			data.pvalue = params[1];
		}
		data = JSON.stringify(data);
		excelSelect(data);
	});
	
	$("#all-download").on("click",function(){
		var params = getParams(location.href);
		var data = new Object();
		if(params=="no data"){
			data.pname = ["page"];
			data.pvalue = ["all"];
		}else{
			params = setParams(params,"page","all");
			data.pname = params[0];
			data.pvalue = params[1];
		}
		data = JSON.stringify(data);
		excelSelect(data);
	});
	
	function excelSelect(data){
		$.ajax({
			type:"POST",
			url:"/process/getExcelData",
			data:"table="+excelTable+"&params="+data,
			dataType:"json",
			success:function(result){
				if(result!="fail"){
					excelSave(result);
				}else{
					alert("DB에 등록된 데이터가 없거나 연결에 실패하였습니다.");
				}
				console.log(result);
			},
			error:function(request,status,error){
				console.log(request.responseText);
			}
		});
	}

	function excelSave(result){
		var excelPlus = new ExcelPlus();
		excelPlus.openRemote("./form/"+excelTable+".xlsx",function(passed){
			if(!passed){
				alert("엑셀파일 저장에 실패하였습니다.");
			}else{
				for(i=0; i<result.length; i++){
					var arrayData = $.map(result[i],function(value,index){
						return [value];
					});
					excelPlus.writeRow((i+2),arrayData);
				}
				// 파일명을 설정한 다음
				var nowDate = timeStamp("yyyy")+timeStamp("mm")+timeStamp("dd")+timeStamp("hh")+timeStamp("ii")+timeStamp("ss");
				excelPlus.saveAs(tableName+"("+nowDate+").xlsx");
			}
		});
	}
	
	$(document).on("click","#excel-upload",function(){		
		$(this).prev().trigger("click");
	});
	
	$(document).on("change","#excel-select",function(){
		var fileName = $(this).val().split("\\");
			fileName = fileName[fileName.length-1].split(".");
		var extension = fileName[fileName.length-1];
			
		if(extension=="xls"||extension=="xlsx"){
			Spinner("on");
			var form = $("#excel-form")[0];
			var formData = new FormData(form);
			formData.append("folder",excelTable);
			formData.append("extension",extension);
			if(formData!=null){
				$.ajax({
					type: "POST",
					url: "./excel/excel_upload.php",
					enctype: "multipart/form-data",
					processData: false,
					contentType: false,
					data: formData,
					dataType: "json",
					success: function(data){
						if(data["status"]=="success"){
							readExcelFile(data["folder"],data["file"]);
						}else{
							Spinner("off");
							alert("파일 업로드에 실패하였습니다.");
						}
					},
					error: function(request, status, error){
						Spinner("off");
						alert("서버와의 통신에 문제가 발생하였습니다.");
					}
				});
			}
		}else{
			alert("엑셀파일이 아닌 파일은 선택할 수 없습니다.");
		}
		
		// 파일선택여부와 관계없이 해당 input 파일을 초기화시킨다
		var agent = navigator.userAgent.toLowerCase();
		if((navigator.appName=="Netscape"&&navigator.userAgent.search('Trident')!=-1)||(agent.indexOf("msie")!=-1)){
			// ie 일때 input[type=file] init.
			$("#excel-select").replaceWith($("#excel-select").clone(true));
		} else {
			//other browser 일때 input[type=file] init.
			$("#excel-select").val("");
		}
	});
		
	function readExcelFile(folder,file){
		var excelPlus = new ExcelPlus();
		excelPlus.openRemote("./excel/"+folder+"/"+file,function(passed){
			if(!passed){
				Spinner("off");
				alert("엑셀파일이 손상되었거나 존재하지 않습니다.");
			}else{
				var dataList = [];
				var excelData = excelPlus.selectSheet(1).readAll();
				for(var i=1; i<excelData.length;i++) {
					if(excelData[i][0]!=null) dataList.push(excelData[i]);
				}
				if(dataList!=null && dataList!=""){
					dataList = JSON.stringify(dataList);
					$.ajax({
						type: "POST",
						url: "/process/excelWrite",
						data: "dataList="+dataList+"&table="+folder,
						//data: "dataList="+dataList+"&table=abcd",
						dataType: "json",
						success: function (data) {
							Spinner("off");
							if(data.status=="success"){
								if(data.length==data.count){
									alert("DB데이터가 정상적으로 적용되었습니다.");
								}else{
									alert("엑셀 데이터에 문제가 있어 일부만 적용되었습니다.");
								}
								location.replace('./'+excelTable);
							}else if(data.status=="fail"){
								alert("엑셀파일이 손상되었거나 존재하지 않습니다.");
							}
						},
						error: function(request, status, error) {
							Spinner("off");
							alert("서버와의 통신에 실패하였습니다.");
						}
					});
				}
			}
		});
	}
		
	function Spinner(SPStatus){
		SPStatus = SPStatus.toLowerCase();
		if(SPStatus=="on"){
			$("#spinner-mask").show();
			$("#spinner").center().show();
		}else{	
			$("#spinner-mask").hide();
			$("#spinner").hide();
		}
	}
});