<?php include '../BaroService_CASHBILL.php'; ?>
	<?php
	// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';		//테스트 인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';		 	                        //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = 'musign';				                                //바로빌 회원 아이디
	$MgtKey = $_POST['mgt_num'];			                    //연동사부여 문서키

	$Result = $BaroService_CASHBILL->CancelCashBillBeforeNTSSend(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
	))->CancelCashBillBeforeNTSSendResult;

	// 성공시,
	if ($Result == '1')
	{
	    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
	    
	    $query =
	                "
                        update cash_recipt
                            set
                            cancel_type               =     '1'
                            where mgt_num             =     '{$MgtKey}'
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
         echo $Result; 
	    ?> 
	    
	    {
        	"isSuc":"fail",
        	"msg":"관리자에게 문의해주세요."
		}
	    <?php 
	}
	?>
