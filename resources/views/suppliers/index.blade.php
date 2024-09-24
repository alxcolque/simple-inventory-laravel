@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Proveedores</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="for" action="{{ route('suppliers.index') }}" method="GET" autocomplete="off">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar proveedor">
                                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end mb-2">
                                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i> Nuevo Proveedor</a>
                                </div>
                            </div>
                            <!-- Agrega el scroll horizontal para la tabla -->
                            <div class="table-responsive">
                                <!-- Agrega la tabla de suppliere"> -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>CI/NIT.</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Celular</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->cinit }}</td>
                                                <td>{{ $supplier->full_name }}</td>
                                                <td>{{ $supplier->email }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>
                                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                                        class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> </a>
                                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                                        style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
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
                                    {{ $suppliers->links() }}
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
