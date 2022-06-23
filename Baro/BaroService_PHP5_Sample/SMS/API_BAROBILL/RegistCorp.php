<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>RegistCorp - 회원사 추가</p>
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
	$MemberName = '';		//담당자 성명
	$JuminNum = '';			//주민등록번호 ('-' 제외, 13자리)
	$ID = '';				//바로빌 회원 아이디
	$PWD = '';				//바로빌 회원 비밀번호 (6~20자만 가능)
	$Grade = '';			//직급
	$TEL = '';				//전화번호
	$HP = '';				//휴대폰
	$Email = '';			//이메일

	$Result = $BaroService_SMS->RegistCorp(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'CorpName'		=> $CorpName,
		'CEOName'		=> $CEOName,
		'BizType'		=> $BizType,
		'BizClass'		=> $BizClass,
		'PostNum'		=> $PostNum,
		'Addr1'			=> $Addr1,
		'Addr2'			=> $Addr2,
		'MemberName'	=> $MemberName,
		'JuminNum'		=> $JuminNum,
		'ID'			=> $ID,
		'PWD'			=> $PWD,
		'Grade'			=> $Grade,
		'TEL'			=> $TEL,
		'HP'			=> $HP,
		'Email'			=> $Email
	))->RegistCorpResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
