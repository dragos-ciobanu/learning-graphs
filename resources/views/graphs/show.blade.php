@extends('layouts.app')
@section('content')
    <script>
        const svgWidth = 500;
        const svgHeight = 500;
        const nodes = @json($graph->getNodesForJS(), JSON_PRETTY_PRINT);
        const links = @json($graph->getLinksForJS(), JSON_PRETTY_PRINT);
        const isCircleGraph = false;
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
                            @isset ($BFS)
                                <div>
                                    <strong>{{ __('BFS') }}</strong>
                                    <em>
                                        @foreach( $BFS as $node)
                                            {{ $node }}
                                        @endforeach
                                    </em>
                                </div>
                            @endisset
                            @isset ($DFS)
                                <div>
                                    <strong>{{ __('DFS') }}</strong>
                                    <em>
                                        @foreach( $DFS as $node)
                                            {{ $node }}
                                        @endforeach
                                    </em>
                                </div>
                            @endisset
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
                            @isset($roadMatrix)
                                <div><strong>Road Matrix</strong></div>
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
                                                    <td>{!! $j === 0 ? '<b>' . $i . '</b>' : $roadMatrix[$i][$j] !!}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
                            @isset($isClique)
                                <div><span>Candidate:</span>
                                @for ($i = 0; $i < count($candidate); $i++)
                                    {{ $candidate[$i] }}&nbsp;
                                @endfor
                                </div>
                                <div>
                                    <strong>
                                        @if($isClique === true)
                                            ESTE CLICA
                                        @else
                                            NU ESTE CLICA
                                        @endif
                                    </strong>
                                </div>
                                <div>
                                    <strong>
                                        @if($isMaximalClique === true)
                                            ESTE CLICA MAXIMALA
                                        @else
                                            NU ESTE CLICA MAXIMALA
                                        @endif
                                    </strong>
                                </div>
                            @endisset
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
