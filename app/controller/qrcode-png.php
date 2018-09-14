<?php

use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

/**
 * make sure we are already logged-in
 */

if (is_logged())
{
    /**
     * get user qr_password
     */

    $user = load_model('superadmin/user')->user($_SESSION['user']['user_id'])->row;

    /**
     * show qr code in PNG format
     */

    $qrcode = new BaconQrCodeGenerator;

    $qrcode->format('png');

    $qrcode->size(300);

    header('Content-Type: image/png');

    echo $qrcode->generate($user['qr_password']);

    exit;
}


