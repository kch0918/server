<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
    
    $user_idx_query = 
                      "
                          SELECT 
                             aa.*,bb.*,aa.idx AS user_idx,
                             TO_DAYS(date_format(date_end, '%Y.%m.%d')) - TO_DAYS(NOW()) as dday,
                            TO_DAYS(NOW()) - TO_DAYS(date_format(date_end, '%Y.%m.%d')) as overday
                           FROM server_info bb
                              JOIN user aa
                              ON bb.idx = aa.server_name
                           WHERE aa.pay_yn = 'Y' 
                      ";
    
        $user_idx_result = sql_query($user_idx_query);
    
    for ($i = 0; $i < sql_count($user_idx_result); $i++) {
        $user_idx_row = sql_fetch($user_idx_result);
        $user_mail = $user_idx_row['user_email'];
        
        $fromEmail = "delivery@musign.net";
        $fromName = '뮤자인';
        $toName = "";
        $subject = "[서비스 기간 만료 및 서비스 신청 안내]";

        $toEmail = "{$user_mail}";
        
        $date_start = $user_idx_row['date_start'];
        $date_end = $user_idx_row['date_end'];
        $new_date_start = date('Y.m.d', strtotime($date_start));
        $new_date_end = date('Y.m.d', strtotime($date_end));
        
        $dday    = $user_idx_row['dday'];
        $overday = $user_idx_row['overday'];
        
        $message = '<div id="edm" style="width:100%;max-width:700px;margin:0 auto;background:White;">
	<div class="edm-top">
		<div class="inner">
			<img src="https://www.kimminlaw.com/img/edm/edm_i01.jpg">
			<div class="tbox tbox-2" style="padding:0 7% 50px;">
                <p style="margin-bottom:5px; display:block;font-size:0;">';
        
        $message .= '<p class="edm-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">이용기간:</span>';
        
        $message .=	"<span style='display:inline-block;vertical-align:middle;font-size:16px;color:#7a7a7a;'>{$new_date_start}~{$new_date_end}</span>";
        
        $message .= '</p>
				<p class="edm-excess-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">초과 무상 이용기간:</span>';
        $message .=	"<span style='display:inline-block;vertical-align:middle;font-size:16px;color:#7a7a7a;'>{$overday}일 ({$new_date_end} 기준)</span>";
        $message .= '</p>
				<p class="edm-expiration-date color-text" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:22px;font-weight:700;color:#6bc0cb !important;letter-spacing:-1px;margin-right:10px;">서버 만료일:</span>
					<span style="position:relative;top:1px;display:inline-block;vertical-align:middle;font-size:22px;font-weight:bold;color:#6bc0cb !important;">';
        if($dday > 0)
        {
            $message .= "{$new_date_end} (만료 {$dday}일 전)</span></p>";
        }
        else 
        {
            $message .= "{$new_date_end} ({$overday}일 초과)</span></p>";
        }
		$message .= 
               '<p class="edm-important color-text" style="display:block;font-size:0;font-size:16.5px;font-weight:700;color:#6bc0cb;letter-spacing:-2.3px;">
					※ 서버 만료일이 초과되면 사이트 이용이 제한될 수 있으니 늦지 않게 연장 신청을 부탁드립니다.
				</p>
			</div>
		</div>
	</div>

	<div class="edm_desc">
    	<img src="https://www.kimminlaw.com/img/edm/edm_idesc.jpg">
	</div> 

	<div class="edm-link-wrap">
		<a href="http://server.musign.co.kr/member/login.php" style="display:block; margin-top:30px;text-align: center;">
			<img src="https://www.kimminlaw.com/img/edm/edm_bt.jpg">
		</a>
	</div>
	<img src="https://www.kimminlaw.com/img/edm/edm_i04.jpg">
</div>';

     
		
		if ($dday <= 30 && $dday > -10) {
            $mail = new PHPMailer(true);
            try {
                $mail -> SMTPDebug = 0;                               // 디버깅 설정
                $mail -> isSMTP();                                    // SMTP 사용 설정
                // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
                $mail -> Host = "smtp.worksmobile.com";               // 네이버의 smtp 서버
                $mail -> SMTPAuth = true;                             // SMTP 인증을 사용함
                $mail -> Username = "delivery@musign.net";           // 메일 계정 (지메일일경우 지메일 계정)
                $mail -> Password = "ehdehddlqkqh1";                    // 메일 비밀번호
                $mail -> SMTPSecure = "ssl";                          // SSL을 사용함
                $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
                $mail -> CharSet = "utf-8"; // 문자셋 인코딩
                // 보내는 메일
                $mail -> setFrom($fromEmail, $fromName);
                // 받는 메일
                $mail -> addAddress($toEmail, $toName);
                //$mail -> addAddress("test2@teacher21.com", "receive02");
                //$mail -> addAttachment("../pdf/musign_our_Company.pdf");
                $mail -> addBcc("coscoswkd@musign.net", "뮤자인케어 담당자");
                $mail -> addBcc("lsm@musign.net", "뮤자인케어 담당자");  
                $mail -> addBcc("angelo@musign.net", "지한규");
                // 첨부파일
                //     $mail -> addAttachment("./test1.zip");
                //     $mail -> addAttachment("./test2.jpg");
                // 메일 내용
                $mail -> isHTML(true); // HTML 태그 사용 여부
                $mail -> Subject = $subject;  // 메일 제목
                if($message == "")
                {
                    $message = "  ";
                }
                $mail -> Body = $message;     // 메일 내용
                // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
                // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
                $mail -> SMTPOptions = array(
                    //         "tls" => array(
                    //             "verify_peer" => false
                    //             , "verify_peer_name" => false
                    //             , "allow_self_signed" => true
                    //         )
                );
                // 메일 전송
                $mail -> send();
            } catch (Exception $e) {          
                ?>
                    {
                        "isSuc":"fail",
                        "msg": <?php echo $mail -> ErrorInfo; ?>
                    }
                <?php 
                }
            
            }
            
        } 
