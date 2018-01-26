<div class="col-md-12" style="min-height: 400px;">
    <label>PEDIDO</label>
    <p >Total a pagar: US${{ga.fData.total_a_pagar}}</p>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <!-- <input type="hidden" name="business" value="rguevarac@hotmail.es"> -->
        <!-- <input type="hidden" name="business" value="info-facilitator@publianuncio.es"> -->
        <input type="hidden" name="business" value="cmorel-facilitator@caribbeanphotocloud.com">
        <input type="hidden" name="item_name" value="SERVICIO PEDIDO">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="amount" value="{{ga.fData.total_a_pagar}}">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="return" value="http://www.unaisangamer.com/admin/#/app/mi-galeria?ok">
    	<input type="hidden" name="cancel_return" value="http://www.unaisangamer.com/admin/#/app/mi-galeria?nok">
        <input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but03.gif"
               name="submit"
               alt="Make payments with PayPal - it's fast, free and secure!">
    </form>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>