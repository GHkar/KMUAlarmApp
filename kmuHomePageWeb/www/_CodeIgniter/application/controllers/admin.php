<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	header("Content-Type: text/html; charset=UTF-8");
	//-------------------------------------------------------------------------------------------//
	//
	//-------------------------------------------------------------------------------------------//
	class Admin extends CI_Controller{
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function asdf(){
			echo "asd";
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function login(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 페이지 이동
			if($auth=="1"){
				echo '
					<script>
						location.href = "./country_map";
					</script>
				';
			// 세션값이 없을 경우 해당페이지 출력
			}else{
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function common_header(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				$params["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:16;
				echo $params["id_project"]."<br>";
				
				// 템플릿 설정				
				$this->template->assign('params',$params);
				$this->template->define("tpl","./admin/common_header.html");				
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function country_map(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function naver_map(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				$this->template->assign('sc',$sc);
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function forecast_tree(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);
				
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_forecast";
				$forecast_tree = $this->table_select($sc);
				$this->template->assign('forecast_tree',$forecast_tree);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function damage_tree(){
			//echo "damage_tree";
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "damage_tree";
				$damage_tree = $this->table_select($sc);
				$this->template->assign('damage_tree',$damage_tree);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function probe_damage(){
			//echo "probe_damage</br>";
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);
		
				//----------------------------------------------------------------------------------
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_probe_damage";
				$probe_damage = $this->table_select($sc);
				$this->template->assign('probe_damage',$probe_damage);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function fumi_dummy_research(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["collection"] = isset($_GET["collection"])?$_GET["collection"]:"";
				$sc["direction"] = isset($_GET["direction"])?$_GET["direction"]:"";
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "fumi_dummy_research";
				$fumi_dummy_research = $this->table_select($sc);
				$this->template->assign('fumi_dummy_research',$fumi_dummy_research);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function control_tree(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["ctrl"] = isset($_GET["ctrl"])?$_GET["ctrl"]:"";
				$sc["ctrl_type"] = isset($_GET["ctrl_type"])?$_GET["ctrl_type"]:"";
				$sc["ctrl_height"] = isset($_GET["ctrl_height"])?$_GET["ctrl_height"]:"";
				$sc["ctrl_peeling"] = isset($_GET["ctrl_peeling"])?$_GET["ctrl_peeling"]:"";
				$sc["ctrl_fumi"] = isset($_GET["ctrl_fumi"])?$_GET["ctrl_fumi"]:"";
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "control_tree";
				$control_tree = $this->table_select($sc);
				$this->template->assign('control_tree',$control_tree);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function control_damage(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["ctrl"] = isset($_GET["ctrl"])?$_GET["ctrl"]:"";
				$sc["ctrl_type"] = isset($_GET["ctrl_type"])?$_GET["ctrl_type"]:"";
				$sc["ctrl_height"] = isset($_GET["ctrl_height"])?$_GET["ctrl_height"]:"";
				$sc["ctrl_peeling"] = isset($_GET["ctrl_peeling"])?$_GET["ctrl_peeling"]:"";
				$sc["ctrl_fumi"] = isset($_GET["ctrl_fumi"])?$_GET["ctrl_fumi"]:"";

				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_name"] = "";
				$sc["project_select"] = $this->project_select($sc);
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_control_damage";
				$control_damage = $this->table_select($sc);
				$this->template->assign('control_damage',$control_damage);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function fumi_dummy(){
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["standard"] = isset($_GET["standard"])?$_GET["standard"]:"";
				$sc["drug"] = isset($_GET["drug"])?$_GET["drug"]:"";
				$sc["amount"] = isset($_GET["amount"])?$_GET["amount"]:"";
				$sc["fumi_confirm"] = isset($_GET["fumi_confirm"])?$_GET["fumi_confirm"]:"";
				$sc["fumi_photo"] = isset($_GET["fumi_photo"])?$_GET["fumi_photo"]:"";
				$sc["cfm_drug"] = isset($_GET["cfm_drug"])?$_GET["cfm_drug"]:"";
				$sc["cfm_fumi"] = isset($_GET["cfm_fumi"])?$_GET["cfm_fumi"]:"";
				$sc["cfm_photo"] = isset($_GET["cfm_photo"])?$_GET["cfm_photo"]:"";
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "fumi_dummy";
				$fumi_dummy = $this->table_select($sc);
				$this->template->assign('fumi_dummy',$fumi_dummy);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}else{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function supervision_damage()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_supervision_damage";
				$supervision_damage = $this->table_select($sc);
				$this->template->assign('supervision_damage',$supervision_damage);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function probe_smoke()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_probe_smoke";
				$probe_smoke = $this->table_select($sc);
				$this->template->assign('probe_smoke',$probe_smoke);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function probe_prevent()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";

				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_probe_prevent";
				$probe_prevent = $this->table_select($sc);
				$this->template->assign('probe_prevent',$probe_prevent);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function control_smoke()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_control_smoke";
				$control_smoke = $this->table_select($sc);
				$this->template->assign('control_smoke',$control_smoke);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function control_prevent()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_control_prevent";
				$control_prevent = $this->table_select($sc);
				$this->template->assign('control_prevent',$control_prevent);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function supervision_smoke()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_supervision_smoke";
				$supervision_smoke = $this->table_select($sc);
				$this->template->assign('supervision_smoke',$supervision_smoke);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function supervision_prevent()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "view_supervision_prevent";
				$supervision_prevent = $this->table_select($sc);
				$this->template->assign('supervision_prevent',$supervision_prevent);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
			//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function design_damage()
		{
			//echo "probe_damage</br>";
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1"){
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";

				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);
				
				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_design_damage";
				$design_damage = $this->table_select($sc);
				$this->template->assign('design_damage',$design_damage);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function design_smoke()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_design_smoke";
				$design_smoke = $this->table_select($sc);
				$this->template->assign('design_smoke',$design_smoke);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function design_prevent()
		{
			// 세션값 확인
			$auth = $this->session->userdata("admin_auth");
			// 세션값이 있을 경우 해당페이지 출력
			if($auth=="1")
			{
				// 필터적용
				$sc["cvt_type"] = isset($_GET["cvt_type"])?$_GET["cvt_type"]:"";
				$sc["tree"] = isset($_GET["tree"])?$_GET["tree"]:"";
				$sc["damage"] = isset($_GET["damage"])?$_GET["damage"]:"";
				$sc["danger"] = isset($_GET["danger"])?$_GET["danger"]:"";
				
				$sc["id_project"] = isset($_GET["id_project"])?$_GET["id_project"]:1;
				$sc["project_select"] = $this->project_select($sc);

				// 페이징 블록설정
				$sc["page"]			 = isset($_GET["page"])?intval($_GET["page"]):1;
				$sc["perpage"]		 = isset($_GET["perpage"])?intval($_GET["perpage"]):10;
				$sc["perblock"]		 = isset($_GET["perblock"])?intval($_GET["perblock"]):10;
				
				// 테이블 값 조회
				$sc["table_name"] = "tbl_design_prevent";
				$design_prevent = $this->table_select($sc);
				$this->template->assign('design_prevent',$design_prevent);
				
				// 페이징 설정
				$sc["count"]		 = $this->table_count($sc);		
				$sc["total_page"]	 = ceil($sc["count"] / $sc["perpage"]);
				$sc["block"]		 = ceil($sc["page"] / $sc["perblock"]);
				$sc["total_block"]	 = ceil($sc["total_page"] / $sc["perblock"]);
				$sc["start_page"]	 = (($sc["block"] - 1) * $sc["perblock"]) + 1;
				$sc["end_page"]	 	 = $sc["start_page"] + $sc["perblock"] - 1;
				if($sc["end_page"] > $sc["total_page"]) $sc["end_page"] = $sc["total_page"];
				$sc["paging"] = $this->table_paging($sc);
				$this->template->assign('sc',$sc);
				
				// 템플릿 설정
				$this->template->define("tpl","./admin/".__FUNCTION__.".html");
				$this->template->print_("tpl");
			}
			else
			{
				echo '
					<script>
						alert("세션 유효시간이 만료되어 자동 로그아웃 됩니다.");
						location.href = "./login";
					</script>
				';
			}
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function table_select($sc)
		{
			//echo "table_select : ".$sc["table_name"]."</br>";
			// LIMIT을 위한설정
			// page가 1번이면 0번부터 시작,
			// 2번부터는 페이지 값에서 1을 빼준 후 보여지는 갯수만큼을 곱해줌.
			$sc["page"] = $sc["page"]==1?0:($sc["page"]-1)*$sc["perpage"];
			
			// 쿼리 틀 작성
			// Select
			$querySelect = 'SELECT * ';
			// From
			$queryFrom = 'FROM '.$sc["table_name"].' as a ';
			// Where
			$queryWhere = 'WHERE id_project = '.$sc["id_project"]." ";
			// Order by
			$queryOrderBy = 'ORDER BY ';
			// Limit
			$queryLimit = 'LIMIT '.$sc["page"].','.$sc["perpage"];
			
			// 조건문을 걸기위한 switch
			switch($sc["table_name"])
			{
				case "tbl_forecast":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "damage_tree":
					if($sc["tree"]!="") $queryWhere .= 'AND tree = "'.$sc["tree"].'" ';
					if($sc["damage"]!="") $queryWhere .= 'AND damage = "'.$sc["damage"].'" ';
					if($sc["danger"]!="") $queryWhere .= 'AND danger = "'.$sc["danger"].'" ';
					$queryOrderBy .= 'a.seq DESC ';
					break;
				case "control_tree":
					if($sc["ctrl"]!="") $queryWhere .= 'AND ctrl = "'.$sc["ctrl"].'" ';
					if($sc["ctrl_type"]!="") $queryWhere .= 'AND ctrl_type = "'.$sc["ctrl_type"].'" ';
					if($sc["ctrl_height"]!="") $queryWhere .= 'AND ctrl_height = "'.$sc["ctrl_height"].'" ';
					if($sc["ctrl_peeling"]!="") $queryWhere .= 'AND ctrl_peeling = "'.$sc["ctrl_peeling"].'" ';
					if($sc["ctrl_fumi"]!="") $queryWhere .= 'AND ctrl_fumi = "'.$sc["ctrl_fumi"].'" ';
					$queryOrderBy .= 'a.seq DESC ';
					break;
				case "fumi_dummy_research":
					if($sc["collection"]!="") $queryWhere .= 'AND collection = "'.$sc["collection"].'" ';
					if($sc["direction"]!="") $queryWhere .= 'AND direction = "'.$sc["direction"].'" ';
					$queryOrderBy .= 'a.seq DESC ';
					break;
				case "fumi_dummy":
					if($sc["standard"]!="") $queryWhere .= 'AND standard = "'.$sc["standard"].'" ';
					if($sc["drug"]!="") $queryWhere .= 'AND drug = "'.$sc["drug"].'" ';
					if($sc["amount"]!="") $queryWhere .= 'AND amount = "'.$sc["amount"].'" ';
					if($sc["fumi_confirm"]!="") $queryWhere .= 'AND fumi_confirm = "'.$sc["fumi_confirm"].'" ';
					if($sc["fumi_photo"]!="") $queryWhere .= 'AND fumi_photo = "'.$sc["fumi_photo"].'" ';
					if($sc["cfm_drug"]!="") $queryWhere .= 'AND cfm_drug = "'.$sc["cfm_drug"].'" ';
					if($sc["cfm_fumi"]!="") $queryWhere .= 'AND cfm_fumi = "'.$sc["cfm_fumi"].'" ';
					if($sc["cfm_photo"]!="") $queryWhere .= 'AND cfm_photo = "'.$sc["cfm_photo"].'" ';
					$queryOrderBy .= 'a.seq DESC ';
					break;
				case "tbl_probe_damage":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "view_control_damage":
					//$queryOrderBy .= 'a.work_datetime DESC, ';
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "view_control_smoke":
					$queryOrderBy .= 'a.id_serial DESC ';
					break;
				case "view_control_prevent":
					$queryOrderBy .= 'a.id_serial DESC ';
					break;
				case "view_supervision_damage":
					//$queryWhere .= " AND work_datetime_supervision IS NOT NULL ";
					//$queryOrderBy .= 'a.work_datetime_supervision DESC, ';
					$queryOrderBy .= 'a.work_datetime_supervision DESC ';
					break;
				case "view_supervision_smoke":
					$queryOrderBy .= 'a.id_serial DESC ';
					break;
				case "view_supervision_prevent":
					$queryOrderBy .= 'a.id_serial DESC ';
					break;
				case "tbl_probe_smoke":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "tbl_probe_prevent":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "tbl_control_smoke":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "tbl_control_prevent":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "tbl_design_damage":
					$queryOrderBy .= 'a.id_serial ASC ';
					break;
				case "tbl_design_smoke":
					$queryOrderBy .= 'a.work_datetime DESC ';
					break;
				case "tbl_design_prevent":
					$queryOrderBy .= 'a.id_serial DESC ';
					break;
			}
			// 공통
			if($sc["cvt_type"]!="") $queryWhere .= 'AND cvt_type = "'.$sc["cvt_type"].'" ';
			
			echo $querySelect.$queryFrom.$queryWhere.$queryOrderBy.$queryLimit."</br>";
			// 쿼리 결과를 저장
			$result = $this->db->query($querySelect.$queryFrom.$queryWhere.$queryOrderBy.$queryLimit);
			
			// 쿼리결과가 있으면 반복문을 통해 데이터 저장후 Return
			if($result->num_rows >= 1)
			{
				foreach ($result->result_array() as $row)
				{
					$loop[] = $row;
				}
				//echo "TRUE</br>";
				return $loop;
			}
			//echo "FALSE</br>";
			return false;
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function table_count($sc)
		{
			// 쿼리 작성
			// Select
			$querySelect = 'SELECT count(*) as cnt ';
			// From
			$queryFrom = 'FROM '.$sc["table_name"].' as a ';
			// Where
			$queryWhere = 'WHERE id_project = '.$sc["id_project"]." ";
			
			// 조건문을 걸기위한 switch
			switch($sc["table_name"])
			{
				case "damage_tree":
					if($sc["cvt_type"]!="") $queryWhere .= 'AND cvt_type = "'.$sc["cvt_type"].'" ';
					if($sc["tree"]!="") $queryWhere .= 'AND tree = "'.$sc["tree"].'" ';
					if($sc["damage"]!="") $queryWhere .= 'AND damage = "'.$sc["damage"].'" ';
					if($sc["danger"]!="") $queryWhere .= 'AND danger = "'.$sc["danger"].'" ';
				break;
				case "fumi_dummy_research":
					if($sc["collection"]!="") $queryWhere .= 'AND collection = "'.$sc["collection"].'" ';
					if($sc["direction"]!="") $queryWhere .= 'AND direction = "'.$sc["direction"].'" ';
				break;
				case "control_tree":
					if($sc["ctrl"]!="") $queryWhere .= 'AND ctrl = "'.$sc["ctrl"].'" ';
					if($sc["ctrl_type"]!="") $queryWhere .= 'AND ctrl_type = "'.$sc["ctrl_type"].'" ';
					if($sc["ctrl_height"]!="") $queryWhere .= 'AND ctrl_height = "'.$sc["ctrl_height"].'" ';
					if($sc["ctrl_peeling"]!="") $queryWhere .= 'AND ctrl_peeling = "'.$sc["ctrl_peeling"].'" ';
					if($sc["ctrl_fumi"]!="") $queryWhere .= 'AND ctrl_fumi = "'.$sc["ctrl_fumi"].'" ';
				break;
				case "fumi_dummy":
					if($sc["standard"]!="") $queryWhere .= 'AND standard = "'.$sc["standard"].'" ';
					if($sc["drug"]!="") $queryWhere .= 'AND drug = "'.$sc["drug"].'" ';
					if($sc["amount"]!="") $queryWhere .= 'AND amount = "'.$sc["amount"].'" ';
					if($sc["fumi_confirm"]!="") $queryWhere .= 'AND fumi_confirm = "'.$sc["fumi_confirm"].'" ';
					if($sc["fumi_photo"]!="") $queryWhere .= 'AND fumi_photo = "'.$sc["fumi_photo"].'" ';
					if($sc["cfm_drug"]!="") $queryWhere .= 'AND cfm_drug = "'.$sc["cfm_drug"].'" ';
					if($sc["cfm_fumi"]!="") $queryWhere .= 'AND cfm_fumi = "'.$sc["cfm_fumi"].'" ';
					if($sc["cfm_photo"]!="") $queryWhere .= 'AND cfm_photo = "'.$sc["cfm_photo"].'" ';
				break;
			}
			
			// Result에 쿼리결과 저장
			$result = $this->db->query($querySelect.$queryFrom.$queryWhere);
			// 쿼리결과가 있으면 변수에 저장후 Return
			if($result->num_rows >= 1)
			{
				$row = $result->result_array();
				$loop = $row[0]["cnt"];		
				return $loop;
			}
			return false;
		}	
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function table_paging($sc)
		{
			// 테이블 틀
			$html_tag = '<table id="paging-table" class="paging table"><tr>';
			
			// 처음버튼
			if($sc["count"] >= 1)
			{
				$html_tag .= '<td class="paging-button pointer" data-value="page=1">처음</td>';
			}
			
			// 이전버튼
			if($sc["block"] > 2)
			{
				$html_tag .= '<td class="paging-button pointer" data-value="page='.($sc["start_page"]-1).'">이전</td>';
			}

			// 페이지 번호
			for($i = $sc["start_page"]; $i <= $sc["end_page"]; $i++)
			{
				$html_tag .= '<td class="paging-number paging-button pointer" ';
				$html_tag .= 'data-value="page='.$i.'" data-index="'.$i.'">'.$i.'</td>';
			}

			// 다음버튼
			if($sc["block"] < $sc["total_block"])
			{
				$html_tag .= '<td class="paging-button pointer" data-value="page='.($sc["end_page"]+1).'">다음</td>';
			}
		
			// 마지막
			if($sc["count"] >= 1)
			{
				$html_tag .= '<td class="paging-button pointer" data-value="page='.($sc["total_page"]).'">끝</td>';
			}
			$html_tag .= '</table>';
			return $html_tag;
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
		public function project_select($sc)
		{
			$str =  "프로젝트 선택 ".$sc["id_project"]." ";

			$query  = "SELECT id, name, organ, create_date ";
			$query .= "FROM tbl_project ";
			$query .= ";";
			$str .= $query;

			$result = $this->db->query($query);

			$html = "&nbsp;&nbsp;&nbsp<b>프로젝트 선택 : </b>";
			if($result->num_rows >= 1)
			{	
				$html .= "<select class='where-select' data-type='id_project'>";

				foreach ($result->result_array() as $row)
				{
					if( $row["id"] === $sc["id_project"] )
					{
						$html .= "<option value=".$row["id"]." selected>".$row["name"]."</option>";
						$sc["project_name"] = $row["name"];
					}
					else
						$html .= "<option value=".$row["id"]." >".$row["name"]."</option>";
				}	
				
				$html .= "</select>";
			}


			return $html;
		}
		//---------------------------------------------------------------------------------------//
		//
		//---------------------------------------------------------------------------------------//
	}
//-----------------------------------------------------------------------------------------------//
//
//-----------------------------------------------------------------------------------------------//
?>
