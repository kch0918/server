<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetDailyTaxInvoiceSalesList - 일별 매출 세금계산서 조회 [국세청 전송완료 건만] (대표품목 포함)</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$UserID = '';			//바로빌 회원 아이디
	$TaxType = 1;			//과세형태
	$DateType = 1;			//조회기준, 1:작성일자 2:발행일자
	$BaseDate = '';			//기준날짜
	$CountPerPage = 10;		//페이지당 갯수
	$CurrentPage = 1;		//현재페이지

	$Result = $BaroService_TI->GetDailyTaxInvoiceSalesList(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $UserID,
		'TaxType'		=> $TaxType,
		'DateType'		=> $DateType,
		'BaseDate'		=> $BaseDate,
		'CountPerPage'	=> $CountPerPage,
		'CurrentPage'	=> $CurrentPage
	))->GetDailyTaxInvoiceSalesListResult;
	
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
