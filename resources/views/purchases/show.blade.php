@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title"> {{$purchase->product->name}} </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Compras</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$purchase->product->name}}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Producto:</strong> {{ $purchase->product->name }}</p>
                                <p><strong>Unidad:</strong> {{ $purchase->unit }}</p>
                                {{-- Barra de progreso de fecha de expiracion --}}
                                @if($purchase->expiration_date)
                                <p><strong>Fecha de expiración:</strong> {{ $purchase->expiration_date }}</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ min(max(0, (strtotime('now') - strtotime($purchase->expiration_date)) / (365 * 24 * 60 * 60) * 100), 100) }}%"
                                         aria-valuenow="{{ $purchase->expiration_date ? min(max(0, (strtotime('now') - strtotime($purchase->expiration_date)) / (365 * 24 * 60 * 60) * 100), 100) : 0 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                @endif
                                <p><strong>Categoría:</strong> {{ $purchase->product->category->title }}</p>
                                <p><strong>Código:</strong> {{ $purchase->product->code }}</p>
                                <p><strong>Proveedor:</strong> {{ $purchase->supplier->full_name }}</p>
                                <p><strong>Cantidad:</strong> {{ $purchase->qty }}</p>
                                <p><strong>Precio de compra:</strong> {!! $purchase->price !!}</p>
                                <p><strong>Precio de venta:</strong> {!! $purchase->price + $purchase->revenue !!}</p>
                                <p><strong>Ganancia:</strong> {!! $purchase->revenue !!}</p>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ $purchase->product->image? $purchase->product->image : 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png' }}" height="250" alt="{{ $purchase->product->name }}" class="">
                            </div>
                            <div class="col-md-12">
                                <p><strong>Descripción:</strong> {!! $purchase->product->description !!}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">

                                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-primary btn-sm"> <i class="mdi mdi-pencil"></i> Editar</a>

                                @if(auth()->user()->role == 'admin')
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                    style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar esta compra?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i>Eliminar</button>
                                </form>
                                @endif
                                <a href="{{ route('purchases.index') }}" class="btn btn-dark btn-sm"> <i class="mdi mdi-arrow-left"></i>Atrás</a>
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
