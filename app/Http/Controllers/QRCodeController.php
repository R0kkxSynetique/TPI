<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function downloadQr($rcModelId)
    {
        $path = storage_path('app/QRCodes/') . $rcModelId . ".svg";

        if (!file_exists($path)) {
            $this->createQr($rcModelId);
        }
        return response()->download($path, "QRCode.svg");
    }

    public function createQr($rcModelId)
    {
        $path = storage_path('app/QRCodes/') . $rcModelId . ".svg";
        // $url = env('APP_URL') . '/rc-models/'. $rcModelId;
        $url = "http://192.168.160.69" . '/rc-models/' . $rcModelId . '/guest';
        $headers = array(
            'Content-Type: image/svg+xml',
        );
        $salt = "Aeromodel";
        $content = "QrCodeGenerated";
        $userId = Auth::user()->id;

        $token = md5($salt . $content . $userId . "-" . $rcModelId);

        DB::transaction(function () use ($rcModelId, $token) {
            DB::table('rc_models')
                ->where('id', $rcModelId)
                ->update(['identification_token' => $token]);
        });

        $url .= "?token=" . $token;

        QrCode::size(500)->gradient(41, 61, 172, 145, 24, 159, "vertical")->generate($url, $path, $headers);

        return;
    }
}
