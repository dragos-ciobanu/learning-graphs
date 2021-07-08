@extends('layouts.app')

@section('content')
    <!-- Scripts -->
    <script src="{{ asset('js/playground.js') }}" defer></script>
    <div class="container">
        <div class="row pull-left">
            <div class="col-md-12">
                <div class="float-left">
                    <h2>{{ __('Play') }}</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-primary float-right" href="{{route('graphs.index')}}" title="Go back">
                        <i class="fas fa-backward ">Grafuri</i>
                    </a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div id="app-container" class="container hidden">
            <div class="row">
                <div id="app-area" class="col-md-12 col-sm-12">
                    <div id="svg-wrap-playground"></div>
                    <div id="math-output"></div>
                </div>
            </div>
        </div>
        <form action="{{ route('graphs.store') }}" method="POST" >
            @csrf
            <input type="hidden" name="vertices" id="vertices" value="" />
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Name') }}:</strong>
                        <input readonly type="text" name="name" class="form-control" required placeholder="{{ __('Name') }}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Vertices count') }}:</strong>
                        <input readonly type="number" name="vertices_count"  id="vertices_count" class="form-control" required placeholder="{{ __('Vertices count') }}" value="13"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges count') }}:</strong>
                        <input readonly type="number" name="edges_count"  id="edges_count" class="form-control" required placeholder="{{ __('Edges count') }}" value="18"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges') }}:</strong>
                        <textarea readonly name="edges" id="edges" class="form-control" required placeholder="{{ __('Edges') }}" rows="10" cols="8">
        0, 1,
        1, 2
        2, 0
        1, 3
        3, 2
        3, 4
        4, 5
        5, 6
        5, 7
        6, 7
        6, 8
        7, 8
        9, 4
        9, 11
        9, 10
        10, 11
        11, 12
        12, 10

                        </textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
