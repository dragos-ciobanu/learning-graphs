@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pull-left">
            <div class="col-md-12">
                <div class="float-left">
                    <h2>{{ __('Add new graph') }}</h2>
                </div>
                <div class="float-right">
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
                    <div id="svg-wrap-playground"></div>
                </div>
            </div>
        </div>
        <form action="{{ route('graphs.store') }}" method="POST" >
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Name') }}:</strong>
                        <input type="text" name="name" class="form-control" required placeholder="{{ __('Name') }}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Vertices count') }}:</strong>
                        <input type="number" name="vertices_count" class="form-control" required placeholder="{{ __('Vertices count') }}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges count') }}:</strong>
                        <input type="number" name="edges_count" class="form-control" required placeholder="{{ __('Edges count') }}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Edges') }}:</strong>
                        <textarea name="edges" class="form-control" required placeholder="{{ __('Password') }}" rows="10" cols="8"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
