<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'First Article',
            ],
            [
                'id' => 2,
                'name' => 'Second Article',
            ],
            [
                'id' => 3,
                'name' => 'Third Article',
            ],
            [
                'id' => 4,
                'name' => 'Final Article',
            ],
        ];

        return view('articles.index', compact('data'));
    }
}
