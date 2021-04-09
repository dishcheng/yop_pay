<?php

namespace DishCheng\YopPay\Util;

class UriUtils
{
    //子商户入网—重发授权码
    const sendAuthorizeNum = '/rest/v1.0/sys/merchant/sendauthorizenum';
    //子商户入网—企业
    const EnterpriseReginfoAdd = '/rest/v1.0/sys/merchant/enterprisereginfoadd';
    //子商户入网—个体
    const individualreginfoadd = '/rest/v1.0/sys/merchant/individualreginfoadd';
    //查询银行卡卡bin信息 ------------------已接
    const QueryQueryBanCardBinInfo = '/rest/v1.0/sys/merchant/query-bank-card-bin-info';
    //子商户入网一修改产品     支持沙箱
    const ModifyModifyPayProductInfo = '/rest/v1.0/router/modify/pay-product-info';
    //子商户入网一修改结算卡
    const MerSettleInfoUpdateForO2O = '/rest/v1.0/merchantService/mer-settle/mer-settle-info-update-for-o2o';
    //子商户入网—查询支行信息
    const QueryBankBranchInfo = '/rest/v1.0/sys/merchant/bankbranchinfo';
    //子商户入网一开通产品查询
    const QueryPayProductInfo = '/rest/v1.0/router/query/pay-product-info';
    //子商户入网—入网状态查询  支持沙箱
    const QueryRegStatus = '/rest/v1.0/sys/merchant/regstatusquery';
    //通过该接口获取易宝与子商户的协议内容
    const QueryAgreeInfo = '/rest/v1.0/sys/merchant/agreeinfoquery';
    //子商户入网一发送短验
    const SendMerSmsNotify = '/rest/v1.0/merchantService/mer-out-invoke/send-mer-sms-notify';
    //提现一一提现请求
    const BalanceCash = '/rest/v1.0/balance/cash';
    //提现一一提现查询
    const QueryCacheByorder = '/rest/v1.0/balance/query-cash-byorder';
    //提现一一余额查询
    const QueryAccount = '/rest/v1.0/balance/account-query';
    //订单处理器——结算查询
    const QuerySettlement = '/rest/v1.0/sys/trade/settlementsquery';
    //获取子商户密钥接口     支持沙箱  ------------------已接
    const QueryHmacKey = '/rest/v1.0/sys/merchant/hmackeyquery';
    //订单处理器——创建订单------------------已接
    const CreateOrder = '/rest/v1.0/sys/trade/order';
    //订单处理器——查询订单------------------已接
    const QueryOrder = '/rest/v1.0/sys/trade/orderquery';
    //订单处理器-分账------------------已接
    const TradeDivide = '/rest/v1.0/sys/trade/divide';
    //订单处理器-分账查询------------------已接
    const TradeDivideQuery = '/rest/v1.0/sys/trade/dividequery';
    //订单处理器-完结分账------------------已接
    const TradeEndDivide = '/rest/v1.0/sys/trade/enddivide';
    //订单处理器——资金全额确认------------------已接
    const TradeFullSettle = '/rest/v1.0/sys/trade/fullsettle';
    //订单处理器——退款查询
    const TradeRefundQuery = '/rest/v1.0/sys/trade/refundquery';
    //订单处理器——退款请求------------------已接
    const TradeRefund = '/rest/v1.0/sys/trade/refund';
    //订单处理器——关闭订单------------------已接
    const TradeOrderClose = '/rest/v1.0/sys/trade/orderclose';
    //API收银台聚合下单支付一体化
    const NcCashierApiOrderPay = '/rest/v1.0/nccashierapi/api/orderpay';
    //聚合报备——报备服务--------------------已接
    const OpenPayAsyncReport = '/rest/v1.0/router/open-pay-async-report/report';
    //聚合报备——报备查询
    const QueryOpenPayReport = '/rest/v1.0/router/open-pay-report/query';
    //统一公众号配置 --------------------已接
    const OpenPayAsyncReportConfig = '/rest/v1.0/router/open-pay-async-report/config';
    //统一公众号配置查询 --------------------已接
    const OpenPayJsApiConfigQuery = '/rest/v1.0/router/open-pay-jsapi-config/query';
    //openid查询     支持沙箱
    const QueryOpenId = '/rest/v1.0/new-retail/marketing/query-open-id';
    //获取商户余额接口  --------------------已接
    const MerchantBalanceQuery = '/rest/v1.0/sys/merchant/balancequery';
    //聚合API收银台接口--------------------已接
    const NcCashierApiPay = '/rest/v1.0/nccashierapi/api/pay';
    //代付代发--单笔出款请求     支持沙箱-------已接
    const DFTransferToSingle='/rest/v1.0/balance/transfer_send';
    //代付代发--出款查询     支持沙箱-------已接
    const DFTransferQuery='/rest/v1.0/balance/transfer_query';
    //无卡支付、等使用-------已接
    const YopPayByCashier='/rest/v1.0/bc/cashier/create-yop-cashier-url';
}