<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function downloadQr($rcModelId)
    {
        $path = storage_path('app/QRCodes/') . $rcModelId . ".svg";
        $url = 'Http://192.168.17.69/rc-models/'. $rcModelId;
        $headers = array(
            'Content-Type: image/svg+xml',
        );
        
        QrCode::size(500)->gradient(41, 61, 172, 145, 24, 159, "vertical")->generate($url, $path, $headers);

        return response()->download($path, "QRCode.svg");
    }
}
