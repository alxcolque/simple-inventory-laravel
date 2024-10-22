@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h2 class="card-title text-center">KARDEX FÍSICO - VALORADO</h2>
                        {{-- Botones de imprimir y descargar --}}
                        <div class="">
                            <button class="btn btn-primary"><i class="mdi mdi-printer"></i></button>
                            <button class="btn btn-success"><i class="mdi mdi-file-download"></i></button>
                            {{-- Devolucion al proveedor --}}
                            <a href="javascript:void(0)" onclick="openReturnToSupplierModal()" title="Devolucion al proveedor"
                                class="btn btn-warning"><i class="mdi mdi-undo"></i> Devolver</a>
                            {{-- Devolucion del cliente --}}
                            <a href="javascript:void(0)" onclick="openReturnFromClientModal()" title="Devolucion del cliente"
                                class="btn btn-danger"><i class="mdi mdi-undo"></i> Devolucion del cliente</a>
                        </div>
                        <b>PRODUCTO: {{ $product->name }}</b>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Fecha</th>
                                    <th rowspan="2">Tipo de movimiento</th>
                                    <th colspan="3" class="text-center">CANTIDAD FÍSICA</th>
                                    <th rowspan="2">Costo unitario</th>
                                    <th colspan="3" class="text-center">CONTROL VALORADO</th>

                                </tr>
                                <tr>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Saldo</th>
                                    <th>Monto entrada</th>
                                    <th>Monto salida</th>
                                    <th>Monto saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kardex as $k)
                                    <tr>
                                        <td>{{ $k->created_at }}</td>
                                        <td>{{ $k->detail }}</td>
                                        <td>{{ $k->product_entry }}</td>
                                        <td>{{ $k->product_exit }}</td>
                                        <td>{{ $k->product_stock }}</td>
                                        <td>{{ $k->cost_unit }}</td>
                                        <td>{{ $k->amount_entry }}</td>
                                        <td>{{ $k->amount_exit }}</td>
                                        <td>{{ $k->amount_stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('kardexes.return-to-supplier')
    @include('kardexes.return-from-client')
@endsection

@section('css')
@endsection

@section('js')
<script>
    function openReturnToSupplierModal(){
        $('#returnToSupplierModal').modal('show');
    }
    function openReturnFromClientModal(){
        $('#returnFromClientModal').modal('show');
    }
</script>
@endsection
