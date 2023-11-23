<?php
include 'inc/header.php';
?>
<div class="text-center">
    <div id="smart-button-container">
        <div>
            <div id="paypal-button-container"></div>
        </div>
    </div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id=AW7pfvAPd_B03a0GQNJkAWVmQrO9vrBQIEE5ABeS0EtFIm5xIFf_lXdsGhSIo-6mBv8cvNbSM9x1Inbl&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "amount": {
                            "currency_code": "USD",
                            "value": 1
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    // Full available details
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // Show a success message within this page, e.g.
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            },
            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>
<?php
include 'inc/footer.php';
?>
