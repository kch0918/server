<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>GetEDoc - 문서 정보</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_EDOC->GetEDoc(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'UserID'	=> $ID,
		'MgtKey'	=> $MgtKey
	))->GetEDocResult;

	if ($Result->EDocInvoiceType < 0){ //실패
		echo $Result->EDocInvoiceType;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
