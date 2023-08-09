<?php
    $conx = mysqli_connect("localhost","root","","senior");
    if(!$conx){
        echo 'Connection Failed';
    }
