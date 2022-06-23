<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_excel_mail($date_start,$date_end,$over_date,$send_email,$today,$client_name_str,$connect_domain_str,$finish_date){
    
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
    
    // 오늘날짜
    $today = date("Y.m.d");
    $fromEmail = "delivery@musign.net";
    $fromName = "뮤자인";
    $toName = "";
    $subject = "[뮤자인 케어] 서버 운영 기간 만료 및 신청 안내";
    $toEmail = "{$send_email}";
    
    $message = '<div id="edm" style="width:100%;max-width:700px;margin:0 auto;background:White;">
	<div class="edm-top">
		<div class="inner">
			<img src="https://www.kimminlaw.com/img/edm/edm_i01.jpg">
			<div class="tbox tbox-2" style="padding:0 7% 50px;">
                <p style="margin-bottom:5px; display:block;font-size:0;">';   
                  
    $message .= '<p class="edm-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">이용기간:</span>';
    
	$message .=	"<span style='display:inline-block;vertical-align:middle;font-size:16px;color:#7a7a7a;'>{$date_start}~{$date_end} (1년무상)</span>";
	
	$message .= '</p>
				<p class="edm-excess-usage-period" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:16px;color:inherit; font-weight:bold;color:#7a7a7a;letter-spacing:-1px;margin-right:10px;">초과 무상 이용기간:</span>';
	$message .=	"<span style='display:inline-block;vertical-align:middle;font-size:16px;color:#7a7a7a;'>{$over_date}일 ({$today} 기준)</span>";
    $message .= '</p>
				<p class="edm-expiration-date color-text" style="margin-bottom:5px; display:block;font-size:0;">
					<span style="display:inline-block;vertical-align:middle;font-size:22px;font-weight:700;color:#6bc0cb !important;letter-spacing:-1px;margin-right:10px;">서버 만료일:</span>
					<span style="position:relative;top:1px;display:inline-block;vertical-align:middle;font-size:22px;font-weight:bold;color:#6bc0cb !important;">2021.01.27 (만료'; 
    $message .= "{$finish_date}";
    $message .=	'일 전)</span>
				</p>
				<p class="edm-important color-text" style="display:block;font-size:0;font-size:16.5px;font-weight:700;color:#6bc0cb;letter-spacing:-2.3px;">
					※ 서버 만료일이 초과되면 사이트 이용이 제한될 수 있으니 늦지 않게 연장 신청을 부탁드립니다. 
				</p>
			</div>
		</div>
	</div>
    <div class="edm_desc">
        <img src="https://www.kimminlaw.com/img/edm/edm_idesc.jpg"> 
    </div>
	<div class="edm-link-wrap">
		<a href="http://forms.gle/DB8U5y5AgYR5qprz6" style="display:block; margin-top:30px;text-align: center;">
			<img src="https://www.kimminlaw.com/img/edm/edm_bt.jpg">		
		</a>
	</div>
	<img src="https://www.kimminlaw.com/img/edm/edm_i04.jpg">
</div>';
     
    $mail = new PHPMailer(true);
    try {
        $mail -> SMTPDebug = 0; // 디버깅 설정
        $mail -> isSMTP(); // SMTP 사용 설정
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
        //첨부파일
        //     $mail -> addAttachment("./test1.zip");
        //     $mail -> addAttachment('/img/edm_logo.png');
        // 메일 내용
        $mail -> isHTML(true);        // HTML 태그 사용 여부
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
?>