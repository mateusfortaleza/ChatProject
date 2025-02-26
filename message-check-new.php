<?php
    require 'business.php';

    if (message_check_new()) {
        echo "{ \"newMessages\": true }";
    } else {
        echo "{ \"newMessages\": false }";
    }

    header('Content-Type: application/json');

?>