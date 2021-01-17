@extends('layouts.app')
@section('content')
    <script>
        const svgWidth = 500;
        const svgHeight = 500;
        const nodes = @json($graph->getNodesForJS(), JSON_PRETTY_PRINT);
        const links = @json($graph->getLinksForJS(), JSON_PRETTY_PRINT);
        const isCircleGraph = {{$isCircleGraph}};
        //
        // var nodes = [
        //     { id: 1, degree: 4 },
        //     { id: 2, degree: 4 },
        //     { id: 3, degree: 4 },
        //     { id: 4, degree: 4 },
        //     { id: 5, degree: 4 },
        //     { id: 6, degree: 4 }
        // ];
        //
        // var links = [
        //     { source: 0, target: 1 },
        //     { source: 0, target: 2 },
        //     { source: 0, target: 3 },
        //     { source: 0, target: 4 },
        //     { source: 1, target: 2 },
        //     { source: 2, target: 3 },
        //     { source: 3, target: 4 },
        //     { source: 4, target: 1 },
        //     { source: 5, target: 1 },
        //     { source: 5, target: 2 },
        //     { source: 5, target: 3 },
        //     { source: 5, target: 4 }
        // ];
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span class="col-md-5">{{ __('Show Graph') }}</span>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary col-md-3 float-right" data-toggle="modal" data-target="#graphForm">
                            {{__('Add new graph')}}
                        </button>
                    </div>
                    <div id="app-container" class="container hidden">
                        <div class="row">
                            <div id="app-area" class="col-md-8 col-sm-12">
                                <div id="svg-wrap"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ( $graph->getVerticesCount() > 0 )
                            <div>
                                <strong>{{ __('Nodes') }}</strong>
                                <em>{{ $graph->getVerticesCount() }}</em>
                            </div>
                            <div>
                                <strong>{{ __('Vertices') }}</strong>
                                <em>{{ $graph->getEdgesCount() }}</em>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                    <tr>
                                        @for ($i = 0; $i <= $graph->getVerticesCount(); $i++)
                                            <th>{{ $i > 0 ? $i : "" }}</th>
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 1; $i <= $graph->getVerticesCount(); $i++)
                                        <tr>
                                            @for ($j = 0; $j <= $graph->getVerticesCount(); $j++)
                                                <td>{!! $j === 0 ? '<b>' . ($i) . '</b>' : $graph->getMatrix()[$i][$j] !!}</td>
                                            @endfor
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            @isset($newMatrix)
                                <div><strong>Circular Matrix</strong></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            @for ($i = -1; $i < $graph->getEdgesCount(); $i++)
                                                <th>{{ $i >= 0 ? $i+1 . '(' . $graph->getEdge($i)[0] . ',' . $graph->getEdge($i)[1] . ')': "" }}</th>
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for ($i = 1; $i <= $graph->getEdgesCount(); $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graph->getEdgesCount(); $j++)
                                                    <td>{!! $j === 0 ? '<b>' . $i .  ('(' . $graph->getEdge($i-1)[0] . ',' . $graph->getEdge($i-1)[1] . ')') . '</b>' : $newMatrix[$i][$j] !!}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
                            @isset($lenght)
                                <div>
                                    <strong>Lungimea arcelor:</strong>
                                    <span>{{ $lenght }}</span>
                                </div>
                                <div>
                                    <strong>Densitatea:</strong>
                                    <span>{{ $density }}</span>
                                </div>
                            @endisset
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
