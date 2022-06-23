<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_BANKACCOUNT.php'; ?>
<p>GetMonthlyBankAccountLog - 월별 계좌 입출금내역 조회</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$BankAccountNum = '';	//계좌번호
	$BaseMonth = '';		//기준월
	$CountPerPage = 10;		//한 페이지 당 조회 건 수
	$CurrentPage = 1;		//현재페이지
	$OrderDirection = 2;	//1:ASC 2:DESC

	$Result = $BaroService_BANKACCOUNT->GetMonthlyBankAccountLog(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'ID'				=> $ID,
		'BankAccountNum'	=> $BankAccountNum,
		'BaseMonth'			=> $BaseMonth,
		'CountPerPage'		=> $CountPerPage,
		'CurrentPage'		=> $CurrentPage,
		'OrderDirection'	=> $OrderDirection
	))->GetMonthlyBankAccountLogResult;

	if ($Result->CurrentPage < 0) { //실패
		echo $Result->CurrentPage;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
