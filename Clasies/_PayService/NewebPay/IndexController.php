<?php

namespace App\Http\Controllers\_PayService\NewebPay;

use App\Http\Controllers\_PayService\_PayServiceController;
use App\ModOrder;
use App\ModOrderAddressee;
use App\ModPayServiceInfo;
use App\ModPayServiceOrderLog;
use App\ModPayServiceTrade;
use App\ModPayServiceTradeFeedback;
use App\ModProductPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IndexController extends _PayServiceController
{
    protected $module = "newebpay";
    protected $vPayService = "NewebPay";
    protected $vPaymentType = "信用卡一次性";
    private static $CARD_URL = "https://testmaple2.neweb.com.tw/NewebmPP/cdcard.jsp";

    /*
     * NewebPay for 平台收費(填卡頁)
     */
    function pay_service ( Request $request, $id )
    {
        $this->func = "_template_pay." . $this->module;
        $this->view = View()->make( $this->func . ".index" );
        $this->view->with('CARD_URL', self::$CARD_URL);

        //藍新店家資料
        $userid = config('_pay_service.newebpay.userid');
        $passwd = config('_pay_service.newebpay.passwd');
        $MerchantNumber = config('_pay_service.newebpay.MerchantNumber');
        $Code = config('_pay_service.newebpay.Code');

        //訂單資料
        $mapOrder['iPayStatus'] = 0;    //未付款
        $DaoOrder = ModOrder::where( 'iStatus', '<>', 2 )->find( $id );
        if ( !$DaoOrder) {
            $this->view = View()->make( $this->func . ".error" );

            return $this->view;
        }

        //藍新管理介面訂單編號(國泰只接受大寫訂單號)
        $OrderNumber = strtoupper( $DaoOrder->vOrderNum );
        //訂單總額
        $Amount = sprintf("%.2f", $DaoOrder->iTotal);
        //授權指標
        $ApproveFlag = 1;
        //請款指標(自動請款)
        $DepositFlag = 1;
        //中英文版本指標
        $Englishmode = 0;
        //手機刷卡頁版本指標
        $iphonepage = 0;
        //訂單回傳網址
        $OrderURL = url( 'payservice/' . $this->module . '/feedback' );
        //交易回傳網址
        $ReturnURL = url( 'payservice/' . $this->module . '/receive' );
        //編碼值
        $checkstr = $MerchantNumber . $OrderNumber . $Code . $Amount;
        $checksum = md5( $checkstr );
        //交易模式
        $op = "AcceptPayment";

        //藍新支付參數
        $params = array (
            "MerchantNumber" => $MerchantNumber,
            "OrderNumber" => $OrderNumber,
            "Amount" => $Amount,
            "ApproveFlag" => $ApproveFlag,
            "DepositFlag" => $DepositFlag,
            "Englishmode" => $Englishmode,
            "iphonepage" => $iphonepage,
            "OrderURL" => $OrderURL,
            "ReturnURL" => $ReturnURL,
            "checksum" => $checksum,
            "op" => $op,
        );

        //訂單支付記錄
        $DaoPayServiceOrderLog = new ModPayServiceOrderLog();
        $DaoPayServiceOrderLog->vPayService = $this->vPayService;
        $DaoPayServiceOrderLog->vOrderNum = $DaoOrder->vOrderNum;
        $DaoPayServiceOrderLog->vValue = json_encode( $params );
        $DaoPayServiceOrderLog->iCreateTime = time();
        $DaoPayServiceOrderLog->save();
        $DaoOrder->iUpdateTime = time();
        $DaoOrder->save();

        return $this->view->with( 'params', $params );
    }

    /*
     * NewebPay for 平台收費(Feedback)
     */
    public function feedback ( Request $request )
    {
        //
        $DaoPayServiceTrade = new ModPayServiceTrade();
        $DaoPayServiceTrade->vPayService = $this->vPayService;
        $DaoPayServiceTrade->vTradeType = "feedback";
        $DaoPayServiceTrade->vOrderNum = $request->input('OrderNumber' );
        $DaoPayServiceTrade->vPaymentType = $this->vPaymentType . "Feedback";
        $DaoPayServiceTrade->vMessage = "success";
        $DaoPayServiceTrade->vResult =  json_encode($request->all());
        $DaoPayServiceTrade->iCreateTime = time();
        $DaoPayServiceTrade->save();

        return 'ok';
    }

    /*
     * NewebPay for 平台收費(Feedback)
     */
    public function receive ( Request $request )
    {
        //
        $DaoPayServiceTrade = new ModPayServiceTrade();
        $DaoPayServiceTrade->vPayService = $this->vPayService;
        $DaoPayServiceTrade->vTradeType = "pay";
        $DaoPayServiceTrade->vOrderNum = $request->input('OrderNumber' );
        $DaoPayServiceTrade->vPaymentType = $this->vPaymentType . "Receive";
        $DaoPayServiceTrade->vMessage = "success";
        $DaoPayServiceTrade->vResult =  json_encode($request->all());
        $DaoPayServiceTrade->iCreateTime = time();
        $DaoPayServiceTrade->save();

        //
        $DaoOrder = ModOrder::find( $request->input('P_OrderNumber', 0) );
        //藍新店家資料
        $userid = config('_pay_service.newebpay.userid');
        $passwd = config('_pay_service.newebpay.passwd');
        $MerchantNumber = config('_pay_service.newebpay.MerchantNumber');
        $Code = config('_pay_service.newebpay.Code');
        //
        $params = [];
        $params ['final_result'] = $request->input("final_result", "");
        $params ['P_MerchantNumber'] = $request->input("P_MerchantNumber", "");
        $params ['P_OrderNumber'] = $request->input("P_OrderNumber", "");
        $params ['P_Amount'] = $request->input("P_Amount", "");
        $params ['P_CheckSum'] = $request->input("P_CheckSum", "");
        $params ['final_return_PRC'] = $request->input("final_return_PRC", "");
        $params ['final_return_SRC'] = $request->input("final_return_SRC", "");
        $params ['final_return_ApproveCode'] = $request->input("final_return_ApproveCode", "");
        $params ['final_return_BankRC'] = $request->input("final_return_BankRC", "");
        $params ['final_return_BatchNumber'] = $request->input("final_return_BatchNumber", "");
        $params ['final_redemption_point'] = $request->input("final_redemption_point", "");
        $params ['final_redemption_amount'] = $request->input("final_redemption_amount", "");
        $params ['final_redemption_remain'] = $request->input("final_redemption_remain", "");
        $params ['final_redemption_payamount'] = $request->input("final_redemption_payamount", "");

        if($params ['final_result'] == 1) {
            //
            if ($params ['P_CheckSum']) {
                $DaoOrder->iPayStatus = 1;                      // 支付完成
                $DaoOrder->vPaymentType = $this->vPaymentType;  // 支付方式
                $DaoOrder->iStatus = 1;                         // 備貨
                $DaoOrder->iUpdateTime = time();
                $DaoOrder->save();
                $DaoPayServiceTrade = new ModPayServiceTrade();
                $DaoPayServiceTrade->vPayService = $this->vPayService;
                $DaoPayServiceTrade->vTradeType = "pay";
                $DaoPayServiceTrade->vOrderNum = $DaoOrder->vOrderNum;
                $DaoPayServiceTrade->vPaymentType = $this->vPaymentType;
                $DaoPayServiceTrade->vMessage = "success";
                $DaoPayServiceTrade->vResult = json_encode($params);
                $DaoPayServiceTrade->iCreateTime = time();
                $DaoPayServiceTrade->save();
                $this->rtndata ['status'] = 1;
                $this->rtndata ['message'] = "Success";

                return response()->json( $this->rtndata );
            } else {
                $this->rtndata ['status'] = 0;
                $this->rtndata ['message'] = "參數驗證錯誤";

                return response()->json( $this->rtndata );
            }
        } else {
            //
            if ($params ['P_CheckSum']) {
                $DaoOrder->iPayStatus = 99;                     // 支付失敗
                $DaoOrder->vPaymentType = $this->vPaymentType;  // 支付方式
                $DaoOrder->iStatus = 2;                         // 取消訂單
                $DaoOrder->iUpdateTime = time();
                $DaoOrder->save();
                $DaoPayServiceTrade = new ModPayServiceTrade();
                $DaoPayServiceTrade->vPayService = $this->vPayService;
                $DaoPayServiceTrade->vTradeType = "pay";
                $DaoPayServiceTrade->vOrderNum = $DaoOrder->vOrderNum;
                $DaoPayServiceTrade->vPaymentType = $this->vPaymentType;
                $DaoPayServiceTrade->vMessage = "fail";
                $DaoPayServiceTrade->vResult = json_encode($params);
                $DaoPayServiceTrade->iCreateTime = time();
                $DaoPayServiceTrade->save();
                $this->rtndata ['status'] = 1;
                $this->rtndata ['message'] = "Success";

                return response()->json( $this->rtndata );
            } else {
                $this->rtndata ['status'] = 0;
                $this->rtndata ['message'] = "參數驗證錯誤";

                return response()->json( $this->rtndata );
            }
        }
    }
}
