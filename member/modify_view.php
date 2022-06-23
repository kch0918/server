<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/include/init.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/include/login_check.php");

$query = "select * from user where idx = '{$_REQUEST['idx']}'";
$result = sql_query($query);
$row = sql_fetch($result);

$manager_query = "select * from user where user_id = '{$_SESSION['login_id']}'";
$manager_result = sql_query($manager_query);
$manager_row = sql_fetch($manager_result);

$sv_query = "select idx,server_type from server_info";
$sv_result = sql_query($sv_query);

?>
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script>
	var manager = "<?php echo $manager_row['manager_yn']?>";
	var dp = jQuery.noConflict();

    	var all_chk = "off";

    	// 관리자 권한 있다면, 활성화 
    	if(manager != "Y"){
        	$(document).ready(function(){
        		a_disabled();
        	});
    	}

    	
    	$(function(){
    		//전체동의시
    		$("#allAgree").click(function(){
    	 		if(all_chk == "off"){
    				$("input[type=checkbox]").each(function(){
    					$(this).prop("checked", true);
    				});
    				a_enabled();
    				all_chk = "on";
    			}else{
    				$("input[type=checkbox]").each(function(){
    					$(this).prop("checked", false);
    				})
    				a_disabled();
    				all_chk = "off";
    			}
    		});
    		
        	//개별동의시
        	$("input[id*=termsAgree]").click(function(){
        			if($(this).attr("checked") == "checked"){
        				$(this).attr("checked", false);
        			}else{
        				$(this).attr("checked", true);
        			}
        			if($("#termsAgree1").attr("checked") == "checked" && $("#termsAgree2").attr("checked") == "checked"){
        				a_enabled();
        			}else{
        				a_disabled();
        			}
        		});;
        		$(".agree-post").each(function(){
        			var $this = $(this);
        			var cont = $(this).find(".term-wr").html();
        			$this.find(".btn-line").click(function(){
        				$(".agree-div").prepend(cont);
        				$(".agree-popup").show();
        			})
        		})
        		$(".close-btn, .agree-bg").click(function(){
        			$(".agree-popup").hide();
        			$(".agree-div").html("");
        		})
        	})
            	function a_disabled(){		//비활성화
            		$(".login-btn").bind("click", false);
            		$(".login-btn").css("background-color", "gray");		//색변경 부탁드립니다
            		$(".join_btn").css("border", "1px solid gray");			//색변경 부탁드립니다
            	}
    	
            	function a_enabled(){		//활성화
            		$(".login-btn").unbind("click", false);
            		$(".login-btn").css("background-color", "#00a6b6");
            		$(".login-btn").css("border", "1px solid #00a6b6");
            	}


</script>
<link rel="stylesheet"
	href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css"
	type="text/css" />
<script>
var chk_per_yn = "<?php echo $row['per_yn']?>",
	chk_pay_yn = "<?php echo $row['pay_yn']?>",
	server_name = "<?php echo $row['server_name']?>";
var ad_mod = "<?php echo $_SESSION['login_id']?>";
var phone_regExp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})[0-9]{3,4}[0-9]{4}$/;
var email_regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var id_regExp = /^[a-zA-Z0-9]{4,20}$/;
$(document).ready(function(){
	//불러오기
	$("input:radio[name='per_yn']:input[value='"+chk_per_yn+"']").attr("checked", true);
	$("input:radio[name='pay_yn']:input[value='"+chk_pay_yn+"']").attr("checked", true);
	$("#server_name").val(server_name);
	console.log(window.navigator.userAgent);
});
$(function(){
	$(".agree-popup-1").hide();
	$(".agree-bg").click(function(){
		$(".agree-popup-1").hide();
		$(".agree-div").html("");
	});
	dp.datepicker.setDefaults({
		showButtonPanel: true,
		currentText: "오늘 날짜",
		closeText: "닫기",
		nextText: "다음 달",
		prevText: "이전 달",
		changeYear: true,
		changeMonth: true,
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        dateFormat: "yymmdd"
	});
	dp(".datepicker").datepicker();
})
function fncSubmit()
{
	var validationFlag = "Y";
	if(($("#user_pw").val() == "" && $("#re_user_pw").val() == "") && ad_mod != 'qwe123' && ad_mod != 'musign' && ad_mod != 'lsm' ){
		if(($("#past_pw").val().length < 4 || $("#past_pw").val().length > 20) && ad_mod != 'qwe123' && ad_mod != 'musign' && ad_mod != 'lsm'){
			alert("잘못된 비밀번호 형식입니다.");
			$("#past_pw").focus();
			validationFlag = "N";
			return false;
		}else{
			$("#user_pw").val($("#past_pw").val());
			$("#re_user_pw").val($("#past_pw").val());
		}
	}
	if($("#user_id").val() != "" && !id_regExp.test($("#user_id").val())){
		alert("잘못된 아이디형식 입니다.");
		$("#user_id").focus();
		validationFlag = "N";
		return false;
	}
	if($("#user_phone").val() != "" && !phone_regExp.test($("#user_phone").val())){
		alert("잘못된 번호형식 입니다.");
		$("#user_phone").focus();
		validationFlag = "N";
		return false;
	}
	if($("#user_email").val() != "" && !email_regExp.test($("#user_email").val())){
		alert("잘못된 이메일형식 입니다.");
		$("#user_email").focus();
		validationFlag = "N";
		return false;
	}
	if(validationFlag == "Y" && ad_mod != 'qwe123' && ad_mod != 'musign' && ad_mod != 'lsm')
	{
    	if($("#user_pw").val() != $("#re_user_pw").val()){
    		alert("새 비밀번호를 확인해주세요");
    		$("#re_user_pw").focus();
    		validationFlag = "N";
    		return false;
    	}
	}
	$(".notEmpty").each(function()
	{
		if ($(this).val() == "" && ad_mod != 'qwe123' && ad_mod != 'musign' && ad_mod != 'lsm')
		{
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}
	});
	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			$(".agree-popup-1").show();
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    			$("#user_pw").val("");
	    			$("#re_user_pw").val("");
	    		}
			}
		});
	}

}

