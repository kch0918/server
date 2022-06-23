<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>CheckMgtKeyIsExists - 연동사부여 문서키 사용여부 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키

	$Result = $BaroService_EDOC->CheckMgtKeyIsExists(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'UserID'	=> $ID,
		'MgtKey'	=> $MgtKey,
	))->CheckMgtKeyIsExistsResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
