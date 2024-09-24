@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Mis Compras</h2>
                            <!-- Agrega el filtro de categorías aquí -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex overflow-auto">
                                        <!-- Agrega un botón para mostrar todos los productos -->
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary me-2">Todos</a>
                                        <!-- bucle foreach para mostrar las categorías -->
                                        @foreach ($categories as $category)

                                            <!-- El boton debe tener un enlace a la ruta de filtrado por categoría y debe tener de background su color -->
                                            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary me-2" style="background-color: {{ $category->color }}; color: white;">{{ $category->title }}</a>
                                        @endforeach
                                        <!-- Agrega más botones de categoría según sea necesario -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="for" action="{{ route('products.index') }}" method="GET" autocomplete="off">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar producto">
                                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end mb-2">
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon">
                                        <i class="mdi mdi-plus" onclick="window.location.href='{{ route('purchases.create') }}'" style="font-size: 1.5rem"></i>
                                      </button>
                                      <button type="button" class="btn btn-dark btn-rounded btn-icon">
                                        <i class="mdi mdi-printer" style="font-size: 1.5rem"></i>
                                      </button>
                                      <button type="button" class="btn btn-success btn-rounded btn-icon">
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
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>PCom</th>
                                            <th>PVen</th>
                                            <th>G</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchases as $purchase)
                                            <tr>
                                                <td>
                                                    <img src="{{ $purchase->product->image? $purchase->product->image : 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png' }}" alt="{{ $purchase->product->name }}" class="" width="100">
                                                </td>
                                                <td>{{ $purchase->product->name }}</td>
                                                <td>{{ $purchase->product->category->title }}</td>
                                                <td>{{ $purchase->qty }}</td>
                                                <td>{{ $purchase->price }}</td>
                                                <td>{{ $purchase->price*$purchase->revenue }}</td>
                                                <td>{{ $purchase->revenue}}</td>
                                                <td>
                                                    <a href="{{ route('purchases.show', $purchase) }}"
                                                        class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> </a>
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
@endsection
@section('js')
<script>

</script>
@endsection
