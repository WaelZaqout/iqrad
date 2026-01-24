<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Support\Facades\Auth;

class AdminSupportController extends Controller
{
    public function index()
    {
        $conversations = SupportConversation::with([
            'user',
            'latestMessage'
        ])
            ->withCount('messages')
            ->latest()
            ->paginate(10);

        return view('admin.supports.messages.index', compact('conversations'));
    }
    public function show($id)
    {
        $conversation = SupportConversation::with([
            'messages.sender',
            'user'
        ])->findOrFail($id);

        return view('admin.supports.messages.show', compact('conversation'));
    }



    public function reply(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:support_conversations,id',
            'message' => 'required|string',
        ]);

        SupportMessage::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::id(),  // لا حاجة guard لأنك داخل لوحة التحكم
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'تم إرسال الرد بنجاح');
    }
}
