<?php 
    require_once 'Database.php';
    session_start();
    
    $id = $_SESSION['user_id'];


   
    $url = $_POST['url'];
    //$url = 'https://www.facebook.com';
    $pattern = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})';
    $port = 443;
    

    if(!isset($url) || preg_match($pattern, $url) != 1 || !isset($id)){
        //return to the main page
        header('Location: main.php');
    }

    $host = parse_url($url, PHP_URL_HOST);


    $contextOptions = [
        "ssl" => [
            "capture_peer_cert" => true,
            "verify_peer" => false,
            "verify_peer_name" => false
        ]
        ];

    
    $context = stream_context_create($contextOptions);

    //Opens sockets connection to get SSL certificate 
    $client = @stream_socket_client(
        "ssl://$host:$port",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $context
    );



    //parse the ssl certificates
    $params = stream_context_get_params($client);
    $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);



    //extract useful ssl certificate fields
    $certName = $cert['subject']['CN'] ?? 'N/A';
    $certIssuer = $cert['issuer']['CN'] ?? 'N/A';
    
    //Converts expiration date from UNIX time to a readable format
    $certExpireUnix = $cert['validTo_time_t'] ?? 0;
    $certExpireDate = date('Y-m-d H:i:s', $certExpireUnix);





    //uses cURL to get http response and ssl protocol
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    curl_exec($ch);


    //retreive information
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseHeader = curl_getinfo($ch, CURLINFO_HEADER_OUT);
    //$sslProtocol = curl_getinfo($ch, CURLINFO_SSL_VERSION); Could not get this to work
    curl_close($ch);


    $query = 'INSERT INTO url
              (url_name, user_id, certName, certIssuer, certExpirate, responseCode)
              VALUES 
              (:url, :id, :certName, :certIssuer, :certExpireDate, :responseCode)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':url', $url);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':certName', $certName);
    $statement->bindValue(':certIssuer', $certIssuer);
    $statement->bindValue(':certExpireDate', $certExpireDate);
    $statement->bindValue(':responseCode', $responseCode);
    $statement->execute();
    $statement->closeCursor();

    header('Location: main.php');
    
   

/*

echo "The URL " . $url . " ";
echo "User ID: " . $id . " ";

    echo "🔒 SSL Certificate Information:\n ";
echo "  Common Name (CN): $certName\n ";
echo "  Issuer: $certIssuer\n";
echo "  Expiration Date: $certExpireDate\n ";

echo "\n🌐 HTTP Response Information:\n ";
echo "  Response Code: $responseCode " . "\n";
echo "Response Header: " . $responseHeader;
//echo "  SSL Protocol: $sslProtocol\n"; Could not get this to work


*/










?>