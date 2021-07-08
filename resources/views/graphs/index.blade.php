@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span class="col-md-5">{{ __('Graphs') }}</span>
                        <!-- Button trigger modal -->
                        <a href="{{ route('graphs.create') }}" type="button" class="btn btn-primary col-md-3 float-right" style="margin-left: 10px;">
                            {{__('Add graph')}}
                        </a>
                        <a href="{{ route('graphs.draw') }}" type="button" class="btn btn-primary col-md-3 float-right">
                            {{__('Draw graph')}}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Vertices') }}</th>
                                        <th>{{ __('Edges') }}</th>
                                        <th>{{ __('User') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($graphs as $graph)
                                    <tr>
                                        <td>{{ $count++  }}</td>
                                        <td>
                                            <a href="{{route('graphs.show', $graph)}}">{{ $graph->name }}</a>
                                        </td>
                                        <td>{{ $graph->vertices_count }}</td>
                                        <td>{{ $graph->edges_count }}</td>
                                        <td>{{ $graph->user->name }}</td>
                                        <td>
                                            @guest
                                                <a href="{{ route('graphs.show', $graph) }}" class="btn btn-info float-right" style="margin-right: 10px;">{{ __('View') }}</a>
                                            @endguest
                                            @auth
                                                <form method="post" action="{{ route('graphs.destroy', $graph) }}" class="float-right">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                </form>&nbsp;
                                                <a href="{{ route('graphs.edit', $graph) }}" class="btn btn-info float-right" style="margin-right: 10px;">{{ __('Edit') }}</a>
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!!  $graphs->links("pagination::bootstrap-4") !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
