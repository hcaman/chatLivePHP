<?php
    include('../config.php');

    switch($_REQUEST['action']){
        case "sendMessage":
            //global $db;
            session_start();
            $query = $db->prepare("INSERT INTO messages SET user=?, message=?");

            $run = $query->execute([$_SESSION['username'], $_REQUEST['message']]);
            
            if($run){
                echo 1;
                exit;
            }
        break;
        case "getMessage":            
            $query = $db->prepare("SELECT * FROM messages");
            $run = $query->execute();
            $rs = $query->fetchAll(PDO::FETCH_OBJ);
            $chat = '';
            foreach($rs as $message){
                /*$chat .= $message->message . '<br />';*/
                $chat .= '<div class="singleMessage">
                            <strong>'.$message->user.': </strong> '.$message->message.
                            '<span>'.date('m-d-Y h:i a', strtotime($message->data)).'</span></div>';
            }
            echo $chat;
        break;
    }
?>