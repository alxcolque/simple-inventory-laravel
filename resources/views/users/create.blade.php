@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Nuevo usuario </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo usuario</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('users.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @include('users.fields')

                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
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
