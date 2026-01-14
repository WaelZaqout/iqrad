<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        // بناء الـ Query بدون تنفيذ
        $reviewsQuery = Review::query();

        // البحث
        if ($q) {
            $reviewsQuery->where('name', 'like', '%' . $q . '%');
        }

        // تنفيذ الاستعلام مع pagination
        $reviews = $reviewsQuery->paginate(10);

        // استجابة Ajax
        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.reviews._rows', compact('reviews'))->render(),
                'pagination' => $reviews->links()->toHtml(),
            ]);
        }

        // عرض الصفحة العادية
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::updateOrCreate(
            [
                'project_id' => $validated['project_id'],
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'تم تقديم تقييمك بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reviews = Review::where('type', 'reviews')->findOrFail($id);
        $reviews->delete();
        return redirect()->back()->with('success', 'تم حذف المستثمر بنجاح.');
    }
}
