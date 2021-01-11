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
                            @isset($roadMatrix)
                                <div><strong>Road Matrix</strong></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            @for ($i = 0; $i <= $graph['n']; $i++)
                                                <th>{{ $i > 0 ? $i : "" }}</th>
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for ($i = 0; $i < $graph['n']; $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graph['n']; $j++)
                                                    <td>{!! $j === 0 ? '<b>' . ($i + 1) . '</b>' : $roadMatrix[$i][$j - 1] !!}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
                            @isset($isClica)
                                <div><span>Candidate:</span>
                                @for ($i = 0; $i < count($candidate); $i++)
                                    {{ $candidate[$i] }}&nbsp;
                                @endfor
                                </div>
                                <div>
                                    <strong>
                                        @if($isClica === true)
                                            ESTE CLICA
                                        @else
                                            NU ESTE CLICA
                                        @endif
                                    </strong>
                                </div>
                                <div>
                                    <strong>
                                        @if($isClicaMaximala === true)
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
