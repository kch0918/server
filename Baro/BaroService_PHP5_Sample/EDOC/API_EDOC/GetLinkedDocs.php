<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>GetLinkedDocs - 연결된 문서 목록</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$DocType = '3';			//원본 문서의 종류 : 3-전자문서
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_EDOC->GetLinkedDocs(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'DocType'	=> $DocType,
		'MgtKey'	=> $MgtKey
	))->GetLinkedDocsResult;

	if (array_key_exists('LinkedDoc',$Result) && !is_array($Result->LinkedDoc) && $Result->LinkedDoc->DocType < 0){ //실패
		echo $Result->LinkedDoc->DocType;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
