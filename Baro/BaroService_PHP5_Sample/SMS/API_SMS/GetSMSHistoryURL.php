<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>GetSMSHistoryURL - 문자 전송내역 URL</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$ID = '';			//바로빌 회원 아이디		
	$PWD = '';			//계사업자 담당자 비밀번호

	$Result = $BaroService_SMS->GetSMSHistoryURL(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'ID'		=> $ID,
		'PWD'		=> $PWD
	))->GetSMSHistoryURLResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