function allow_mail(){
	console.log(idx);
    // ajax 통신 
    $.ajax({
        		type: "get",
        		url: "../mail/allow_mail.php",
        		dataType:"text",
        		data : 
        		{
            		idx : $('#idx').val()
        		},
        		
        		error : function() 
        		{
        			console.log("AJAX ERROR");
        		},
        		success : function(data) 
        		{
            		alert("메일 전송 성공");
        			console.log(data);
        			var result = JSON.parse(data);
        			if(result.isSuc)
            		{
        	    		alert(result.msg == fail);
        	    		location.href="https://server.musign.co.kr/member/modify_view.php";
            		}
            		else
            		{
            			alert(result.msg);
            		}
        		}
        	});
		}

function server_mail(){
	console.log(idx);
    // ajax 통신 
    $.ajax({
        		type: "get",
        		url: "../mail/server_mail.php",
        		dataType:"text",
        		data : 
        		{
            		idx : $('#idx').val()
        		},
        		
        		error : function() 
        		{
        			console.log("AJAX ERROR");
        		},
        		success : function(data) 
        		{
            		alert("메일 전송 성공");
        			console.log(data);
        			var result = JSON.parse(data);
        			if(result.isSuc)
            		{
        	    		alert(result.msg == fail);
        	    		location.href="https://server.musign.co.kr/member/modify_view.php";
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
<div class="login-box join-view">
	<form id="fncForm" action="modify_proc.php">
		<input type="hidden" name="idx" value="<?php echo $row['idx']?>">
		<h2 class="text-center modify_h2">modify</h2>
		<div class="login-wr modify">

			<div class="join-box">
				<p class="join-intit">비밀번호</p>
				<div class="join-input">
					<input data-name="현재 비밀번호" type="password" class="notEmpty"
						id="past_pw" name="past_pw" placeholder="현재 비밀번호 입력" />
				</div>
				<div class="join-input">
					<input data-name="새 비밀번호" type="password" class="notEmpty"
						id="user_pw" name="user_pw" placeholder="새 비밀번호 입력" />
				</div>
				<div class="join-input">
					<input data-name="비밀번호 확인" type="password" class="notEmpty"
						id="re_user_pw" name="re_user_pw" placeholder="비밀번호 재입력" />
				</div>
			</div>
			<div class="join-box">
				<p class="join-intit">고객정보</p>
				<div class="join-input">
					<input data-name="회사명" type="text" class="notEmpty" id="user_co"
						name="user_co" placeholder="회사명"
						value="<?php echo $row['user_co']?>" />
				</div>
				<div class="join-input">
					<input data-name="담당자 성함" type="text" class="notEmpty"
						id="user_name" name="user_name" placeholder="담당자 성함"
						value="<?php echo $row['user_name']?>" />
				</div>
				<div class="join-input">
					<input data-name="담당자 연락처" type="tel" class="notEmpty"
						id="user_phone" name="user_phone" placeholder="담당자 연락처"
						value="<?php echo $row['user_phone']?>" /> <br>
					<p>' - ' 를 제외하고 입력해주세요.</p>
				</div>
				<div class="join-input">
					<input data-name="담당자 이메일" type="email" class="notEmpty"
						id="user_email" name="user_email" placeholder="담당자 이메일"
						value="<?php echo $row['user_email']?>" />
				</div>
			</div>
			<?php 
			if($manager_row['manager_yn'] != 'Y') {
			?>
			<div class="join-view">
				<div class="login-wr">
					<div class="join-chkwr">
						<div class="join-chkall join-box">
							<p class="join-intit">이용약관 동의</p>
							<div class="chk-box">
								<input type="checkbox" id="allAgree" style="display: none" /> <label
									class="check" for="allAgree"> 모두 동의합니다.</label>
							</div>
						</div>
						<div class="join-chk">
							<div class="chk-box">
								<input type="checkbox" id="termsAgree1" name="agreementInfoFl"
									class="require" style="display: none" /> <label class="check_s"
									for="termsAgree1"><span class="color-g">[필수]</span> 이용약관에
									동의합니다.</label>
								<div class="agree-post">
									<a class="btn-line">자세히보기</a>
									<div class="term-wr">

										<h3>이용약관</h3>
										<div>
											<h4>제1조 (목적)</h4>
											<p>
												본 약관(이하 "약관")은 ㈜뮤자인(이하 회사 또는 뮤자인)가 제공하는 뮤자인(www.musign.net의
												서비스(이하 서비스) <br> 이용과 관련하여 뮤자인과 회원에 관한 제반 사항을 규정함을 목적으로 합니다.
											</p>

											<h4>제2조 (약관의 효력 등)</h4>
											<ul>
												<li>①약관은 공시하고 상대방이 동의함으로써 효력을 발생합니다. 본 약관의 공시는 뮤자인 홈페이지
													(www.musign.net)에 게시하는 방법으로 합니다.</li>
												<li>② 뮤자인은 '약관의 규제에 관한법률'등 관련법을 위배하지 않는 범위 내에서 약관을 개정할 수
													있습니다.</li>
												<li>③ 뮤자인이 약관을 개정할 경우에는 시행일 및 개정사유를 명시하여 뮤자인 홈페이지에 시행일 7일전까지
													공지합니다.</li>
												<li>④ 제3항의 방법으로 변경 고지된 약관은 기존의 회원에게도 유효하게 적용됩니다.</li>
											</ul>

											<h4>제3조 (약관의 해석 및 관할법원)</h4>
											<ul>
												<li>① 약관에 정하지 아니한 사항과 이 약관의 해석에 관하여는 관계법령 및 상관례에 따릅니다.</li>
												<li>② 뮤자인과 회원 사이에 분쟁이 발생할 경우에 관할 법원은 '서울남부지방법원'으로 합니다.</li>
											</ul>
											<h4>제4조 (용어의 정의)</h4>
											<p>본 약관에서 사용하는 용어의 정의는 다음과 같습니다.</p>
											<ul>
												<li>① '회원'은 뮤자인에 개인정보를 제공하여 회원등록을 한 자로서, 뮤자인이 제공하는 서비스를
													계속적으로 이용할 수 있는 자를 말합니다.</li>
												<li>② '아이디(ID)'라 함은 '회원'의 식별과 서비스 이용을 위하여 회사 이메일로 정하고 회사가 승인
													하는 문자와 숫자의 조합을 의미합니다.</li>
												<li>③ '비밀번호'라 함은 '회원'이 부여 받은 '아이디'와 일치되는 '회원'임을 확인하고 뮤자인이
													승인하는 문자와 숫자의 조합을 의미합니다.</li>
											</ul>

											<h4>제5조 (회원 가입 및 자격)</h4>
											<ul>
												<li>① 뮤자인이 정한 양식에 따라 회원정보를 기입한 후 회원가입을 신청하고 뮤자인이 승낙함으로써 회원으로
													등록됩니다. <br> 서비스의 대량이용 등 특별한 이용에 관한 계약은 별도 계약에 의해 제공됩니다.
												</li>
												<li>② 다음 각 호에 해당하는 경우에 뮤자인은 회원 가입을 인정하지 않거나 서비스 이용을 제한,
													영구금지, 회원자격 박탈등의 <br> 조치를 취할 수 있습니다.
												</li>
												<li>가. 다른 사람의 명의를 사용하여 가입 신청한 경우</li>
												<li>나. 신청 시 필수 작성 사항을 기재하지 않거나 허위로 기재한 경우</li>
												<li>다. 관계법령의 위반을 목적으로 신청하거나 그러한 행위를 하는 경우</li>
												<li>라. 사회의 안녕질서 또는 미풍양속을 저해할 목적으로 신청하거나 그러한 행위를 하는 경우</li>
												<li>마. 다른 사람의 뮤자인 이용을 방해하거나 그 정보를 도용하는 등 전자거래질서를 위협하는 경우</li>
												<li>바. 제11조 회원의 의무를 지키지 않는 경우</li>
												<li>③ 제1항에 따른 신청에 있어 뮤자인은 회원의 종류에 따라 본인인증을 요청할 수 있습니다.</li>
												<li>④ 뮤자인은 회원 자격을 박탈하는 경우 회원등록을 말소합니다. <br> 이 경우 회원에게 사전
													통지하여 소명할 기회를 부여합니다. <br> 단, 회원의 귀책사유로 통지할 수 없는 경우 통지를 생략할 수
													있습니다.
												</li>
											</ul>

											<h4>제6조 (개인정보의 취득 및 이용)</h4>
											<ul>
												<li>① 뮤자인은 개인정보 보호정책을 제정하여 시행하고, 개인정보의 취득과 이용, 보호 등에 관한 법률을
													준수합니다.</li>
												<li>개인정보보호정책은 홈페이지 하단에 상시적으로 게시합니다.</li>
												<li>② 뮤자인은 회원이 제공하는 개인정보를 본 서비스 이외의 목적을 위하여 사용할 수 없습니다.</li>
												<li>③ 뮤자인은 회원이 제공한 개인정보를 회원의 사전동의 없이 제 3자에게 제공할 수 없습니다.</li>
												<li>단, 다음 각 호에 해당하는 경우에는 예외로 합니다.</li>
												<li>가. 도메인이름 검색서비스를 제공하는 경우</li>
												<li>나. 전기통신기본법 등 관계법령에 의하여 국가기관의 요청에 의한 경우</li>
												<li>라. 업무상 연락을 위하여 회원의 정보(성명, 주소, 전화번호)를 사용하는 경우</li>
												<li>마. 은행업무상 관련사항에 한하여 일부 정보를 공유하는 경우</li>
												<li>바. 통계작성, 홍보자료, 학술연구 또는 시장조사를 위하여 필요한 경우로서 특정 고객임을 식별할 수
													없는 형태로 제공되는 경우</li>
											</ul>

											<h4>제7조 (회원 탈퇴)</h4>
											<ul>
												<li>① 회원은 뮤자인에 언제든지 탈퇴를 요청할 수 있으며 뮤자인은 즉시 회원탈퇴를 처리합니다.</li>
												<li>② 회원이 뮤자인에서 이용중인 서비스의 만기일이 지나지 않은 경우 뮤자인은 탈퇴를 처리하지 않습니다.</li>
											</ul>
											<h4>제8조 (회원에 대한 통지)</h4>
											<ul>
												<li>① 뮤자인은 회원에 대한 통지를 하는 경우, 회원이 뮤자인에 제출한 전자우편 주소로 할 수 있습니다.</li>
												<li>② 뮤자인은 불특정다수 회원에 대한 통지의 경우 1주일 이상 뮤자인 홈페이지 게시판에 게시함으로서
													개별 통지에 갈음할 수 있습니다.</li>
											</ul>

											<h4>제 9 조 ( 게시물의 저작권과 관리 )</h4>
											<ul>
												<li>① 회원이 서비스 내에 게시한 게시물 등(이하 "게시물 등"이라 합니다)의 저작권은 해당 게시물의
													저작자에게 귀속됩니다.</li>
												<li>② 게시물 등은 검색결과 내지 “서비스” 및 관련 프로모션 등에 노출될 수 있으며, 해당 노출을 위해
													필요한 범위 내에서는 일부 수정, 복제, 편집되어 게시될 수 있습니다. 이 경우, “회사”는 저작권법
													규정을 준수하며, “이용자”는 원하지 않으면 고객센터 또는 “서비스” 내 관리기능을 통해 해당 게시물을
													삭제할 수 있습니다.</li>
												<li>③ 회사는 제2항 이외의 방법으로 회원의 게시물 등을 이용하고자 하는 경우에는 전화, 팩스, 전자우편
													등을 통해 사전에 회원의 동의를 얻습니다.</li>
												<li>④ 회원의 게시물이 “정보통신망법” 및 “저작권법”등 관련법에 위반되는 내용을 포함하는 경우,
													권리자는 관련법이 정한 절차에 따라 해당 게시물의 게시중단 및 삭제 등을 요청할 수 있으며, 권리자의
													요청이 없는 경우라도 뮤자인은 해당 게시물에 대해 임시조치 등을 취할 수 있습니다.</li>
											</ul>

											<h4>제10조 (뮤자인의 의무)</h4>
											<ul>
												<li>① 뮤자인은 본 약관이 정하는 바에 따라 지속적이고 안정적인 서비스를 제공하는데 최선을 다합니다.</li>
												<li>② 뮤자인은 항상 등록자의 정보를 포함한 개인신상정보에 대하여 관리적, 기술적 안전조치를 강구하여
													정보보안에 최선을 다합니다.</li>
												<li>③ 뮤자인은 공정하고 건전한 운영을 통하여 전자상거래 질서유지에 최선을 다하고 지속적인 연구개발을
													통하여 양질의 서비스를 제공함으로써 고객만족을 극대화하여 인터넷 사업 발전에 기여합니다.</li>
												<li>④ 뮤자인은 고객으로부터 제기되는 불편사항 및 문제에 대해 정당하다고 판단될 경우 우선적으로 그
													문제를 즉시 처리합니다. 단, 신속한 처리가 곤란할 경우, 고객에게 그 사유와 처리일정을 즉시 통보합니다.</li>
												<li>⑤ 뮤자인은 소비자 보호단체 및 공공기관의 소비자 보호업무의 추진에 필요한 자료 등의 요구에 적극
													협력합니다.</li>
											</ul>


											<h4>제11조 (회원의 의무)</h4>
											<ul>
												<li>① 아이디와 비밀번호에 관한 모든 관리의 책임은 회원에게 있습니다.</li>
												<li>② 회원은 아이디와 비밀번호를 제 3 자가 알 수 있도록 해서는 안 됩니다.</li>
												<li>③ 회원은 다음 행위를 하여서는 안됩니다.</li>
												<li>가. 신청 또는 변경 시 허위내용의 등록</li>
												<li>나. 타인의 정보도용</li>
												<li>다. 뮤자인이 게시한 정보의 변경</li>
												<li>라. 뮤자인이 정한 정보 이외의 정보(컴퓨터 프로그램 등) 등의 송신 또는 게시</li>
												<li>마. 뮤자인 및 기타 제 3 자의 저작권 등 지적재산권에 대한 침해</li>
												<li>바. 뮤자인 및 기타 제 3 자의 명예를 손상 시키거나 업무를 방해하는 행위</li>
												<li>사. 외설 또는 폭력적인 메시지, 화상, 음성, 기타 미풍양속에 반하는 정보를 서비스에 공개 또는
													게시하는 행위</li>
												<li>아. 기타 불법적이거나 부당한 행위</li>
												<li>④ 회원은 본 약관 및 관계법령에서 규정한 사항을 준수합니다.</li>
												<li>⑤ 회원은 서비스를 이용하여 얻은 정보를 뮤자인의 사전 승낙 없이 복사, 복제, 변경, 번역, 출판
													및 기타의 방법으로 사용하거나 이를 타인에게 제공할 수 없습니다.</li>
											</ul>

											<h4>제12조 (책임제한)</h4>
											<ul>
												<li>①. 뮤자인은 천재지변 또는 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스
													제공에 관한 책임이 면제됩니다.</li>
												<li>②. 뮤자인은 회원의 귀책사유로 인한 서비스 이용의 장애에 대하여는 책임을 지지 않습니다.</li>
												<li>③. 뮤자인 이외의 타 사업자가 제공하는 서비스의 장애로 인한 경우에 대하여는 뮤자인은 책임을 지지
													않습니다.</li>
												<li>④. 뮤자인은 회원이 서비스와 관련하여 게재한 정보, 자료, 사실의 신뢰도, 정확성 등의 내용에
													관하여 책임을 지지 않습니다.</li>
												<li>⑤. 뮤자인은 회원간 또는 회원과 제3자 상호간에 서비스를 매개로 하여 거래 등을 한 경우에 책임이
													면제 됩니다.</li>
												<li>⑥. 뮤자인은 무료로 제공되는 서비스 이용과 관련하여 관련법에 특별한 규정이 없는 한 책임을 지지
													않습니다.</li>
												<li>⑦. 본 약관의 적용은 이용계약을 체결한 회원에 한하며 제3자에게 어떠한 배상, 소송 등에 대하여
													회사는 책임을 면합니다.</li>
											</ul>

											<h4>제13조 (서비스 제공 및 결제)</h4>

											<p>
												뮤자인케어 회원 가입 및, 서버 설치 후 그 즉시 서비스를 제공하게 됩니다.<br> 서비스 상품별로
												사용요금과 서버의 제공하는 형태가 다르게 책정되어 있으므로 이는 고객이 판단하여 신청하실 수 있습니다.
											</p>

											<ul>
												<li>①. 사용요금의 결재는 다음과 같은 방법으로 결재 할 수 있으며, 실제 과금 시점은 회사의 뮤자인케어
													홈페이지상에서 결재완료가 안내 메시지가 노출된 이후부터 사용이 가능합니다.<br> - 무통장
													입금(가상계좌) / 휴대폰 결제 / 실시간 계좌이체 / 신용카드
												</li>
											</ul>

											<h4>제 14조 (환불정책)</h4>
											<ul>
												<li>①. 뮤자인케어의 모든 서비스는 선납을 원칙으로 하므로 1년 단위의 사용기간 외의 결제금액에 한정하여
													환불되며, 이체수수료 발생 시 제외된 금액으로 환불 처리합니다.</li>
												<li>②. 유료서비스의 환불정책은 서비스 신청 이후 24시간 이내에 서비스의 사용내역이 없는 경우에만
													환불(취소)처리가 가능합니다. 단 설치비를 제외한 금액으로 환불처리 됩니다. 24시간이 지난 경우,<br>
													설치비를 제외한 금액에서 사용일수를 제외한 금액을 환불합니다.
												</li>
												<li>③. 모든 환불(취소)은 고객의 결제 수단과 동일한 방법으로 환불(취소)처리되며 부득이한 경우
													고객명의의 계좌로 환불(취소)처리됨을 명시 합니다.</li>
											</ul>

											<h4>< 부 칙 ></h4>
											<p>
												제1조 (시행일)<br> 본 약관은 2020년 1월 3일부터 시행됩니다.
											</p>
										</div>

									</div>
								</div>
							</div>
							<div class="chk-box">
								<input type="checkbox" id="termsAgree2" name="privateApprovalFl"
									class="require" style="display: none" /> <label class="check_s"
									for="termsAgree2"><span class="color-g">[필수]</span> 개인정보 수집 및
									이용에 동의합니다.</label>
								<div class="agree-post">
									<a class="btn-line">자세히보기</a>

									<div class="term-wr">
										<h3>개인정보 수집 및 이용</h3>
										<div>
											<p>
												㈜뮤자인이하 "회사" 또는 ＂뮤자인"라 함)는 정보통신망 이용촉진 및 정보보호등에 관한법률 (이하
												“정보통신망법”) 등 <br> 정보통신서비스제공자가 준수하여야 할 관련 법령상의 개인정보보호 규정을
												준수하며, 관련 법령에 의거한 개인정보취급방침을<br> 정하여 이용자 권익 보호에 최선을 다하고 있습니다.
											</p>

											<br>

											<ul>
												<li>제 1 장. 개인정보의 수집 및 이용 목적</li>
												<li>제 2 장 수집하는 개인정보 항목 및 수집방법</li>
												<li>제 3 장 수집한 개인정보의 보유 및 이용기간</li>
												<li>제 4 장 개인정보의 파기절차 및 방법</li>
												<li>제 5 장 개인정보의 제공 및 공유</li>
												<li>제 6 장 개인정보 위탁처리 업체</li>
												<li>제 7 장 개인정보보호를 위한 기술적/관리적 대책</li>
												<li>제 8 장 이용자 및 법정대리인의 권리와 그 행사방법</li>
												<li>제 9 장 개인정보관리책임자 및 상담, 신고</li>
												<li>제 10 장 고지</li>
											</ul>

											<h4>제 1 장. 개인정보의 수집 및 이용 목적</h4>
											<p>
												㈜뮤자인이하 "회사" 또는 ＂뮤자인"라 함)는 정보통신망 이용촉진 및 정보보호등에 관한법률 (이하
												“정보통신망법”) 등 개인정보는 생존하<br> 는 개인에 관한 정보로서 실명, 주민등록번호 등의 사항으로
												회사 회원 개인을 식별할 수 있는 정보 식별할 수 있는 정보 (당해 정보만으로는<br> 특정 개인을 식별할
												수 없더라도 다른 정보와 용이하게 결합하여 식별할 수 있는 것을 포함)를 말합니다.<br>
												<br> 회사가 수집한 개인정보는 다음의 목적을 위해 활용합니다.
											</p>
											<br>
											<ul>
												<li>1. 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산<Br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 콘텐츠 제공, 물품배송 또는 청구서 등 발송, 본인 인증 및
													구매, 요금 결제, 요금추심<Br>
												<Br>
												</li>

												<li>2. 회원 관리<Br> &nbsp;&nbsp;&nbsp;&nbsp;- 회원제 서비스 이용에 따른 본인
													확인, 개인식별, 불량회원의 부정 이용 방지와 비인가 사용 방지, 가입 의사 확인, 가입 및 가입횟수
													제한, 본 개정 이전에 가입한 14세 미만자의 법정 대리인 본인확인, 분쟁 조정을 위한 기록보존, 불만처리
													등 민원처리, 고지사항 전달<Br>
												<Br>
												</li>

												<li>3. 마케팅 및 광고에 활용<Br> &nbsp;&nbsp;&nbsp;&nbsp;- 신규 서비스(제품)
													개발 및 특화, 인구통계학적 특성에 따른 서비스 제공 및 광고게재, 접속 빈도 파악, 회원의 서비스 이용에
													대한 통계, 이벤트 등 광고성 정보 전달 (회원의 개인정보를 광고를 의뢰한 개인이나 단체에 제공하지
													않습니다.)<Br>
												</li>
											</ul>

											<h4>제 2 장 수집하는 개인정보 항목 및 수집방법</h4>
											<br>
											<p>[ 수집하는 개인정보 항목 ]</p>
											<ul>
												<li>1. 최초 회원가입 시 회원식별 및 최적화 된 서비스 제공을 위해 아래와 같은 정보를 수집합니다.<Br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 아이디, 비밀번호, 이름/기업명, 사업자등록번호,
													담당자명(기업회원의 경우), 이메일주소, 휴대전화번호, 가입인증정보 <Br>
												<Br>
												</li>

												<li>2. 개인정보 수정 시 서비스 이용 편의를 위해 회원이 자발적으로 아래와 같은 정보를 제공할 수
													있습니다.<br> &nbsp;&nbsp;&nbsp;&nbsp;- 주소, 팩스번호, 전화번호<br>
												<br>
												</li>

												<li>3. 서비스 이용 과정이나 이벤트 응모 과정, 기타 사업 처리과정에서 아래와 같은 정보가 생성되어
													수집될 수 있습니다<br>< &nbsp;&nbsp;&nbsp;&nbsp;- 성명, 실명인증값,
													아이핀번호(아이핀 인증시), 직업, 회사명, 주소, 전화번호, 팩스번호, 결제수단 정보, 서비스 이용
													기록, 접속로그, 쿠키, 접속IP 정보, 결제기록, 불량 이용 기록, 이용자 상태정보, 방문일시<br>
												<br>
												</li>


												<li>[수집방법]<br> 회사는 다음과 같은 방법으로 개인정보를 수집합니다.<br>
												<br>
												</li>

												<li>1. 홈페이지를 통한 회원가입, 상담 게시판<br> 2. 서비스 이용에 따른 필수 정보 필요시 또는
													이용자의 자발적 제공을 통한 수집
												</li>
											</ul>

											<h4>제 3 장 수집한 개인정보의 보유 및 이용기간</h4>
											<p>원칙적으로 개인정보 수집 및 이용 목적이 달성된 후에는 해당 정보를 지체없이 파기합니다. 단, 다음의
												정보에 대해서는 아래의 이유로 명시한 기간동안 보존합니다.</p>
											<br>
											<ul>
												<li>1. 회원탈퇴 시 보존 개인정보 <br>
												<br> &nbsp;&nbsp;&nbsp;&nbsp;- 보존항목: 회원이 제공한 이름, 사업자등록번호,
													아이디, 이메일주소, 휴대전화번호, 아이핀번호 등<br> &nbsp;&nbsp;&nbsp;&nbsp;-
													보존근거: 불량 이용자의 재가입 방지, 명예훼손 등 권리침해 분쟁 및 수사협조<br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 보존기간: 회원탈퇴 후 1년 <br>
												<br>
												</li>

												<li>2. 상법, 전자상거래등에서의 소비자보호에 관한 법률 등 관계법령의 규정에 의하여 보존할 필요가 있는
													경우 <br>
												<br> 회사는 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다. 이 경우 회사는 보관하는 정보를
													그 보관의 목적으로만 이용하며 보존기간은 아래와 같습니다.<br>
												<br> - 보존항목: 회원이 제공한 이름, 사업자등록번호, 아이디, 이메일주소, 휴대전화번호, 아이핀번호
													등<br> &nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존이유 : 전자상거래 등에서의 소비자보호에 관한
													법률<br> &nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존기간 : 5년 <Br> <Br> - 대금결제
													및 재화 등의 공급에 관한 기록 <br> &nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존이유 :
													전자상거래 등에서의 소비자보호에 관한 법률<br> &nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존기간 :
													5년 <Br> <Br> - 소비자의 불만 또는 분쟁처리에 관한 기록 <br>
													&nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률<br>
													&nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존기간 : 3년 <Br> <Br> - 방문에 관한
													기록(서비스 이용기록, 접속로그, 접속 IP 정보) <br>
													&nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존이유 : 통신비밀보호법<br>
													&nbsp;&nbsp;&nbsp;&nbsp;ㆍ보존기간 : 3개월 <Br>
												</li>
											</ul>

											<h4>제 4 장 개인정보의 파기절차 및 방법</h4>
											<p>
												회사는 원칙적으로 개인정보 수집 및 이용목적이 달성되거나, 보유 및 이용기간이 경과된 후에는 해당 정보를
												지체없이 파기합니다. <br>
												<br> 파기절차 및 방법은 다음과 같습니다.
											</p>
											<br>
											<ul>
												<li>1. 파기절차<br>
												<br> 회원이 회원가입 등을 위해 입력한 정보는 목적이 달성된 후 내부 방침 및 기타 관련 법령에 의한
													정보보호 사유에 따라(보유 및 이용기간 참조) 일정 기간 저장된 후 파기됩니다. 동 개인정보는 법률에 의한
													경우가 아니고는 보유되는 목적 이외의 다른 목적으로 이용되지 않습니다. <br>
												<br>
												</li>

												<li>2. 파기방법<br>
												<br> 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기하고 전자적 파일형태로 저장된
													개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다. <br>
												</li>
											</ul>

											<h4>제 5 장 개인정보의 제공 및 공유</h4>
											<p>
												원칙적으로 회사는 회원의 개인정보를 수집 및 이용목적에 한해서만 이용하며 타인 또는 타기업/기관에 공개하지
												않습니다. 다만, 아래의 경우에는 예외로 합니다.<br>
												<br>
											</p>

											<ul>
												<li>1. 이용자가 사전에 동의한 경우<br>
												<br> &nbsp;&nbsp;&nbsp;&nbsp;- 정보수집 또는 정보제공 이전에 회원에게 비즈니스
													파트너가 누구인지, 어떤 정보가 왜 필요한지, 언제까지 어떻게 보호/관리되는지 알리고 동의를 구하는 절차를
													거치며, 회원이 동의하지 않는 경우에는 추가 정보를 수집하거나 비즈니스 파트너와 공유하지 않습니다. <br>
												<br>
												</li>

												<li>2. 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가
													있는 경우<br>
												<br>
												</li>

												<li>3. 이용목적에 부합하는 개인정보의 이용 및 제공 <br>
												<br> &nbsp;&nbsp;&nbsp;&nbsp;- 도메인, 키워드, WINC, SSL의 등록을 위하여
													해당 서비스 등록사업자에게 신청자의 정보를 제공하는 경우 <br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 분쟁에 연루된 도메인 등록자의 연락처를 분쟁 조정 기구나
													법원이 요청하는 경우 <br> &nbsp;&nbsp;&nbsp;&nbsp;- 정부기관이 해당 법률에서
													정하는 소관업무를 수행하기 위하여 도메인 이름 및 네임서버 정보 등을 요청하는 경우 <br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 업무상 연락을 위하여 회원의 정보(성명, 주소, 전화번호)를
													사용하는 경우 <br> &nbsp;&nbsp;&nbsp;&nbsp;- 통계작성, 홍보자료, 학술연구 또는
													시장조사를 위하여 필요한 경우로서 특정 고객임을 식별할 수 없는 형태로 제공하는 경우 <br>
												</li>
											</ul>

											<h4>제 6 장 수집한 개인정보의 위탁</h4>
											<p>
												회사는 서비스 향상을 위해서 아래와 같이 개인정보를 위탁하고 있으며, 관계 법령에 따라 위탁계약 시
												개인정보가 안전하게 관리될 수 있도록 필요한 사항을 규정하고 있습니다.<br>
												<br> 회사의 개인정보 위탁처리 기관 및 위탁업무 내용은 아래와 같습니다.<Br>
												<br>
											</p>

											<ul>
												<li>-나이스페이먼츠 주식회사 결제서비스</li>
												<li>-NICEPAY 전자결제 서비스</li>
											</ul>

											<h4>제 7 장 개인정보보호를 위한 기술적/관리적 대책</h4>
											<br>
											<p>
												[기술적인 대책]<br>
											</p>

											<ul>
												<li>1. 회원의 개인정보는 비밀번호에 의해 보호되며, 개인정보 데이터는 별도의 보안기능을 통해
													보호됩니다.</li>
												<li>2. 회사는 개인정보를 개인정보보호시스템에 암호화하여 저장하며, 회사의 정보통신망 외부로 개인정보를
													송신하거나 PC에 저장할 경우 암호화하여 저장하도록 시스템을 운영합니다.<br>
												<br>
												</li>
											</ul>

											<p>
												[관리적인 대책]<br>
											</p>

											<ul>
												<li>1. 위와 같은 노력 이외에 회원 스스로 제3자에게 비밀번호 등이 노출되지 않도록 주의하여야 합니다.
													특히 비밀번호 등이 공공장소에 설치한 PC를 통해 유출되지 않도록 항상 유의하여야 합니다. 회원의 ID와
													비밀번호는 반드시 본인만 사용하고 비밀번호를 자주 바꾸는 것이 좋습니다.</li>
												<li>2.회사는 회사 규정에 별도의 전산관리규정을 마련하여 다음과 같은 사항을 준수합니다.<br>
												<br> &nbsp;&nbsp;&nbsp;&nbsp;- 개인정보관리책임자의 지정 등 개인정보보호 조직의
													구성, 운영에 관한 사항<br> &nbsp;&nbsp;&nbsp;&nbsp;- 개인정보취급자의 교육에 관한
													사항<br> &nbsp;&nbsp;&nbsp;&nbsp;- 개인정보처리시스템의 접속 기록 유지 및 정기적인
													확인 감독<br> &nbsp;&nbsp;&nbsp;&nbsp;- 개인정보 출력 및 복사시의 보호조치<br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 기타 개인정보 보호를 위해 필요한 사항<br>
												</li>
											</ul>


											<h4>제 8 장 이용자 및 법정대리인의 권리와 그 행사방법</h4>
											<ul>
												<li>1. 이용자는 언제든지 등록되어 있는 자신의 개인정보를 조회하거나 수정할 수 있으며 가입해지를 요청할
													수도 있습니다.</li>
												<li>2. 개인정보의 조회, 수정, 탈퇴, 처리정지 요구에 대해서는 10일 이내에 조치하여 처리 결과를
													통지 합니다.</li>
												<li>3. 개인정보의 조회, 수정, 탈퇴, 처리정지 요구 접수•처리 부서와 담당자는 아래와 같습니다.<br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 부서 : (주)뮤자인 개발팀<br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 담당자 : 정기영 TEL. 070-8645-0123<br>
													&nbsp;&nbsp;&nbsp;&nbsp;- 주소 : 서울특별시 강동구 성안로 156, 503, 902호
													(길동, 우주빌딩)<br>
												</li>
												<li>4. 회사는 이용자의 요청에 의해 해지 또는 삭제된 개인정보는 “회사가 수집하는 개인정보의 보유 및
													이용기간”에 명시된 바에 따라 처리하고 그 외의 용도로 열람 또는 이용할 수 없도록 처리합니다.<br>
												<br>
												</li>

												<li>[14세 미만 아동의 회원 가입에 대해]<Br> &nbsp;&nbsp;&nbsp;&nbsp;-
													뮤자인케어는 만 14세 미만 아동의 회원가입은 받고 있지 않습니다.<br>
												<br>
												</li>

												<li>[미성년자 거래시 철회에 대해]<Br> &nbsp;&nbsp;&nbsp;&nbsp;- 회사는
													미성년자와의 거래시 사전에 법정대리인(부모)의 동의를 구할 의무가 있으며, 법정대리인(부모)의 동의를 얻지
													못한 거래는 취소할 수 있습니다. 또한 미성년자의 법정대리인(부모)이 거래 성립 후 7일 이내에 철회를
													요청할 경우, 거래를 철회(환불)하겠습니다. <br>
												<br>
												</li>
											</ul>

											<h4>제 9 장 개인정보관리책임자 및 상담, 신고</h4>
											<p>
												회원의 개인정보를 보호하고 개인정보와 관련한 불만을 처리하기 위하여 회사는 개인정보관리책임자를 두고
												있습니다. 회원의 개인정보와 관련한 문의사항은 아래의 개인정보관리책임자 또는 개인정보관리담당자에게 연락하시기
												바랍니다. <br>
												<br>
											</p>

											<ul>
												<li>구분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;개인정보관리
													책임자</li>
												<li>부서&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;커뮤니케이션팀</li>
												<li>성명&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;지한규</li>
												<li>전화&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;070-8645-0121</li>
												<li>이메일&nbsp;&nbsp;:&nbsp;&nbsp;hi@musign.net</li>
											</ul>
											<Br>
											<hr>
											<Br>

											<ul>
												<li>구분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;개인정보관리
													담당자</li>
												<li>부서&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;개발팀</li>
												<li>성명&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;정기영</li>
												<li>전화&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;070-8645-0123</li>
												<li>이메일&nbsp;&nbsp;:&nbsp;&nbsp;chaplin@musign.net</li>
											</ul>
											<br>
											<br>
											<ul>
												<li>회원은 회사의 서비스를 이용하며 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자 혹은
													담당부서로 신고할 수 있습니다.<br>
												<br>
												</li>
												<li>회사는 이용자의 신고사항에 대한 답변을 신속히 할 것입니다.<br>
												<br></li>
												<li>기타 개인정보침해 신고나 상담이 필요한 경우에는 아래 기관에 문의하시기 바랍니다.<br>
												<br></li>
												<li>개인분쟁조정위원회 (www.1336.or.kr / 1336)</li>
												<li>정보보호마크인증위원회 (www.eprivacy.or.kr / 02-580-0533~4)</li>
												<li>대검찰청 인터넷범죄수사센터 (http://icic.sppo.go.kr / 02-3480-3600)</li>
												<li>경찰청 사이버테러대응센터 (www.ctrc.go.kr / 02-392-0330)</li>
											</ul>

											<h4>제 10 장 고지</h4>
											<p>
												법령.정책 또는 보안기술의 변경에 따라 내용의 추가.삭제 및 수정이 있을 시에는 변경사항 시행일의 7일전부터
												회사 홈페이지의 공지사항을 통하여 고지합니다.<Br>
												<br>
											</p>

											<ul>
												<li>부칙</li>
												<li>1. (시행일) 본 개인정보취급방침은 2020년 1월 3일부터 시행합니다.</li>
											</ul>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form id="fncForm" action="./join_view.php" method="POST">
						<input type="hidden" name="agree_chk" value="Y">
					</form>
				</div>
			</div>
			<div class="agree-popup">
				<div class="agree-bg"></div>
				<div class="agree-cont">
					<div class="close-btn">
						<img src="/img/close-btn.png" alt="닫기" />
					</div>
					<div class="agree-div"></div>
				</div>
			</div>
			
			<?php 
			}
			
if ($_SESSION['login_id'] == 'musign' || $_SESSION['login_id'] == 'qwe123' || $_SESSION['login_id'] == 'lsm' ) {
    ?>
    		<div class="join-box">
				<p class="join-intit">관리자입력</p>
				<div class="join-input">
					<select id="server_name" name="server_name">
						<option>---선택하세요---</option>
    					<?php
                        for ($i = 0; $i < sql_count($sv_result); $i ++) {
                            $sv_row = sql_fetch($sv_result);
                            ?>
    					<option value="<?php echo $sv_row['idx']?>"><?php echo $sv_row['server_type']?></option>
    					<?php
                            }
                            ?>
    				</select>
				</div>
				<div class="join-input">
					<input type="text" class="" id="server_root" name="server_root"
						placeholder="서버경로" value="<?php echo $row['server_root']?>" />
				</div>
				<div class="join-input">
					<input type="text" class="datepicker" id="date_start"
						name="date_start" placeholder="시작일"
						value="<?php echo $row['date_start']?>" readonly="readonly" />
				</div>
				<div class="join-input">
					<input type="text" class="datepicker" id="date_end" name="date_end"
						placeholder="종료일" value="<?php echo $row['date_end']?>"
						readonly="readonly" />
				</div>
				<div class="join-input">
					<input type="text" class="" id="url" name="url" placeholder="URL"
						value="<?php echo $row['url']?>" />
				</div>
				<div class="join-input">
					<input type="text" class="" id="url_test" name="url_test"
						placeholder="테스트 URL" value="<?php echo $row['url_test']?>" />
				</div>
				<div class="join-input">
					<input type="text" class="" id="aws_cloud" name="aws_cloud"
						placeholder="아마존 클라우드" value="<?php echo $row['aws_cloud']?>" />
				</div>
				</div>
				<div class="join-box">
				<p class="join-intit">허가여부</p>
				<div class="join-input">
					<label class="ox_label"><input type="radio" class="ox_check" id="" name="per_yn" value="Y" />O</label><br>
					<label class="ox_label"><input type="radio" class="ox_check" id="" name="per_yn" value="N" />X</label>
				</div>
				</div>
				<div class="join-box">
					<p class="join-intit">결제여부</p>
					<div class="join-input">
						<label class="ox_label"><input type="radio" class="ox_check" id="" name="pay_yn" value="Y" />O</label><br>
						<label class="ox_label"><input type="radio" class="ox_check" id="" name="pay_yn" value="N" />X</label>
					</div>
				</div>
				<div class="join-box">
			    <p class="join-intit">승인메일전송</p>
				<div class="join-input">
					<label><input type="button" class="" id="" name="" onclick="allow_mail();" value="가입승인메일 보내기" /></label>
					<input type="hidden" class="" id="idx" name="" value="<?php echo $row['idx']?>"/>
				</div>
				<br/>
				<p class="join-intit">서버세팅완료 메일 전송</p>
				<div class="join-input">
					<label><input type="button" class="" id="" name="" onclick="server_mail();" value="서버세팅완료 메일 보내기" /></label>
					<input type="hidden" class="" id="idx" name="" value="<?php echo $row['idx']?>"/>
				</div>
				</div>
			</div>
		    <?php
		}
		?>

	<div class="modify_btn price_btn">
				<a class="del-btn" href="/mypage">취소</a> <a class="login-btn"
					href="javascript:fncSubmit();">수정</a>
			</div>
		</div>
	</form>
</div>

<div class="agree-popup-1 joine-popup">
	<div class="tb-">
		<div class="inner">
			<div class="agree-bg"></div>
			<div class="agree-cont">
				<div class="joine-div">
					<img src="/img/join-icon01.png" alt="회원수정 완료 아이콘" />
					<p class="color-g joine-tit">수정 되었습니다.</p>
					<div>
						<a href="/" class="login-btn">메인페이지 이동</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>