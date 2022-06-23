<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetTaxInvoiceStatesEX - 문서 상태 (수신확인, 등록일시, 작성일자, 발행예정일시, 발행일시 추가) (대량, 100건 까지)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKeyList = array(	//연동사부여 문서키 배열
		'',
		''
	);

	$Result = $BaroService_TI->GetTaxInvoiceStatesEX(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKeyList'	=> $MgtKeyList
	))->GetTaxInvoiceStatesEXResult->TaxInvoiceStateEX;

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
