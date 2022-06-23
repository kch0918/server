<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CORPSTATE.php'; ?>
<p>GetCorpMemberContacts - 회원사 담당자 목록</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CheckCorpNum = '';		//확인할 사업자번호 ('-' 제외, 10자리)

	$Result = $BaroService_CORPSTATE->GetCorpMemberContacts(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'CheckCorpNum'	=> $CheckCorpNum
	))->GetCorpMemberContactsResult->Contact;

	if (!is_array($Result) && $Result->ContactName < 0){ //실패
		echo $Result->ContactName;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
