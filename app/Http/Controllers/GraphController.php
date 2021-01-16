<?php

namespace App\Http\Controllers;

use App\Models\Graph;
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
     * @param int $start
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showBFS($start = 1)
    {
        $graph = new Graph([
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
        ]);

        if ($start < 1 || $start > $graph->getVerticesCount()) {
            $start = 1;
        }

        $bfsResult = $graph->BFS($start);

        for ($i = 0; $i < count($bfsResult); $i++) {
            echo $bfsResult[$i] . ' ';
        }

        return view('graphs.show', [
            'graph' => $graph,
            'BFS' => $bfsResult
        ]);
    }

    /**
     * @param int $start
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showDFS($start = 1)
    {
        $graph = new Graph([
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
        ]);

        if ($start < 1 || $start > $graph->getVerticesCount()) {
            $start = 1;
        }

        $dfsResult = $graph->DFS($start);

        for ($i = 0; $i < count($dfsResult); $i++) {
            echo $dfsResult[$i] . ' ';
        }

        return view('graphs.show', ['graph' => $graph]);

    }

    public function circle($start = 1) {
        $graph = new Graph([
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
        ]);

        $newGraph = [];
        $edges = $graph->getEdges();
        $lenght = 0;
        for ($i = 0; $i < count($edges); $i++) {
            $e1n1 = $edges[$i][0];
            $e1n2 = $edges[$i][1];
            $lenght += $e1n2 - $e1n1;
            for ($j = $i+1; $j < count($edges); $j++) {
                $e2n1 = $edges[$j][0];
                $e2n2 = $edges[$j][1];
                if (
                    ($e2n1 > $e1n1 && $e2n1 < $e1n2 && $e2n2 > $e1n2)
                ) {
                    array_push($newGraph, [$i+1, $j+1]);
                }
            }
        }

        $newMatrix = $this->edgesToMatrixFromOne(count($edges), count($newGraph), $newGraph);
        $density = 0;
        for ($i = 1; $i < count($edges); $i++) {
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
                'length' => $lenght,
                'density' => $density,
                'isCircleGraph' => true
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
    public function clique()
    {
        $graph = new Graph([
            'n' => 6,
            'v' => 7,
            'edges' => [
                [1, 2],
                [1, 5],
                [2, 5],
                [2, 3],
                [3, 4],
                [5, 4],
                [4, 6],
            ]
        ]);


        $candidate = [1, 2, 5];

        $roadMatrix = $graph->getRoadMatrix();

        $isClique = $graph->isClique($candidate);
        $isMaximalClique = $graph->isMaximalClique($candidate);

//        $all = $this->generateAll(range(1, $graph->getVerticesCount()));
//
//
//        echo "<pre>" . var_export($all, true) . "</pre>";

        return view('graphs.show',
            [
                'graph' => $graph,
                'roadMatrix' => $roadMatrix,
                'isClique' => $isClique,
                'isMaximalClique' => $isMaximalClique,
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
    private function isClica($candidates): bool
    {
        for ($i = 0; $i < count($candidates); $i++) {
            for ($j = $i + 1; $j < count($candidates); $j++) {
                if ($this->graph['matrix'][$candidates[$i]-1][$candidates[$j]-1] === 0) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
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
