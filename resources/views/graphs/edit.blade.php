@extends('layouts.app')

@section('content')
    <!-- Scripts -->
    <script>
        const nodesLoaded = @json($graphObject->getNodesForJS(), JSON_PRETTY_PRINT);
        const linksLoaded = @json($graphObject->getLinksForJS(), JSON_PRETTY_PRINT);
        const nodesCountLoaded = {{ $graph->vertices_count }};
    </script>
    <script src="{{ asset('js/draw.js') }}" defer></script>
    <script id="MathJax-script" async src="/js/mathjax/tex-chtml.js"></script>

    <div class="container">
        <div class="row pull-left">
            <div class="col-md-12">
                <div class="float-left">
                    <h2>{{ __('Edit graph') }}</h2>
                </div>
                <div class="float-right">
                    <button class="btn btn-primary float-right" style="margin-left: 10px;" id="clear-graph" title="Clear">
                        <i class="fas fa-backward ">Clear</i>
                    </button>
                    <a class="btn btn-primary float-right" href="{{route('graphs.index')}}" title="Go back">
                        <i class="fas fa-backward ">Go back</i>
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
                <div id="app-area" class="col-md-8 col-sm-12">
                    <div id="svg-wrap-draw"></div>
                    <div id="math-output"></div>
                </div>
            </div>
        </div>
        <form action="{{ route('graphs.update', $graph) }}" method="POST" >
            @csrf
            @method('PUT')
            <input type="hidden" name="vertices" id="vertices" value="" />
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Name') }}:</strong>
                        <input type="text" name="name" class="form-control" required placeholder="{{ __('Name') }}" value="{{ $graph->name }}"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Vertices count') }}:</strong>
                        <input type="number" name="vertices_count"  id="vertices_count" class="form-control" required placeholder="{{ __('Vertices count') }}" value="{{ $graph->vertices_count }}"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges count') }}:</strong>
                        <input type="number" name="edges_count"  id="edges_count" class="form-control" required placeholder="{{ __('Edges count') }}" value="{{ $graph->edges_count }}"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges') }}:</strong>
                        <textarea name="edges" id="edges" class="form-control" required placeholder="{{ __('Edges') }}" rows="10" cols="8"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
