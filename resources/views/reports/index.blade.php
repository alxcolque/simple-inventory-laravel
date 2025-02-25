@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2>Reportes</h2>
                        @if($products->isEmpty())
                            <div class="alert alert-warning">
                                No hay productos registrados.
                            </div>
                        @else

                        <div class="row no-print">
                            <div class="col-md-4">
                                <form class="for" action="{{ route('products.index') }}" method="GET" autocomplete="off">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ $search }}" placeholder="Buscar producto">
                                        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 text-end mb-2">
                                {{-- Botones: Mas vendidos y menos vendidos --}}
                                <a href="" class="btn btn-success">
                                    <i class="mdi mdi-chart-bar" style="font-size: 1.5rem"></i>
                                    Mas vendidos
                                </a >
                                <a href="" class="btn btn-danger">
                                    <i class="mdi mdi-chart-bar" style="font-size: 1.5rem"></i>
                                    Menos vendidos
                                </a>
                                <button type="button" onclick="window.print()" class="btn btn-dark btn-rounded btn-icon">
                                    <i class="mdi mdi-printer" style="font-size: 1.5rem"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-rounded btn-icon btn-excel">
                                    <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color:black"></i>
                                </button>
                            </div>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Unidades vendidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $products->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
        /* document.getElementById('filter').addEventListener('change', function() {
            window.location.href = this.value;
            fetch(this.value)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.table-responsive').innerHTML = html;
                });
            window.history.pushState(null, '', this.value);
            history.replaceState(null, null, this.value);
        }); */
        document.querySelector('.btn-excel').addEventListener('click', function() {

            var wb = XLSX.utils.table_to_book(document.querySelector('table'), {
                sheet: "Sheet JS"
            });

            XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: true,
                type: 'base64'
            });
            var fileName = new Date().toISOString().slice(0, 19).replace(/:/g, '-') + ".xlsx";
            XLSX.writeFile(wb, 'Reporte_ventas_' + fileName);
        });
    </script>
@endsection
