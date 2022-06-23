<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>GetFaxSendMessages - 팩스 대량확인A (바로빌부여 전송키)</p>
<div class="result">
	<?php
	$CERTKEY = '';				//인증키
	$CorpNum = '';				//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SendKeyList = array(		//바로빌부여 전송키 배열
		'',
		''
	);

	$Result = $BaroService_FAX->GetFaxSendMessages(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SendKeyList'	=> $SendKeyList
	))->GetFaxSendMessagesResult->FaxMessage;

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