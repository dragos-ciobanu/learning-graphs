@extends('layouts.app')
@section('content')
    <script>
        const svgWidth = 500;
        const svgHeight = 500;
        const nodesLoaded = @json($graphObject->getNodesForJS(), JSON_PRETTY_PRINT);
        const linksLoaded = @json($graphObject->getLinksForJS(), JSON_PRETTY_PRINT);
        const nodesCountLoaded = {{ $graph->vertices_count }};
        const isCircleGraph = false;
    </script>
    <script src="{{ asset('js/draw.js') }}" defer></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="col-md-5">{{ __('Show Graph') }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary float-right" href="{{route('graphs.index')}}" title="Go back">
                                <i class="fas fa-backward ">{{ __('Go back') }}</i>
                            </a>
                        </div>
                    </div>
                    <div id="app-container" class="container hidden">
                        <div class="row">
                            <div id="app-area" class="col-md-8 col-sm-12">
                                <div id="svg-wrap-draw"></div>
                                <div id="math-output"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ( $graphObject->getVerticesCount() > 0 )
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
                                <em>{{ $graphObject->getVerticesCount() }}</em>
                            </div>
                            <div>
                                <strong>{{ __('Edges') }}</strong>
                                <em>{{ $graphObject->getEdgesCount() }}</em>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            @for ($i = 0; $i <= $graphObject->getVerticesCount(); $i++)
                                                <th>{{ $i > 0 ? $i : "" }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $graphObject->getVerticesCount(); $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graphObject->getVerticesCount(); $j++)
                                                    <td>{!! $j === 0 ? '<b>' . ($i) . '</b>' : $graphObject->getMatrix()[$i][$j] !!}</td>
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
                                            @for ($i = 0; $i <= $graphObject->getVerticesCount(); $i++)
                                                <th>{{ $i > 0 ? $i : "" }}</th>
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for ($i = 1; $i <= $graphObject->getVerticesCount(); $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graphObject->getVerticesCount(); $j++)
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
