<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>DeleteAttachFile - 첨부파일 전체삭제</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_TI->DeleteAttachFile(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey
	))->DeleteAttachFileResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
