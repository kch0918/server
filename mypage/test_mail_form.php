<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
$user_query = "select * from user where user_id = '{$_SESSION['login_id']}'";
$user_result = sql_query($user_query);
$user_row = sql_fetch($user_result);


$server_info_query="select * from server_info where server_type = '{$user_row['server_name']}'";
$server_info_result =sql_query($server_info_query);
$server_info_row = sql_fetch($server_info_result);



/*
 *******************************************************
 * <결제요청 파라미터>
 * 결제시 Form 에 보내는 결제요청 파라미터입니다.
 * 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며,
 * 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
 *******************************************************
 */
$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
$MID         = "{$user_row['user_id']}"; // 상점아이디
$goodsName   = "{$user_row['server_name']}"; // 결제상품명
$price       = "{$server_info_row['server_price']}"; // 결제상품금액
$buyerName   = "{$user_row['user_name']}"; // 구매자명
$buyerTel	 = "{$user_row['user_phone']}"; // 구매자연락처
$buyerEmail  = "{$user_row['user_email']}"; // 구매자메일주소
$moid        = "{$server_info_row['idx']}"; // 상품주문번호
$returnURL	 = $_SERVER['DOCUMENT_ROOT']."/api_test_code/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

/*
 *******************************************************
 * <해쉬암호화> (수정하지 마세요)
 * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 *******************************************************
 */
$ediDate = date("YmdHis");
$hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));



?>

<div style="margin-top:100px; display:table; width:100%; height:50px;"></div>

<div id="edm" style="width:100%;max-width:700px;margin:0 auto;background:White;">
	<div class="edm-top" style="padding:50px;">
		<div class="inner" style="position:relative;">
			<div class="edm-logo" style="float:right;margin-bottom:40px;">
				<img src="/img/edm_logo.png">
			</div>
			<div class="tbox tbox-1" style="display:table;width:100%;">
				<span class="en-text" style="display:block;font-style: italic;font-size:18px;font-weight:400;color:#333333;">
					Digital Experience platform - musign
				</span>
				<strong style="display:block;font-size:38px;font-weight:bold;color:#333333;margin:3px 0 25px;letter-spacing:-2px;">
					서비스 기간 만료 및 서비스 신청 안내
				</strong>
				<p class="text" style="display:block;font-size:16px;color:#7a7a7a;">
					뮤자인의 서버관리기간 만료안내입니다.<br>
					안녕하세요. 디지털아티스트 컴퍼니 뮤자인입니다.<br>
					뮤자인에서 제공하는 고객님의 서버관리 서비스 기간이 만료되었습니다.
				</p>
			</div>
			<div class="tbox tbox-2" style="display:table;width:100%;">
				<p class="edm-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">이용기간</span>
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit;">2019.00.00~2020.00.00(1년무상)</span>
				</p>
				<p class="edm-excess-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">초과 무상 이용기간</span>
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit;">00일 (2020.11.19 기준)</span>
				</p>
				<p class="edm-expiration-date color-text" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;font-weight:bold;color:#6bc0cb !important;letter-spacing:-1px;margin-right:10px;">서버 만료일</span>
					<span style="position:relative;top:1px;display:inline-block;vertical-align:middle;font-size:16px;font-weight:bold;color:#6bc0cb !important;">2020.00.00</span>
				</p>
				<p class="edm-important color-text" style="display:block;font-size:0;font-size:16px;font-weight:500;color:#6bc0cb;letter-spacing:-1px;">
					※ 서버 만료일 이전까지 연장계약되지 않을 경우, 서버 이용이 제한됩니다. 
				</p>
			</div>
		</div>
	</div>
	<div class="edm-link-wrap">
		<div class="link-box link-box-1" style="display:table;width:100%;height:200px;background:#f5f5f5;text-align:center;margin-bottom:5px;">
			<div style="display:table-cell;vertical-align:middle;">
				<p style="font-size:18px;color:#000000;">
					서버관리 서비스를 이용 또는 해지하길 원하신다면,<br>
					<b>아래 링크를 통해 서버 서비스 연장 또는 해지 신청</b>을 해주시기 바랍니다.			
				</p>
				<a href="" style="display:block;width:260px;height:50px;line-height:50px;text-align:center;margin:20px auto 0;font-size:15px;color:#ffffff; background:#333333;">
					연장 / 해지 신청하기
				</a>
			</div>
		</div>
		<div class="link-box link-box-2" style="display:table;width:100%;height:200px;background:#f5f5f5;text-align:center;">
			<div style="display:table-cell;vertical-align:middle;">
				<p style="font-size:18px;color:#000000;">
					<b>뮤자인의 서버관리시스템을 확인하세요!</b>
				</p>
				<a href="" style="display:block;width:260px;height:50px;line-height:50px;text-align:center;margin:20px auto 0;font-size:15px;color:#ffffff; background:#00a6b6;">
					musigncare 서비스 소개
				</a>
			</div>
		</div>
	</div>
	<div class="edm-bottom" style="text-align:center;padding:45px 50px;">
		<div class="inner">
			<div class="tbox">
				<p class="text" style="display:block;font-size:16px;color:#7a7a7a;">언제나 최고의 서비스를 제공하기 위해  최선을 다하는 뮤자인이 되겠습니다. </p>
				<p class="en-text en-txt03" style="display:block;font-size:60px;font-weight:bold;color:#f0f0f0;margin:10px 0;">musigned by musign</p>
				<div class="questions-box" style="padding:30px 0 0 0;margin:30px 0 0 0;border-top:1px solid #e6e6e6;">
					<p style="display:block;font-size:16px;color:#7a7a7a;">추가 문의 사항은 아래 대표전화로 문의해 주시기 바랍니다.</p>
					<strong style="display:block;margin:5px 0 ;font-size:16px;font-weight:bold;color:rgba(0,0,0,.8);">
						<img src="/img/edm-call.png" style="position:relative;top:1px;margin-right:5px;">
						070 - 7763 - 6740
					</strong>
					<p style="display:block;font-size:16px;color:#7a7a7a;">감사합니다.</p>
				</div>
			</div>
		</div>
	</div>
