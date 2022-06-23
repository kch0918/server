<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CORPSTATE.php'; ?>
<p>GetBalanceCostAmount - 잔여포인트 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	
	$Result = $BaroService_CORPSTATE->GetBalanceCostAmount(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum
	))->GetBalanceCostAmountResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
