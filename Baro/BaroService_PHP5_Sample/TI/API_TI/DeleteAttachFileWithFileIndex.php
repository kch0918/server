<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>DeleteAttachFileWithFileIndex - 첨부파일 삭제</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey = '';			//연동사부여 문서키
	$FileIndex = 0;			//삭제할 첨부파일의 인덱스 (GetAttachedFileList 로 확인된 인덱스)

	$Result = $BaroService_TI->DeleteAttachFileWithFileIndex(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,				
		'MgtKey'		=> $MgtKey,
		'FileIndex'		=> $FileIndex
	))->DeleteAttachFileWithFileIndexResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
