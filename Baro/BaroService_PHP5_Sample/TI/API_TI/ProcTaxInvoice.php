<?php include '../BaroService_TI.php'; ?>

	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';		                         	//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey  = $_POST['mgt_num'];			                    //연동사부여 문서키
	$ProcType = 'ISSUE_CANCEL';			                         //프로세스 타입
							                                    //CANCEL : 승인(발행)요청 취소
							                                    //ACCEPT : 승인
							                                    //REFUSE : 거부
							                                    //ISSUE_CANCEL : 발행완료된 매출 세금계산서의 발행을 취소
	$Memo = '';				                                    //프로세스 처리시 거래처에 전달할 메모.
	
	$CancelType = '1';
    $CustNo    = $_POST['cust_no'];
	
	
	$Result = $BaroService_TI->ProcTaxInvoice(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey,
		'ProcType'		=> $ProcType,
		'Memo'			=> $Memo
	))->ProcTaxInvoiceResult;
	
	// 성공시,
	if ($Result == 1)
	{
	    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
	    
	    $query =
	                "
                        update invoice_payment
                            set 
                            proc_type               =     'ISSUE_CANCEL',
                            cancel_type             =     '1'
                            where mgt_num           =     '{$MgtKey}'                    
                    ";
	    
	    sql_query($query);
	    ?>
	    {
        	"isSuc":"success",
        	"msg":"취소되었습니다."
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
	?>
