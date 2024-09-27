@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header no-print">
            <h2 class="page-title"> Venta No.: {{$sale->id}} </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Ventas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$sale->id}}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">{{ config('app.name', 'Laravel') }}</h2>
                        <h4 class="text-center mb-3">Detalle de la venta</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>No. venta:</strong> {{ $sale->id }}</p>
                                <p><strong>NIT:</strong> {{ 1564847857 }}</p>
                                <p><strong>Dirección:</strong> Calle 23 de septiembre puente</p>

                            </div>
                            <div class="col-md-6">
                                <p><strong>Fecha:</strong> {{ $sale->updated_at }}</p>
                                <p><strong>Cliente CI/NIT:</strong> {!! $sale->client->cinit !!}</p>
                                <p><strong>Cliente:</strong> {!! $sale->client->name !!}</p>
                                <p><strong>Vendedor:</strong> {!! $sale->user->name !!}</p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detail as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->qty * $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot></tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                                            <td><strong>{{ $sale->total }}</strong></td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3 no-print">
                            <div class="col-md-12">
                                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-dark"> <i class="mdi mdi-arrow-left"></i>Cancelar</a>
                                <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="mdi mdi-printer"></i> Imprimir</button>
                                {{-- boton inicio --}}
                                <a href="{{route('home')}}" class="btn btn-info btn-sm"><i class="mdi mdi-home"></i> Inicio</a>
                                @if(auth()->user()->role == 'admin')
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                    style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i>Eliminar</button>
                                </form>
                                @endif
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
<style>
    /*Al imprimir omite la ultima columna de acciones de la tabla*/
    @media print {
        .no-print {
            display: none;
        }
    }
</style>
@endsection
@section('js')
@endsection
