@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are here to learn about graph theory') }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <img src="{{ asset('img/normal.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Graf de introducere</h5>
                            <p class="card-text">Un graf este o structură ce este formată dintr-un grup de obiecte între care putem să definim o relație</p>
                            <a href="{{route('graphs.show', 12)}}" class="btn btn-primary">Vizualizare</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <img src="{{ asset('img/complet.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Graf complet</h5>
                            <p class="card-text">Graful complet este un graf neorientat in care intre oricare doua noduri avem prezenta o muchie.</p>
                            <a href="{{route('graphs.show', 11)}}" class="btn btn-primary">Vizualizare</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <img src="{{ asset('img/bipartit.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Graf bipartit</h5>
                            <p class="card-text">Un graf bipartit este un graf în care nodurile pot fi împărțite în două mulțimi disjuncte A și B, astfel încât fiecare muchie conectează un nod din A cu unul din B</p>
                            <a href="{{route('graphs.show', 13)}}" class="btn btn-primary">Vizualizare</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <img src="{{ asset('img/bipartit-complet.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Graf bipartit complet</h5>
                            <p class="card-text">Graful bipartit complet⁠ este un graf bipartit în care toate nodurile din prima mulțime sunt conectate tu toate nodurile din a doua mulțime</p>
                            <a href="{{route('graphs.show', 14)}}" class="btn btn-primary">Vizualizare</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
