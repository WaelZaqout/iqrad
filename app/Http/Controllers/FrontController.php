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
        // جميع المشاريع
        $categories = Category::orderBy('name')->get();
        $projects = Project::with('category')->get();
        $investments = Investment::with('project')->get(); // جلب كل الاستثمارات مع المشروع
        $reviews = Review::with(['user', 'project'])
            ->latest()
            ->take(10) // عدد الآراء في الصفحة الرئيسية
            ->get();
        // مجموع التمويل الفعلي والهدف لكل المشاريع
        $fundedAmount = $projects->sum('funded_amount');
        $fundingGoal  = $projects->sum('funding_goal');
        $percentage   = $fundingGoal > 0 ? round(($fundedAmount / $fundingGoal) * 100) : 0;
        // حالات المشاريع
        $activeProjects    = $projects->where('status', 'active')->count();
        $pendingProjects    = $projects->where('status', 'pending')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        $approvedProjects  = $projects->where('status', 'approved')->count(); // إذا احتجته
        $fundedProjects    = $projects->where('status', 'funding')->count();
        $requiredFunding = Project::where('status', 'approved')->sum('funding_goal');

        $statusStyles = [
            'draft' => ['class' => 'secondary', 'icon' => 'fas fa-pencil-alt', 'label' => 'مسودة'],
            'pending' => [
                'class' => 'warning',
                'icon' => 'fas fa-hourglass-half',
                'label' => 'قيد الانتظار',
            ],
            'approved' => [
                'class' => 'success',
                'icon' => 'fas fa-check-circle',
                'label' => 'موافق عليه',
            ],
            'funding' => ['class' => 'info', 'icon' => 'fas fa-coins', 'label' => 'تمويل جاري'],
            'active' => ['class' => 'primary', 'icon' => 'fas fa-play-circle', 'label' => 'نشط'],
            'completed' => [
                'class' => 'success',
                'icon' => 'fas fa-flag-checkered',
                'label' => 'مكتمل',
            ],
            'defaulted' => [
                'class' => 'danger',
                'icon' => 'fas fa-exclamation-triangle',
                'label' => 'متأخر الدفع',
            ],
        ];


        // --- الحسابات المالية ---

        // إجمالي رأس المال المستثمر
        $totalCapital = $investments->sum('amount');

        // الأرباح المستلمة (status = paid)
        $receivedProfits = $investments->where('status', 'paid')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // الأرباح المتوقعة (status = pending)
        $expectedProfits = $investments->where('status', 'pending')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // حساب المبلغ الممول لكل مشروع
        foreach ($projects as $project) {
            $project->funded_amount = $investments
                ->where('project_id', $project->id)
                ->sum('amount');
        }


        $averageRating = round(Review::avg('rating'), 1);
        $reviewsCount  = Review::count();

        $userReview = Auth::check()
            ? Review::where('user_id', Auth::id())->first()
            : null;

        $user = Auth::user();

        if ($user) {
            // تحديث جميع الإشعارات غير المقروءة لتصبح مقروءة
            $user->unreadNotifications->markAsRead();

            // جلب آخر 5 إشعارات بعد التحديث
            $notifications = $user->notifications
                ->sortByDesc('created_at')
                ->take(5); // هنا نأخذ فقط آخر 5 إشعارات

            $unreadNotifications = collect(); // بما أن كل الإشعارات أصبحت مقروءة
        } else {
            $notifications = collect();
            $unreadNotifications = collect();
        }

        return view('front.index', compact(
            'categories',
            'projects',
            'percentage',
            'statusStyles',
            'activeProjects',
            'notifications',
            'unreadNotifications',
            'pendingProjects',
            'completedProjects',
            'fundedProjects',
            'approvedProjects',
            'totalCapital',
            'requiredFunding',
            'receivedProfits',
            'expectedProfits',
            'investments',
            'reviews',
            'averageRating',
            'reviewsCount',
            'userReview'

        ));
    }

    /**
     * Show the dashboard for authenticated users (passes categories)
     */
    public function dashboard()
    {
        // جميع المشاريع
        $projects = Project::with('category')->get();

        // مجموع التمويل الفعلي والهدف لكل المشاريع
        $fundedAmount = $projects->sum('funded_amount');
        $fundingGoal  = $projects->sum('funding_goal');
        $percentage   = $fundingGoal > 0 ? round(($fundedAmount / $fundingGoal) * 100) : 0;
        // حالات المشاريع
        $activeProjects    = $projects->where('status', 'active')->count();
        $pendingProjects    = $projects->where('status', 'pending')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        $approvedProjects  = $projects->where('status', 'approved')->count(); // إذا احتجته
        $fundedProjects    = $projects->where('status', 'funding')->count();
        $requiredFunding = Project::where('status', 'approved')->sum('funding_goal');
        // $nextInstallments = Installment::where('due_date', '>=', today())
        //     ->where('status', 'unpaid')
        //     ->count();

        // نسبة الإنجاز

        $categories = Category::orderBy('name')->get();

        // --- الحسابات المالية ---
        $investments = Investment::with('project')->get(); // جلب كل الاستثمارات مع المشروع

        // إجمالي رأس المال المستثمر
        $totalCapital = $investments->sum('amount');

        // الأرباح المستلمة (status = paid)
        $receivedProfits = $investments->where('status', 'paid')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // الأرباح المتوقعة (status = pending)
        $expectedProfits = $investments->where('status', 'pending')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // حساب المبلغ الممول لكل مشروع
        foreach ($projects as $project) {
            $project->funded_amount = $investments
                ->where('project_id', $project->id)
                ->sum('amount');
        }

        return view('front.dashboard', compact(
            'categories',
            'projects',
            'percentage',
            'activeProjects',
            'pendingProjects',
            'completedProjects',
            'fundedProjects',
            'approvedProjects',
            'totalCapital',
            'requiredFunding',
            'receivedProfits',
            'expectedProfits',
            'investments'
        ));
    }

    public function all()
    {
        $projects = Project::with('category')
            ->where('status', '!=', 'draft')
            ->latest()
            ->get();

        // تجهيز JSON مبسط يحتوي الحقول التي يحتاجها الـ frontend
        $items = $projects->map(function ($p) {
            $funded = (float) $p->investments()->sum('amount');
            $percentage = $p->funding_goal > 0 ? (int) round(($funded / $p->funding_goal) * 100) : 0;

            return [
                'id' => $p->id,
                'title' => $p->title,
                'summary' => $p->summary,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
                'created_at' => $p->created_at ? $p->created_at->toIso8601String() : null,
                'category' => $p->category ? ['id' => $p->category->id, 'name' => $p->category->name] : null,
                'term_months' => $p->term_months,
                'min_investment' => $p->min_investment,
                'funding_goal' => $p->funding_goal,
                'funded_amount' => $funded,
                'percentage' => $percentage,
                'interest_rate' => $p->interest_rate,
            ];
        });

        return response()->json($items);
    }

    public function filterByCategory($categoryId)
    {
        $projects = Project::with('category')
            ->where('category_id', $categoryId)
            ->where('status', '!=', 'draft')
            ->latest()
            ->get();

        // تجهيز JSON مبسط كما في all()
        $items = $projects->map(function ($p) {
            $funded = (float) $p->investments()->sum('amount');
            $percentage = $p->funding_goal > 0 ? (int) round(($funded / $p->funding_goal) * 100) : 0;

            return [
                'id' => $p->id,
                'title' => $p->title,
                'summary' => $p->summary,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
                'created_at' => $p->created_at ? $p->created_at->toIso8601String() : null,
                'category' => $p->category ? ['id' => $p->category->id, 'name' => $p->category->name] : null,
                'term_months' => $p->term_months,
                'min_investment' => $p->min_investment,
                'funding_goal' => $p->funding_goal,
                'funded_amount' => $funded,
                'percentage' => $percentage,
                'interest_rate' => $p->interest_rate,
            ];
        });

        return response()->json($items);
    }

    public function details($id)
    {
        $project = Project::with('borrower')->findOrFail($id);
        $borrower = $project->borrower;
        $reviews = $project->reviews()->with('user')->latest()->get();

        $averageRating = round($project->reviews()->avg('rating'), 1);
        $reviewsCount  = $project->reviews()->count();

        $userReview = Auth::check()
            ? $project->reviews()->where('user_id', Auth::id())->first()
            : null;

        // توزيع التمويل (مثال: نسب ثابتة، يمكن تعديلها)
        $financialDistribution = [
            'تطوير المنصة التقنية' => $project->funding_goal * 0.4,
            'المحتوى التعليمي' => $project->funding_goal * 0.25,
            'التسويق والترويج' => $project->funding_goal * 0.15,
            'التدريب والدعم الفني' => $project->funding_goal * 0.1,
            'التكاليف الإدارية' => $project->funding_goal * 0.1,
        ];

        // توقعات الإيرادات والأرباح للسنة الأولى والثانية والثالثة
        $years = ['الأولى', 'الثانية', 'الثالثة'];
        $financialPlan = [];
        $initialRevenue = $project->funding_goal * 0.3; // الإيرادات المتوقعة للسنة الأولى
        $cost = $project->funding_goal * 0.25; // التكلفة الافتراضية

        foreach ($years as $i => $year) {
            $revenue = $initialRevenue * pow(2, $i); // مضاعفة الإيرادات تقريبا كل سنة
            $financialPlan[] = [
                'year' => $year,
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $revenue - $cost,
                'profit_percent' => round((($revenue - $cost) / $cost) * 100, 1),
            ];
        }


        $percentage = $project->funding_goal > 0
            ? round(($project->funded_amount / $project->funding_goal) * 100)
            : 0;
        $remaining = max($project->funding_goal - $project->funded_amount, 0);

        return view('front.partials.details', compact(
            'project',
            'percentage',
            'borrower',
            'remaining',
            'financialDistribution',
            'financialPlan',
            'reviews',
            'averageRating',
            'reviewsCount',
            'userReview'
        ));
    }


    public function project()
    {
        // جميع المشاريع
        $categories = Category::orderBy('name')->get();
        $projects = Project::with('category')->get();


        // مجموع التمويل الفعلي والهدف لكل المشاريع
        $fundedAmount = $projects->sum('funded_amount');
        $fundingGoal  = $projects->sum('funding_goal');
        $percentage   = $fundingGoal > 0 ? round(($fundedAmount / $fundingGoal) * 100) : 0;
        // حالات المشاريع

        $activeProjects    = $projects->where('status', 'active')->count();
        $pendingProjects    = $projects->where('status', 'pending')->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        $approvedProjects  = $projects->where('status', 'approved')->count(); // إذا احتجته
        $fundedProjects    = $projects->where('status', 'funding')->count();
        $requiredFunding = Project::where('status', 'approved')->sum('funding_goal');

        $statusStyles = [
            'draft' => ['class' => 'secondary', 'icon' => 'fas fa-pencil-alt', 'label' => 'مسودة'],
            'pending' => [
                'class' => 'warning',
                'icon' => 'fas fa-hourglass-half',
                'label' => 'قيد الانتظار',
            ],
            'approved' => [
                'class' => 'success',
                'icon' => 'fas fa-check-circle',
                'label' => 'موافق عليه',
            ],
            'funding' => ['class' => 'info', 'icon' => 'fas fa-coins', 'label' => 'تمويل جاري'],
            'active' => ['class' => 'primary', 'icon' => 'fas fa-play-circle', 'label' => 'نشط'],
            'completed' => [
                'class' => 'success',
                'icon' => 'fas fa-flag-checkered',
                'label' => 'مكتمل',
            ],
            'defaulted' => [
                'class' => 'danger',
                'icon' => 'fas fa-exclamation-triangle',
                'label' => 'متأخر الدفع',
            ],
        ];

        $categories = Category::orderBy('name')->get();

        // --- الحسابات المالية ---
        $investments = Investment::with('project')->get(); // جلب كل الاستثمارات مع المشروع

        // إجمالي رأس المال المستثمر
        $totalCapital = $investments->sum('amount');

        // الأرباح المستلمة (status = paid)
        $receivedProfits = $investments->where('status', 'paid')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // الأرباح المتوقعة (status = pending)
        $expectedProfits = $investments->where('status', 'pending')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // حساب المبلغ الممول لكل مشروع
        foreach ($projects as $project) {
            $project->funded_amount = $investments
                ->where('project_id', $project->id)
                ->sum('amount');
        }

        return view('front.project', compact(
            'categories',
            'projects',
            'percentage',
            'statusStyles',
            'activeProjects',
            'pendingProjects',
            'completedProjects',
            'fundedProjects',
            'approvedProjects',
            'totalCapital',
            'requiredFunding',
            'receivedProfits',
            'expectedProfits',
            'investments'
        ));
    }
    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('project')->get();

        return view('front.favorites', compact('favorites'));
    }
    public function notification()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        return view('front.partials.notfication', compact('notifications'));
    }
    public function markRead(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }

    public function handle(Request $request)
    {
        $message = $request->input('message');

        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            Log::error('OPENAI_API_KEY غير محدد في ملف .env');
            return response()->json([
                'response' => 'مفتاح OpenAI API غير محدد. يرجى التحقق من ملف .env'
            ], 500);
        }

        try {
            // Retrieve conversation history from session
            $history = Session::get('chat_history', []);

            // Prepare messages array starting with system prompt
            $messages = [
                ['role' => 'system', 'content' => 'أنت مساعد مالي ذكي يجيب على أي أسئلة عن التمويل والاستثمار والقروض.']
            ];

            // Add previous conversation history
            $messages = array_merge($messages, $history);

            // Add current user message
            $messages[] = ['role' => 'user', 'content' => $message];
            $client = OpenAI::client($apiKey);

            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

            $reply = $response->choices[0]->message->content;

            // Add AI response to history
            $history[] = ['role' => 'user', 'content' => $message];
            $history[] = ['role' => 'assistant', 'content' => $reply];

            // Limit history to last 10 messages (5 exchanges)
            if (count($history) > 10) {
                $history = array_slice($history, -10);
            }

            // Save updated history to session
            Session::put('chat_history', $history);

            return response()->json([
                'response' => $reply
            ]);
        } catch (\Exception $e) {
            Log::error('خطأ في OpenAI API: ' . $e->getMessage());
            return response()->json([
                'response' => 'حدث خطأ في السيرفر: ' . $e->getMessage()
            ], 500);
        }
    }
}
