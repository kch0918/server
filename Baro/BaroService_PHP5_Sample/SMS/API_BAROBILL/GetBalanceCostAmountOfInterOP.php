<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>GetBalanceCostAmountOfInterOP - 연동사포인트 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키	

	$Result = $BaroService_SMS->GetBalanceCostAmountOfInterOP(array(
		'CERTKEY'	=> $CERTKEY
	))->GetBalanceCostAmountOfInterOPResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>