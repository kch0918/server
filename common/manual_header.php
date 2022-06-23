<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
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
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/include/ckeditor/ckeditor.js"></script>
	<script src="/js/musign.js"></script>
	<script src="/js/animation.js"></script>
	<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/all.css">
 </head>
 <body>
	<div id="header">
		<div class="header-wr">
			<div class="table">
				<div class="he-logo">
					<a href="/"><img src="/img/logo.png" alt="뮤자인로고"/></a>
				</div>
				<div class="he-nav">
					<ul class="he-gnb">
                        <?php 
                        if($_SESSION['manager_yn'] === "Y")
                        {
                            if($_SESSION['login_name'] === "변지윤" || $_SESSION['login_name'] === "정기영")
                            {
                                ?>
                                <li><a href="/manual/manager.php">담당자관리</a></li>
                                <?php 
                            }
                            ?>
                            <li><a href="/manual/board.php?board=server">서버관리</a></li>
                            <li><a href="/manual/board.php?board=godo">고도몰</a></li>
                            <li><a href="/manual/board.php?board=qa">QA</a></li>
                            <li><a href="/manual/board.php?board=setting">초기셋팅</a></li>
                            <li><a href="/manual/board.php?board=error">오류</a></li>
                            <li><a href="/manual/code.php">코드</a></li>
                            <li><a href="/manual/account.php">계정/유지보수 리스트</a></li>
                            <?php 
                        }
                        if($_SESSION['login_id'] != "" && isset($_SESSION['login_id']))
                        {
                            ?>
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
	<div id="wrap">