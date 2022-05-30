<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=Af_m5xirCIkbVNem71XACk5B_1Vef0PHjXGxAJInukEvT0vLgpsOaagUv7EfeyZOCz9mbQCbb1CAJDYk&currency=EUR"></script>
</head>
<body>
<!-- Gestion de pagos por separado haciendo uso de la api de paypal -->

<div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
          style:{
              color: 'blue',
              shape: 'pill',
              label: 'pay',
          },
        // Inicializa la transaccion al pulsar el boton
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '77.44' // Variable que contiene el precio del producto
              }
            }]
          });
        },

        // Finalize the transaction after payer approval
    
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
            console.log(orderData)
            window.location.href="completado.html"
          });
        }
      }).render('#paypal-button-container');
    </script>
    
</body>
</html>