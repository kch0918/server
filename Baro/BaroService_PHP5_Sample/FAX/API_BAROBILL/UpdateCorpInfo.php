<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>UpdateCorpInfo - 회원사 정보 수정</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CorpName = '';			//회사명
	$CEOName = '';			//대표자명
	$BizType = '';			//업태
	$BizClass = '';			//업종
	$PostNum = '';			//우편번호
	$Addr1 = '';			//주소1 (ex. 서울특별시 양천구 목1동)
	$Addr2 = '';			//주소2 (ex. SBS방송센터 920)

	$Result = $BaroService_FAX->UpdateCorpInfo(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'CorpName'	=> $CorpName,
		'CEOName'	=> $CEOName,
		'BizType'	=> $BizType,
		'BizClass'	=> $BizClass,
		'PostNum'	=> $PostNum,
		'Addr1'		=> $Addr1,
		'Addr2'		=> $Addr2
	))->UpdateCorpInfoResult;
			
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
