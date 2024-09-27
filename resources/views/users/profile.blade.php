@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-12 grid-margin">
                <div class="card">
                    <!-- Mmuestra los datos de perfil de usuario-->
                    <div class="card-body">
                        <h4 class="card-title">Perfil de usuario</h4>
                        <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : 'https://cdn.iconscout.com/icon/free/png-256/free-avatar-380-456332.png' }}"
                                                alt="Avatar" class="img-thumbnail" style="width: 100px">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <!-- Rol -->
                                    <tr>
                                        <td>Rol</td>
                                        <td>
                                            <div class="badge {{Auth::user()->role == 'admin'? 'badge-outline-success' : 'badge-outline-warning'}} ">{{ Auth::user()->role }}</div>
                                        </td>
                                    <tr>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Correo</td>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                        <td>Fecha de creación</td>
                                        <td>{{ Auth::user()->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Botón para editar el perfil de usuario -->
                            {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar perfil</a> --}}
                            <!-- Botón para cambiar la contraseña -->
                            {{-- <a href="{{ route('profile.password') }}" class="btn btn-primary">Cambiar contraseña</a> --}}
                            <!-- Botón para cerrar sesión -->
                            <a class="btn btn-primary" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                            </a>
                            <!-- Formulario para cerrar sesión -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <!-- Botón para eliminar la cuenta -->
                            {{-- <a href="{{ route('profile.delete') }}" class="btn btn-primary">Eliminar cuenta</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
@endsection
@section('css')
@endsection
@section('js')
@endsection
