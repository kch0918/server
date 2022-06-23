<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>IssueTaxInvoice - 발행</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey = '';			//연동사부여 문서키
	$SendSMS = false;		//발행 알림문자 전송여부 (발행비용과 별도로 과금됨)
	$NTSSendOption = 1;		//현재 사용되지 않는 항목으로 1을 입력하면 된다.
	$ForceIssue = false;	//가산세 부과 여부에 상관없이 발행할지 여부
	$MailTitle = '';		//발행 알림메일의 제목 (공백이나 Null의 경우 바로빌 기본값으로 전송됨.)

	$Result = $BaroService_TI->IssueTaxInvoice(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey,
		'SendSMS'		=> $SendSMS,
		'NTSSendOption'	=> $NTSSendOption,
		'ForceIssue'	=> $ForceIssue,
		'MailTitle'		=> $MailTitle
	))->IssueTaxInvoiceResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
