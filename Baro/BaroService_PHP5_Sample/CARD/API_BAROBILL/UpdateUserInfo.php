<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CARD.php'; ?>
<p>UpdateUserInfo - 사용자 정보 수정</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MemberName = '';		//담당자 성명
	$JuminNum = '';			//주민등록번호 ('-' 제외, 13자리)
	$TEL = '';				//전화번호
	$HP = '';				//휴대폰
	$Email = '';			//이메일
	$Grade = '';			//직급

	$Result = $BaroService_CARD->UpdateUserInfo(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'ID'			=> $ID,
		'MemberName'	=> $MemberName,
		'JuminNum'		=> $JuminNum,
		'TEL'			=> $TEL,
		'HP'			=> $HP,
		'Email'			=> $Email,
		'Grade'			=> $Grade
	))->UpdateUserInfoResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
