<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class GraphController
 * @package App\Http\Controllers
 */
class GraphController extends Controller
{
    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function show()
    {
        $graph = [
            'n' => 9,
            'v' => 5,
            'matrix' => [
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],
                [0, 1, 1, 0, 1, 1, 0, 1, 1],

            ]
        ];

        return view('graphs.show', ['graph' => $graph]);

    }
}
