<?php

namespace App\Models;

use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Graph
{
    use HasFactory;
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
            $this->setMatrix($this->getMatrixFromEdges());
        } elseif (isset($options['matrix'])) {
            $this->setMatrix($options['matrix']);
            $this->setEdges($this->getEdgesFromMatrix());
        } else {
            if ($options['n'] > 0 || $options['v'] > 0) {
                throw new Error('Graph needs either adjacency matrix or edges to be defined.');
            }
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
     * @param int $edgeNo
     * @return array
     */
    public function getEdge(int $edgeNo): array
    {
        return $this->edges[$edgeNo];
    }
    /**
     * @return mixed
     */
    public function getEdges()
    {
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
     */
    public function getMatrix(): array
    {
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
     */
    public function BFS($start = 1): array
    {
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
     * @return array
     */
    public function DFS($start = 1): array
    {
        $this->cache = [];
        $this->recursiveDFS($start);
        $dfsResult = (array)$this->cache;
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

    /**
     * @return array
     */
    public function getRoadMatrix(): array
    {
        $roadMatrix = array_fill(1, $this->getVerticesCount(), array_fill(1, $this->getVerticesCount(), 0));

        for ($i = 1; $i <= $this->getVerticesCount(); $i++) {
            $dfsResult = $this->DFS($i);
            for ($j = 0; $j < count($dfsResult); $j++) {
                if ($i !== $dfsResult[$j]) {
                    $roadMatrix[$i][$dfsResult[$j]] = 1;
                    $roadMatrix[$dfsResult[$j]][$i] = 1;
                }
            }
        }

        return $roadMatrix;
    }

    public function isClique($candidate): bool
    {
        for ($i = 0; $i < count($candidate); $i++) {
            for ($j = $i + 1; $j < count($candidate); $j++) {
                if (!$this->isConnected($candidate[$i], $candidate[$j])) {
                    return false;
                }
            }
        }

        return true;
    }

    public function isMaximalClique($candidate): bool
    {
        for ($i = 1; $i <= $this->getVerticesCount(); $i++) {
            if (in_array($i, $candidate)) continue;
            if ($this->isClique(array_merge($candidate, [$i]))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $vertexA
     * @param int $vertexB
     * @return bool
     */
    private function isConnected(int $vertexA, int $vertexB): bool
    {
        return (bool) $this->matrix[$vertexA][$vertexB];
    }
}
