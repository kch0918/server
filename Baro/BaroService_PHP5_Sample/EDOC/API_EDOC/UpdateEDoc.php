<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>UpdateEDoc - 수정</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$MgtKey = '';			//연동사부여 문서키
	$UserID = '';			//바로빌 회원 아이디 - 공급자 사업자번호($InvoicerParty.CorpNum)의 담당자 아이디

	$WriteDate = '';						//작성일자 (YYYYMMDD), 공백입력 시 Today로 작성됨.

	$CertYN = False;						//발행 시 공인인증서 확인 여부
	$AutoAcceptYN = False;					//발행 시 자동승인처리 여부
	$BusinessLicenseYN = False;				//발행 시 자동승인처리 여부
	$BankBookYN = False;					//발행 시 자동승인처리 여부

	//-------------------------------------------
	//과세형태
	//-------------------------------------------
	//거래명세서 : 1-과세, 2-영세, 3-면세
	//입금표 : 1-과세, 3-면세
	//그 외 : 0
	//-------------------------------------------
	$TaxType = 1;

	//-------------------------------------------
	//영수,청구
	//-------------------------------------------
	//거래명세서 : 1-영수, 2-청구
	//입금표, 영수증 : 1
	//청구서 : 2
	//견적서, 발주서 : 0
	//-------------------------------------------
	$PurposeType = 2;

	//-------------------------------------------
	//공급가액 총액
	//-------------------------------------------
	$AmountTotal = "";

	//-------------------------------------------
	//세액합계
	//-------------------------------------------
	//$TaxType 이 2 또는 3 으로 셋팅된 경우 0으로 입력
	//-------------------------------------------
	$TaxTotal = "";

	//-------------------------------------------
	//'합계금액
	//-------------------------------------------
	//공급가액 총액 + 세액합계 와 일치해야 합니다.
	//-------------------------------------------
	$TotalAmount = "";

	$Remark1 = "";
	$Remark2 = "";
	$Remark3 = "";
	$SerialNum = "";

	//-------------------------------------------
	//공급자 정보
	//------------------------------------------
	$EDocInvoicerParty = array(
		'CorpNum' 		=> '',				//필수입력 (바로빌 회원 사업자번호) ('-' 제외, 10자리)
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',				//필수입력
		'CEOName' 		=> '',				//필수입력
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactName' 	=> '',				//필수입력
		'DeptName'		=> '',
		'TEL' 			=> '',
		'HP' 			=> '',
		'FAX' 			=> '',
		'Email' 		=> ''				//필수입력
	);

	//-------------------------------------------
	//공급받는자 정보
	//------------------------------------------
	$EDocInvoiceeParty = array(
		'CorpNum' 		=> '',
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',				//필수입력
		'CEOName' 		=> '',
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactName' 	=> '',
		'DeptName'		=> '',
		'TEL' 			=> '',
		'HP' 			=> '',
		'FAX' 			=> '',
		'Email' 		=> ''
	);

	//-------------------------------------------
	//속성
	//-------------------------------------------
	//아래 3가지 속성은 "바로빌 기본 거래명세서 양식"의 속성입니다.
	//-------------------------------------------
	$EDocProperties = array(
		'EDocProperty'	=> array(
			array(
				'Name'			=> 'Balance',
				'Value'			=> '',
				'Description'	=> ''
			),
			array(
				'Name'			=> 'Deposit',
				'Value'			=> '',
				'Description'	=> ''
			),
			array(
				'Name'			=> 'CBalance',
				'Value'			=> '',
				'Description'	=> ''
			)
		)
	);

	//-------------------------------------------
	//품목
	//-------------------------------------------
	$EDocTradeLineItems = array(
		'EDocTradeLineItem'	=> array(
			array(
				'PurchaseExpiry'=> '',			//YYYYMMDD
				'Name'			=> '',
				'Information'	=> '',
				'ChargeableUnit'=> '',
				'UnitPrice'		=> '',
				'Amount'		=> '',
				'Tax'			=> '',
				'Description'	=> '',
				'Temp1'			=> '',
				'Temp2'			=> '',
				'Temp3'			=> '',
				'Temp4'			=> '',
				'Temp5'			=> ''
			),
			array(
				'PurchaseExpiry'=> '',			//YYYYMMDD
				'Name'			=> '',
				'Information'	=> '',
				'ChargeableUnit'=> '',
				'UnitPrice'		=> '',
				'Amount'		=> '',
				'Tax'			=> '',
				'Description'	=> '',
				'Temp1'			=> '',
				'Temp2'			=> '',
				'Temp3'			=> '',
				'Temp4'			=> '',
				'Temp5'			=> ''
			)
		)
	);

	//-------------------------------------------
	//전자문서
	//-------------------------------------------
	$EDoc = array(
		'MgtKey'			=> $MgtKey,
		'UserID'			=> $UserID,
		'InvoicerParty'		=> $EDocInvoicerParty,
		'InvoiceeParty'		=> $EDocInvoiceeParty,
		'EDocInvoiceType'	=> '',
		'CertYN'			=> $CertYN,
		'AutoAcceptYN'		=> $AutoAcceptYN,
		'BusinessLicenseYN'	=> $BusinessLicenseYN,
		'BankBookYN'		=> $BankBookYN,
		'WriteDate'			=> $WriteDate,
		'TaxType'			=> $TaxType,
		'PurposeType'		=> $PurposeType,
		'AmountTotal'		=> $AmountTotal,
		'TaxTotal'			=> $TaxTotal,
		'TotalAmount'		=> $TotalAmount,
		'Remark1'			=> $Remark1,
		'Remark2'			=> $Remark2,
		'Remark3'			=> $Remark3,
		'SerialNum'			=> $SerialNum,
		'EDocProperties'	=> $EDocProperties,
		'EDocTradeLineItems'=> $EDocTradeLineItems
	);

	$Result = $BaroService_EDOC->UpdateEDoc(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $EDoc['InvoicerParty']['CorpNum'],
		'UserID'	=> $EDoc['UserID'],
		'Invoice'	=> $EDoc
	))->UpdateEDocResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
