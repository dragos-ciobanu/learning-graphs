<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Throwable;

class Graph
{
    use HasFactory;

//    protected $primaryKey = 'id';
//    protected $attributes = ['vertices_count' => 0, 'edges_count' => 0, 'edges' => '[[]]', 'matrix' => '[[]]', 'user_id' => 1];
//    protected $fillable = ['name', 'vertices_count', 'edges_count', 'edges', 'matrix'];
//
//$table->id();
    /** @var string */
    private $name;
    /** @var integer */
    private $vertices_count;
    /** @var integer */
    private $edges_count;
    /** @var mixed */
    private $edges;
    /** @var mixed */
    private $matrix;
    /** @var mixed */
    private $cache = null;

    /**
     * Graph constructor.
     * @param $options
     */
    public function __construct($options)
    {
        if (isset($options['name'])) {
            $this->setVerticesCount($options['name']);
        }
        if (isset($options['n'])) {
            $this->setVerticesCount($options['n']);
        }
        if (isset($options['v'])) {
            $this->setEdgesCount($options['v']);
        }
        if (isset($options['edges'])) {
            $this->setEdges($options['edges']);
        }
        if (isset($options['matrix'])) {
            $this->setMatrix($options['matrix']);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Graph
     */
    public function setName(string $name): Graph
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getVerticesCount(): int
    {
        return $this->vertices_count;
    }

    /**
     * @param int $vertices_count
     * @return Graph
     */
    public function setVerticesCount(int $vertices_count): Graph
    {
        $this->vertices_count = $vertices_count;
        return $this;
    }

    /**
     * @return int
     */
    public function getEdgesCount(): int
    {
        return $this->edges_count;
    }

    /**
     * @param int $edges_count
     * @return Graph
     */
    public function setEdgesCount(int $edges_count): Graph
    {
        $this->edges_count = $edges_count;
        return $this;
    }

    /**
     * @return mixed
     * @throws Throwable
     */
    public function getEdges()
    {
        if (!isset($this->edges)) {
            throw_if(!isset($this->matrix), new \Exception("The graph has no defined edges or matrix"));
            $this->edges = $this->getEdgesFromMatrix();

        }
        return $this->edges;
    }

    /**
     * @param mixed $edges
     * @return Graph
     */
    public function setEdges($edges): Graph
    {
        $this->edges = $edges;
        return $this;
    }

    /**
     * @return array
     */
    private function getEdgesFromMatrix(): array
    {
        $edges = [];
        for ($i = 1; $i < $this->vertices_count; $i++) {
            for ($j = $i + 1; $j <= $this->vertices_count; $j++) {
                if ($this->matrix[$i][$j]) {
                    array_push($edges, [$i, $j]);
                }
            }
        }

        return $edges;
    }

    /**
     * @return mixed
     * @throws Throwable
     */
    public function getMatrix(): array
    {
        if (!isset($this->matrix)) {
            throw_if(!isset($this->edges), new \Exception("The graph has no defined edges or matrix"));
            $this->matrix = $this->getMatrixFromEdges();
        }

        return $this->matrix;
    }

    /**
     * @param mixed $matrix
     * @return Graph
     */
    public function setMatrix($matrix): Graph
    {
        $this->matrix = $matrix;
        return $this;
    }

    /**
     * @return array
     */
    private function getMatrixFromEdges(): array
    {
        $matrix = array_fill(1, $this->vertices_count, array_fill(1, $this->vertices_count, 0));
        for ($i = 0; $i < $this->edges_count; $i++) {
            $edgeNodeA = $this->edges[$i][0];
            $edgeNodeB = $this->edges[$i][1];
            $matrix[$edgeNodeA][$edgeNodeB] = 1;
            $matrix[$edgeNodeB][$edgeNodeA] = 1;
        }

        return $matrix;
    }

    /** Graph Operations
     * @param int $start
     * @return array
     * @throws Throwable
     */
    public function BFS($start = 1) {
        $queue = [];
        $visited = [];
        array_push($queue, $start);
        array_push($visited, $start);
        while (count($queue) > 0) {
            $currentNode = $queue[0];
            for ($i = 1; $i <= $this->getVerticesCount(); $i++) {
                if ($this->getMatrix()[$currentNode][$i] === 1 && in_array($i, $visited) === false) {
                    array_push($queue, $i);
                    array_push($visited, $i);
                }
            }
            array_shift($queue);
        }

        return $visited;
    }

    /** Graph Operations
     * @param int $start
     * @return array|mixed|null
     */
    public function DFS($start = 1) {
        $this->cache = [];
        $this->recursiveDFS($start);
        $dfsResult = $this->cache;
        unset($this->cache);

        return $dfsResult;
    }

    private function recursiveDFS(int $currentNode)
    {
        array_push($this->cache, $currentNode);

        for ($i = 1; $i <= $this->vertices_count; $i++) {
            if ($this->getMatrix()[$currentNode][$i] === 1 && in_array($i, $this->cache) === false) {
                $this->recursiveDFS($i);
            }
        }
    }
}
