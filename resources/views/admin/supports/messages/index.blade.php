@extends('admin.master')
@section('title', 'الدعم الفني')

@section('content')
    <div class="container">

        <h2 class="mb-4 fw-bold text-primary">إدارة الدعم الفني</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم المستخدم</th>
                        <th>آخر رسالة</th>
                        <th>عدد الرسائل</th>
                        <th>آخر تحديث</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($conversations as $conversation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $conversation->user->name ?? 'غير معروف' }}
                            </td>

                            <td class="text-start">
                                {{ Str::limit($conversation->latestMessage->message ?? 'لا توجد رسائل', 50) }}
                            </td>

                            <td>
                                {{ $conversation->messages_count }}
                            </td>

                            <td>
                                {{ $conversation->updated_at->diffForHumans() }}
                            </td>

                            <td>
                                <a href="{{ route('support.show', $conversation->id) }}" class="btn btn-sm btn-primary">
                                    عرض
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">لا توجد محادثات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $conversations->links() }}
        </div>

    </div>
@endsection
