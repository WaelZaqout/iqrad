<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\Rules;
    use Illuminate\View\View;

    class RegisteredUserController extends Controller
    {
        /**
         * Display the registration view.
         */
        public function create(): View
        {
            return view('auth.register');
        }

        /**
         * Handle an incoming registration request.
         *
         * @throws \Illuminate\Validation\ValidationException
         */
        public function store(Request $request)
        {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:20'],
                'password' => ['required', 'confirmed'],
                'role' => ['required', 'in:investor,borrower'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            // Spatie role assignment
            $user->assignRole($request->role);

            Auth::login($user);

            return redirect($this->redirectUserByRole($user->role));
        }
        private function redirectUserByRole($role)
        {
            return match ($role) {
                'admin' => '/admin/dashboard',
                'borrower' => '/dashboard',
                'investor' => '/',
                default => '/',
            };
        }
    }
