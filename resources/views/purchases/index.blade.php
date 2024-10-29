@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 row">
                            <h2 class="col-md-4 mb-4">Mis Compras</h2>
                            <div class="card col-md-4 mb-4">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0" id="total_compras">Bs <span class="text-danger">{{ number_format($total_compras, 2, '.', ',') }}</span> </h3>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-danger">
                                            <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">TOTAL COMPRAS</h6>

                            </div>
                            <div class="card col-md-4 mb-4">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0" id="total_stock">Bs <span class="text-success">{{ number_format($total_stock, 2, '.', ',') }}</span> </h3>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-success ">
                                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">TOTAL STOCK</h6>

                            </div>
                        </div>

                        <!-- Agrega el filtro de categorías aquí -->
                        <div class="row mb-3 no-print">
                            <div class="col-12">
                                <div class="d-flex overflow-auto">
                                    <!-- Agrega un botón para mostrar todos los productos -->
                                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-primary me-2">Todos</a>
                                    <!-- bucle foreach para mostrar las categorías -->

                                    @foreach ($categories as $category)
                                        <!-- El boton debe tener un enlace a la ruta de filtrado por categoría y debe tener de background su color -->
                                        <a href="{{ route('purchases.index', ['category' => $category->id]) }}"
                                            class="btn btn-outline-primary me-2"
                                            style="background-color: {{ $category->color }}; color: white;">{{ $category->title }}</a>
                                    @endforeach
                                    <!-- Agrega más botones de categoría según sea necesario -->
                                </div>
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-md-4">
                                <form class="for" action="{{ route('purchases.index') }}" method="GET"
                                    autocomplete="off">
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
                                    <option value="{{ route('purchases.index') }}">Todos</option>
                                    <option value="{{ route('purchases.index', ['filter' => 'day']) }}"
                                        {{ $filter == 'day' ? 'selected' : '' }}>Hoy</option>
                                    <option value="{{ route('purchases.index', ['filter' => 'week']) }}"
                                        {{ $filter == 'week' ? 'selected' : '' }}>Esta semana</option>
                                    <option value="{{ route('purchases.index', ['filter' => 'month']) }}"
                                        {{ $filter == 'month' ? 'selected' : '' }}>Este mes</option>
                                    <option value="{{ route('purchases.index', ['filter' => 'year']) }}"
                                        {{ $filter == 'year' ? 'selected' : '' }}>Este año</option>
                                </select>

                                <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('purchases.create') }}'">
                                    <i class="mdi mdi-cart-plus"></i> Nueva Compra
                                </button>
                                <button type="button" onclick="window.print()" class="btn btn-dark btn-rounded btn-icon">
                                    <i class="mdi mdi-printer" style="font-size: 1.5rem"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-rounded btn-icon btn-excel">
                                    <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color:black"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Agrega el scroll horizontal para la tabla -->
                        <div class="table-responsive">
                            <!-- Agrega la tabla de productos -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Subtotal</th>
                                        <th>F-Ven</th>
                                        <th class="no-print">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>
                                                <img src="{{ $purchase->product->image ? $purchase->product->image : 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png' }}"
                                                    alt="{{ $purchase->product->name }}" class="" width="100">
                                            </td>
                                            <td>
                                                {{ $purchase->product->name }}
                                                <br>
                                                {{-- span small category --}}
                                                <span style="font-size: 10px; color: {{ $purchase->product->category->color }};">{{ $purchase->product->category->title }}</span>
                                            </td>
                                            <td>{{ $purchase->qty }}</td>
                                            <td>{{ $purchase->price }}</td>
                                            <td>{{ $purchase->stock }}</td>
                                            <td>{{ number_format($purchase->balance, 2, '.', ',') }}</td>
                                            <td>{{ $purchase->expiration_date }}</td>
                                            <td class="no-print">
                                                <a href="{{ route('purchases.show', $purchase) }}"
                                                    title="Ver detalle de compra"
                                                    class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> </a>
                                                <a href="{{ route('get-kardexes.show', ['id' => $purchase->product->id]) }}"
                                                    title="Ver kardex"
                                                    class="btn btn-sm btn-info"><i class="mdi mdi-table"></i> </a>

                                                {{--  --}}
                                                {{-- <a href="{{ route('purchases.edit', $purchase) }}"
                                                        class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> </a>
                                                    <form action="{{ route('purchases.destroy', $purchase) }}" method="POST"
                                                        style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar este purchaseo?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></button>
                                                    </form> --}}

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
        /* Realiza una operacion para obtener el total de compras y el beneficio y sus porcentales*/

    </script>
@endsection
