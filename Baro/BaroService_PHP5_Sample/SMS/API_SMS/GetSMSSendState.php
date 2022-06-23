<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>GetSMSSendState - 문자 전송 상태 (바로빌부여 전송키)</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$SendKey = '';      //바로빌부여 전송키

	$Result = $BaroService_SMS->GetSMSSendState(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'RefKey'	=> $SendKey
	))->GetSMSSendStateResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
