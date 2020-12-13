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
    private $graph;
    private $visited = [];
    private $subsets = [];

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showBFS()
    {
        $graph = [
            'n' => 7,
            'v' => 6,
            'matrix' => [
                [0, 1, 0, 0, 1, 1, 0],
                [1, 0, 1, 1, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 1],
                [0, 0, 0, 0, 0, 1, 0],
            ]
        ];

        $queue = [];
        $visited = [];
        $start = 0;
        array_push($queue, $start);
        array_push($visited, $start);
        while (count($queue) > 0) {
            $current = $queue[0];
            for ($i = 0; $i < $graph['n']; $i++) {
                //echo $graph['matrix'][$current][$i] . '<br />';
                if ($graph['matrix'][$current][$i] === 1 && in_array($i, $visited) === false) {
                    //echo $i . '<br />';
                    array_push($queue, $i);
                    array_push($visited, $i);
                }
            }
            array_shift($queue);
        }

        for ($i = 0; $i < count($visited); $i++) {
            echo $visited[$i] + 1 . ' ';
        }

        //return var_export($visited);

        return view('graphs.show', ['graph' => $graph]);

    }

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showDFS($start = 0)
    {
        $graph = [
            'n' => 7,
            'v' => 6,
            'vertices' => [
                [1, 2],
                [1, 7],
                [1, 6],
                [2, 3],
                [2, 4],
                [2, 7],

            ]
            /*
            'matrix' => [
                [0, 1, 0, 0, 0, 1, 1],
                [1, 0, 1, 1, 0, 0, 1],
                [0, 1, 0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 1],
                [7, 1, 0, 0, 0, 1, 0],
            ]*/
        ];

        $graph['matrix'] = $this->edgesToMatrix($graph['n'], $graph['v'], $graph['vertices']);

        $this->graph = $graph;

        $queue = [];
        $visited = [];

        $this->dfs($start);
        var_export($visited);

        for ($i = 0; $i < count($this->visited); $i++) {
            echo $this->visited[$i] + 1 . ' ';
        }

        //return var_export($visited);

        return view('graphs.show', ['graph' => $graph]);

    }

    public function circle($start = 1) {
        $graph = [
            'n' => 14,
            'v' => 7,
            'vertices' => [
                [1, 5],
                [2, 12],
                [3, 7],
                [4, 9],
                [6, 11],
                [8, 14],
                [10, 13]
            ]
        ];
        $graph['matrix'] = $this->edgesToMatrixFromOne($graph['n'], $graph['v'], $graph['vertices']);

        $this->graph = $graph;
        $newNodes = [];
        $newGraph = [];
        $vertices = $this->graph['vertices'];
        var_export($vertices);
        $lenght = 0;
        for ($i = 0; $i < count($vertices); $i++) {
            $e1n1 = $vertices[$i][0];
            $e1n2 = $vertices[$i][1];
            $lenght += $e1n2 - $e1n1;
            for ($j = $i+1; $j < count($vertices); $j++) {
                $e2n1 = $vertices[$j][0];
                $e2n2 = $vertices[$j][1];
                if (
                    ($e2n1 > $e1n1 && $e2n1 < $e1n2 && $e2n2 > $e1n2)
                ) {
                    array_push($newGraph, [$i+1, $j+1]);
                }
            }
        }

        $newMatrix = $this->edgesToMatrixFromOne(count($vertices), count($newGraph), $newGraph);
        $density = 0;
        for ($i = 1; $i < count($vertices); $i++) {
            $grad = array_sum($newMatrix[$i]);
            if ($density < $grad) {
                $density = $grad;
            }
        }

//        var_export($newMatrix);
        return view('graphs.show1',
            [
                'graph' => $graph,
                'newMatrix' => $newMatrix,
                'lenght' => $lenght,
                'density' => $density
//                'isClica' => $isClica,
//                'isClicaMaximala' => $isClicaMaximala,
//                'candidate' => $candidate
            ]);


    }

    public function chord() {
        $graph = [
            'n' => 7,
            'v' => 11,
            'vertices' => [
                [1, 2],
                [1, 5],
                [2, 3],
                [2, 5],
                [2, 6],
                [3, 4],
                [3, 6],
                [3, 7],
                [4, 7],
                [5, 6],
                [6, 7],

            ]
        ];
        $graph['matrix'] = $this->edgesToMatrixFromOne($graph['n'], $graph['v'], $graph['vertices']);

        $this->maximumCardinalitySearch($graph);


        $this->graph = $graph;
        $newNodes = [];
        $newGraph = [];
        $vertices = $this->graph['vertices'];
        var_export($vertices);
        $lenght = 0;
        for ($i = 0; $i < count($vertices); $i++) {
            $e1n1 = $vertices[$i][0];
            $e1n2 = $vertices[$i][1];
            $lenght += $e1n2 - $e1n1;
            for ($j = $i+1; $j < count($vertices); $j++) {
                $e2n1 = $vertices[$j][0];
                $e2n2 = $vertices[$j][1];
                if (
                    ($e2n1 > $e1n1 && $e2n1 < $e1n2 && $e2n2 > $e1n2)
                ) {
                    array_push($newGraph, [$i+1, $j+1]);
                }
            }
        }

        $newMatrix = $this->edgesToMatrixFromOne(count($vertices), count($newGraph), $newGraph);
        $density = 0;
        for ($i = 1; $i < count($vertices); $i++) {
            $grad = array_sum($newMatrix[$i]);
            if ($density < $grad) {
                $density = $grad;
            }
        }

//        var_export($newMatrix);
        return view('graphs.show1',
            [
                'graph' => $graph,
                'newMatrix' => $newMatrix,
                'lenght' => $lenght,
                'density' => $density
//                'isClica' => $isClica,
//                'isClicaMaximala' => $isClicaMaximala,
//                'candidate' => $candidate
            ]);


    }


    private function maximumCardinalitySearch($graph)
    {
        $label = array_fill(1, count($graph['vertices']), 0);
         for ($i = $graph['n']; $i > 0; $i--) {

        }
    }

