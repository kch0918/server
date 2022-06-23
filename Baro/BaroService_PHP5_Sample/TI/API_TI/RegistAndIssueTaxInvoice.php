<?php //include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>

	<?php
	
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';		//인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';		//실서버 인증키

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

	//-------------------------------------------
	//수정사유코드
	//-------------------------------------------
	//공백-일반세금계산서, 1-기재사항의 착오 정정, 2-공급가액의 변동, 3-재화의 환입, 4-계약의 해제, 5-내국신용장 사후개설, 6-착오에 의한 이중발행
	//-------------------------------------------
	$ModifyCode = '';
	$Kwon = htmlspecialchars(addslashes($_POST['kwon']));								//별지서식 11호 상의 [권] 항목
	$Ho =htmlspecialchars(addslashes( $_POST['ho']));							       	//별지서식 11호 상의 [호] 항목
	$SerialNum = htmlspecialchars(addslashes($_POST['serial_num']));					//별지서식 11호 상의 [일련번호] 항목

	//-------------------------------------------
	//공급가액 총액
	//-------------------------------------------
	$AmountTotal = htmlspecialchars(addslashes($_POST['amount2']));

	//-------------------------------------------
	//세액합계
	//-------------------------------------------
	//$TaxType 이 2 또는 3 으로 셋팅된 경우 0으로 입력
	//-------------------------------------------
	$TaxTotal = $AmountTotal/10;

	//-------------------------------------------
	//합계금액
	//-------------------------------------------
	//공급가액 총액 + 세액합계 와 일치해야 합니다.
	//-------------------------------------------
	$TotalAmount = $AmountTotal+$TaxTotal;

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
	//69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB
	$MgtNum=htmlspecialchars(addslashes($_POST['mgt_num']));
	$CorpNum=htmlspecialchars(addslashes($_POST['corp_num']));
	$TaxRegID=htmlspecialchars(addslashes($_POST['tax_reg_id']));
	$CorpName=htmlspecialchars(addslashes($_POST['corp_name']));
	$CEOName=htmlspecialchars(addslashes($_POST['ceo_name']));
	$Addr=htmlspecialchars(addslashes($_POST['addr']));
	$BizType=htmlspecialchars(addslashes($_POST['biz_type']));
	$BizClass=htmlspecialchars(addslashes($_POST['biz_class']));
	$ContactName=htmlspecialchars(addslashes($_POST['contact_name']));
	$TEL=htmlspecialchars(addslashes($_POST['tel']));
	$Email=htmlspecialchars(addslashes($_POST['email']));
	$Name=htmlspecialchars(addslashes($_POST['item']));
	
	$InvoicerParty = array(
	    'MgtNum' 		=> $MgtNum,	//필수입력 - 연동사부여 문서키
	    'CorpNum' 		=> '8088800950',	//필수입력 - 바로빌 회원 사업자번호 ('-' 제외, 10자리)
		'TaxRegID' 		=> '',
		
		'CorpName' 		=> '뮤자인',				//필수입력
		'CEOName' 		=> '이호걸',				//필수입력
		'Addr' 			=> '서울특별시 강동구 성안로 156 우주빌딩',
		'BizType' 		=> '정보서비스업,도매및소매업',
		'BizClass' 		=> '시스템 소프트웨어 개발 및 공급',
		
		'ContactID' 	=> 'musign',				//필수입력 - 담당자 바로빌 아이디
		'ContactName' 	=> '이수린',				        //필수입력
		'TEL' 			=> '070-7763-6740',
		'HP' 			=> '02-476-6740',
		'Email' 		=> 'rininini90@musign.net'		//필수입력
	);

	//-------------------------------------------
	//공급받는자 정보 - 역발행시 세금계산서 작성자
	//------------------------------------------
	
	$InvoiceeParty = array(
	    'MgtNum' 		=> '',
	    'CorpNum' 		=> $CorpNum,				//필수입력
	    'TaxRegID' 		=> $TaxRegID,
	    'CorpName' 		=> $CorpName,				//필수입력
	    'CEOName' 		=> $CEOName,				//필수입력
	    'Addr' 			=> $Addr,
	    'BizType' 		=> $BizType,
	    'BizClass' 		=> $BizClass,
		'ContactID' 	=> $_SESSION['login_id'],
	    'ContactName' 	=> $ContactName,				//필수입력
	    'TEL' 			=> $TEL,
		'HP' 			=> '',
	    'Email' 		=> $Email
	);

	//-------------------------------------------
	//수탁자 정보 - 입력하지 않음
	//------------------------------------------
	$BrokerParty = array(
		'MgtNum' 		=> '',
		'CorpNum' 		=> '',
		'TaxRegID' 		=> '',
		'CorpName' 		=> '',
		'CEOName' 		=> '',
		'Addr' 			=> '',
		'BizType' 		=> '',
		'BizClass' 		=> '',
		'ContactID' 	=> '',
		'ContactName' 	=> '',
		'TEL' 			=> '',
		'HP' 			=> '',
		'Email' 		=> ''
	);

	//-------------------------------------------
	//품목
	//-------------------------------------------
	$today = date("Ymd");
	
	$TaxInvoiceTradeLineItems = array(
		'TaxInvoiceTradeLineItem'	=> array(
			array(
			    'PurchaseExpiry'=> $today,			//YYYYMMDD
			    'Name'			=> $Name,
				'Information'	=> '',
				'ChargeableUnit'=> '1',
				'UnitPrice'		=> $AmountTotal,
				'Amount'		=> $AmountTotal,
				'Tax'			=> $TaxTotal,
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

	//-------------------------------------------

	$SendSMS = false;							//문자 발송여부 (공급받는자 정보의 HP 항목이 입력된 경우에만 발송됨)

	$ForceIssue = false;						//가산세가 예상되는 세금계산서 발행 여부
	
	$MailTitle = '';							//전송되는 이메일의 제목 설정 (공백 시 바로빌 기본 제목으로 전송됨)

	//-------------------------------------------

	//정발행
	$Result = $BaroService_TI->RegistAndIssueTaxInvoice(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $TaxInvoice['InvoicerParty']['CorpNum'],
		'Invoice'	=> $TaxInvoice,
		'SendSMS'	=> $SendSMS,
		'ForceIssue'=> $ForceIssue,
		'MailTitle'	=> $MailTitle,
	))->RegistAndIssueTaxInvoiceResult;

	//echo $Result;
	
	if ($Result=='1') {
	    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 
	    
	    $query = "insert into invoice_payment
                set
                mgt_num = '{$MgtNum}',
                cust_no = '{$_SESSION['idx']}',
                corp_num = '{$CorpNum}',
                tax_reg_id='{$TaxRegID}',
                corp_name='{$CorpName}',
                ceo_name='{$CEOName}',
                addr='{$Addr}',
                biz_type='{$BizType}',
                biz_class='{$BizClass}',
                contact_name='{$ContactName}',
                tel='{$TEL}',
                email='{$Email}',
                item='{$Name}',
                amount='{$AmountTotal}',
                tax='{$TaxTotal}',
                total_amount='{$TotalAmount}',
                submit_date = now()+0
              ";
	    sql_query($query);
	}
	
	//정말 전자세금 계산서가 갔느지 유효성 체크 $query와 $Result로 if문 이용해서 조절
	
?>

{
	"isSuc":"success",
	"msg":"세금계산서가 발행 되었습니다."
}
