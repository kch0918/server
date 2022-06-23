<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>SendToNTS - 연동사부여 문서키 사용여부 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_TI->SendToNTS(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'MgtKey'	=> $MgtKey
	))->SendToNTSResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
