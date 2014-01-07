<?php

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
        update_user_meta( $user_id, 'stripe_customer_id', $stripe_response->id );

       return $stripe_response->id;

    }

    function stripe_update_user( $stripe_user, $mode = 'test' ) {

        $curl = curl_init();
        $header[] = 'Content-type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: Bearer ' . get_option('stripe_' . $mode . '_secret_key');

        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.stripe.com/v1/customers/' . $stripe_user,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => 'card[number]=' . $_POST['card_number'] . '&card[exp_month]=' . $_POST['exp_month'] . '&card[exp_year]=' . $_POST['exp_year'] . '&card[cvc]=' . $_POST['cvc']
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $stripe_response = json_decode( $resp );
        return $stripe_response;

    }

    function stripe_get_user( $stripe_user, $mode = 'test' ) {

        $curl = curl_init();
        $header[] = 'Content-type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: Bearer ' . get_option('stripe_' . $mode . '_secret_key');

        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.stripe.com/v1/customers/' . $stripe_user,
            CURLOPT_HTTPHEADER => $header
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $stripe_response = json_decode( $resp );
        return $stripe_response;

    }

    function stripe_create_charge( $stripe_user, $mode = 'test' ) {
        
        if ( $stripe_user ) {

            extract( $_POST );

            $amount = ($quantity * $price) * 100;

            // Get cURL resource
            $curl = curl_init();
            $header[] = 'Content-type: application/x-www-form-urlencoded';
            $header[] = 'Authorization: Bearer ' . get_option('stripe_' . $mode . '_secret_key');

            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://api.stripe.com/v1/charges',
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => 'customer=' . $stripe_user . '&amount=' . $amount . '&currency=usd'
            ));

            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            // Close request to clear up some resources
            curl_close($curl);

            $stripe_response = json_decode( $resp );

            return json_decode( $resp );

        }

    }

?>