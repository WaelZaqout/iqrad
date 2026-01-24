@extends('admin.master')
@section('title', 'إدارة الدعم الفني')
@section('content')

    <div class="container">
        <h2 class="mb-4">إدارة الدعم الفني</h2>
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>المستخدم: {{ $conversation->user->name ?? 'غير معروف' }}</strong>
                <span>عدد الرسائل: {{ $conversation->messages->count() }}</span>
            </div>

            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @foreach ($conversation->messages as $msg)
                    <div
                        class="mb-2 p-2 rounded
                {{ $msg->sender_id == Auth::id() ? 'bg-primary text-white text-end' : 'bg-light' }}">

                        <small>
                            {{ $msg->sender_id == Auth::id() ? 'أنت' : $msg->sender->name ?? 'المستخدم' }}
                            - {{ $msg->created_at->format('d/m/Y H:i') }}
                        </small>

                        <p class="mb-0">{{ $msg->message }}</p>
                    </div>
                @endforeach
            </div>

            <div class="card-footer">
                <form action="{{ route('support.reply') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <input type="text" name="message" class="form-control" placeholder="اكتب ردك هنا" required>
                    <button class="btn btn-success">إرسال</button>
                </form>
            </div>
        </div>


    </div>

@endsection
