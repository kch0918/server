<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>MakeDocLinkage - 문서 연결</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$FromDocType = 1;		//원본 문서의 종류 : 1-세금계산서, 2-계산서
	$FromMgtKey = '';		//원본 연동사부여 문서키
	$ToDocType = 1;			//대상 문서의 종류 : 1-세금계산서, 2-계산서, 3-전자문서
	$ToMgtKey = '';			//대상 연동사부여 문서키

	$Result = $BaroService_TI->MakeDocLinkage(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'FromDocType'	=> $FromDocType,
		'FromMgtKey'	=> $FromMgtKey,
		'ToDocType'		=> $ToDocType,
		'ToMgtKey'		=> $ToMgtKey
	))->MakeDocLinkageResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
