<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>GetFaxFileURL - 팩스 파일 다운로드 URL</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$SendKey = '';		//바로빌부여 전송키
	$FileType = 1;		//1:원본파일 2:TIF(변환)파일 

	$Result = $BaroService_FAX->GetFaxFileURL(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'SendKey'	=> $SendKey,
		'FileType'	=> $FileType
	))->GetFaxFileURLResult;

	foreach($Result as $URL) {
		echo $URL.'<br>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>