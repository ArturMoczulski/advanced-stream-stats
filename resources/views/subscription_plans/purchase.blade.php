@extends('layouts.ssr')
 
@section('title', 'Subscription Purchase')
 
@section('content')


  <div id="dropin-wrapper">
    <div id="checkout-message">
      @if ($message = Session::get('error'))
      <div class="overflow-hidden sm:rounded-lg">
          <div class="max-w-7xl mx-auto pb-4 px-4 sm:px-6 lg:px-8">
              <div class="sm:p-4 bg-red-300 shadow sm:rounded-lg">
                  <div class="alert error">
                    {{ $message }}
                  </div>
              </div>
          </div>
      </div>
      @endif
    </div>
    <div id="dropin-container"></div>
    <button id="submit-button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">Submit payment</button>
  </div>
  <script>
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var button = document.querySelector('#submit-button');

    braintree.dropin.create({
      // Insert your tokenization key here
      authorization: '{{ config("app.braintree.tokenizationKey")}}',
      container: '#dropin-container',
      paypal: {
        flow: 'vault'
      }
    }, function (createErr, instance) {
      button.addEventListener('click', function () {
        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
          // When the user clicks on the 'Submit payment' button this code will send the
          // encrypted payment information in a variable called a payment method nonce
          $.ajax({
            type: 'POST',
            url: '/checkout',
            data: {
              'paymentMethodNonce': payload.nonce,
              'subscriptionPlanId': {{ $subscriptionPlan->id }}
            }
          }).done(function(result) {
            // Tear down the Drop-in UI
            instance.teardown(function (teardownErr) {
              if (teardownErr) {
                console.error('Could not tear down Drop-in UI!');
              } else {
                console.info('Drop-in UI has been torn down!');
                // Remove the 'Submit payment' button
                $('#submit-button').remove();
              }
            });

            if (result.success) {
              window.top.location.href = "/dashboard"; 
            } else {
              window.location.href = "/subscription_plans/{{ $subscriptionPlan->id }}/purchase"; 
            }
          });
        });
      });
    });
  </script>
@stop