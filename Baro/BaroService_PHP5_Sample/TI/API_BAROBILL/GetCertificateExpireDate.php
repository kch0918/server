<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetCertificateExpireDate - 등록한 공인인증서 만료일 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)

	$Result = $BaroService_TI->GetCertificateExpireDate(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum
	))->GetCertificateExpireDateResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
