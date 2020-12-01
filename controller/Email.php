<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");

class Email
{
//    public static function  sendMail($email,$subject,$link) {
//        $url = self::URL().'/obs/mail/index.php';
//        $data = array('email' => $email, 'subject' => $subject, 'link' => $link, 'type' => 1);
//        $options = array(
//            'http' => array(
//                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
//                'method' => 'POST', 'content' => http_build_query($data)
//            )
//        );
//        $context = stream_context_create($options);
//        file_get_contents($url, false, $context);
//        return "Mail send sucessfully";
//    }

    public static function sendMail($email,$subject,$link,$replyto=null,$cc){
        $curl = curl_init();
        $url = self::URL().'/obs/mail/index.php';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('email' => $email,'subject' => $subject,'link' => $link,'type' => '1','replyto'=>$replyto,'cc'=>$cc),
            CURLOPT_HTTPHEADER => array(
                "Cookie: PHPSESSID=ggcj82ocvhbktrqsfa83qkq7r1"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        file_put_contents('log_email.txt', json_encode(['email'=>$email,$subject=>$subject,'status'=>$response]) . "\n", FILE_APPEND);
//        echo $response;
    }


    public  static function URL(){
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );
    }

}