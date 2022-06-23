<?php include '../BaroService_CASHBILL.php'; ?>

	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';	 //인증	
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';	//실서버 인증키
	// 기본 값 세팅
	$HP                    = '';
	$Fax                   = '';
	$TradeType             = 'N';
	$CancelType            = '';
	$CancelNTSConfirmNum   = '';
	$CancelNTSConfirmDate  = '';	
	
	//공급자 정보 - 정발행시 세금계산서 작성자
	//------------------------------------------
	$MgtKey            =   htmlspecialchars(addslashes($_POST['cash_mgt_num']));
	$TradeDate         =   htmlspecialchars(addslashes($_POST['trade_date']));
	$Identity          =   htmlspecialchars(addslashes($_POST['identity']));
	$Identity_B        =   htmlspecialchars(addslashes($_POST['identity_b']));
	$Email             =   htmlspecialchars(addslashes($_POST['email']));
	$ItemName          =   htmlspecialchars(addslashes($_POST['item_name']));
	$TradeUsage        =   htmlspecialchars(addslashes($_POST['trade_usage']));
	$TradeMethod       =   htmlspecialchars(addslashes($_POST['trade_method']));
	$Amount            =   htmlspecialchars(addslashes($_POST['amount'])); 
	$Tax               =   $Amount/10;
	$ServiceCharge     =   $Amount/100;
	$Total_amount      =   $Amount + $Tax + $ServiceCharge;
	
	if($TradeUsage == 1) {
	   
	$CashBill = array(
	    'MgtKey'				=>  $MgtKey,	                        //연동사부여 문서키
	    'TradeDate'				=>  $TradeDate,		                    //거래일자 (YYYYMMDD), 공백입력 시 Today로 작성됨.
	    'FranchiseCorpNum'		=>  '8088800950',	                    //가맹점 사업자번호
	    'FranchiseMemberID'		=>  'musign',		                    //가맹점 바로빌 회원 아이디
	    'FranchiseCorpName'		=>  '뮤자인',		                        //가맹점 회사명
	    'FranchiseCEOName'		=>  '이호걸',		                        //가맹점 대표자명
	    'FranchiseAddr'			=>  '서울특별시 강동구 성안로 156 우주빌딩',	    //가맹점 주소
	    'FranchiseTel'			=>  '070-7763-6740',		            //가맹점 전화번호
	    
	    'IdentityNum'			=>  $Identity,		                    //소비자 신분확인번호 ("-" 를 제외한 주민등록번호/사업자번호/휴대폰번호/카드번호 중 택1)
		'HP'					=>  $HP,		                        //소비자 휴대폰번호 (문자 전송시 활용)
		'Fax'					=>  $Fax,		                        //소비자 팩스번호 (팩스 전송시 활용)
		'Email'					=>  $Email,		                        //소비자 이메일 (이메일 전송시 활용)
		
		'TradeType'				=>  $TradeType,		                    //거래구분 : N-승인거래, D-취소거래
		'TradeUsage'			=>  $TradeUsage,		                //거래용도 : 1-소득공제용, 2-지출증빙용 (신분확인번호가 사업자번호인 경우 지출증빙용으로)
		'TradeMethod'			=>  $TradeMethod,                       //거래방법 : 1-카드, 3-주민등록번호, 4-사업자번호, 5-휴대폰번호 (신분확인번호 종류에 따라 선택)
		
		'ItemName'				=>  $ItemName,		                    //품목명
		'Amount'				=>  $Amount,		                    //공급가액
		'Tax'					=>  $Tax,		                        //부가세
		'ServiceCharge'			=>  $ServiceCharge,		                //봉사료
		
		'CancelType'			=>  $CancelType,		                //취소사유 : 1-거래취소, 2-오류발행, 3-기타 (거래구분이 취소거래일 경우에만 작성)
		'CancelNTSConfirmNum'	=>  $CancelNTSConfirmNum,		        //취소할 원본 현금영수증의 국세청 승인번호
		'CancelNTSConfirmDate'	=>  $CancelNTSConfirmDate,		        //취소할 원본 현금영수증의 국세청 승인일자 (YYYYMMDD)     
		
	);
	 
	} else {
	    
	    $CashBill = array(
	        'MgtKey'				=>  $MgtKey,	                        //연동사부여 문서키
	        'TradeDate'				=>  $TradeDate,		                    //거래일자 (YYYYMMDD), 공백입력 시 Today로 작성됨.
	        'FranchiseCorpNum'		=>  '8088800950',	                    //가맹점 사업자번호
	        'FranchiseMemberID'		=>  'musign',		                    //가맹점 바로빌 회원 아이디
	        'FranchiseCorpName'		=>  '뮤자인',		                        //가맹점 회사명
	        'FranchiseCEOName'		=>  '이호걸',		                        //가맹점 대표자명
	        'FranchiseAddr'			=>  '서울특별시 강동구 성안로 156 우주빌딩',	    //가맹점 주소
	        'FranchiseTel'			=>  '070-7763-6740',		            //가맹점 전화번호
	        
	        'IdentityNum'			=>  $Identity_B,		                //소비자 신분확인번호 ("-" 를 제외한 주민등록번호/사업자번호/휴대폰번호/카드번호 중 택1)
	        'HP'					=>  $HP,		                        //소비자 휴대폰번호 (문자 전송시 활용)
	        'Fax'					=>  $Fax,		                        //소비자 팩스번호 (팩스 전송시 활용)
	        'Email'					=>  $Email,		                        //소비자 이메일 (이메일 전송시 활용)
	        
	        'TradeType'				=>  $TradeType,		                    //거래구분 : N-승인거래, D-취소거래
	        'TradeUsage'			=>  $TradeUsage,		                //거래용도 : 1-소득공제용, 2-지출증빙용 (신분확인번호가 사업자번호인 경우 지출증빙용으로)
	        'TradeMethod'			=>  $TradeMethod,                       //거래방법 : 1-카드, 3-주민등록번호, 4-사업자번호, 5-휴대폰번호 (신분확인번호 종류에 따라 선택)
	        
	        'ItemName'				=>  $ItemName,		                    //품목명
	        'Amount'				=>  $Amount,		                    //공급가액
	        'Tax'					=>  $Tax,		                        //부가세
	        'ServiceCharge'			=>  $ServiceCharge,		                //봉사료
	        
	        'CancelType'			=>  $CancelType,		                //취소사유 : 1-거래취소, 2-오류발행, 3-기타 (거래구분이 취소거래일 경우에만 작성)
	        'CancelNTSConfirmNum'	=>  $CancelNTSConfirmNum,		        //취소할 원본 현금영수증의 국세청 승인번호
	        'CancelNTSConfirmDate'	=>  $CancelNTSConfirmDate,		        //취소할 원본 현금영수증의 국세청 승인일자 (YYYYMMDD)
	        
	    );
	    
	}
	
	$Result = $BaroService_CASHBILL->RegistCashBill(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CashBill['FranchiseCorpNum'],
		'UserID'	=> $CashBill['FranchiseMemberID'],
		'Invoice'	=> $CashBill
	))->RegistCashBillResult;
	
	//-------------------------------------------
	//  임시저장한 영수증 ->  현금영수증 발급(국세청으로)
	//------------------------------------------
	// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';	
	$CorpNum        = '8088800950';			                                   //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID             = 'musign';			                                       //바로빌 회원 아이디
	$SMSSendYN      =  false;		                                           //발행 알림문자 전송여부 (발행비용과 별도로 과금됨)
	$MailTitle      = '[발급완료] 뮤자인님으로부터 현금영수증(이)가 발급 되었습니다.';		   //발행 알림메일의 제목 (공백이나 Null의 경우 바로빌 기본값으로 전송됨.)
	
	$Result = $BaroService_CASHBILL->IssueCashBill(array(
	'CERTKEY'		=> $CERTKEY,
	'CorpNum'		=> $CorpNum,
	'UserID'		=> $ID,
	'MgtKey'		=> $MgtKey,
	'SMSSendYN'		=> $SMSSendYN,
	'MailTitle'		=> $MailTitle
	))->IssueCashBillResult;
	
	//-------------------------------------------
	// 결과값이 1일때 insert문 작동
	//------------------------------------------
	if ($Result == '1' && $TradeUsage == 1) 
	{
	    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
	    
	    $query =
	               "
                    insert into cash_recipt
                        set
                        user_idx                  =     '{$_SESSION['idx']}',
                        mgt_num                   =     '{$MgtKey}',
                        identity_num              =     '{$Identity}',
                        hp                        =     '{$HP}',
                        fax                       =     '{$Fax}',
                        email                     =     '{$Email}',
                        trade_type                =     '{$TradeType}',
                        trade_usage               =     '{$TradeUsage}',
                        trade_method              =     '{$TradeMethod}',
                        item_name                 =     '{$ItemName}',
                        amount                    =     '{$Amount}',
                        tax                       =     '{$Tax}',
                        service_charge            =     '{$ServiceCharge}',
                        total_amount              =     '{$Total_amount}',
                        cancelents_confirmnum     =     '{$CancelNTSConfirmNum}',
                        cancelents_confirmdate    =     '{$CancelNTSConfirmDate}',
                        submit_date               =      now()+0
                     ";
	    
	    sql_query($query);
	    ?>
	    {
      		"isSuc":"success",
        	"msg":"현금영수증이 발급되었습니다."
		}
	    <?php 
	}
	
	else if($Result == '1' && $TradeUsage == 2) 
    {	
        require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
        
        $query =
                  "
                    insert into cash_recipt
                        set
                        user_idx                  =     '{$_SESSION['idx']}',
                        mgt_num                   =     '{$MgtKey}',
                        identity_num              =     '{$Identity_B}',
                        hp                        =     '{$HP}',
                        fax                       =     '{$Fax}',
                        email                     =     '{$Email}',
                        trade_type                =     '{$TradeType}',
                        trade_usage               =     '{$TradeUsage}',
                        trade_method              =     '{$TradeMethod}',
                        item_name                 =     '{$ItemName}',
                        amount                    =     '{$Amount}',
                        tax                       =     '{$Tax}',
                        service_charge            =     '{$ServiceCharge}',
                        total_amount              =     '{$Total_amount}',
                        cancelents_confirmnum     =     '{$CancelNTSConfirmNum}',
                        cancelents_confirmdate    =     '{$CancelNTSConfirmDate}',
                        submit_date               =      now()+0
                     ";
        
        sql_query($query);
	    ?> 
	    {
      		"isSuc":"success",
        	"msg":"현금영수증이 발급되었습니다."
		}
	    <?php 
    } 
    else 
    {
	       ?>
    	{
        	"isSuc":"fail",
        	"msg":"관리자에게 문의해주세요."
		}
	<?php 
	}