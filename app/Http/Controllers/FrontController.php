<?php

namespace App\Http\Controllers;


use OpenAI;
use OpenAI\Client;
use App\Models\User;
use App\Models\Review;
use App\Models\Project;
use App\Models\Category;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Models\SupportConversation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Notifications\ApplicationAcceptedNotification;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        return view('front.index', [
            'categories' => Category::orderedByLocale(app()->getLocale())->get(),

            'projects'   => Project::visibleTo(Auth::user())->latest()->get(),

            'stats'      => Project::homepageStats(),

            'reviews'    => Review::homepage(),
            'userReview' => Auth::user()?->review,
            'averageRating' => Review::averageRating(),
            'reviewsCount'  => Review::ratingsCount(),
        ]);
    }


    /**
     * Show the dashboard for authenticated users (passes categories)
     */
    public function dashboard()
    {
        $user = Auth::user();

        return view('front.dashboard', [
            'categories'       => Category::orderedByLocale(app()->getLocale())->get(),
            'projects'         => Project::with('category')->visibleTo($user)->paginate(10)->withQueryString(),
            'stats'            => Project::homepageStats(),
            'conversation'     => $user?->latestConversation,
            'upcomingPayments' => $user?->upcomingPayments ?? 0,
        ]);
    }
        public function filter(Request $request)
        {
            $status = $request->query('status', 'all');
            $category = $request->query('category'); // يمكن أن يكون null

            $projects = Project::with('category')
                ->withInvestmentsSum()
                ->active()
                ->ofStatus($status);

            if ($category) {
                $projects->ofCategory($category);
            }

            $projects = $projects->latest()->paginate(10);

            return view('front.partials.projects-cards', compact('projects'))->render();
        }


    public function details($id)
    {
        $user = Auth::user();

        $project = Project::with(['borrower', 'reviews.user'])->findOrFail($id);

        $reviews = $project->reviews->sortByDesc('created_at'); // استخدام Collection بدل Query عدة مرات
        $averageRating = round($reviews->avg('rating'), 1);
        $reviewsCount = $reviews->count();
        $userReview = $reviews->firstWhere('user_id', $user?->id);

        return view('front.partials.details', [
            'categories' => Category::orderedByLocale(app()->getLocale())->get(),
            'project' => $project,
            'borrower' => $project->borrower,
            'remaining' => $project->remaining(),
            'financialPlan' => $project->financialPlan,
            'stats' => $project->homepageStats(),
            'reviews' => $reviews,
            'userReview' => $userReview,
            'averageRating' => $averageRating,
            'reviewsCount' => $reviewsCount,
        ]);
    }


    public function project()
    {

        $user = Auth::user();

        return view('front.project', [
            'categories'       => Category::orderedByLocale(app()->getLocale())->get(),
            'projects'         => Project::with('category')->visibleTo($user)->paginate(10)->withQueryString(),
            'stats'            => Project::homepageStats(),
        ]);
    }
    public function favorites()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $favorites = $user->favorites->with('project')->paginate(20); // أفضل من get() إذا كانت البيانات كثيرة

        return view('front.favorites', compact('favorites'));
    }

    public function notification()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $notifications = $user->notifications()->latest()->take(50)->get();

        return view('front.partials.notification', compact('notifications'));
    }


    public function markRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }


        $count = $user->unreadNotifications->count();
        $user->unreadNotifications->update(['read_at' => now()]);

        return response()->json([
            'status' => 'success',
            'marked' => $count
        ]);
    }



    // public function filter(Request $request)
    // {
    //     $status = $request->status;

    //     $projects = Project::with('category')->ofStatus($status)->latest()->paginate(10);

    //     return view('front.partials.projects-cards', compact('projects'))->render();
    // }
}
