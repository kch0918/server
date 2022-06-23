<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>GetChargeUnitCost - 요금 단가 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ChargeCode = 12;		//1:세금계산서 2:계산서 3:거래명세서 4:입금표 5:청구서 6:견적서 7:영수증 8:발주서 9:현금영수증 11:SMS전송 12:FAX전송 13:LMS전송 14:MMS전송

	$Result = $BaroService_FAX->GetChargeUnitCost(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'ChargeCode'	=> $ChargeCode
	))->GetChargeUnitCostResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
