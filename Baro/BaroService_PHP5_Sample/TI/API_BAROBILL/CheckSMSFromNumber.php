<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>CheckSMSFromNumber - 발신번호 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$FromNumber = '';		//문자 발신번호

	$Result = $BaroService_TI->CheckSMSFromNumber(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'FromNumber'	=> $FromNumber
	))->CheckSMSFromNumberResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
