<?php
if(!empty($_GET['s'])){
    include '../class/qrcode.class.php';
    header('Content-Type: image/png');
    QRcode::png($_GET['s'], false, 'L', 9, 2);
}