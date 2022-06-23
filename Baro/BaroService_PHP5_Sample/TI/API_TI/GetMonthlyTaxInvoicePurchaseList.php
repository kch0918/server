<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetMonthlyTaxInvoicePurchaseList - 월별 매입 세금계산서 조회 [국세청 전송완료 건만] (대표품목 포함)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$UserID = '';			//바로빌 회원 아이디
	$TaxType = 1;			//과세형태
	$DateType = 1;			//조회기준, 1:작성일자 2:발행일자
	$BaseMonth = '';		//기준월
	$CountPerPage = 10;		//한 페이지 당 조회 건 수
	$CurrentPage = 1;		//현재페이지
	$OrderDirection = 2;	//1:ASC 2:DESC

	$Result = $BaroService_TI->GetMonthlyTaxInvoicePurchaseList(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'UserID'			=> $UserID,
		'TaxType'			=> $TaxType,
		'DateType'			=> $DateType,
		'BaseMonth'			=> $BaseMonth,
		'CountPerPage'		=> $CountPerPage,
		'CurrentPage'		=> $CurrentPage,
		'OrderDirection'	=> $OrderDirection
	))->GetMonthlyTaxInvoicePurchaseListResult;

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
