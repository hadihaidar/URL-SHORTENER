<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
include "../connection.php";
$app = new \Slim\App;
//$charset = $app->request()->headers()->get('Authorization');
// get list of all urls of the user
$app->get('/{name}', function (Request $request, Response $response, array $args) {
   
   $header = "";
   $headers = $request->getHeaders();
    foreach ($headers as $name => $values) {
        if($name=='HTTP_KEY'){
            $header= implode(", ", $values);
        }
    }
      // $charset = $request->headers->get('ACCEPT_CHARSET');
    $name = $args['name'];
    $array = array();
    global $db;
    $query = $db->query("SELECT * FROM link");
    $n =0;
    foreach ($query as $row) {
        if ($row['email'] == $name && $row['apikey']==$header) {
            $n=1;
            $small = array("original" => $row['original'], "shortened" => $GLOBALS['urlink'] . $row['new']);
            array_push($array, $small);
        }
    }
    if($n==0){return "";}
    $response->getBody()->write(json_encode($array));
    return $response;
});

//add new url
$app->post(
    '/{email}',
    function (Request $request, Response $response, array $args) {
        
        $header = "";
        $headers = $request->getHeaders();
        foreach ($headers as $name => $values) {
            if($name=='HTTP_KEY'){
                $header= implode(", ", $values);
            }
        }
		$body = $request->getParsedBody();
		global $db;
		$email = $args['email'];
        $COUNT = 0;
        
        $query = $db->query("SELECT * FROM users");
        foreach ($query as $row) {
            if ($row['Email'] == $email) {
                $COUNT = 1;
            }
        }
        if ($COUNT == 0) {
            return '';
        } else {
	        $key = $header;
            $url = $db->quote($body['url']);
            $query = $db->query("SELECT * FROM users");
            foreach ($query as $row) {
                if ($row['Email'] == $email && $row['apikey'] == $key) {
                    $generate = generateID();
                    $new =  $db->quote($generate);
                    $email = $db->quote($email);
					$key= $db->quote($key);
                    $query = $db->exec("INSERT INTO link VALUES ($url, $new,$email,$key);");
                    if ($query) {
                        return ($GLOBALS['urlink'] . $generate);
                    } else {
                        return ('');
                    }
                }
            }
            return ('');
        }
    }
);

//delete url using the short link 
$app->delete(
    '/{name}/{url}',
    function (Request $request, Response $response, array $args) {
        global $db;
        $url = $db->quote($args['url']);
        $email = $db->quote($args['name']);
        $header= "";
        $headers = $request->getHeaders();
        foreach ($headers as $name => $values) {
            if($name=='HTTP_KEY'){
                $header= implode(", ", $values);
            }
        }
        $key = $db->quote($header);
        
        
        $query = $db->exec("DELETE FROM link WHERE (new=$url AND email=$email AND apikey=$key)");
        if ($query) {
            return ('url successfully deleted');
        } else {
            return ("url doesn't exist");
        }
    }
);

//update the url
$app->put('/{name}/{short}', function (Request $request, Response $response, array $args) {
    global $db;
    $name =  $db->quote($args['name']);
    $short =  $db->quote($args['short']);
    $body = $request->getParsedBody();
	        $header= "";
        $headers = $request->getHeaders();
        foreach ($headers as $name => $values) {
            if($name=='HTTP_KEY'){
                $header= implode(", ", $values);
            }
        }
        $key = $db->quote($header);
        
    $original = $db->quote($body['original']);
	
    $query = $db->query("UPDATE link SET original=$original WHERE new=$short AND email=$name AND apikey=$key");
    if ($query) {
        return ('link updated');
    } else {
        return 'something went wrong try again';
    }
});

function generateID()
{

    global $db;
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $ID =  substr(str_shuffle($permitted_chars), 0, 5);
    $query = $db->query("SELECT * FROM link");
    foreach ($query as $row) {
        if ($ID == $row['new']) {
            return generateID();
        }
    }
    return $ID;
}
$app->run();
