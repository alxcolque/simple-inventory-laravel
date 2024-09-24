@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{$user->name}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">useros</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $user->avatar? $user->avatar : 'https://cdn.iconscout.com/icon/free/png-256/free-avatar-380-456332.png%22' }}" height="300" alt="{{ $user->name }}" class="">
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $user->name }}</h2>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Rol:</strong> {{ $user->role }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar</a>
                                <a href="{{ route('users.index') }}" class="btn btn-dark">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
@endsection
@section('css')
@endsection
@section('js')
@endsection
