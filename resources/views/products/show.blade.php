@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{$product->name}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="" width="100">
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $product->name }}</h2>
                                <p><strong>Código:</strong> {{ $product->code }}</p>
                                <p><strong>Categoría:</strong> {{ $product->category->title }}</p>
                                <p><strong>Descripción:</strong> {!! $product->description !!}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Editar</a>
                                <a href="{{ route('products.index') }}" class="btn btn-dark">Cancelar</a>
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
