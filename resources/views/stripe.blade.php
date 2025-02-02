@extends('layout')
@section('content')

    <div class="panel panel-default credit-card-box" style="margin-top: 40px;">
        <div class="panel-heading display-table">
            <h2 class="text-center">Stripe Payment Gateway Integration by <span class="text-info">khaled.dev</span></h2>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table">
                    <h3 class="panel-title">Payment Details</h3>
                </div>

                <div class="panel-body">
                    <div class='form-row row'>
                        <div class='col-xs-4 form-group'>
                            <label class='control-label'>Name</label>
                            <input class='form-control' name="name" id="name" type='text' placeholder="Name">
                        </div>
                        <div class='col-xs-4 form-group'>
                            <label class='control-label'>Email</label>
                            <input class='form-control' name="email" id="email" type='email' placeholder="Email">
                        </div>
                        <div class='col-xs-4 form-group'>
                            <label class='control-label'>Product Quantity</label>
                            <input class='form-control' name="quantity" id="quantity" type='number' placeholder="Email">
                        </div>
                    </div>

                    <div class='form-row row'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Address</label>
                            <input class='form-control' name="address" id="address" type='text' placeholder="Address">
                        </div>
                    </div>

                    <div class='form-row row'>
                        <div class='col-xs-6 form-group'>
                            <label class='control-label'>Currency</label>
                            <input class='form-control' name="currency" id="currency" type='text' placeholder="USD">
                        </div>
                        <div class='col-xs-6 form-group'>
                            <label class='control-label'>Rate</label>
                            <input class='form-control' name="rate" id="rate" type='number' placeholder="120">
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Description</label>
                            <input class='form-control' name="description" id="description" type='text' placeholder="Description">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table">
                    <h3 class="panel-title">Card Details</h3>
                </div>

                <div class="panel-body">
                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                          data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf

                        <input type="hidden" name="name" id="hidden-name">
                        <input type="hidden" name="quantity" id="hidden-quantity">
                        <input type="hidden" name="email" id="hidden-email">
                        <input type="hidden" name="address" id="hidden-address">
                        <input type="hidden" name="currency" id="hidden-currency">
                        <input type="hidden" name="rate" id="hidden-rate">
                        <input type="hidden" name="description" id="hidden-description">

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label>
                                <input class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVV</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 547' size='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>
                                    Please correct the errors and try again!
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            var $form = $(".require-validation");

            $('form.require-validation').on('submit', function (e) {
                e.preventDefault();

                $('#hidden-name').val($('#name').val());
                $('#hidden-email').val($('#email').val());
                $('#hidden-quantity').val($('#quantity').val());
                $('#hidden-address').val($('#address').val());
                $('#hidden-currency').val($('#currency').val());
                $('#hidden-rate').val($('#rate').val());
                $('#hidden-description').val($('#description').val());

                var inputSelector = [
                    'input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', ');

                var $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;

                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');

                $inputs.each(function () {
                    var $input = $(this);
                    if ($input.val().trim() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        valid = false;
                    }
                });

                if (!valid) {
                    return;
                }

                if (!$form.data('cc-on-file')) {
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, function (status, response) {
                        if (response.error) {
                            $('.error').removeClass('hide').find('.alert').text(response.error.message);
                        } else {
                            var token = response.id;
                            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                            $form.off('submit').submit();
                        }
                    });
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>
@endsection
