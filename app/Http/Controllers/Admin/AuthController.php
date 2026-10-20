<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $captcha = session('admin_login_captcha') ?: $this->newCaptcha();
        session(['admin_login_captcha' => $captcha]);

        return view('admin.login', ['captchaSvg' => $this->captchaSvg($captcha)]);
    }

    public function captcha(Request $request): \Illuminate\Http\Response
    {
        $captcha = $this->newCaptcha();
        $request->session()->put('admin_login_captcha', $captcha);

        return response($this->captchaSvg($captcha), 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $expectedCaptcha = (string) $request->session()->pull('admin_login_captcha', '');
        $submittedCaptcha = strtoupper(trim((string) $request->input('captcha')));

        if ($expectedCaptcha === '' || ! hash_equals($expectedCaptcha, $submittedCaptcha)) {
            $request->session()->put('admin_login_captcha', $this->newCaptcha());

            return back()->withErrors(['captcha' => 'Kode keamanan tidak sesuai. Silakan coba kode yang baru.'])->withInput($request->only('email'));
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($request->user()->role !== 'admin') {
                Auth::logout();

                return back()->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
            }

            AuditLog::record('Login', 'Admin (' . Auth::user()->name . ') berhasil login ke sistem');

            return redirect()->intended(route('admin.dashboard'));
        }

        $request->session()->put('admin_login_captcha', $this->newCaptcha());
        return back()->withErrors(['email' => 'Email atau password tidak sesuai.'])->onlyInput('email');
    }

    private function newCaptcha(): string
    {
        return Str::upper(Str::random(3));
    }

    private function captchaSvg(string $code): string
    {
        $letters = '';
        foreach (str_split($code) as $index => $letter) {
            $x = 78 + ($index * 40);
            $rotation = random_int(-12, 12);
            $letters .= '<text x="'.$x.'" y="43" transform="rotate('.$rotation.' '.$x.' 35)" fill="#263f85" font-family="Arial,sans-serif" font-size="34" font-weight="700">'.$letter.'</text>';
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" width="240" height="64" viewBox="0 0 240 64" role="img" aria-label="Kode keamanan tiga karakter">'
            .'<rect x="1" y="1" width="238" height="62" rx="12" fill="#f8fafc" stroke="#dfe6ef" stroke-width="2"/>'
            .'<path d="M24 45 L205 20 M30 23 L206 49 M56 12 L188 54" stroke="#c4b5fd" stroke-width="2" stroke-dasharray="5 5" opacity=".9"/>'
            .$letters.'</svg>';
    }

    public function logout(Request $request): RedirectResponse
    {
        $userName = Auth::user()?->name ?: 'Admin Perpustakaan';
        AuditLog::record('Logout', 'Admin (' . $userName . ') keluar dari sistem', null, $userName);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
