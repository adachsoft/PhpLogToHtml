<?php 
    if( 'cli-server'===php_sapi_name() ){
        [$ip, $port] = explode(':', $_SERVER['HTTP_HOST']);
    }else{
        $ip = $_SERVER['SERVER_ADDR'];
    }
    $urlWebSocket = "ws://{$ip}:8080/";

    /*var_dump(php_sapi_name());

    $host= gethostname();
$ip = gethostbyname($host);
var_dump($host, $ip, $_SERVER);*/

?><!DOCTYPE HTML>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type = "text/javascript">
            var cnt = 0;
            function runWebSocket() {
                if ("WebSocket" in window) {
                    var ws = new WebSocket("<?php echo $urlWebSocket; ?>");
                    ws.onopen = () => {

                    };
                    ws.onmessage = (evt) => { 
                        let receivedMsg = evt.data;
                        //let color = cnt % 2 === 0 ? '#e0e0e0' : '#d0d0d0';
                        //$('#result').html($('#result').html() + "<pre style=\"background-color: " + color + "\">" + receivedMsg + "</pre>");
                        $('#result').html($('#result').html() + "<pre>" + receivedMsg + "</pre>");
                        cnt++;
                        $('html, body').animate({scrollTop:$(document).height()}, 'fast');
                    };
                    ws.onclose = () => { 
                        
                    };
                } else {
                    console.log("WebSocket NOT supported by your Browser!");
                }
            }
            function clearAll(){
                $('#result').html('');
            }
            $(document).ready(()=>{
                runWebSocket();
            });
        </script>
        <style>
            pre{
                padding: 5px;
                color: #808080;
                border-top: 1px #ffffff dotted;
            }
            div#result{
                padding: 5px;
                background-color: black;
            }
            div#header{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 50px;
                background-color: #3399ff;
            }
        </style>
    </head>
    <body>
        <div id="header">
            <?php echo $urlWebSocket; ?> <button type="button" onclick="clearAll()">Clear all</button>
        </div>
        <div id="result"></div>
    </body>
</html>