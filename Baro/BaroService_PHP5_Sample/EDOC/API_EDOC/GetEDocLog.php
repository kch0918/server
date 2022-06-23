<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>GetEDocLog - 문서 이력</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_EDOC->GetEDocLog(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'UserID'	=> $ID,
		'MgtKey'	=> $MgtKey
	))->GetEDocLogResult->InvoiceLog;

	if (!is_array($Result) && $Result->Seq < 0){ //실패
		echo $Result->Seq;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
