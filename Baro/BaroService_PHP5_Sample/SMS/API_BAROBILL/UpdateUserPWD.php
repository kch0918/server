<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>UpdateUserPWD - 사용자 비밀번호 수정</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$newPWD = '';			//새 비밀번호 (6~20자만 가능)

	$Result = $BaroService_SMS->UpdateUserPWD(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'ID'		=> $ID,
		'newPWD'	=> $newPWD
	))->UpdateUserPWDResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
