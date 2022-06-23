<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>IssueEDoc - 발행</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키
	$SMSSendYN = false;		//발행 알림문자 전송여부 (발행비용과 별도로 과금됨)	
	$Memo = '';				//발행 시 공급받는자에게 전달할 메모.
	$MailTitle = '';		//발행 알림메일의 제목 (공백이나 Null의 경우 바로빌 기본값으로 전송됨.)

	$Result = $BaroService_EDOC->IssueEDoc(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
		'SMSSendYN'		=> $SMSSendYN,
		'Memo'			=> $Memo,
		'MailTitle'		=> $MailTitle
	))->IssueEDocResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
