<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CORPSTATE.php'; ?>
<p>CheckCorpIsMember - 회원사 여부 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CheckCorpNum = '';		//확인할 사업자번호 ('-' 제외, 10자리) 

	$Result = $BaroService_CORPSTATE->CheckCorpIsMember(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'CheckCorpNum'	=> $CheckCorpNum
	))->CheckCorpIsMemberResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
