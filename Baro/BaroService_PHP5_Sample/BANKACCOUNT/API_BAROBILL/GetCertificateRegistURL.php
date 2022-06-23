<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_BANKACCOUNT.php'; ?>
<p>GetCertificateRegistURL - 공인인증서 등록 URL</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$PWD = '';				//바로빌 회원 비밀번호

	$Result = $BaroService_BANKACCOUNT->GetCertificateRegistURL(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum, 
		'ID'		=> $ID, 
		'PWD'		=> $PWD
	))->GetCertificateRegistURLResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
