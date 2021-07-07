<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureGraphDataPopulation
{
    private $baseGraph = [
            'n' => 7,
            'v' => 6,
            'edges' => [
                [1, 2],
                [1, 7],
                [1, 6],
                [2, 3],
                [2, 4],
                [2, 7],

            ]
        ];
    private $circleGraph = [
            'n' => 14,
            'v' => 7,
            'edges' => [
                [1, 5],
                [2, 12],
                [3, 7],
                [4, 9],
                [6, 11],
                [8, 14],
                [10, 13]
            ]
        ];
    private $cliqueCandidate = [1, 2, 3];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $baseGraph = $this->baseGraph;
        $circularGraph = $this->circleGraph;
        $cliqueCandidate = $this->cliqueCandidate;

        if ($request->input('savethisgraph')) {
            $vertexNo = $request->input('vertexNo');
            $edges = $request->input('edges');
            $edges = preg_replace('/\s+^\n/', ' ', $edges);
            $edges = explode("\n", trim($edges));
            $edgesNo = count($edges);
            foreach ($edges as &$edge) {
                $edge = explode(' ', trim($edge));
                $vertexNo = max($vertexNo, $edge[0], $edge[1]);
            }
            if ($request->input('isCircular')) {
                $circularGraph = [
                    'n' => $vertexNo,
                    'v' => $edgesNo,
                    'edges' => $edges
                ];
            } else {
                $baseGraph = [
                    'n' => $vertexNo,
                    'v' => $edgesNo,
                    'edges' => $edges
                ];
            }
            if ($request->input('candidate')) {
                $candidate = $request->input('candidate');
                var_export($candidate);
                $candidate = explode(' ', trim(preg_replace('/\s+^\n/', ' ', $candidate)));
                $request->session()->put('candidate', $candidate);
            }
            $request->session()->put('baseGraph', $baseGraph);
            $request->session()->put('circularGraph', $circularGraph);
        } else {
            if (!$request->session()->has('baseGraph')) {
                $request->session()->put('baseGraph', $baseGraph);
            }
            if (!$request->session()->has('circularGraph')) {
                $request->session()->put('circularGraph', $circularGraph);
            }
            if (empty($request->session()->has('candidate'))) {
                $request->session()->put('candidate', $cliqueCandidate);
            }
        }

        return $next($request);
    }

}
