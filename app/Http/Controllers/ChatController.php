<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use OpenAI;

class ChatController extends Controller
{
    /**
     * Handle user message and return AI response.
     */
    public function handle(Request $request)
    {
        $user = Auth::user();
        $message = $request->input('message');
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            Log::error('OPENAI_API_KEY not set in .env');
            return response()->json([
                'response' => 'حدث خطأ في السيرفر. يرجى التحقق من الإعدادات.'
            ], 500);
        }

        try {
            // Session key per user to avoid overlap
            $sessionKey = 'chat_history_user_' . ($user?->id ?? 'guest');
            $history = Session::get($sessionKey, []);

            // Prepare messages with system prompt
            $messages = [
                [
                    'role' => 'system',
                    'content' => config('openai.system_prompt', 'أنت مساعد مالي ذكي يجيب عن أي أسئلة عن التمويل والاستثمار والقروض.')
                ]
            ];

            // Merge previous history and current message
            $messages = array_merge($messages, $history, [
                ['role' => 'user', 'content' => $message]
            ]);

            // Call OpenAI API
            $client = OpenAI::client($apiKey);
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

            $reply = $response->choices[0]->message->content;

            // Save new exchange to session
            $history[] = ['role' => 'user', 'content' => $message];
            $history[] = ['role' => 'assistant', 'content' => $reply];

            // Keep last 10 messages (5 exchanges)
            if (count($history) > 10) {
                $history = array_slice($history, -10);
            }

            Session::put($sessionKey, $history);

            return response()->json(['response' => $reply]);
        } catch (\Exception $e) {
            Log::error('OpenAI API error: ' . $e->getMessage());
            return response()->json([
                'response' => 'حدث خطأ في السيرفر، يرجى المحاولة لاحقًا.'
            ], 500);
        }
    }
}
