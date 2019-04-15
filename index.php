<?php 
    $urlWebSocket = "ws://" . $_SERVER['SERVER_ADDR'] . ":8080/";
?><!DOCTYPE HTML>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type = "text/javascript">
            var cnt = 0;
            function runWebSocket() {
                if ("WebSocket" in window) {
                    console.log("WebSocket is supported by your Browser!");
                    // Let us open a web socket
                    var ws = new WebSocket("<?php echo $urlWebSocket; ?>");
                    ws.onopen = function() {
                        
                        // Web Socket is connected, send data using send()
                        ws.send("Message to send");
                        console.log("Message is sent...");
                    };
                    ws.onmessage = function (evt) { 
                        var receivedMsg = evt.data;
                        let color = cnt % 2 === 0 ? '#e0e0e0' : '#d0d0d0';
                        $('#result').html($('#result').html() + "<pre style=\"background-color: " + color + "\">" + receivedMsg + "</pre>");
                        cnt++;
                        $('html, body').animate({scrollTop:$(document).height()}, 'slow');
                    };
                    ws.onclose = function() { 
                        // websocket is closed.
                        console.log("Connection is closed..."); 
                    };
                } else {
                    // The browser doesn't support WebSocket
                    console.log("WebSocket NOT supported by your Browser!");
                }
            }
            $(document).ready(()=>{
                runWebSocket();
            });
        </script>
    </head>
    <body>
        <?php echo $urlWebSocket; ?><br>
        <div id="result">
        </div>
    </body>
</html>