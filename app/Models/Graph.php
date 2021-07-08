<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Graph extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vertices_count',
        'edges_count',
        'vertices',
        'edges',
        'matrix',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'vertices_count' => 'integer',
        'edges_count' => 'integer',
        'vertices' => 'array',
        'edges' => 'array',
        'matrix' => 'array',

    ];

    public static function getArrayFromGraphObject(GraphObject $graphObject) {
        return [
            'name' => $graphObject->getName(),
            'vertices_count' => $graphObject->getVerticesCount(),
            'edges_count' => $graphObject->getEdgesCount(),
            'vertices' => $graphObject->getVertices(),
            'edges' => $graphObject->getEdges(),
            'matrix' => $graphObject->getMatrix(),
            'user_id' => Auth::id()
        ];
    }

    /**
     * return the user associated to the graph
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
