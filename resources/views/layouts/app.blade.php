<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }} Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-toaster.min.css') }}"> --}}
    @yield('css')
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <style>
        .form-control,
        .form-select,
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea {
            background-color: #ffffff !important;
            /* Fondo blanco */
            color: #333333 !important;
            /* Texto oscuro para contraste */
        }

        /* Ajuste del color del placeholder para mejor visibilidad */
        .form-control::placeholder,
        input::placeholder,
        textarea::placeholder {
            color: #999999 !important;
        }
    </style>
</head>

<body>

    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('layouts.partials.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <div class="no-print">
                @include('layouts.partials.navbar')
            </div>


            <!-- partial -->
            <div class="main-panel">
                @include('layouts.partials.alert')
                @yield('content')
                @include('layouts.partials.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @yield('modals')
    <!-- Modal para un carrito de compras -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Carrito de compras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table-reponsive" id="cartTable" style="font-size: 0.8rem;">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>IVA</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">

                        </tbody>
                        <!-- Agrega más filas para totales -->
                        <tfoot>
                            <tr>
                                <td> </td>
                                <td colspan="2"> <b>Con IVA:</b></td>
                                <td>
                                    <h4 id="totalIva">0</h4>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <h4>Total: Bs </h4>
                                </td>
                                <td>
                                    <h4 id="total">0</h4>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    {{-- Alineado a la --}}
                    <div class="d-flex justify-content-between">
                        {{-- Check para marcar iva --}}
                        <span id="clientNameCompra"></span>

                        <!-- Asigna el cliente a esta compra, con select 2, desde la bariable $clients -->
                        <div id="clientSelect" class="form-group"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- Boton cancelar --->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-danger" onclick="clearLocalStorage();">Limpiar</button>

                    <button type="button" id="payButton" class="btn btn-primary">Pagar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('js/bootstrap-toaster.min.js') }}"></script> --}}
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->
    @yield('js')
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
