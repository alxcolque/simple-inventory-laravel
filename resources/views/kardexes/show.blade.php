@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h2 class="card-title text-center">KARDEX FÍSICO - VALORADO</h2>
                        {{-- Botones de imprimir y descargar --}}
                        <div class="no-print">
                            <button class="btn btn-primary" onclick="window.print()"><i class="mdi mdi-printer"></i></button>
                            <button class="btn btn-success btn-excel"><i class="mdi mdi-file-excel"></i></button>
                            {{-- Devolucion al proveedor --}}
                            <a href="javascript:void(0)" onclick="openReturnToSupplierModal()"
                                title="Devolucion al proveedor" class="btn btn-warning"><i class="mdi mdi-arrow-up"></i>
                                Devolver al proveedor</a>
                            {{-- Devolucion del cliente --}}
                            <a href="javascript:void(0)" onclick="openReturnFromClientModal()"
                                title="Devolucion del cliente" class="btn btn-danger"><i class="mdi mdi-undo"></i>
                                Devolucion del cliente</a>
                            {{-- Eliminar el ultimo registro --}}
                            <a href="javascript:void(0)" onclick="deleteLastRecord()" title="Eliminar el ultimo registro"
                                class="btn btn-danger"><i class="mdi mdi-delete"></i> Eliminar</a>
                        </div>
                        <b id="productName">PRODUCTO: {{ $product->name }}</b>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        function openReturnToSupplierModal() {
            $('#returnToSupplierModal').modal('show');
        }

        function openReturnFromClientModal() {
            $('#returnFromClientModal').modal('show');
        }

        function deleteLastRecord() {
            if (confirm('¿Estas seguro de eliminar el ultimo registro?')) {
                var url = '{{ route('kardexes.destroy', '') }}';
                let kardexId = {!! $kardex->last()->id !!};
                let token = '{{ csrf_token() }}';
                // peticion delete
                $.ajax({
                    url: url + '/' + kardexId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        }
    </script>


    <script>

        document.querySelector('.btn-excel').addEventListener('click', function() {

            var wb = XLSX.utils.table_to_book(document.querySelector('table'), {
                sheet: "Sheet JS"
            });

            XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: true,
                type: 'base64'
            });

            var productName = document.querySelector('#productName').textContent.split(':')[1].trim();

            productName = productName.replace(/\s+/g, '_');
            var fileName = new Date().toISOString().slice(0, 19).replace(/:/g, '-') + ".xlsx";
            XLSX.writeFile(wb, 'kardex_' + productName + '_' + fileName);
        });
        /* Realiza una operacion para obtener el total de compras y el beneficio y sus porcentales*/
    </script>
@endsection
