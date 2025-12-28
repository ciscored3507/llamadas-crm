<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class CallController extends Controller
{
    public function create()
    {
        return view('calls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_number' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
            'agent_number'    => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
        ]);

        $client = new Client(
            config('services.twilio.account_sid'),
            config('services.twilio.auth_token')
        );

        // Webhook TwiML: Twilio lo consultará cuando el agente conteste
        $bridgeUrl = route('twilio.voice.bridge', [], true) . '?customer=' . urlencode($validated['customer_number']);

        // Callback de estados (para log/auditoría)
        $statusUrl = route('twilio.voice.status', [], true);

        try {
            $call = $client->calls->create(
                $validated['agent_number'],            // To (agente)
                config('services.twilio.from_number'), // From (tu número Twilio)
                [
                    'url' => $bridgeUrl,
                    'method' => 'POST',

                    'statusCallback' => $statusUrl,
                    'statusCallbackMethod' => 'POST',
                    'statusCallbackEvent' => ['initiated', 'ringing', 'answered', 'completed'],
                ]
            );

            return back()->with('status', 'Llamada iniciada. CallSid: ' . $call->sid);
        } catch (\Throwable $e) {
            Log::error('Twilio call create failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['twilio' => $e->getMessage()]);
        }
    }
}
