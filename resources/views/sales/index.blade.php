@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2>Mis Ventas</h2>
                        @if($sales->isEmpty())
                            <div class="alert alert-warning">
                                No hay ventas registradas.
                            </div>
                        @else

                        <div class="row no-print">
                            <div class="col-md-4">
                                <form class="for" action="{{ route('sales.index') }}" method="GET" autocomplete="off">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ $search }}" placeholder="Buscar producto">
                                        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 text-end mb-2">
                                <!-- Agrega un input de select para filtrar por dia semana mes y año -->

                                <select class="me-2" id="filter" name="filter"
                                    onchange="window.location.href = this.value">
                                    <option value="">-- Filtrar por: --</option>
                                    <option value="{{ route('sales.index') }}">Todos</option>
                                    <option value="{{ route('sales.index', ['filter' => 'day']) }}"
                                        {{ $filter == 'day' ? 'selected' : '' }}>Hoy</option>
                                    <option value="{{ route('sales.index', ['filter' => 'week']) }}"
                                        {{ $filter == 'week' ? 'selected' : '' }}>Esta semana</option>
                                    <option value="{{ route('sales.index', ['filter' => 'month']) }}"
                                        {{ $filter == 'month' ? 'selected' : '' }}>Este mes</option>
                                    <option value="{{ route('sales.index', ['filter' => 'year']) }}"
                                        {{ $filter == 'year' ? 'selected' : '' }}>Este año</option>
                                </select>


                                <button type="button" onclick="window.print()" class="btn btn-dark btn-rounded btn-icon">
                                    <i class="mdi mdi-printer" style="font-size: 1.5rem"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-rounded btn-icon btn-excel">
                                    <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color:black"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th class="no-print">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->created_at }}</td>
                                            <td>{{ $sale->client->name }}</td>
                                            <td>{{ $sale->total }}</td>
                                            <td class="no-print">
                                                <a href="{{ route('sales.show', $sale) }}"
                                                    class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $sales->links() }}
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
        document.getElementById('filter').addEventListener('change', function() {
            window.location.href = this.value;
            fetch(this.value)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.table-responsive').innerHTML = html;
                });
            window.history.pushState(null, '', this.value);
            history.replaceState(null, null, this.value);
        });
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
            XLSX.writeFile(wb, 'compra_' + fileName);
        });
    </script>
@endsection
