<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>AttachFileByFTP - 파일 첨부</p>
<div class="result">
	<?php
	//바로빌로부터 부여받은 FTP에 FileName 의 이름으로 전송할 파일을 업로드하는 코드를 구현한다.

	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키
	$FileName = '';			//첨부할 파일명
	$DisplayFileName = '';	//다운로드시 보여질 파일명

	$Result = $BaroService_EDOC->AttachFileByFTP(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'UserID'			=> $ID,
		'MgtKey'			=> $MgtKey,
		'FileName'			=> $FileName,
		'DisplayFileName'	=> $DisplayFileName
	))->AttachFileByFTPResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
