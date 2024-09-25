@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">

        <div class="row">
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Beneficio</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">$32123</h2>
                                    <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p>
                                </div>
                                <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-codepen text-primary ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Ventas</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">$45850</h2>
                                    <p class="text-success ms-2 mb-0 font-weight-medium">+8.3%</p>
                                </div>
                                <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-wallet-travel text-danger ms-auto"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Compras</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div class="d-flex d-sm-block d-md-flex align-items-center">
                                    <h2 class="mb-0">$2039</h2>
                                    <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p>
                                </div>
                                <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                            </div>
                            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                <i class="icon-lg mdi mdi-monitor text-success ms-auto"></i>
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
                            <form class="for" action="{{ route('home') }}" method="GET" autocomplete="off">
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
                        <select class="mb-2" id="filter" name="filter" onchange="window.location.href = this.value">
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

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Código </th>
                                        <th> Producto </th>
                                        <th> Categoría </th>
                                        <th> Stock </th>
                                        <th> Precio </th>
                                        <th> Acciones </th>
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
                                            <td> {{ $purchase->price + $purchase->revenue }} </td>
                                            <td>
                                                <!-- añadir boton de añadir al carrrito -->
                                                <button type="button"
                                                    onclick="addToCart('{{ $purchase->product_id }}','{{ $purchase->product->name }}','{{ $purchase->product->image }}', '{{ $purchase->price + $purchase->revenue }}')"
                                                    class="btn btn-success"><i class="mdi mdi-cart"></i></button>
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
@section('modals')
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
                    <!-- Asigna el cliente a esta compra, con select 2, desde la bariable $clients -->
                    <select class="js-example-basic-single" id="client" name="client"
                        onchange="asignClient( this.value, this.options[this.selectedIndex].text )">
                        <option value="">-- Seleccione un cliente --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    <b>Cliente: </b><span id="clientNameCompra"></span>
                </div>
                <div class="modal-footer">
                    <!-- Boton cancelar --->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-danger"
                        onclick="clearLocalStorage();">Limpiar</button>

                    <button type="button" id="payButton" class="btn btn-primary">Pagar</button>
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
    </script>
    <script>
        // Agrega el código para mandar productos al carrito de compras, donde se debe almacenar en memoria temporal del navegador.
        // Al abrir el modal de carrito de compras, se debe mostrar el contenido del carrito.
        // Al eliminar un producto del carrito, se debe eliminar del carrito y actualizar la vista.
        // Al pagar el carrito, se debe limpiar el carrito y mostrar un mensaje de éxito.
        // Obtén una referencia al botón "Agregar al carrito"
        function addToCart(id, name, image, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let product = cart.find(p => p.id == id);
            if (product) {
                product.quantity++;
            } else {
                cart.push({
                    id,
                    name,
                    image,
                    price,
                    quantity: 1
                });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        //Abrir el modal
        function openCartModal() {
            showCart();
            let modal = new bootstrap.Modal(document.getElementById('cartModal'), {
                keyboard: false
            });
            modal.show();
        }
        // recupera el carrito del local storage y lo muestra en el modal
        function showCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let tbody = document.getElementById('cart-items');
            tbody.innerHTML = '';
            cart.forEach(product => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                <td>
                    <img src="${product.image}" width="50" />
                    ${product.name}
                </td>
                <td>${product.price}</td>
                <td>${product.quantity}</td>
                <td>${product.price * product.quantity}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${product.id})"><i class="mdi mdi-delete"></i></button>
                </td>
                `;
                tbody.appendChild(tr);
            });
            // Calcular el total
            let total = cart.reduce((acc, p) => acc + p.price * p.quantity, 0);
            // guardar el total en el local storage
            localStorage.setItem('total', total);
            document.getElementById('total').textContent = total;
            //
            var clientNameCompra = localStorage.getItem('clientName');
            document.getElementById('clientNameCompra').textContent = clientNameCompra;
        }

        function asignClient(clientId, clientName) {
            // Los parametros guarda en una variable del storage para recuperar en el pago
            localStorage.setItem('clientId', clientId);
            localStorage.setItem('clientName', clientName);
            // Para mostrar en el modal recupera el nombre del cliente desde localstorage para asignarle a clientNameCompra
            showCart()
        }
        function clearLocalStorage() {
            localStorage.removeItem('cart');
            localStorage.removeItem('clientId');
            localStorage.removeItem('clientName');
            localStorage.removeItem('total');
            showCart();
        }
        function removeFromCart(id) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let product = cart.find(p => p.id == id);
            if (product) {
                product.quantity--;
                if (product.quantity <= 0) {
                    cart = cart.filter(p => p.id != id);
                }
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            showCart();
        }
        // una funcion cuando se de clic en payButton es el boton de pagar del modal
        document.getElementById('payButton').addEventListener('click', function() {
            // recupera el carrito del local storage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            // recupera el cliente del local storage
            let clientId = localStorage.getItem('clientId');
            // recupera el nombre del cliente del local storage
            let clientName = localStorage.getItem('clientName');
            // recupera el total del local storage
            let total = localStorage.getItem('total');
            // si no hay productos en el carrito
            if (cart.length == 0) {
                alert('No hay productos en el carrito');
                return;
            }
            if (!clientId) {
                alert('Seleccione un cliente');
                return;
            }
            fetch("/sales", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        cart,
                        clientId,
                        total,
                    })
                }).then(response => response.json())
                .then(data => {
                    alert('Venta realizada con éxito');
                    clearLocalStorage()
                    showCart();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
                    modal.hide();
                    window.location.reload();
                });
        });
    </script>
@endsection
