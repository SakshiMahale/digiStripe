<?php
require 'vendor/autoload.php';
if(1)//isset($_POST['authKey'])&& ($_POST['authKey']=="abc") for setting condition to be always true used 1
{
    $stripe = new \Stripe\StripeClient('sk_test_51NndNISHXO9o3WhY98AxM89h68PMk19jLlbnewRBgPZU2KQmzOGyBKAUa4VtWr0e84a9jxHI6kzwOJiarix5ikQV00dZAPaPpt');

    $customer = $stripe->customers->create(
        [
            'name'=>"SAKSHI",
            'address'=>[
                'line1'=>'53 Sujal Apartment Datar Colony'

            ]
        ]
    );
    $ephemeralKey = $stripe->ephemeralKeys->create([
        'customer' => $customer->id,
    ], [
        'stripe_version' => '2022-08-01',
    ]);
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => 1099,//10.99euro
        'currency' => 'INR',
        'description'=>'Payemnt Gateway for DigiMart',
        'customer' => $customer->id,
        // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
        'automatic_payment_methods' => [
            'enabled' => 'true',
        ],
    ]);

    echo json_encode(
        [
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51NndNISHXO9o3WhYb7RVXeHfENgUKajXmW2LMSx1pYK0bTA2Gmt7x3t6jHJ8kqqvsK1esdx3cEHS8ifcZCafrDTr00tUmcyldl'
        ]
    );
    http_response_code(200);
}
else
{
    echo "NOT AUTHORISED";
}