</div>



<div id="edm" style="width:100%;max-width:700px;margin:0 auto;background:White;">
	<div class="edm-top">
		<div class="inner">
			<img src="http://server.musign.co.kr/img/edm_i1.jpg">
			<div class="tbox tbox-2" style="display:table;width:100%;padding:0 7% 50px;">
				<p class="edm-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:14px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">이용기간</span>
					<span style="display:inline-block;vertical-align:middle;font-size:14px;color:inherit;">2019.00.00~2020.00.00(1년무상)</span>
				</p>
				<p class="edm-excess-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:14px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">초과 무상 이용기간</span>
					<span style="display:inline-block;vertical-align:middle;font-size:14px;color:inherit;">00일 (2020.11.19 기준)</span>
				</p>
				<p class="edm-expiration-date color-text" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:14px;font-weight:bold;color:#6bc0cb !important;letter-spacing:-1px;margin-right:10px;">서버 만료일</span>
					<span style="position:relative;top:1px;display:inline-block;vertical-align:middle;font-size:14px;font-weight:bold;color:#6bc0cb !important;">2020.00.00</span>
				</p>
				<p class="edm-important color-text" style="display:block;font-size:0;font-size:14px;font-weight:500;color:#6bc0cb;letter-spacing:-1px;">
					※ 서버 만료일 이전까지 연장계약되지 않을 경우, 서버 이용이 제한됩니다. 
				</p>
			</div>
		</div>
	</div>
	<div class="edm-link-wrap">
		<a href="" style="display:block; margin-bottom:5px;">
			<img src="http://server.musign.co.kr/img/edm_i2.jpg">		
		</a>
		<a href="" style="display:block;">
			<img src="http://server.musign.co.kr/img/edm_i3.jpg">		
		</a>
	</div>
	<img src="http://server.musign.co.kr/img/edm_i4.jpg">
</div>



<?php require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php"); ?>