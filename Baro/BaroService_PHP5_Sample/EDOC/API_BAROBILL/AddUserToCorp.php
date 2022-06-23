<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>AddUserToCorp - 사용자 추가</p>
<p class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MemberName = '';		//담당자 성명
	$JuminNum = '';			//주민등록번호 ('-' 제외, 13자리)
	$ID = '';				//바로빌 회원 아이디
	$PWD = '';				//바로빌 회원 비밀번호 (6~20자만 가능)
	$Grade = '';			//직급
	$TEL = '';				//전화번호
	$HP = '';				//휴대폰
	$Email = '';			//이메일

	$Result = $BaroService_EDOC->AddUserToCorp(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MemberName'	=> $MemberName,
		'JuminNum'		=> $JuminNum,
		'ID'			=> $ID,
		'PWD'			=> $PWD,
		'Grade'			=> $Grade,
		'TEL'			=> $TEL,
		'HP'			=> $HP,
		'Email'			=> $Email
	))->AddUserToCorpResult;
	
	echo $Result;
	?>
</p>
<?php include '../../_include/bottom.php'; ?>
