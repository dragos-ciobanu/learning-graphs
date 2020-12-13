@extends('layouts.app')
werwer
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
                                            @for ($i = 0; $i <= $graph['n']; $i++)
                                                <th>{{ $i > 0 ? $i : "" }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $graph['n']; $i++)
                                            <tr>
                                                @for ($j = 0; $j <= $graph['n']; $j++)
                                                    <td>{!! $j === 0 ? '<b>' . ($i + 1) . '</b>' : $graph['matrix'][$i][$j - 1] !!}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
