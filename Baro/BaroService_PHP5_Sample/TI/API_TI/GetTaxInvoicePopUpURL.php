<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetTaxInvoicePopUpURL - 문서 내용보기 팝업 URL (연동사부여 문서키)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$MgtKey = '';			//연동사부여 문서키
	$ID = '';				//바로빌 회원 아이디
	$PWD = '';				//바로빌 회원 비밀번호

	$Result = $BaroService_TI->GetTaxInvoicePopUpURL(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey,
		'ID'			=> $ID,
		'PWD'			=> $PWD
	))->GetTaxInvoicePopUpURLResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
