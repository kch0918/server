<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>RegistTaxInvoice - 일반세금계산서 등록</p>
<div class="result">
	<?php
	$CERTKEY = '';							//인증키

	$IssueDirection = 1;					//1-정발행, 2-역발행(위수탁 세금계산서는 정발행만 허용)
	$TaxInvoiceType = 1;					//1-세금계산서, 2-계산서, 4-위수탁세금계산서, 5-위수탁계산서

	//-------------------------------------------
	//과세형태
	//-------------------------------------------
	//TaxInvoiceType 이 1,4 일 때 : 1-과세, 2-영세
	//TaxInvoiceType 이 2,5 일 때 : 3-면세
	//-------------------------------------------
	$TaxType = 1;
	$TaxCalcType = 1;						//세율계산방법 : 1-절상, 2-절사, 3-반올림

	$PurposeType = 2;						//1-영수, 2-청구
	
	$Kwon = '';								//별지서식 11호 상의 [권] 항목
	$Ho = '';								//별지서식 11호 상의 [호] 항목
	$SerialNum = '';						//별지서식 11호 상의 [일련번호] 항목

	//-------------------------------------------
	//공급가액 총액
	//-------------------------------------------
	$AmountTotal = '';

	//-------------------------------------------
	//세액합계
	//-------------------------------------------
	//$TaxType 이 2 또는 3 으로 셋팅된 경우 0으로 입력
	//-------------------------------------------
	$TaxTotal = '';

	//-------------------------------------------
	//합계금액
	//-------------------------------------------
	//공급가액 총액 + 세액합계 와 일치해야 합니다.
	//-------------------------------------------
	$TotalAmount = '';
	
	$Cash = '';								//현금
	$ChkBill = '';							//수표
	$Note = '';								//어음
	$Credit = '';							//외상미수금

	$Remark1 = '';
	$Remark2 = '';
	$Remark3 = '';

	$WriteDate = '';						//작성일자 (YYYYMMDD), 공백입력 시 Today로 작성됨.

	//-------------------------------------------
	//공급자 정보 - 정발행시 세금계산서 작성자
	//------------------------------------------
	$InvoicerParty = array(
		'MgtNum' 		=> '',				//정발행시 필수입력 - 연동사부여 문서키
		'CorpNum' 		=> '',				//필수입력 - 바로빌 회원 사업자번호 ('-' 제외, 10자리) 
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',				//필수입력
		'CEOName' 		=> '',				//필수입력
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactID' 	=> '',				//필수입력 - 담당자 바로빌 아이디 
		'ContactName' 	=> '',				//필수입력
		'TEL' 			=> '',
		'HP' 			=> '',
		'Email' 		=> ''				//필수입력
	);

	//-------------------------------------------
	//공급받는자 정보 - 역발행시 세금계산서 작성자
	//------------------------------------------
	$InvoiceeParty = array(
		'MgtNum' 		=> '',				//역발행시 필수입력 - 연동사부여 문서키
		'CorpNum' 		=> '',				//필수입력
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',				//필수입력
		'CEOName' 		=> '',				//필수입력
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactID' 	=> '',				//역발행시 필수입력 - 담당자 바로빌 아이디
		'ContactName' 	=> '',				//필수입력
		'TEL' 			=> '',
		'HP' 			=> '',
		'Email' 		=> ''				//역발행시 필수입력
	);

	//-------------------------------------------
	//수탁자 정보 - 위수탁 발행시 세금계산서 작성자
	//------------------------------------------
	$BrokerParty = array(
		'MgtNum' 		=> '',				//위수탁발행시 필수입력 - 연동사부여 문서키
		'CorpNum' 		=> '',				//위수탁발행시 필수입력 - 바로빌 회원 사업자번호 ('-' 제외, 10자리)
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',				//위수탁발행시 필수입력
		'CEOName' 		=> '',				//위수탁발행시 필수입력
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactID' 	=> '',				//위수탁발행시 필수입력 - 담당자 바로빌 아이디
		'ContactName' 	=> '',				//위수탁발행시 필수입력	
		'TEL' 			=> '',
		'HP' 			=> '',
		'Email' 		=> ''				//위수탁발행시 필수입력	
	);

	//-------------------------------------------
	//품목
	//-------------------------------------------
	$TaxInvoiceTradeLineItems = array(
		'TaxInvoiceTradeLineItem'	=> array(
			array(
				'PurchaseExpiry'=> '',			//YYYYMMDD
				'Name'			=> '',
				'Information'	=> '',
				'ChargeableUnit'=> '',
				'UnitPrice'		=> '',
				'Amount'		=> '',
				'Tax'			=> '',
				'Description'	=> ''
			),
			array(
				'PurchaseExpiry'=> '',			//YYYYMMDD
				'Name'			=> '',
				'Information'	=> '',
				'ChargeableUnit'=> '',
				'UnitPrice'		=> '',
				'Amount'		=> '',
				'Tax'			=> '',
				'Description'	=> ''
			)
		)
	);

	//-------------------------------------------
	//전자세금계산서
	//-------------------------------------------
	$TaxInvoice = array(
		'InvoiceKey'				=> '',
		'InvoiceeASPEmail'			=> '',
		'IssueDirection'			=> $IssueDirection,
		'TaxInvoiceType'			=> $TaxInvoiceType,
		'TaxType'					=> $TaxType,
		'TaxCalcType'				=> $TaxCalcType,
		'PurposeType'				=> $PurposeType,
		'ModifyCode'				=> $ModifyCode,
		'Kwon'						=> $Kwon,
		'Ho'						=> $Ho,
		'SerialNum'					=> $SerialNum,
		'Cash'						=> $Cash,
		'ChkBill'					=> $ChkBill,
		'Note'						=> $Note,
		'Credit'					=> $Credit,
		'WriteDate'					=> $WriteDate,
		'AmountTotal'				=> $AmountTotal,
		'TaxTotal'					=> $TaxTotal,
		'TotalAmount'				=> $TotalAmount,
		'Remark1'					=> $Remark1,
		'Remark2'					=> $Remark2,
		'Remark3'					=> $Remark3,
		'InvoicerParty'				=> $InvoicerParty,
		'InvoiceeParty'				=> $InvoiceeParty,
		'BrokerParty'				=> $BrokerParty,
		'TaxInvoiceTradeLineItems'	=> $TaxInvoiceTradeLineItems
	);

	//정발행
	$Result = $BaroService_TI->RegistTaxInvoice(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $TaxInvoice['InvoicerParty']['CorpNum'],
		'Invoice'	=> $TaxInvoice
	))->RegistTaxInvoiceResult;
	/*
	//역발행
	$Result = $BaroService_TI->RegistTaxInvoiceReverse(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $TaxInvoice['InvoiceeParty']['CorpNum'],
		'Invoice'	=> $TaxInvoice
	))->RegistTaxInvoiceReverseResult;

	//위수탁
	$Result = $BaroService_TI->RegistBrokerTaxInvoice(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $TaxInvoice['BrokerParty']['CorpNum'],
		'Invoice'	=> $TaxInvoice
	))->RegistBrokerTaxInvoiceResult;
	*/

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
