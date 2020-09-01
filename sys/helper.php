<?php


if ( !function_exists('getIp')) {
    function getIp($_server)
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_server) === true){
                foreach (explode(',', $_server[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return '';
    }
}



if ( !function_exists('getUserIpAddr')) {
    function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

if ( !function_exists('PHPsendMail_fuja')) {
    function PHPsendMail_fuja($to, $subject, $arr, $headers, $charset='utf-8')
    {
        $msg = '
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="margin: 0px;">
    <div style="font-family: \'微軟正黑體\', \'Microsoft JhengHei\', Arial, sans-serif;width: 100%;background-color: #f3f2ee">
        <table style="width: 80%;margin: 0px auto;height: 120px;">
            <tbody>
            <tr>
                <td style="width: 46%;vertical-align: bottom;padding-bottom: 8px;">
                    <img src="/images/logo.png" alt="" style="width: 100%;height: auto;max-width: 280px;">
                </td>
                <td style="width: 54%;text-align: right;vertical-align: bottom;font-size: 20px;color: #6a6a6a;padding: 10px 5px 15px;letter-spacing: 1px;font-weight: 800;">忘記密碼 密碼通知信
                </td>
            </tr>
            </tbody>
        </table>
        <div style="width: 80%;margin: 0 auto;background-color: #ffffff;">
            <div style="color: #6a6a6a;padding: 90px 50px;">
                <div style="border-left: 10px solid #6a8e24;padding: 2px 15px;font-size: 22px;font-weight: 900;letter-spacing: 1px;color: #6a6a6a;margin-bottom: 50px;">
                    <div style="margin-bottom: 4px;">親愛的User<span style="color:#789162;margin:0 5px;font-weight: 800;"></span>您好：</div>
                    <div style="font-size: 14px;color: #898989;font-weight: normal;">我們收到了您忘記密碼的消息，請確認此為您本人的操作。</div>
                </div>
                <div style="font-size: 22px;margin-bottom: 50px;line-height: 40px;padding: 0 25px;text-align: justify;">
                    <div style=""> 以下是您的臨時密碼</div>
                    <div style="font-size: 30px;margin-bottom: 18px;border-bottom: 1px solid;">'. $arr['verification'] .'</div>
                </div>
                <div style="font-size: 18px;margin-bottom: 50px;line-height: 40px;padding: 0 25px;text-align: justify;">
                    <div style=""> 假如網站沒有跳轉，可以到下方連結更改您的密碼</div>
                    <div style="font-size: 16px;margin-bottom: 18px;border-bottom: 1px solid;">
                        <a href="'. $arr['url'] .'">'. $arr['url'] .'</a>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 25px;text-align: center;background-color: #789162;color: #fff;letter-spacing: 1px;font-size: 16px;">'. $arr['app_name'] .'</div>
        <div style="height: 20px;font-size: 12px;letter-spacing: 1px;background-color: #000000;color: #ffffff;padding: 11px;text-align: center;">※此信件為系統發出信件，請勿直接回覆。</div>
    </div>
    </body>
</html>
';

        /*
          $to ="lovekyoe@gmail.com"; //收件者
          $subject = "test"; //信件標題
          $msg = "smtp發信測試";//信件內容
          $headers = "From: testmail@fujacook.com"; //寄件者
        */

        //重新組裝mail header
        $headers = "From: ".$headers."\r\n".
            "MIME-Version: 1.0\r\n" .
            "Content-type: text/html; charset=".$charset."\r\n";
        ;

//        ini_set('SMTP', '211.72.249.178');
//        ini_set('SMTP', '192.168.88.4');
        ini_set('SMTP', 'msa.hinet.net'); //Hinet：msa.hinet.net (目前在光世代測試可以)
        //
        if (mail("$to", "$subject", "$msg", "$headers")) {
            echo "信件已經發送成功。";//寄信成功就會顯示的提示訊息
            return true;
        } else {
            echo "信件發送失敗！";//寄信失敗顯示的錯誤訊息
            return false;
        }
    }
}
