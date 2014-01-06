<?php
    
    function stripe_create_token() {

        $curl = curl_init();
        $header[] = 'Content-type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: Bearer ' . get_option('stripe_test_secret_key');

        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.stripe.com/v1/tokens' ,
                CURLOPT_HTTPHEADER => $header,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'card[number]=' . $_POST['card_number'] . '&card[exp_month]=' . $_POST['exp_month'] . '&card[exp_year]=' . $_POST['exp_year'] . '&card[cvc]=' . $_POST['cvc']
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $stripe_response = json_decode( $resp );

        if ( isset($stripe_response->id) ) return $stripe_response->id;
        else return false;

    }

    function stripe_create_user( $user_id, $mode = 'test' ) {

        $user = get_userdata( $user_id );

        $curl = curl_init();
        $header[] = 'Content-type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: Bearer ' . get_option('stripe_' . $mode . '_secret_key');

        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.stripe.com/v1/customers' ,
                CURLOPT_HTTPHEADER => $header,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'description=' . $user->data->display_name . '&email=' . $user->data->user_email
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $stripe_response = json_decode( $resp );

        print_r( $stripe_response );

    }

?>