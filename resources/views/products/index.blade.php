@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Productos</h2>
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
                                    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i> Nuevo producto</a>
                                </div>
                            </div>
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
                            <!-- Agrega el scroll horizontal para la tabla -->
                            <div class="table-responsive">
                                <!-- Agrega la tabla de productos -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Codigo</th>
                                            <th>Categoría</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <img src="{{ $product->image? $product->image : 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png' }}" alt="{{ $product->name }}" class="" width="100">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->category->title }}</td>
                                                <td>
                                                    <a href="{{ route('products.show', $product) }}"
                                                        class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> </a>
                                                    <a href="{{ route('products.edit', $product) }}"
                                                        class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> </a>
                                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                        style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></button>
                                                    </form>

                                                </td>
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
@endsection
@section('js')
@endsection
