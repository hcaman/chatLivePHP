<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="style.css">

        <title>ChatInLive</title>
    </head>
    <body>     

        <?php
            //session_destroy();
        ?>

        <div id="wrapper">
            <h1>Welcome <?php session_start(); echo $_SESSION['username']; ?> to my ChatInLive </h1>
            <div class="chat_wrapper">
                <div id="chat">                    
                </div>
                <form id="messageForm" action="" method="post">
                    <textarea class="textarea" name="message" cols="30" rows="7"></textarea>
                </form>
            </div>
        </div>

    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
    </script>
    <script>
        LoadChat();
        setInterval(function(){
            LoadChat();
        }, 1000);
        function LoadChat(){
            $.post('handlers/messages.php?action=getMessage', function(response){

				var scrollpos = $('#chat').scrollTop();
				var scrollpos = parseInt(scrollpos) + 520;
				var scrollHeight = $('#chat').prop('scrollHeight');

                $('#chat').html(response);
                if( scrollpos < scrollHeight ) {

                } else {
                    $('#chat').scrollTop( $('#chat').prop('scrollHeight') );
                }
            });
        }
        $('.textarea').keyup(function(e){
            //alert($(this).val()); // se puede usar para especificar el valor de una tecla
            
            if( e.which == 13 ){ //13 es el valor de la tecla enter
                $('form').submit();
            }
        });
        $('form').submit(function(){
            var message = $('.textarea').val();
            $.post('handlers/messages.php?action=sendMessage&message='+message, function(response){
                //alert(response);
                if(response==1){
                    LoadChat();
                    document.getElementById('messageForm').reset();
                }
            });
            return false;
        });
    </script>
    </body>
</html>