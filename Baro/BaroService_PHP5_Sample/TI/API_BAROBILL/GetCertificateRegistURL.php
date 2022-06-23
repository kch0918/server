<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetCertificateRegistURL - 공인인증서 등록 URL</p>
<div class="result">
	<?php
	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//인증키
	$CorpNum = '8088800950';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = 'musign';				//바로빌 회원 아이디
	$PWD = 'casanova1!';				//바로빌 회원 비밀번호

	$Result = $BaroService_TI->GetCertificateRegistURL(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum, 
		'ID'		=> $ID, 
		'PWD'		=> $PWD
	))->GetCertificateRegistURLResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
