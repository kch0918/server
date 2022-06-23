<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
?>
<script>
$(function(){
	$(".agree-bg").click(function(){
		$(".agree-popup").hide();
		$(".agree-div").html("");
	})
			
})
function fncSubmit()
{
	var validationFlag = "Y";
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
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			$(".joine-popup").show();
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
	<form id="fncForm" action="find_pw_proc.php">
	<h2 class="text-center">비밀번호 찾기</h2>
	<div class="login-wr">
		<div class="join-box">
			<p class="join-intit">정보 확인</p>
			<div class="join-input">
				<input data-name="아이디" type="text" class="notEmpty" id="user_id" name="user_id" placeholder="아이디 입력"/>
			</div>
			<div class="join-input">
				<input data-name="담당자 이메일" type="email" class="notEmpty" id="user_email" name="user_email" placeholder="담당자 이메일"/>
			</div>
		</div>
		<div>
			<a class="login-btn" href="javascript:fncSubmit();">비밀번호 찾기</a>
		</div>
		<div class="log-fot table">

			<div class="log-r">
				<a href="/member/login.php" >로그인</a>
				<a href="./join_agreement.php" >회원가입</a>
				<a href="find_pw_view.php" >비밀번호 찾기</a>
			</div>
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
        			<img src="/img/join-icon01.png" alt="회원가입 완료 아이콘"/>
        			<p class="color-g joine-tit">비밀번호 찾기 신청이 완료되었습니다.</p>
        			<p class="joine-stit">입력하신 이메일 주소로 메일이 발송되오니, <br>확인후 이용해 주시기 바랍니다.</p>
        			<div><a href="./login.php" class="login-btn">로그인 페이지</a><a href="./find_id_view.php" class="login-btn">아이디 찾기</a></div>
        		</div>
        	</div>		
		</div>
	</div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>