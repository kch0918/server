<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_BANKACCOUNT.php'; ?>
<p>GetBankAccount - 등록한 계좌번호 조회</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)

	$Result = $BaroService_BANKACCOUNT->GetBankAccount(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum
	))->GetBankAccountResult;

	if (array_key_exists('BankAccount',$Result) && !is_array($Result->BankAccount) && $Result->BankAccount->BankAccountNum < 0){ //실패
		echo $Result->BankAccount->BankAccountNum;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
