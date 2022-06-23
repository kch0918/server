<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetNTSSendOption - 국세청 전송설정 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	
	$Result = $BaroService_TI->GetNTSSendOption(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum
	))->GetNTSSendOptionResult;

	if ($Result->TaxationOption < 0){ //실패
		echo $Result->TaxationOption;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
