<?php

function generateJoinCode($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $joinCode = '';
    for ($i = 0; $i < $length; $i++) {
        $joinCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $joinCode;
}

function getCurrentTimestamp()
{
    date_default_timezone_set('Asia/Kuala_Lumpur');
    return date('Y-m-d H:i:s');
}
