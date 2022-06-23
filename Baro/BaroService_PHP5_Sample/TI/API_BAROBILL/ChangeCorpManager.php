<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>ChangeCorpManager - 회원사 관리자 변경</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$newManagerID = '';		//새 관리자 아이디

	$Result = $BaroService_TI->ChangeCorpManager(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'newManagerID'	=> $newManagerID
	))->ChangeCorpManagerResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
