/*var stripe = Stripe('pk_test_rZT3x5ueWbRUbhBeIORoR5bx00uCLqGqY1'); // Remplacez par votre clé publique
var elements = stripe.elements();

var card = elements.create('card');
card.mount('#card-element');

var $form = $('#checkout-form');

$form.submit(function(event) {
    event.preventDefault(); // Empêcher la soumission standard

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            $('#charge-error').removeClass('hidden');
            $('#charge-error').text(result.error.message);
        } else {
            var token = result.token.id;
            $form.append($('<input type="hidden" name="stripeToken"/>').val(token));
            $form.get(0).submit();  // Soumettre le formulaire
        }
    });
});*/ 

var stripe = Stripe('pk_test_rZT3x5ueWbRUbhBeIORoR5bx00uCLqGqY1');
var elements = stripe.elements();

var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

var card = elements.create('card', { style: style });
card.mount('#card-element');

// Gestion des erreurs
card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var form = document.getElementById('checkout-form');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    var cardholderName = document.getElementById('cardholder-name').value;
    var addressLine1 = document.getElementById('address-line1').value;

    // Créer le token en incluant l'adresse
    stripe.createToken(card, {
        name: cardholderName,
        address_line1: addressLine1
    }).then(function(result) {
        if (result.error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    var form = document.getElementById('checkout-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit();
}
