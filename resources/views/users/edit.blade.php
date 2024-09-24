@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Editar usuario </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar usuario</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('users.update', $user->id) }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('users.fields')

                            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                            <a href="{{ route('users.index') }}" class="btn btn-dark">Cancelar</a>
                        </form>
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
<script type="text/javascript" src="{{ asset('js/preview-img.js') }}"></script>

@endsection
