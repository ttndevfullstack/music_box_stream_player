<?php

namespace App\Presentation\Http\Controllers\Web;

use Illuminate\Contracts\View\View;

class IndexController
{
    public function __invoke(): View
    {
        return view('index');
    }
}