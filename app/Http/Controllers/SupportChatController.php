<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;
use App\Models\SupportConversation;
use Illuminate\Support\Facades\Auth;

class SupportChatController extends Controller
{
    public function index()
    {
        // جلب آخر محادثة للمستخدم أو null
        $conversation = SupportConversation::latest()
            ->where('user_id', Auth::id())
            ->first();

        return view('dashboard', compact('conversation'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $conversationId = $request->conversation_id;

        // إذا لم توجد محادثة، أنشئ واحدة جديدة
        if (!$conversationId) {
            $conversation = SupportConversation::create([
                'user_id' => Auth::id(),
                // 'subject' => 'محادثة جديدة',
                'status' => 'open',
            ]);
            $conversationId = $conversation->id;
        }

        SupportMessage::create([
            'conversation_id' => $conversationId,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->back();
    }
}
