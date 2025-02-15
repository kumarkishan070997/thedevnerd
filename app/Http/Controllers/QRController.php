<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRController extends Controller
{
    public function show(){
        return view('QR.show');
    }
    public function generateQR(Request $request){
        $detail = $request->input('detail');
        switch ($request->input('action')) {
            case 'generateQR':
                $image = $this->generateSimpleQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            
            case 'generateColoredQR':
                $image = $this->generateColoredQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
    
            case 'generateDottedQR':
                $image = $this->generateDottedQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generateGradientQR':
                $image = $this->generateGradientQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generateEmailQR':
                $image = $this->generateEmailQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generatePhoneNumberQR':
                $image = $this->generatePhoneNumberQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generateSmsQR':
                $image = $this->generateSmsQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generateWifiQR':
                $image = $this->generateWifiQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            case 'generateGeoQR':
                $image = $this->generateGeoQR($detail);
                return redirect()->route('qr.show')->with('image', $image);
            default:
                return redirect()->back()->with('error', 'Invalid action');
        }
    }
    public function generateSimpleQR($detail){
        return QrCode::generate(
            $detail,
        );
    }
    public function generateColoredQR($detail){
        return QrCode::size(200)
                ->backgroundColor(173, 216, 230)
                ->color(128, 0, 128)
                ->margin(1)
                ->generate($detail);

    }
    public function generateDottedQR($detail){
        return QrCode::size(200)
                ->style('dot')
                ->eye('circle')
                ->backgroundColor(173, 216, 230)
                ->color(128, 0, 128)
                ->margin(1)
                ->generate($detail);
    }
    public function generateGradientQR($detail){
        return QrCode::size(200)
                ->style('dot')
                ->eye('circle')
                ->backgroundColor(173, 216, 230)
                ->gradient(255, 182, 193, 128, 0, 128, 'diagonal')
                ->color(128, 0, 128)
                ->margin(1)
                ->generate($detail);
    }
    public function generateEmailQR($detail){
        return QrCode::size(200)
                ->email('hello@thedevnerd.com', 'This is the email subject', 'This is the email body');
    }
    public function generatePhoneNumberQR($detail){
        return QrCode::size(200)
                ->phoneNumber('555-555-5555');
    }
    public function generateSmsQR($detail){
        return QrCode::size(200)
                ->SMS('555-555-5555');
    }
    public function generateWifiQR($detail){
        return QrCode::size(200)->wiFi([
            'encryption' => 'WPA/WEP',
            'ssid' => 'SSID of the network',
            'password' => 'Password of the network',
            'hidden' => 'Whether the network is a hidden SSID or not.'
        ]);
    }
    public function generateGeoQR($detail){
        return QrCode::size(200)
                    ->geo(40.748817, -73.985428);
    }
    
}
