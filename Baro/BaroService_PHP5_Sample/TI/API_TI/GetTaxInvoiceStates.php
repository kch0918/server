<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetTaxInvoiceStates - 문서 상태(대량, 100건 까지) (연동사부여 문서키)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKeyList = array(	//연동사부여 문서키 배열
		'',
		''
	);

	$Result = $BaroService_TI->GetTaxInvoiceStates(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKeyList'	=> $MgtKeyList
	))->GetTaxInvoiceStatesResult->TaxInvoiceState;

	if (!is_array($Result) && $Result->BarobillState < 0){ //실패
		echo $Result->BarobillState;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
