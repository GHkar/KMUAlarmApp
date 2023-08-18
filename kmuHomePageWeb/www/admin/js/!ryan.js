// 문자열 바꾸기 a:내용, b:찾을값, c:변환값
function replaceAll(a,b,c){a=a.replace(new RegExp(b,'gi'),c); return a;}

// a 파라메터의 첫번째 글자를 대문자로 치환
function string2Upper(a){return a.charAt(0).toUpperCase()+a.slice(1);}

// 한국식 전화번호 양식 세팅 (일반전화 및 핸드폰번호 전부 됨)
function string2Tel(a){a=a.replace(/[^0-9]/g,''); a=a.replace(/(^02.{0}|^01.{1}|0[1-9]{2})([0-9]{3,4})([0-9]{4})/,'$1-$2-$3'); return a;}

// 시간양식 맞춰주는 함수 (0000 ~ 2359 까지의 문자열을 자동으로 00:00 ~ 23:59으로 변경)
function string2Time(a){a=a.replace(/[^0-9]/g,''); a=a.replace(/([01][0-9]|2[0-3])([0-5][0-9])/,'$1:$2'); if(a.length==4){return '';}else{return a;}}

// a 파라메터의 값을 b의 숫자만큼 자릿수에 맞춰 앞쪽에 0을 추가 (예: a=6, b=2 -> 결과: 06), 특정양식 (한자릿수의 앞쪽에 0을 추가하는 경우 등)
function addZero(a,b){var c=''; a=a.toString(); if(a.length<b) for(i=0; i<b-a.length; i++) c+='0'; return c+a;}

