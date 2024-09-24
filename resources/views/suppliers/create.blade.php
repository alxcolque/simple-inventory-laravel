@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Nuevo proveedor </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">proveedors</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo proveedor</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('suppliers.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @include('suppliers.fields')

                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-dark">Cancelar</a>
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
@endsection
