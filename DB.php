<?php

$db = mysqli_connect('localhost:3307','root','030515','level1');


if(!$db)
{
    echo "오류 원인 : ", mysqli_connect_error();
    exit();
}

?>