<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>ChangeCorpManager - 회원사 관리자 변경</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';      //바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$ReceiptNum = '';	//바로빌부여 다량전송키

	$Result = $BaroService_SMS->GetMessagesByReceiptNum(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'ReceiptNum'	=> $ReceiptNum
	))->GetMessagesByReceiptNumResult->SMSMessage;

	if (!is_array($Result) && $Result->SendState < 0){ //실패
		echo $Result->SendState;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>

