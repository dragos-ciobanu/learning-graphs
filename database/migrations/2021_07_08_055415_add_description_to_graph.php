<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToGraph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graphs', function (Blueprint $table) {
            $table->text("description")->nullable(true)->default('');
        });

        DB::table('graphs')->insert(
            array (
                'id' => 11,
                'name' => 'complet',
                'vertices_count' => 6,
                'edges_count' => 15,
                'vertices' => '[{"id":1},{"id":2},{"id":3},{"id":4},{"id":5},{"id":6}]',
                'edges' => '[[1,2],[1,3],[1,4],[1,5],[1,6],[2,3],[2,4],[2,5],[2,6],[3,4],[3,5],[3,6],[4,5],[4,6],[5,6]]',
                'matrix' => '{"1":{"1":0,"2":1,"3":1,"4":1,"5":1,"6":1},"2":{"1":1,"2":0,"3":1,"4":1,"5":1,"6":1},"3":{"1":1,"2":1,"3":0,"4":1,"5":1,"6":1},"4":{"1":1,"2":1,"3":1,"4":0,"5":1,"6":1},"5":{"1":1,"2":1,"3":1,"4":1,"5":0,"6":1},"6":{"1":1,"2":1,"3":1,"4":1,"5":1,"6":0}}',
                'user_id' => 1
            ));
        DB::table('graphs')->insert(
            array (
                'id' => 12,
                'name' => 'normal',
                'vertices_count' => 7,
                'edges_count' => 8,
                'vertices' => '[{"id":1},{"id":2},{"id":3},{"id":4},{"id":5},{"id":6},{"id":7}]',
                'edges' => '[[1,3],[3,2],[7,3],[6,7],[5,6],[5,4],[3,4],[2,4]]',
                'matrix' => '{"1":{"1":0,"2":0,"3":1,"4":0,"5":0,"6":0,"7":0},"2":{"1":0,"2":0,"3":1,"4":1,"5":0,"6":0,"7":0},"3":{"1":1,"2":1,"3":0,"4":1,"5":0,"6":0,"7":1},"4":{"1":0,"2":1,"3":1,"4":0,"5":1,"6":0,"7":0},"5":{"1":0,"2":0,"3":0,"4":1,"5":0,"6":1,"7":0},"6":{"1":0,"2":0,"3":0,"4":0,"5":1,"6":0,"7":1},"7":{"1":0,"2":0,"3":1,"4":0,"5":0,"6":1,"7":0}}',
                'user_id' => 1,
            ));
        DB::table('graphs')->insert(
            array (
                'id' => 13,
                'name' => 'bipartit',
                'vertices_count' => 5,
                'edges_count' => 5,
                'vertices' => '[{"id":1},{"id":2},{"id":3},{"id":4},{"id":5}]',
                'edges' => '[[1,5],[1,4],[2,4],[3,5],[3,4]]',
                'matrix' => '{"1":{"1":0,"2":0,"3":0,"4":1,"5":1},"2":{"1":0,"2":0,"3":0,"4":1,"5":0},"3":{"1":0,"2":0,"3":0,"4":1,"5":1},"4":{"1":1,"2":1,"3":1,"4":0,"5":0},"5":{"1":1,"2":0,"3":1,"4":0,"5":0}}',
                'user_id' => 1,
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graph', function (Blueprint $table) {
            //
        });
    }
}
