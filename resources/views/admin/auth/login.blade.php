@extends('layouts.app', ['title' => 'تسجيل دخول الإدارة'])

@section('content')
    <section class="mx-auto flex min-h-[70vh] max-w-7xl items-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-md rounded-[2rem] border border-white/10 bg-white/5 p-8">
            <h1 class="text-4xl font-black text-white">تسجيل دخول الإدارة</h1>
            <p class="mt-3 text-slate-300">لن يمكن الوصول إلى لوحة التحكم أو الطلبات أو الرسائل إلا بعد تسجيل الدخول.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm text-slate-300">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm text-slate-300">كلمة المرور</label>
                    <input type="password" name="password" class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white">
                </div>
                <label class="flex items-center gap-3 text-slate-300">
                    <input type="checkbox" name="remember" value="1">
                    تذكرني
                </label>
                <button class="w-full rounded-2xl bg-amber-400 px-8 py-4 font-bold text-slate-950">دخول</button>
            </form>
        </div>
    </section>
@endsection
