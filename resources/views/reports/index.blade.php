@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h2>Reportes</h2>
                @if ($products->isEmpty())
                    <div class="alert alert-warning">
                        No hay ventas registrados.
                    </div>
                    <a href="{{ route('reports.index') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-reload" style="font-size: 1.5rem"></i>Todos
                    </a>
                @else
                    <div class="row no-print">
                        {{-- Seleccionar hoy semana mes o año --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">

                                <select class="form-select" id="timeSel" name="time-sel"
                                    aria-label="Default select example">
                                    <option selected>Seleccionar</option>
                                    <option value="today">Hoy</option>
                                    <option value="week">Semana</option>
                                    <option value="month">Mes</option>
                                    <option value="year">Año</option>
                                </select>
                            </div>
                            {{-- date picker range --}}
                            <div class="mb-3 col-md-6">
                                <span>Rango de fechas</span>
                                <input type="text" name="daterange" value="01/01/2025 - 01/01/2025" />
                            </div>

                        </div>

                        <div class="col-md-4">
                            <form class="for" action="{{ route('reports.index') }}" method="GET" autocomplete="off">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ $search }}"
                                        placeholder="Buscar producto">
                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8 text-end mb-2">
                            {{-- Todos --}}
                            <a href="{{ route('reports.index') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-reload" style="font-size: 1.5rem"></i>Todos
                            </a>
                            {{-- Botones: Mas vendidos y menos vendidos --}}
                            <a href="{{ route('reports.index', ['type' => 'most_sold']) }}" class="btn btn-success btn-sm">
                                <i class="mdi mdi-chart-bar" style="font-size: 1.5rem"></i>
                                Mas vendidos
                            </a>
                            <a href="{{ route('reports.index', ['type' => 'least_sold']) }}" class="btn btn-danger btn-sm">
                                <i class="mdi mdi-chart-bar" style="font-size: 1.5rem"></i>
                                Menos vendidos
                            </a>
                            <button type="button" onclick="window.print()"
                                class="btn btn-dark btn-rounded btn-icon btn-sm">
                                <i class="mdi mdi-printer" style="font-size: 1.5rem"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-rounded btn-icon btn-sm btn-excel">
                                <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color:black"></i>
                            </button>
                        </div>
                    </div>
                @endIf
            </div>
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
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- Date piker de fondo negro --}}
    <style>
        .daterangepicker {
            background-color: #000000;
            color: white;
        }

        .daterangepicker .calendar-table {
            border: 1px solid #fff;
            border-radius: 4px;
            background-color: #c1b5c4;
        }
    </style>

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                //    .format('YYYY-MM-DD'));
                var route = '{{ route('reports.index') }}?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD');

                window.location.href = route;
                fetch(route)
                    .then(response => response.text())
                    .then(html => {
                        location.reload();
                    });

                window.history.pushState(null, '', route);
            });
        });
    </script>
    <script>
        document.getElementById('timeSel').addEventListener('change', function() {
            let value = this.value;

            /* Peticion get a la ruta reports.index y le pasamos el valor del input*/
            var route = '{{ route('reports.index') }}?time-sel=' + value;

            window.location.href = route;
            fetch(route)
                .then(response => response.text())
                .then(html => {
                    location.reload();
                });

            window.history.pushState(null, '', route);
            //history.replaceState(null, null, this.value);
        });
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
