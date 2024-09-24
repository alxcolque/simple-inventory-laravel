@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Categorías</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="for" action="{{ route('categories.index') }}" method="GET" autocomplete="off">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar categoría">
                                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Agregar</a>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Categoría</th>
                                        <th>Icono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td><i class="{{ $category->icon }}" style="color: {{ $category->color }}"></i></td>
                                            <td>
                                                {{-- <a href="{{ route('categories.show', $category) }}"
                                                    class="btn btn-sm btn-primary">Ver</a> --}}
                                                <a href="{{ route('categories.edit', $category) }}"
                                                    class="btn btn-sm btn-secondary"><i class="mdi mdi-pencil"></i> </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                    style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
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
                            {{ $categories->links() }}
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
