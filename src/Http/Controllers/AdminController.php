<?php

namespace Elfcms\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function blog()
    {
        return view('blog::admin.blog.index',[
            'page' => [
                'title' => 'Blog',
                'current' => url()->current(),
            ]
        ]);
    }

}
