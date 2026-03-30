<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(Language $language): RedirectResponse
    {
        abort_unless($language->is_active, 404);

        session(['locale' => $language->code]);

        return redirect()->back();
    }
}
