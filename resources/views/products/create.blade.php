@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Nuevo producto </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo producto</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('products.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @include('products.fields')

                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            <a href="{{ route('products.index') }}" class="btn btn-dark">Cancelar</a>
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
<script src="https://cdn.tiny.cloud/1/cqu9z23sxsssxrvq8aabyju86nlrsh9j57v2u70r0r8gf40q/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script type="text/javascript" src="{{ asset('js/preview-img.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/text-editor.js') }}"></script>
@endsection
