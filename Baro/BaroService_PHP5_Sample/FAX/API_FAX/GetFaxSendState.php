<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>GetFaxSendState - 팩스 전송 상태 (바로빌부여 전송키)</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SendKey = '';      //바로빌부여 전송키

	$Result = $BaroService_FAX->GetFaxSendState(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SendKey'		=> $SendKey
	))->GetFaxSendStateResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>