//    private function chooseNodeWithLasrgestLabel


    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function clica()
    {
        $graph = [
            'n' => 6,
            'v' => 7,
            'vertices' => [
                [1, 2],
                [1, 5],
                [2, 5],
                [2, 3],
                [3, 4],
                [5, 4],
                [4, 6],

            ]
            /*
            'matrix' => [
                [0, 1, 0, 0, 0, 1, 1],
                [1, 0, 1, 1, 0, 0, 1],
                [0, 1, 0, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 1],
                [7, 1, 0, 0, 0, 1, 0],
            ]*/
        ];
        $candidate = [1, 2, 5];

        $graph['matrix'] = $this->edgesToMatrix($graph['n'], $graph['v'], $graph['vertices']);

        $this->graph = $graph;

        $queue = [];
        $visited = [];

        $roadMatrix = $matrix = array_fill(0, $this->graph['n'], array_fill(0, $this->graph['n'], 0));


        for ($i = 0; $i < $this->graph['n']; $i++) {
            $this->dfs($i);
            for ($j = 0; $j < count($this->visited); $j++) {
                if ($i !== $this->visited[$j]) {
                    $roadMatrix[$i][$this->visited[$j]] = 1;
                    $roadMatrix[$this->visited[$j]][$i] = 1;
                }
            }
            $this->visited = [];

        }


        $isClica = $this->isClica($candidate);
        $isClicaMaximala = $this->isClicaMaximala($candidate);


        for ($i = 0; $i < count($this->visited); $i++) {
            echo $this->visited[$i] + 1 . ' ';
        }



        $all = $this->generateAll(range(1, $this->graph['n']));


        echo "<pre>" . var_export($all, true) . "</pre>";

        return view('graphs.show',
            [
                'graph' => $graph,
                'roadMatrix' => $roadMatrix,
                'isClica' => $isClica,
                'isClicaMaximala' => $isClicaMaximala,
                'candidate' => $candidate
            ]);

    }

    private function generateAll($nodes) {
        $subset = [];
        $index = 0;
        $this->generateSubset($nodes, $subset, $index);
        $result = [];
        foreach ($this->subsets as $subsetCandidate) {
            if ($this->isClica($subsetCandidate)) {
                array_push($result, $subsetCandidate);
            }
        }

        return $result;
    }

    private function generateSubset($nodes, array $subset, int $index)
    {
        if (count($subset) > 1) {
            array_push($this->subsets, $subset);
        }
        for ($i = $index; $i < count($nodes); $i++) {
            array_push($subset, $nodes[$i]);
            $this->generateSubset($nodes, $subset, $i + 1);
            array_pop($subset);
        }
    }
    private function isClica($candidates) {
        for ($i = 0; $i < count($candidates); $i++) {
            for ($j = $i + 1; $j < count($candidates); $j++) {
                if ($this->graph['matrix'][$candidates[$i]-1][$candidates[$j]-1] === 0) {
                    return false;
                }
            }
        }

        return true;
    }
    private function isClicaMaximala($candidates) {
        for ($i = 1; $i <= $this->graph['n']; $i++) {
            if (in_array($i, $candidates)) continue;
            if ($this->isClica(array_merge($candidates, [$i]))) {
                return false;
            }
        }

        return true;
    }
    /**
     * @param $node
     * @return array
     */
    private function dfs($node): void
    {
        array_push($this->visited, $node);

        for ($i = 0; $i < $this->graph['n']; $i++) {
            if ($this->graph['matrix'][$node][$i] === 1 && in_array($i, $this->visited) === false) {
                $this->dfs($i);
            }
        }
    }

    /**
     * @param $nodes
     * @param $verticesNo
     * @param $edges
     * @return array
     */
    private function edgesToMatrix($nodes, $verticesNo, $edges): array
    {
        $matrix = array_fill(0, $nodes, array_fill(0, $nodes, 0));
        for( $i = 0; $i < $verticesNo; $i++) {
            $matrix[$edges[$i][0] - 1][$edges[$i][1] -1] = 1;
            $matrix[$edges[$i][1] -1][$edges[$i][0] - 1] = 1;
        }

        return $matrix;
    }    /**
     * @param $nodes
     * @param $verticesNo
     * @param $edges
     * @return array
     */
    private function edgesToMatrixFromOne($nodes, $verticesNo, $edges): array
    {
        $matrix = array_fill(1, $nodes, array_fill(1, $nodes, 0));
        for( $i = 0; $i < $verticesNo; $i++) {
            $matrix[$edges[$i][0]][$edges[$i][1]] = 1;
            $matrix[$edges[$i][1]][$edges[$i][0]] = 1;
        }

        return $matrix;
    }
}
