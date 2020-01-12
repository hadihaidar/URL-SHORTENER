<script>
function browser(){
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    
    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
    
    // Safari 3.0+ "[object HTMLElementConstructor]" 
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
    
    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    
    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
    
    // Chrome 1 - 71
    var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
    
    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;
    
    
    var output = '';
    if(isFirefox){output='firefox'}
    else if(isChrome){output='Chrome'}
    else if(isSafari){output='Safari'}
    else if(isOpera){output='Opera'}
    else if(isIE){output='Internet Explorer'}
    else if(isEdge){output='Edge'}
    else {output='Unkown Browser'}
    return (output);
}


//send ajax request to a new page with the ip address and the browser and the short url
</script>

<?php
	include "connection.php";
	$redirect = $_GET['url'];
	$redirect = substr($redirect,1);
	$query = $db->query("SELECT * FROM link");
	


    function getUserIP(){
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
    
        return $ip;
    }
	foreach ($query as $row) {
        if ($row['new'] == $redirect) {
            $x= $db->quote($row['clicks']+1);
            $y= $db->quote($redirect);
            $user_ip = $db->quote(getUserIP());
            $original = $row['original'];
            /////insert the IP address and the url to a table
            echo("<script>
                                var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location = '$original';
                }
            };
            xhttp.open('post', 'userDetails.php' , true);
    		var data = new FormData();
            data.append('browser', browser());
            data.append('ip', $user_ip);
            data.append('url', $y);
            xhttp.send(data);
            </script>
            ");
            
            $query = $db->query("UPDATE link SET clicks=$x WHERE new=$y");
			
		}
	}

	//echo("<h1>Oops, this url doesn't exist</h1>")
?>
<h1>Oops, this url doesn't exist</h1>