<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $rawPostBody = file_get_contents('php://input');
        echo "Raw POST Body: $rawPostBody";
    }
    else
    {
        echo "Hello GET";
    }
?>