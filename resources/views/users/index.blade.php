@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span class="col-md-5">{{ __('Users') }}</span>
                        <!-- Button trigger modal -->
                        <a href="{{ route('users.create') }}" type="button" class="btn btn-primary col-md-3 float-right">
                            {{__('Add user')}}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $count++  }}</td>
                                        <td>
                                            <a href="{{route('users.show', $user)}}">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <form method="post" action="{{ route('users.destroy', $user) }}" class="float-right">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                            </form>&nbsp;
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-info float-right" style="margin-right: 10px;">{{ __('Edit') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
