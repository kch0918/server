<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
$agree_chk = $_REQUEST['agree_chk'];
if($agree_chk != "Y"){
    alert('잘못된 접근입니다.');
    href('/');
}
?>
<script>
var phone_regExp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})[0-9]{3,4}[0-9]{4}$/;
var email_regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var id_regExp = /^[a-zA-Z0-9]{4,20}$/;
$(function(){
	$(".agree-popup-1").hide();
	$(".agree-bg").click(function(){
		$(".agree-popup-1").hide();
		$(".agree-div").html("");
	})

	   $("#insNum1").keyup(function(){ 	
	    	var value = $(this).val()	
	    	if (value.length == 3) {
	    		$("#insNum2").focus();
	    	}
	    });
	    
	    $("#insNum2").keyup(function(){ 	
	    	var value = $(this).val()	
	    	if (value.length == 4) {
	    		$("#insNum3").focus();
	    	}
	    });
	    
	    $("#insNum3").keyup(function(){ 	
	    	var value = $(this).val()	
	    	if (value.length == 4) {
	    		$("#insNum4").focus();
	    	}
	    }); 
})
function fncSubmit()
{
	var validationFlag = "Y";
	if($("#user_id").val() != "" && !id_regExp.test($("#user_id").val())){
		alert("잘못된 아이디형식 입니다.");
		$("#user_id").val('');
		$("#user_id").focus();
		validationFlag = "N";
		return false;
	}

	var musign_yn  =  $("input:radio[name='musign_yn']:checked").val();	

	// 비밀번호 형식 검사
	var pw = $("#user_pw").val();
	var id = $("#user_id").val();
    var checkNumber = pw.search(/[0-9]/g);
    var checkEnglish = pw.search(/[a-z]/ig);

	if($("#user_id").val() == "" && !id_regExp.test($("#user_id").val())) {
		alert('아이디를 입력해주세요.');
		$("#user_id").focus();
        return;
	}else if(!/^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,25}$/.test(pw)){            
        alert('비밀번호는 숫자+영문자+특수문자 조합으로 8자리 이상 사용해야 합니다.');
        $("#user_pw").val('');
		$("#user_pw").focus();
        return;
        
    }else if(checkNumber <0 || checkEnglish <0){
        alert("숫자와 영문자를 혼용하여야 합니다.");
        $("#user_pw").val('');
		$("#user_pw").focus();
        return;
        
    }else if(/(\w)\1\1\1/.test(pw)){
        alert('같은 문자를 4번 이상 사용하실 수 없습니다.');
        $("#user_pw").val('');
		$("#user_pw").focus();
        return;
        
    }else if(pw.search(id) > -1){
        alert("비밀번호에 아이디가 포함되었습니다.");
        $("#user_pw").val('');
		$("#user_pw").focus();
        return;
    }
	
	if($("#user_pw").val() != $("#re_user_pw").val()){
		alert("비밀번호를 확인해주세요");
		$("#re_user_pw").val('');
		$("#re_user_pw").focus();
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
	$(".notEmpty").each(function()
	{
		if ($(this).val() == "") 
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
			data : {
				musign_yn : musign_yn
			},
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
	    		}
			}
		});
	}
}
</script>
<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>
<div class="login-box join-view">
	<form id="fncForm" action="join_proc.php">
	<h2 class="text-center">join</h2>
	<div class="login-wr">
		<div class="join-box">
			<p class="join-intit">아이디 (필수)</p>
			<div class="join-input">
				<input data-name="아이디" type="text" class="notEmpty" id="user_id" name="user_id" placeholder="아이디 입력"/>
				<br><span>4 ~ 20 자리의 영문, 숫자</span>
			</div>
		</div>
		<div class="join-box">
			<p class="join-intit">비밀번호 (필수)</p>
			<div class="join-input">
				<input data-name="비밀번호" type="password" class="notEmpty" id="user_pw" name="user_pw" placeholder="비밀번호는 숫자+영문자+특수문자 조합으로 8자리 이상 사용해야 합니다."/>
    			<br><span>4 ~ 20 자리</span>
			</div>
			<div class="join-input">
				<input data-name="비밀번호 확인" type="password" class="notEmpty" id="re_user_pw" name="re_user_pw" placeholder="비밀번호 재입력"/>
			</div>
		</div>
		<div class="join-box">
			<p class="join-intit">고객정보 (필수)</p>
			<div class="join-input">
				<input data-name="회사명" type="text" class="notEmpty" id="user_co" name="user_co" placeholder="회사명"/>
			</div>
			<div class="join-input">
				<input data-name="담당자 성함" type="text" class="notEmpty" id="user_name" name="user_name" placeholder="담당자 성함"/>
			</div>
			<div class="join-input">
				<input data-name="담당자 연락처" type="tel" class="notEmpty" id="user_phone" name="user_phone" placeholder="담당자 연락처"/>
				<p class="join-intit join-desc">' - ' 를 제외하고 입력해주세요.</p>
			</div>
			<div class="join-input">
				<input data-name="담당자 이메일" type="email" class="notEmpty" id="user_email" name="user_email" placeholder="담당자 이메일"/>
			</div>
			<br/>
			<br/>
			<p class="join-intit ">뮤자인내에서 홈페이지 구축 여부 (필수)</p>
				<div class="join-input">
					<label class="ox_label"><input type="radio" class="ox_check" id="" name="musign_yn" value="Y" />O</label><br>
					<label  class="ox_label"s><input type="radio" class="ox_check" id="" name="musign_yn" value="N" />X (최초설치비 10만원 추가금액 발생)</label>
				</div><br/><br/>			
		</div>
		<div class="join_page_btn">
			<a class="login-btn" href="javascript:fncSubmit();">가입하기</a>
		</div>
	</div>
	</form>
</div>

<div class="agree-popup-1 joine-popup">
	<div class="tb-">
		<div class="inner">
        	<div class="agree-cont box">
        		<div class="joine-div">
        			<img src="/img/join-icon01.png" alt="회원가입 완료 아이콘"/>
        			<p class="color-g joine-tit">회원가입 신청이 완료되었습니다.</p>
        			<p class="joine-stit">회원가입 시 입력하신 이메일 주소로 가입승인 메일이 발송되며, <br>승인이 완료된 이후 이용하실 수 있습니다.</p>
        			<div><a href="/" class="login-btn">확인</a></div>
        		</div>
        	</div>
		</div>
	</div>
	<div class="agree-bg"></div>

</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>