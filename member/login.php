<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
?>
<script>
function enter_check_login()
{
	if(event.keyCode == 13){
		login();
		return;
	}
}
function login()
{
	if($("#login_id").val() == "")
	{
		alert("아이디를 입력해주세요.");
		$("#login_id").focus();
		return;
	}
	if($("#login_pw").val() == "")
	{
		alert("비밀번호를 입력해주세요.");
		$("#login_pw").focus();
		return;
	}
	$("#loginForm").ajaxSubmit({
		success: function(data)
		{
			console.log(data);
    		var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert('환영합니다.');
    			location.href="/mypage";
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
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>
<div class="login-box">
	<h2 class="text-center">login</h2>
	<div class="login-wr">
		<form id="loginForm" name="loginForm" method="post" action="login_proc.php">
    		<div><input type="text" placeholder="아이디" id="login_id" name="login_id"/></div>
    		<div><input type="password" placeholder="비밀번호" id="login_pw" name="login_pw" onkeydown="javascript:enter_check_login();"/></div>
		</form>
		<div><a href="javascript:login();" class="login-btn">로그인</a></div>
		<div class="log-fot table">
			<div class="log-l">
				<a href="./join_agreement.php" >회원가입</a>
			</div>
			<div class="log-r">
				<a href="find_id_view.php" >아이디찾기</a>
				<a href="find_pw_view.php" >비밀번호 찾기</a>
			</div>
		</div>
	</div>
</div>

<div class="login-bot text-center">
	<p class="care-tit">회원가입 후 간단한 승인절차 후 이용 가능합니다.</p>
	<div class="log-prc table">
		<div class="log-ic">
			<img src="/img/login-icon02.png" alt="뮤자인 로그인"/>회원가입
		</div>
		<div class="log-ic">
			<img src="/img/login-icon03.png" alt="뮤자인 로그인"/>승인요청<span>(담당자 확인)</span>
		</div>
		<div class="log-ic">
			<img src="/img/login-icon04.png" alt="뮤자인 로그인"/>승인<span>(승인메일 발송)</span>
		</div>
		<div class="log-ic">
			<img src="/img/login-icon05.png" alt="뮤자인 로그인"/>완료
		</div>
	</div>
	<div class="log-ptxt">
		<p class="log-ptit color-g">뮤자인 서버 담당자</p>
		<p class="log-stit ser-name">정기영 책임</p>
		<p>Tel. <span class="ser-tel">070-8645-0123</span></p>
		<p>E-mail. <span class="ser-tel">chaplin@musign.net</span></p>
	</div>
</div>



<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>