// }
?>
	<link rel="stylesheet" href="/wp-content/themes/musign/css/musign/mu_layout.css">
	<style>
		ul{list-style:none; padding-left:0px;}
		#e-page{width:850px; margin: 0 auto; padding:49px 55px 74px; background: url("../img/email-bg.png")no-repeat center center; /*background-size:contain;*/ border-radius: 50px 50px 0 0; }
		.e-page-wrap{width:740px; background:#fff; border-radius: 50px; padding-bottom:66px;}
		.e-main-txt{ text-align: center;}
		.e-main-img{margin:0 auto; width:241px; padding: 80px 0 45px 0;}
		.e-main-txt h2{font-size:36px; margin-bottom: 20px;}
		.e-main-txt p{font-size:18px; color:#7d7d7d; font-weight:600;}
		.btn-wrap{text-align: center; margin-top: 55px;}
		.round-text{text-align: center; margin-top: 30px;}
		.round-text span{width: 382px; height: 65px; line-height:65px; border-radius: 32.5px; background-color: #23afe3; font-size:20px; color:#fff; margin: 0 auto; text-align: center; font-weight:700; display:block;}
		.e-btn2{ width: 280px; height: 65px; margin: 40px 0 0 51px; padding: 24px 70px; border-radius: 32.5px; box-shadow: 0 0 40px 0 rgba(0, 0, 0, 0.05); background-color: #ffffff; font-size:18px; color:#000; margin-bottom:42px; font-weight: 600;}
		.e-main-bot{margin-top: 20px;}
		.e-main-txt table caption{ font:18px; color:#000; margin-bottom:20px; font-weight:800;}
		.e-main-txt table{border-top:1px solid #000; margin:0 5%; border-spacing: 0;}
		.e-main-txt table tr{border-bottom:1px solid #eaeaea;}
		.e-main-txt table th{background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -1.6px; font-weight:800;}
		.e-main-txt table th.top-th{padding-bottom: 74px;}
		.e-main-txt table td{color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.06em; font-weight: 600;}
		.e-page-footer{background:#fff; border-radius: 0 0 50px 50px; margin: 0 auto; background:#fff; border-radius: 0 0 50px 50px;}
		.e-footer-top{margin-bottom:35px;}
		.e-footer-top ul{overflow:hidden; margin-bottom:0;}
		.e-footer-top ul li{display:inline-block; position:relative; margin-right:30px; padding-right:30px;}
		.e-footer-top ul li a{font-weight:600;}
		/* .e-footer-top ul li:after{content:''; display:block; position:absolute; top:8px; right:-4px; width: 1px; height: 14px; background-color: #afafaf; } 메일상 가상선택자 안됨 */
		.e-footer-top ul li:last-child:after{display:none;}
		.e-footer-top ul li a:hover{text-decoration:underline;}
		.e-footer-top P{font-size:16px; color:#7d7d7d; margin-top:10px; white-space:normal;}
		.color-point1{color:#23afe3;}
		.color-point1:hover{text-decoration:underline;}
		.e-footer-bot {overflow:hidden;}
		.e-footer-bot .e-main-img{width:151px; float:left; padding:0; margin-right:45px;}
		.e-footer-bot ul{margin:13px 0 0 0;}
		.e-footer-bot ul li{font-size:14px; color:#7d7d7d;}
		.th-w{width:21%;}
		.td-w{width:29%;}
		.bor-left{border-left:1px solid #eaeaea; }
	</style>