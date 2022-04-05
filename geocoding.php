<?php

// Create an API key in the Google Cloud Console
// https://console.cloud.google.com/

$key = '';
$address = urlencode('205 Humber College Blvd, Etobicoke, ON M9W 5L7');

?>
<!doctype html>
<html>
    <head>
        <title>Google Books API</title>
    </head>
    <body>

        <h1>Google Books API</h1>

        <hr>

        <h2>Lookup Place Using Address</h2>

        <?php

        // Define the endpoint to look up a place using an address

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        $lat = $data['results'][0]['geometry']['location']['lat'];
        $lng = $data['results'][0]['geometry']['location']['lng'];
        $place_id = $data['results'][0]['place_id'];
        $formatted_address = $data['results'][0]['formatted_address'];

        if($lat)
        {
            echo '<p>Formatted Address: '.$formatted_address.'</p>';
            echo '<p>Place ID: '.$place_id.'</p>';
            echo '<p>Geocode: '.$lat.','.$lng.'</p>';
        }

        echo '<hr>';

        echo '<pre>';
        print_r($data);
        echo '</pre>';

        ?>

        <hr>

        <h2>Generate Map Image</h2>

        <?php

        // Generate an image of Humber on a map using the Google Static Maps API

        if($lat)
        {
            $image = 'https://maps.googleapis.com/maps/api/staticmap'.
                '?center='.$lat.','.$lng.
                '&zoom=13&size=600x600'.
                '&maptype=roadmap'.
                '&markers=color:red|label:A|'.$lat.','.$lng.
                '&key='.$key.'">';
            echo '<img src="'.$image.'">';
        }

        ?>

    </body>

</html>