<?php

namespace App\Http\Controllers\_PayService;

use App\Http\Controllers\Controller;

class _PayServiceController extends Controller
{
    public $view;
    public $func;

    /*
     *
     */
    function addpadding ( $string, $blocksize = 32 )
    {
        $len = strlen( $string );
        $pad = $blocksize - ( $len % $blocksize );
        $string .= str_repeat( chr( $pad ), $pad );

        return $string;
    }

    /*
     *
     */
    function curl_work ( $url = "", $parameter = "" )
    {
        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "PTW",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => $parameter,
        ];
        $ch = curl_init();
        curl_setopt_array( $ch, $curl_options );
        $result = curl_exec( $ch );
        $retcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $curl_error = curl_errno( $ch );
        curl_close( $ch );
        $return_info = [
            "url" => $url,
            "sent_parameter" => $parameter,
            "http_status" => $retcode,
            "curl_error_no" => $curl_error,
            "web_info" => $result
        ];

        return $return_info;
    }
    /*
     *
     */
    function curl_work_proxy ( $url = "", $parameter = "" )
    {
        $userPass = 'jumpmyip:nx57z6u5';
        $proxyAddr = 'web-proxy.pin2wall.com';
        $proxyPort = '3128';

        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_PROXY => $proxyAddr,
            CURLOPT_PROXYPORT => $proxyPort,
            CURLOPT_PROXYUSERPWD => $userPass,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "PTW",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => "1",
            CURLOPT_POSTFIELDS => $parameter
        ];
        $ch = curl_init();
        curl_setopt_array( $ch, $curl_options );
        $result = curl_exec( $ch );
        $retcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $curl_error = curl_errno( $ch );
        curl_close( $ch );
        $return_info = [
            "url" => $url,
            "sent_parameter" => $parameter,
            "http_status" => $retcode,
            "curl_error_no" => $curl_error,
            "web_info" => $result
        ];

        return $return_info;
    }

    /*
     * 文字轉換
     */
    function _NumTrasfer( $money ){
        $ar = array('零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖') ;
        $cName = array('', '', '拾', '佰', '仟', '萬', '拾', '佰', '仟', '億', '拾', '佰', '仟');
        $conver = '';
        $cLast = '' ;
        $cZero = 0;
        $i = 0;
        for ($j = strlen($money) ; $j >=1 ; $j--){
          $cNum = intval(substr($money, $i, 1));
          $cunit = $cName[$j]; //取出位數
          if ($cNum == 0) { //判斷取出的數字是否為0,如果是0,則記錄共有幾0
             $cZero++;
             if (strpos($cunit,'萬億') >0 && ($cLast == '')){ // ‘如果取出的是萬,億,則位數以萬億來補
              $cLast = $cunit ;
             }
          }else {
            if ($cZero > 0) {// ‘如果取出的數字0有n個,則以零代替所有的0
              if (strpos('萬億', substr($conver, strlen($conver)-2)) >0) {
                 $conver .= $cLast; //’如果最後一位不是億,萬,則最後一位補上”億萬”
              }
              $conver .=  '零' ;
              $cZero = 0;
              $cLast = '' ;
            }
             $conver = $conver.$ar[$cNum].$cunit; // ‘如果取出的數字沒有0,則是中文數字+單位
          }
          $i++;
        }
        //’判斷數字的最後一位是否為0,如果最後一位為0,則把萬億補上
         if (strpos('萬億', substr($conver, strlen($conver)-2)) >0) {
           $conver .=$cLast; // ‘如果最後一位不是億,萬,則最後一位補上”億萬”
            }

        return $conver;
    }
}

