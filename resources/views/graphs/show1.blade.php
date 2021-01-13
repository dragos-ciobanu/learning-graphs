@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Show Graph') }}</div>

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
