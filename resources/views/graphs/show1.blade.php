@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Show Graph') }}</div>

                    <div class="card-body">
                        @if ( count($graph) > 0 && count($graph['matrix']) > 0 )
                            <div>
                                <strong>{{ __('Nodes') }}</strong>
                                <em>{{ $graph['n'] }}</em>
                            </div>
                            <div>
                                <strong>{{ __('Vertices') }}</strong>
                                <em>{{ $graph['v'] }}</em>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            @for ($i = 0; $i < $graph['n']+1; $i++)
                                                <th>{{ $i > 0 ? $i : "" }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $graph['n']; $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graph['n']; $j++)
                                                    <td>{!! $j === 0 ? '<b>' . $i . '</b>' : $graph['matrix'][$i][$j] !!}</td>
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
                                            @for ($i = 0; $i <= $graph['v']; $i++)
                                                <th>{{ $i > 0 ? $i . '(' . $graph['vertices'][$i-1][0] . ',' . $graph['vertices'][$i-1][1] . ')': "" }}</th>
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for ($i = 1; $i <= $graph['v']; $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graph['v']; $j++)
                                                    <td>{!! $j === 0 ? '<b>' . ('(' . $graph['vertices'][$i-1][0] . ',' . $graph['vertices'][$i-1][1] . ')') . '</b>' : $newMatrix[$i][$j] !!}</td>
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
