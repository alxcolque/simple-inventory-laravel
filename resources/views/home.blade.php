@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>COMPRAS</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h4 class="mb-0">Bs {{ $total_compras }}</h4>
                                    {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal">11.38% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-credit-card text-danger ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>STOCK</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h4 class="mb-0">Bs {{ $total_stock }}</h4>
                                    {{-- <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal">2.27% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-database text-warning ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>VENTAS</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h4 class="mb-0">Bs {{ $total_ventas }}</h4>
                                    {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+8.3%</p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-sale text-primary ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>BENEFICIO</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h4 class="mb-0">Bs {{ $total_beneficio }}</h4>
                                    {{-- <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p> --}}
                                </div>
                                {{-- <h6 class="text-muted font-weight-normal">2.27% Since last month</h6> --}}
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right no-print">
                                <i class="icon-lg mdi mdi-wallet text-success ms-auto"></i>
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
                                            <td> {{ $purchase->price }} </td>
                                            <td class="no-print">
                                                <!-- añadir boton de añadir al carrrito -->
                                                <button type="button"
                                                    onclick="selectProduct('{{ $purchase->id }}','{{ $purchase->product->id }}','{{ $purchase->product->name }}','{{ $purchase->product->image }}', '{{ $purchase->price }}', '{{ $purchase->stock }}')"
                                                    class="btn btn-success"><i class="mdi mdi-cart"></i></button>
                                                {{-- Show kardex --}}
                                                <a href="{{ route('get-kardexes.show', ['id' => $purchase->product->id]) }}"
                                                    class="btn btn-info"><i class="mdi mdi-eye"></i></a>

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

                        <h4 class="card-title">Total Stock: {{ $total_beneficio }}</h4>
                        <canvas id="stockCanva" style="height: 311px; display: block; width: 623px;" width="623"
                            height="311" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Ventas por categoría</h4>
                        <canvas id="pieChartByCategory" style="height: 311px; display: block; width: 623px;"
                            width="623" height="311" class="chartjs-render-monitor"></canvas>
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
    <!-- Modal para agregar cantidad de producto al carrito -->
    <div class="modal fade" id="addCartQuantityModal" tabindex="-1" aria-labelledby="addCartQuantityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCartQuantityModalLabel">Agregar al carrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCartQuantity">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>¿Cuántas unidades?</p>
                                {{-- Aumentar de tamaño de campo de cantidad --}}
                                <input type="number" class="form-control text-dark" id="quantity" min="1"
                                    value="1" style="width: 100px;font-size: 1.2rem; background-color: #f0f0f0;">
                            </div>
                            <div class="col-md-6">
                                {{-- input de unidades --}}
                                <p class="mt-2">Selecciona la unidad de medida</p>
                                <div class="mt-2">
                                    {{-- units = ['caja', 'tableta', 'frasco', 'kilo', 'quintal', 'tonelada', 'unidad', 'gramos', 'mililitros', 'miligramos', 'microgramos']; --}}
                                    <select class="form-select" id="unit" name="unit" required>
                                        <option value="unidad">Unidad</option>
                                        <option value="kilo">Kilo</option>
                                        <option value="quintal">Quintal</option>
                                        <option value="tonelada">Tonelada</option>
                                        <option value="unidad">Unidad</option>
                                        <option value="gramos">Gramos</option>
                                        <option value="mililitros">Mililitros</option>
                                        <option value="miligramos">Miligramos</option>
                                        <option value="microgramos">Microgramos</option>
                                        <option value="jarabe">Jarabe</option>
                                        <option value="ampolla">Ampolla</option>
                                        <option value="caja">Caja</option>
                                        <option value="tableta">Tableta</option>
                                        <option value="frasco">Frasco</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- 2 columnas para iva y revenue --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="iva" class="col-form-label">Marca si es con IVA</label>
                                <input type="checkbox" class="form-check-input mt-2 me-2" id="iva" name="iva"
                                    placeholder="IVA" value="{{ old('iva', $purchase->iva ?? '0') }}"
                                    {{ old('iva', $purchase->iva ?? '0') ? 'checked' : 'checked' }}>
                            </div>
                            <div class="col-md-6">
                                <label for="revenue" class="col-form-label">Ganancia en porcentaje (%)</label>
                                <input type="number" class="form-control mt-2 text-dark" id="revenue" min="0"
                                    value="50" style="width: 100px;font-size: 1.2rem; background-color: #f0f0f0;">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
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
        /* Crar el grafico de stock */
        var forSale = '{{ $total_stock }}';
        // alternativa para obtener datos de la variable de php
        // var forSale = document.getElementById('forSale').value;

        var sold = {{ $total_beneficio - $total_stock }}
        //Recupera la sonculta de la variable $categories_sales y la convierte en arreglo de javascript
        //Uncaught SyntaxError: Expected property name or '}' in JSON at position 2
        var categoriesSales = JSON.parse('{!! json_encode($categories_sales) !!}');

        var purchaseId;
        var productId2;
        var productName;
        var productImage;
        var productPrice;
        var productStock;

        function selectProduct(id, productId, name, image, price, stock) {
            purchaseId = id;
            productId2 = productId;
            productName = name;
            productImage = image;
            productPrice = price;
            productStock = stock;

            var titleProduct = name + ' : Bs. ' + price;

            // colocar el titutlo del modal con el nombre del producto
            $('#addCartQuantityModalLabel').text(titleProduct);
            $('#addCartQuantityModal').modal('show');
        }

        //al dar click en el boton de agregar, se agrega el producto al carrito
        document.getElementById('addCartQuantity').addEventListener('submit', function(e) {
            e.preventDefault();
            //console.log(productId, productName, productImage, productPrice, productStock);
            //obtener la cantidad de productos a agregar
            var quantity = document.getElementById('quantity').value;
            var unit = document.getElementById('unit').value;


            if (quantity == 0) {
                return;
            }
            /*if (quantity > productStock) {
                alert('No hay suficiente stock disponible');
                //$('#addCartQuantityModal').modal('hide');
                return;
            } */
            else {
                //if is checked iva
                var iva = document.getElementById('iva').checked;
                var revenue = document.getElementById('revenue').value;
                if (iva) {
                    iva = true;
                } else {
                    iva = false;
                }
                var priceWithRevenue = parseFloat(productPrice) * parseFloat(revenue) / 100;
                //Parse float
                var priceTotal = parseFloat(productPrice) + parseFloat(priceWithRevenue)
                if (iva) {
                    priceTotal = priceTotal * 1.13;
                }

                addToCart(purchaseId, productId2, productName, productImage, priceTotal, productStock, quantity, unit, iva);
                $('#addCartQuantityModal').modal('hide');
            }

        });
    </script>
    <script src="{{ asset('js/chart-home.js') }}"></script>
@endsection
