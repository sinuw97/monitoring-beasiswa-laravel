<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Google_Client;
use App\Http\Controllers\Controller;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(config('filesystems.disks.google.clientId'));
        $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->addScope('https://www.googleapis.com/auth/drive');

        return redirect()->away($client->createAuthUrl());
    }

    public function handlegoogleCallback(Request $request) {

        if (!$request->code) {
            return redirect('/')->with('error', 'Authorization code tidak ditemukan!');
        }

        $client = new Google_Client();
        $client->setClientId(config('filesystems.disks.google.clientId'));
        $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $client->setRedirectUri(url('/google/callback'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['refresh_token'])) {
            return response()->json([
                'refresh_token' => $token['refresh_token']
            ]);
        }

        return redirect('/')->with('error', 'refresh_token tidak ditemukan');
    }
}
