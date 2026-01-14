<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #0DB8DE, #27EF9F);
        font-family: 'Roboto', sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        background: #1A2226;
        border-radius: 15px;
        padding: 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: #ECF0F5;
    }

    .login-icon {
        font-size: 60px;
        background: linear-gradient(135deg, #27EF9F, #0DB8DE);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }

    .login-title {
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 2px;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-control {
        background-color: #1A2226;
        border: none;
        border-bottom: 2px solid #0DB8DE;
        border-radius: 0;
        color: #ECF0F5;
        font-weight: bold;
        text-align: right;
    }

    .form-control:focus {
        background-color: #1A2226;
        color: #ECF0F5;
        border-color: #27EF9F;
        box-shadow: none;
    }

    .btn-custom {
        background: #0DB8DE;
        border: none;
        font-weight: bold;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-custom:hover {
        background: #27EF9F;
        color: #000;
    }

    .login-footer {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #aaa;
    }
</style>

<div class="login-card text-center" dir="rtl">
    <div class="login-icon">
        <i class="fa-solid fa-lock"></i>
    </div>
    <div class="login-title">لوحة الإدارة</div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3 text-end">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4 text-end position-relative">
            <label class="form-label">كلمة المرور</label>
            <input type="password" id="password" name="password"
                class="form-control ps-5 @error('password') is-invalid @enderror" required>

            <!-- الأيقونة على اليسار -->
            <span class="position-absolute top-50 start-0 translate-middle-y ms-3" style="cursor: pointer;"
                onclick="togglePassword()">
                <i id="toggleIcon" class="fas fa-eye"></i>
            </span>

            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>


        {{-- لو في رسالة عامة (مثلاً credentials غلط) --}}
        @if ($errors->has('email') || $errors->has('password'))
            <div class="alert alert-danger py-2">
                بيانات الاعتماد هذه لا تتطابق مع سجلاتنا.
            </div>
        @endif

        <button type="submit" class="btn btn-custom w-100 py-2">تسجيل الدخول</button>
    </form>


    <div class="login-footer mt-3">
        <a href="{{ route('password.request') }}" class="text-decoration-none text-info">نسيت كلمة المرور؟</a>
    </div>

</div>
<script>
    function togglePassword() {
        const password = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");
        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            password.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
