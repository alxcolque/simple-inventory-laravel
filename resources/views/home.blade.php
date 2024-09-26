@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Beneficio</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Bs {{ $total_beneficio }}</h2>
                                    {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal">11.38% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-codepen text-primary ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Ventas</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Bs {{ $total_ventas }}</h2>
                                    {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+8.3%</p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-wallet-travel text-danger ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Compras</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">Bs {{ $total_compras }}</h2>
                                    {{-- <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal">2.27% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-monitor text-success ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <!--Alinea 2 elementos en una misma linea-->
                        <div class="d-flex justify-content-between">
                            <h4 class="">Mi stock</h4>
                            <form class="no-print" action="{{ route('home') }}" method="GET" autocomplete="off">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ $search }}"
                                        placeholder="Buscar producto">
                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                </div>
                            </form>
                        </div>

                        <!-- Agrega el filtro de categorías aquí -->
                        <div class="row mb-3 no-print">
                            <div class="col-12">
                                <div class="d-flex overflow-auto">
                                    <!-- Agrega un botón para mostrar todos los productos -->
                                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">Todos</a>
                                    <!-- bucle foreach para mostrar las categorías -->

                                    @foreach ($categories as $category)
                                        <!-- El boton debe tener un enlace a la ruta de filtrado por categoría y debe tener de background su color -->
                                        <a href="{{ route('home', ['category' => $category->id]) }}"
                                            class="btn btn-outline-primary me-2"
                                            style="background-color: {{ $category->color }}; color: white;">{{ $category->title }}</a>
                                    @endforeach
                                    <!-- Agrega más botones de categoría según sea necesario -->
                                </div>
                            </div>
                        </div>
                        <div class="no-print">
                            <select class="mb-2" id="filter" name="filter"
                                onchange="window.location.href = this.value">
                                <option value="">-- Filtrar por: --</option>
                                <option value="{{ route('home') }}">Todos</option>
                                <option value="{{ route('home', ['filter' => 'day']) }}"
                                    {{ $filter == 'day' ? 'selected' : '' }}>Hoy</option>
                                <option value="{{ route('home', ['filter' => 'week']) }}"
                                    {{ $filter == 'week' ? 'selected' : '' }}>Esta semana</option>
                                <option value="{{ route('home', ['filter' => 'month']) }}"
                                    {{ $filter == 'month' ? 'selected' : '' }}>Este mes</option>
                                <option value="{{ route('home', ['filter' => 'year']) }}"
                                    {{ $filter == 'year' ? 'selected' : '' }}>Este año</option>
                            </select>
                            <button type="button" onclick="window.print()" class="btn btn-warning btn-rounded btn-icon">
                                <i class="mdi mdi-printer" style="font-size: 1.5rem; color:black"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-rounded btn-icon btn-excel">
                                <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color:black"></i>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Código </th>
                                        <th> Producto </th>
                                        <th> Categoría </th>
                                        <th> Stock </th>
                                        <th> Precio </th>
                                        <th class="no-print"> Acciones </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td> {{ $purchase->product->code }} </td>
                                            <td>
                                                <img
                                                    src="{{ $purchase->product->image ? $purchase->product->image : 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png' }}" />
                                                <span class="ps-2">{{ $purchase->product->name }}</span>
                                            </td>
                                            <td> {{ $purchase->product->category->title }} </td>
                                            <td> {{ $purchase->stock }} </td>
                                            <td> {{ $purchase->price + $purchase->revenue }} </td>
                                            <td class="no-print">
                                                <!-- añadir boton de añadir al carrrito -->
                                                <button type="button"
                                                    onclick="addToCart('{{ $purchase->product->id }}','{{ $purchase->product->name }}','{{ $purchase->product->image }}', '{{ $purchase->price + $purchase->revenue }}', '{{ $purchase->stock }}')"
                                                    class="btn btn-success"><i class="mdi mdi-cart"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $purchases->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Seccion de graficos -->
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Total Stock: {{$total_beneficio}}</h4>
                        <canvas id="stockCanva" style="height: 311px; display: block; width: 623px;" width="623"
                            height="311" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Ventas por categoría</h4>
                        <canvas id="pieChartByCategory" style="height: 311px; display: block; width: 623px;" width="623"
                            height="311" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Venta por tiempo</h4>
                        <!-- Select para graficar ventas por semanas, meses y años -->
                        <select class="mb-2" id="filterGrahp" name="filter_graph" onchange="filterGraph(this.value)">
                            <option value="week">Última semana</option>
                            <option value="month">Ultimo Año</option>
                            <option value="year">Ultimos 5 año</option>
                        </select>
                        <canvas id="barChart" style="height: 166px; display: block; width: 333px;" width="222"
                            height="110" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
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
        /* Crar el grafico de stock */
        var forSale = '{{$total_stock}}';
        // alternativa para obtener datos de la variable de php
        // var forSale = document.getElementById('forSale').value;

        var sold = {{$total_beneficio - $total_stock}}
        //Recupera la sonculta de la variable $categories_sales y la convierte en arreglo de javascript
        //Uncaught SyntaxError: Expected property name or '}' in JSON at position 2
        var categoriesSales = JSON.parse('{!! json_encode($categories_sales) !!}');
        //console.log(categoriesSales);

    </script>
    <script src="{{ asset('js/chart-home.js') }}"></script>
@endsection
