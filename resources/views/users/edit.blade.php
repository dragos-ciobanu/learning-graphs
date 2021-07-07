@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pull-left">
            <div class="col-md-12">
                <div class="float-left">
                    <h2>{{ __('Edit user') }}</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-primary float-right" href="{{route('users.index')}}" title="Go back">
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
        <form action="{{ route('users.update', $user) }}" method="POST" >
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Name') }}:</strong>
                        <input type="text" name="name" class="form-control" required placeholder="{{ __('Name') }}" value="{{$user->name}}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Email') }}:</strong>
                        <input type="email" name="email" class="form-control" required placeholder="{{ __('Email') }}" value="{{$user->email}}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Password') }}:</strong>
                        <input type="password" name="newPassword" class="form-control" placeholder="{{ __('Password') }}" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('Role') }}:{{$user->role}}</strong>
                        <select name="role" class="form-control">
                            <option value="student" @if($user->role == 'student') selected @endif>{{ __('Student') }}</option>
                            <option value="professor" @if($user->role == 'professor') selected @endif>{{ __('Professor') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
