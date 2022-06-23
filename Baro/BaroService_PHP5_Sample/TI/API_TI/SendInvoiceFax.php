<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>SendInvoiceFax - 팩스 전송 (문서이력에 기록됨)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$MgtKey = '';			//연동사부여 문서키	
	$SenderID = '';			//바로빌 회원 아이디
	$FromFaxNumber = '';	//발신자 팩스 번호
	$ToFaxNumber = '';		//수신자 팩스 번호

	$Result = $BaroService_TI->SendInvoiceFax(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey,
		'SenderID'		=> $SenderID,
		'FromFaxNumber'	=> $FromFaxNumber,
		'ToFaxNumber'	=> $ToFaxNumber
	))->SendInvoiceFaxResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