// a 파라메터의 숫자값에 콤마찍어줌
function addComma(a){return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");}

// 현재시간을 출력해주는 함수 - ymdhis (년월일시분초, 대소문자 구분X)
function timeStamp(a){var b=''; var c=new Date(); switch(a.toLowerCase()){case 'yy': b=String(c.getFullYear()).substr(2); break; case 'yyyy': b=String(c.getFullYear()); break; case 'm': b=String(c.getMonth()+1); break; case 'mm': b=String(addZero(c.getMonth()+1,2)); break; case 'd': b=String(c.getDate()); break; case 'dd': b=String(addZero(c.getDate(),2)); break; case 'h': b=String(c.getHours()); break; case 'hh': b=String(addZero(c.getHours(),2)); break; case 'i': b=String(c.getMinutes()); break; case 'ii': b=String(addZero(c.getMinutes(),2)); break; case 's': b=String(c.getSeconds()); break; case 'ss': b=String(addZero(c.getSeconds(),2)); break;} return b;}

// 파라메터 저장함수
function getParams(a){
	e = a.split("?");
	if(e[1]==null||e[1]==""){
		return "no data";
	}else{
		e = e[1];
		e = e.split("&");
		var b = new Array(), c = new Array();
		for(i=0; i<e.length; i++){
			var f = e[i];
			f = f.split("=");
			if(f[0]!=null&&f[1]!=null){
				b.push(f[0]);
				c.push(f[1]);
			}
		}
		var d = new Array();
		d.push(b);
		d.push(c);
		return d;
	}
}
function setParams(a,b,c){
	if(a[0]==null||a[1]==null||a[0][0]==null||a[1][0]==null){
		return "not parameter";
	}else if(b==null||c==null){
		return "undefined data";
	}else{
		var a1_len = a[0].length;
		var a2_len = a[1].length;
		if(a1_len!=a2_len){
			return "different length";
		}else{
			for(i=0; i<a1_len; i++){
				if(a[0][i]==b){
					a[1][i] = c;
				}
			}
			return a;
		}
	}
}

// 입력값 유효성 검사 - a: 내용, b: 타입 || return - 1: 통과, 0: 실패, -1: 정규식없음
function regExr(a,b){
	var c;
	switch(b.toLowerCase()){
		case 'email':
			c = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.(com|net)$/i;
			return (c==null)?-1:(!c.test(a))?0:1;
			break;
		case 'tel':
			c = /(^02.{0}|^01.{1}|0[1-9]{2})([0-9]{3,4})([0-9]{4})/;
			return (c==null)?-1:(!c.test(a))?0:1;
			break;
		case 'phone':
			c = /01([0|1|6|7|8|9]{1})([0-9]{3,4})([0-9]{4})$/;
			return (c==null)?-1:(!c.test(a))?0:1;
			break;
		case 'password':
			c = /^(?=.*[a-zA-Z])(?=.*[0-9]).{1,100}$/;
			return (c==null)?-1:(!c.test(a))?0:1;
			break;
		case 'password2':
			c = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{1,100}$/;
			return (c==null)?-1:(!c.test(a))?0:1;
			break;
		case 'blank':
			c = /[\s]/g;
			return (c==null)?-1:(!c.test(a))?1:0;
			break;
	}
}

// 쿠키값 설정 - a: 쿠키명, b: 쿠키값, c: 기간(일)
function setCookie(a,b,c){var d = new Date(); d.setDate(d.getDate() + c); var e = escape(b) + ((c==null) ? "" : "; expires=" + d.toGMTString()); document.cookie = a + "=" + e;}
 
// 쿠키삭제 - a: 쿠키명
function deleteCookie(a){var b = new Date(); b.setDate(b.getDate() - 1); document.cookie = a + "= " + "; expires=" + b.toGMTString(); }
 
// 쿠키불러오기 - a: 쿠키명
function getCookie(a){a = a + '='; var b = document.cookie; var c = b.indexOf(a);var d = ''; if(c != -1){c += a.length; var e = b.indexOf(';', c); if(e == -1) e = b.length; d = b.substring(c, e);}return unescape(d);}

// Element 크기를 화면크기 비례 원하는 %로 설정 및 postion 설정
function setSize(a,b,c,d){var e = $(window).width()*b+"px"; var f = $(window).height()*c+"px"; $(a).css({"position":d,"width":e,"height":f});}

// Element 숨기기
$.fn.hidden=function(){this.css("visibility","hidden");}

// Element 영역보이기
$.fn.visible=function(){this.css("visibility","visible");}

// 화면 정중앙 위치조절(jQuery), $(object).center(a); 
$.fn.center=function(a){this.css("position","absolute"); var b=$(window).scrollTop(); if(a==1){$(window).scrollTop(9999); var c=$(window).scrollTop(); $(window).scrollTop(b); this.css("top",Math.max(0,(($(window).height() - $(this).outerHeight()) / 2) + b - (c/2)) + "px");}else{this.css("top",Math.max(0,(($(window).height() - $(this).outerHeight()) / 2) + b) + "px");}	this.css("left",Math.max(0,(($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px"); return this;}

// 테이블 행 병합 (jQuery), $(테이블).rowspan(행번호); 
$.fn.rowspan=function(a,b){return this.each(function(){var c; $('tr',this).each(function(row){$('td:eq('+a+')',this).filter(':visible').each(function(col){if($(this).html()==$(c).html() && (!b||b && $(this).prev().html()==$(c).prev().html())){rowspan=$(c).attr("rowspan")||1; rowspan=Number(rowspan)+1; $(c).attr("rowspan",rowspan); $(this).remove();}else{c=this;}c=(c==null)?this:c;});});});}; 

// 테이블 열 병합 (jQuery), $(테이블).rowspan(열번호); 
$.fn.colspan=function(a){return this.each(function(){var c; $('tr',this).filter(":eq("+a+")").each(function(row){$(this).find('th').filter(':visible').each(function(col){if($(this).html()==$(c).html()){colspan=$(c).attr("colSpan")||1; colspan=Number(colspan)+1; $(c).attr("colSpan",colspan); $(this).remove();}else{c=this;}c=(c==null)?this:c;});});});}