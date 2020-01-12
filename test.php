
<?php
function getShortenedURL($longURL)

{
    $email = "hadi@gmail.com";
    $apikey = "36e87da838a987e4750c28240223e702";
    $url = "http://ilnk.ml/api/$email/$apikey";
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "url=$longURL",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
        "cache-control: no-cache"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
}

?>
<?php
if(isset($_POST["get"])){
    $x =getShortenedURL($_POST["url"]);
  
}

?>

<html>
    <head>
        
    </head>
    <body>
        <form action="" method="POST">
            
        <input type="text" name="url" />
        <button name="get" type ="submit">Test</button>
        </form>
    </body>
</html>
