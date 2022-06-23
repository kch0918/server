<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>CancelEDoc - 발행취소</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키
	$Memo = '';				//발행취소 시 공급받는자에게 전달할 메모.

	$Result = $BaroService_EDOC->CancelEDoc(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
		'Memo'			=> $Memo
	))->CancelEDocResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
