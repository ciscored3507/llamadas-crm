<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\VoiceResponse;

class TwilioVoiceController extends Controller
{
    public function bridge(Request $request)
    {
        $customer = $request->query('customer');

        if (!is_string($customer) || !preg_match('/^\+[1-9]\d{1,14}$/', $customer)) {
            abort(422, 'Invalid customer number');
        }

        $twiml = new VoiceResponse();
        $twiml->say('Conectando su llamada.', ['language' => 'es-MX']);

        $dial = $twiml->dial('', [
            'callerId' => config('services.twilio.from_number'),
        ]);

        $dial->number($customer);

        return response((string)$twiml, 200)->header('Content-Type', 'text/xml');
    }

    public function status(Request $request)
    {
        Log::info('Twilio status callback', $request->all());
        return response()->json(['ok' => true]);
    }
}
