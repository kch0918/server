<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetTaxInvoicesPrintURL - 대량인쇄 팝업 URL (연동사부여 문서키)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$PWD = '';				//바로빌 회원 비밀번호
	$MgtKeyList = array(	//연동사부여 문서키 배열
		'',
		''
	);

	$Result = $BaroService_TI->GetTaxInvoicesPrintURL(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKeyList'	=> $MgtKeyList,
		'ID'			=> $ID,
		'PWD'			=> $PWD				
	))->GetTaxInvoicesPrintURLResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
