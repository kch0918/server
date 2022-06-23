<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>GetAttachedFileList - 첨부파일 목록</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_EDOC->GetAttachedFileList(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'UserID'	=> $ID,
		'MgtKey'	=> $MgtKey
	))->GetAttachedFileListResult;

	if (array_key_exists('AttachedFile',$Result) && !is_array($Result->AttachedFile) && $Result->AttachedFile->FileIndex < 0){ //실패
		echo $Result->AttachedFile->FileIndex;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
