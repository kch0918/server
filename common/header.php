<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <?php
/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */



 	if($_GET['ref'] === 't')
	{
		echo "<style>#header, .menu-right, .menu-left, .fix-mail, #top .post-nav, #footer{display:none !important}</style>";
		echo '<script>console.log("'.$beforeTxt2.'")</script>';
	}
	else
	{

	}

//	$refer = $_SERVER['HTTP_REFERER'];
//	$beforeTxt = "musign2021.mugazine.co.kr";
//	$beforeTxt2 = "musign.net";
//	echo '<script>console.log("'.$refer.'")</script>';
//	if(strpos($refer,$beforeTxt) !== false){
//		echo "<style>#header, .menu-right, .menu-left, .fix-mail, #top .post-nav, #footer{display:none !important}</style>";
//		echo '<script>console.log("'.$beforeTxt.'")</script>';
//	}
//	else if(strpos($refer,$beforeTxt2) !== false){
//		echo "<style>#header, .menu-right, .menu-left, .fix-mail, #top .post-nav, #footer{display:none !important}</style>";
//		echo '<script>console.log("'.$beforeTxt2.'")</script>';
//	}
?>
	<!-- Scripts/CSS and wp_head hook -->
	<title>디지털 아티스트 컴퍼니 - 뮤자인</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- This site is optimized with the Yoast SEO plugin v3.5 - https://yoast.com/wordpress/plugins/seo/ -->
	<meta name="description" content="브랜드, 비주얼 전문가들에 의한 디지털 플랫폼, 이커머스, 온라인 인프라 구축"/>
	<meta name="robots" content="noodp"/>
	<link rel="canonical" href="" />
	<meta property="og:locale" content="ko_KR" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="디지털 아티스트 컴퍼니 - 뮤자인" />
	<meta property="og:description" content="브랜드, 비주얼 전문가들에 의한 디지털 플랫폼, 이커머스, 온라인 인프라 구축" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="MUSIGN" />
	<meta property="og:image" content="./img/logo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="브랜드, 비주얼 전문가들에 의한 디지털 플랫폼, 이커머스, 온라인 인프라 구축" />
	<meta name="twitter:title" content="디지털 아티스트 컴퍼니 - 뮤자인" />
	<meta name="twitter:image" content="http://musign.net/wp-content/uploads/2019/01/logo.png" />
	
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="/js/musign.js"></script>
	<script src="/js/animation.js"></script>
	<script src="/include/js/function.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- <script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script> -->
	 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
	
 </head>
 <body>
	<div id="header">
		<div class="header-wr">
			<div class="table">
				<div class="he-logo">
					<a href="/"><img src="/img/logo.png" alt="뮤자인로고"/></a>
				</div>

				<div class="he-nav pc-nav">
					<ul class="he-gnb">
                        <?php 
                        if($_SESSION['manager_yn'] === "Y")
                        {
                            ?>
                            <li><a href="/manual/index.php" target="_blank" style="color:#e47676;">개발팀</a></li>
                            <li><a href="/admin/price_management.php" style="color:#e47676;">서버 가격</a></li>
                            <li><a href="/member/family_list.php" style="color:#e47676;">회원 목록</a></li>
                            <li><a href="/admin/notice.php" style="color:#e47676;">공지사항</a></li>
                            <li><a href="/admin/bills_list.php" style="color:#e47676;">현금영수증 내역</a></li>
                            <li><a href="/admin/taxbills_list.php" style="color:#e47676;">세금계산서 내역</a></li>
                            <li><a href="/admin/server_checklist.php" style="color:#e47676;">서버체크리스트</a></li>
                            <li><a href="/admin/cancle.php" style="color:#e47676;">결제 내역</a></li>
                            <li><a href="/member/dashboard.php" style="color:#e47676;">대쉬 보드</a></li>
                            <?php 
                        }
                        ?>
						<li><a href="/">서비스</a></li>
						<?php 
                        if($_SESSION['login_id'] != "" && isset($_SESSION['login_id']))
                        {
                            ?>
    						<li><a href="/mypage">마이페이지</a></li>
    						<li><a href="/member/logout.php">로그아웃</a></li>
                            <?php 
                        }
                        else
                        {
                            ?>
                            <li><a href="/member/login.php">로그인</a></li>
							<li><a href="/member/join_agreement.php">회원가입</a></li>
                            <?php 
                        }
                        ?>
					</ul>
				</div>
				<!-- PC he-nav -->

				<div class="he-nav mo-nav">
					<div class="buger nav-big-menu">
						<div>
							<span class="nav-big-menu-btn">
								line;
							</span>

							<div class="side-nav">
								<div class="inner">
									<ul class="he-gnb">
										<?php 
										if($_SESSION['manager_yn'] === "Y")
										{
											?>
											<li><a href="/manual/index.php" target="_blank" style="color:#e47676;">DEV</a></li>
											<li><a href="/admin/price_management.php" style="color:#e47676;">Price Management</a></li>
											<li><a href="/member/family_list.php" style="color:#e47676;">User List</a></li>
											<li><a href="/admin/notice.php" style="color:#e47676;">Notice</a></li>
											<?php 
										}
										?>
										<li><a href="/">Service</a></li>
										<?php 
										if($_SESSION['login_id'] != "" && isset($_SESSION['login_id']))
										{
											?>
											<li><a href="/mypage">Mypage</a></li>
											<li><a href="/member/logout.php">Logout</a></li>
											<?php 
										}
										else
										{
											?>
											<li><a href="/member/login.php">Login</a></li>
											<li><a href="/member/join_agreement.php">Join</a></li>
											<?php 
										}
										?>
									</ul>		
								</div>
							</div>


						</div>
					</div> 
					<!-- burger -->
				</div>
				<!-- mo he-nav -->
			</div>
		</div>
	</div>



	<div id="header_left">
		<ul class="left_table">
			<li class="on">
				<span class="dotwra">
					<span class="dot"></span>
				</span>
				<a href="#Introduce">Introduce</a>
			</li>
			<li>
				<span class="dotwra">
					<span class="dot"></span>
				</span>				
				<a href="#Features">Features</a>
			</li>
			<li>
				<span class="dotwra">
					<span class="dot"></span>
				</span>
				<a href="#Service_Packages">Service Packages</a>
			</li>
			<li>
				<span class="dotwra">
					<span class="dot"></span>
				</span>			
				<a href="#Partners">Partners</a>
			</li>
		</ul>
	</div>
	<div id="wrap">
