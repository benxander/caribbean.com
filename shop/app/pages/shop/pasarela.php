<div class="col-md-12" style="text-align: center; min-height: 400px;">
    <img src="{{dirBase}}admin/assets/images/paypal.jpg" alt="" style="width: 100%;max-width: 250px;">

    <!-- <label>PEDIDO</label> -->
    <p class="text-primary mt-lg bold f-18" >{{ 'Text.TOTAL_PAGAR' | translate }}: US$ {{ctrl.monto_a_pagar}}</p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="text-center">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="paypal@goeypictures.com">
        <input type="hidden" name="item_name" value="Digital Products GOEYPICTURES.COM ({{fSessionCI.codigo}})">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="amount" value="{{ctrl.monto_a_pagar}}">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="return" value="{{dirBase}}shop/#/app/pago/?id={{ctrl.idmovimiento}}&token={{ctrl.token}}">
    	<input type="hidden" name="cancel_return" value="{{dirBase}}shop/#/app/pago/?nok">
        <input type="image" src="https://www.goeypictures.com/goeyshop/admin/assets/images/paybutton.png"
               name="submit" title="Make payments with PayPal - it's fast, free and secure!">
    </form>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>