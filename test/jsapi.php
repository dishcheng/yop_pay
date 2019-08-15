<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>JSAPI</title>
    <script type="text/javascript">
        123
        function onBridgeReady(){
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {
                    "appId":"wxbfe439d3e1d6fbc1",     //公众号名称，由商户传入
                    "timeStamp":"1560491227",         //时间戳，自1970年以来的秒数
                    "nonceStr":"bb8105192a114854824de49bba5b2d61", //随机串
                    "package":"prepay_id=wx141347079484479d9940e8f51297850500",
                    "signType":"RSA",         //微信签名方式：
                    "paySign":"I30t5n7Z7jh5QDO14CnKCnUT7sR/tsbMcbJgZxa0FBYRR7It5V9dFq0fpJBNUplYDbNpILCpe3tfnTBHG3b9ndlnrcoACCgDMBOtPBUlarWm0x0hEIFUpbOXh7dLqL28XEDpjLhb/j+KI4XTxvjN+uef/f+6IKRT3RgXxliV/A3BXtVC3VxTnibfa9mLj5oB38aEzmu+TYm34UE/aaov2eAE+SdYW//kmRETZSNJl2cej4EwGyLQBxhZUo9pwWzWiWy/ydLE9g6FLvYyEtJbTCml74gOMOmnaLmn0X5LCEStsH3seNgjFgbFpW0vGXjHvQJQ5dSqdIxNim8z9UkOIw==" //微信签名
                },
                function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok" ){
                        // 使用以上方式判断前端返回,微信团队郑重提示：
                        //res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                    }
                });
        }
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        }else{
            onBridgeReady();
        }

    </script>
</head>
<body>
</br></br></br></br>
<div align="center">
    <button style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="onBridgeReady()" >调起支付</button>
</div>
</body>
</html>