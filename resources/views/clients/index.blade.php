@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Clientes</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="for" action="{{ route('clients.index') }}" method="GET" autocomplete="off">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar cliente">
                                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end mb-2">
                                    <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i> Nuevo cliente</a>
                                </div>
                            </div>
                            <!-- Agrega el scroll horizontal para la tabla -->
                            <div class="table-responsive">
                                <!-- Agrega la tabla de cliente"> -->
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
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $client->cinit }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>
                                                    <a href="{{ route('clients.edit', $client) }}"
                                                        class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> </a>
                                                    @if(auth()->user()->role == 'admin')
                                                    <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                                        style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></button>
                                                    </form>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $clients->links() }}
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
