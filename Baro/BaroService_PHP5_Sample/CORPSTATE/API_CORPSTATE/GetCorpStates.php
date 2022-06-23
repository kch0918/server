<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CORPSTATE.php'; ?>
<p>GetCorpStates - 휴폐업 조회 (대량)</p>
<div class="result">
	<?php
	$CERTKEY = '';				//인증키
	$CorpNum = '';				//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CheckCorpNumList = array(	//확인할 사업자번호 배열
		'',
		''
	);

	$Result = $BaroService_CORPSTATE->GetCorpStates(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'CheckCorpNumList'	=> $CheckCorpNumList
	))->GetCorpStatesResult->CorpState;

	if (!is_array($Result) && $Result->State < 0){ //실패
		echo $Result->State;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
