<div class="col-md-12" style="min-height: 400px;">
    <img src="{{dirBase}}admin/assets/images/paypal.jpg" alt="" style="width: 100%;max-width: 250px;">

    <!-- <label>PEDIDO</label> -->
    <p class="text-primary mt-lg bold f-18" >TOTAL A PAGAR: US$ {{ctrl.monto_a_pagar}}</p>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" class="text-left">
        <input type="hidden" name="cmd" value="_xclick">
        <!-- <input type="hidden" name="business" value="rguevarac@hotmail.es"> -->
        <!-- <input type="hidden" name="business" value="info-facilitator@publianuncio.es"> -->
        <input type="hidden" name="business" value="cmorel-facilitator@caribbeanphotocloud.com">
        <input type="hidden" name="item_name" value="SERVICIO PEDIDO">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="amount" value="{{ctrl.monto_a_pagar}}">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="return" value="{{dirBase}}admin/#/app/pago/?id={{ctrl.idmovimiento}}&token={{ctrl.token}}">
    	<input type="hidden" name="cancel_return" value="{{dirBase}}admin/#/app/pago/?nok">
        <input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but03.gif"
               name="submit"
               alt="Make payments with PayPal - it's fast, free and secure!" style="width: 80px">
    </form>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>