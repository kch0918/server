<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>GetFaxHistoryURL - 팩스 전송내역 URL</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';			//바로빌 회원 아이디
	$PWD = '';			//바로빌 회원 비밀번호

	$Result = $BaroService_FAX->GetFaxHistoryURL(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'ID'		=> $ID,
		'PWD'		=> $PWD
	))->GetFaxHistoryURLResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>