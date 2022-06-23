<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function send_id_mail($send_email, $user_id){
    //$send_email 보낼 이메일
    //$user_id 아이디
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
    
    $fromEmail = "delivery@musign.net";
    $fromName = "뮤자인";
    $toName = "";
    $subject = "[musign care]아이디 찾기 문의 관련 메일입니다";
    $toEmail = $send_email;
    
    $message = "고객님의 아이디는 <span>{$user_id}<span> 입니다.<br>
                <a href='https://server.musign.co.kr/'>홈페이지 바로가기</a>";
    $mail = new PHPMailer(true);
    try {
        $mail -> SMTPDebug = 0; // 디버깅 설정
        $mail -> isSMTP(); // SMTP 사용 설정
        // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
        $mail -> Host = "smtp.worksmobile.com";               // 네이버의 smtp 서버
        $mail -> SMTPAuth = true;                         // SMTP 인증을 사용함
        $mail -> Username = "delivery@musign.net";           // 메일 계정 (지메일일경우 지메일 계정)
        $mail -> Password = "ehdehddlqkqh1";                    // 메일 비밀번호
        $mail -> SMTPSecure = "ssl";                       // SSL을 사용함
        $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
        $mail -> CharSet = "utf-8"; // 문자셋 인코딩
        // 보내는 메일
        $mail -> setFrom($fromEmail, $fromName);
        // 받는 메일
        $mail -> addAddress($toEmail, $toName);
        //$mail -> addAddress("test2@teacher21.com", "receive02");
        //$mail -> addAttachment("../pdf/musign_our_Company.pdf");
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
?>
<?php
function send_pw_mail($send_email, $temp_pw){
    //$send_email 보낼 이메일
    //$temp_pw 임시 비밀번호
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
    
    $fromEmail = "delivery@musign.net";
    $fromName = "뮤자인";
    $toName = "";
    $subject = "[musign care]비밀번호 찾기 문의 관련 메일입니다";
    $toEmail = $send_email;
    
    $message = "고객님의 임시 비밀번호는 <span>{$temp_pw}<span> 입니다.<br>
                                로그인 후 비밀번호를 꼭 변경해주시기 바랍니다.<br>
                <a href='http://server.musign.co.kr/'>홈페이지 바로가기</a>";
    $mail = new PHPMailer(true);
    try {
        $mail -> SMTPDebug = 0; // 디버깅 설정
        $mail -> isSMTP(); // SMTP 사용 설정
        // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
        $mail -> Host = "smtp.worksmobile.com";               // 네이버의 smtp 서버
        $mail -> SMTPAuth = true;                         // SMTP 인증을 사용함
        $mail -> Username = "delivery@musign.net";    // 메일 계정 (지메일일경우 지메일 계정)
        $mail -> Password = "casanova1!@";                  // 메일 비밀번호
        $mail -> SMTPSecure = "ssl";                       // SSL을 사용함
        $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
        $mail -> CharSet = "utf-8"; // 문자셋 인코딩
        // 보내는 메일
        $mail -> setFrom($fromEmail, $fromName);
        // 받는 메일
        $mail -> addAddress($toEmail, $toName);
        //$mail -> addAddress("test2@teacher21.com", "receive02");
        //$mail -> addAttachment("../pdf/musign_our_Company.pdf");
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
?>
