<?php

namespace App\Http\Controllers;

use App\Models\GraphObject;
use App\Models\Graph;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $graphs = Graph::latest()->paginate(5);

        return view('graphs.index', compact('graphs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('graphs.create');
    }

    /**
     * Show the form for drawing a new resource.
     *
     * @return Application|Factory|View
     */
    public function draw()
    {
        return view('graphs.draw');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'vertices_count' => 'required',
            'edges_count' => 'required',
        ]);

        Graph::create($request->all());

        return redirect()->route('graphs.index')
            ->with('success', 'Graph added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Graph $graph
     * @return Application|Factory|View
     */
    public function show(Graph $graph)
    {
        return view('graphs.show', compact('graph'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Graph  $graph
     * @return Application|Factory|View
     */
    public function edit(Graph $graph)
    {
        return view('graph.edit', compact('graph'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Graph  $graph
     * @return RedirectResponse
     */
    public function update(Request $request, Graph $graph): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'vertices_count' => 'required',
            'edges_count' => 'required',
        ]);


        $graph->update($request->all());

        return redirect()->route('graph.index')
            ->with('success', 'Graph updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Graph  $graph
     * @return RedirectResponse
     */
    public function destroy(Graph $graph): RedirectResponse
    {
        $graph->delete();

        return redirect()->route('graph.index')
            ->with('success', 'Graph deleted successfully');
    }




    /**
     * @param int $start
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showBFS($start = 1)
    {
        $graphData = session('baseGraph');
        $graph = new GraphObject($graphData);

        if ($start < 1 || $start > $graph->getVerticesCount()) {
            $start = 1;
        }

        $bfsResult = $graph->BFS($start);

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
        $graphData = session('baseGraph');
        $graph = new GraphObject($graphData);

        if ($start < 1 || $start > $graph->getVerticesCount()) {
            $start = 1;
        }

        $dfsResult = $graph->DFS($start);

        return view('graphs.show', [
            'graph' => $graph,
            'DFS' => $dfsResult
        ]);

    }

    public function circle($start = 1) {
        $graphData = session('circularGraph');
        $graph = new GraphObject($graphData);

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
        $graphData = session('circularGraph');
        $graph = new GraphObject($graphData);

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
        $graphData = session('baseGraph');
        $graph = new GraphObject($graphData);

        $candidate = session('candidate');

        $roadMatrix = $graph->getRoadMatrix();

        $isClique = $graph->isClique($candidate);
        $isMaximalClique = $isClique && $graph->isMaximalClique($candidate);

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
