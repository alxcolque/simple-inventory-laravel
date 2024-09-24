@extends('layouts.app')

@section('content')
    <!-- content wrapper -->
    <div class="content-wrapper">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2>Usuarios</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="for" action="{{ route('users.index') }}" method="GET" autocomplete="off">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Buscar usuario">
                                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end mb-2">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i> Nuevo usuario</a>
                                </div>
                            </div>
                            <!-- Agrega el scroll horizontal para la tabla -->
                            <div class="table-responsive">
                                <!-- Agrega la tabla de usuario"> -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    <img src="{{ $user->avatar? $user->avatar : 'https://cdn.iconscout.com/icon/free/png-256/free-avatar-380-456332.png%22' }}" alt="{{ $user->name }}" class="" width="100">
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td> <div class="badge {{$user->role == 'admin'? 'badge-outline-success' : 'badge-outline-warning'}} ">{{ $user->role }}</div> </td>
                                                <td>
                                                    <a href="{{ route('users.show', $user) }}"
                                                        class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i> </a>
                                                    <a href="{{ route('users.edit', $user) }}"
                                                        class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i> </a>
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                        style="display: inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
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
                                    {{ $users->links() }}
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
