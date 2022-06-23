<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CASHBILL.php'; ?>
<p>GetDailyCashBillPurchaseList - 일별 현금영수증 수취분 조회(매입) [국세청 전송완료 건만]</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$UserID = '';			//바로빌 회원 아이디
	$BaseDate = '';			//기준날짜
	$CountPerPage = 10;		//한 페이지 당 조회 건 수
	$CurrentPage = 1;		//현재페이지
	$OrderDirection = 2;	//1:ASC 2:DESC

	$Result = $BaroService_CASHBILL->GetDailyCashBillPurchaseList(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'UserID'			=> $UserID,
		'BaseDate'			=> $BaseDate,
		'CountPerPage'		=> $CountPerPage,
		'CurrentPage'		=> $CurrentPage,
		'OrderDirection'	=> $OrderDirection
	))->GetDailyCashBillPurchaseListResult;

	if ($Result->CurrentPage < 0){ //실패
		echo $Result->CurrentPage;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
