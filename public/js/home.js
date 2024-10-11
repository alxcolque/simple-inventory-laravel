// Agrega el código para mandar productos al carrito de compras, donde se debe almacenar en memoria temporal del navegador.
// Al abrir el modal de carrito de compras, se debe mostrar el contenido del carrito.
// Al eliminar un producto del carrito, se debe eliminar del carrito y actualizar la vista.
// Al pagar el carrito, se debe limpiar el carrito y mostrar un mensaje de éxito.
// Obtén una referencia al botón "Agregar al carrito"
function addToCart(id, name, image, price, stock, quantity, unit) {
    if (stock <= 0) {
        alert('Producto sin stock');
        //Toast.create("Error", 'Producto sin stock', TOAST_STATUS.SUCCESS, 5000);
        return;
    }
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
            quantity,
            unit
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
    //Obtiene y crea un select para selecccionar clientes en el div id=clientSelect
    let clientSelect = document.getElementById('clientSelect');
    clientSelect.innerHTML = '';
    let select = document.createElement('select');
    select.classList.add('js-example-basic-single');
    select.id = 'client';
    select.name = 'client';
    //incluye onclick="asignClient( this.value, this.options[this.selectedIndex].text )" para asignar el cliente seleccionado
    select.setAttribute('onchange', 'asignClient( this.value, this.options[this.selectedIndex].text )');
    select.innerHTML = `
                <option value="">-- Seleccione un cliente --</option>
            `;
    clientSelect.appendChild(select);
    // recupera los clientes de la base de datos
    fetch('/clients-js')
        .then(response => response.json())
        .then(data => {
            data.forEach(client => {
                let option = document.createElement('option');
                option.value = client.id;
                option.textContent = client.name;
                select.appendChild(option);
            });
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
                <td>${(product.price * product.quantity).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${product.id})"><i class="mdi mdi-delete"></i></button>
                </td>
                `;
        tbody.appendChild(tr);
    });

    //Calcula el total
    let total = cart.reduce((acc, p) => acc + p.price * p.quantity, 0);
    //Si es iva es true, se calcula el total con iva
    let iva = localStorage.getItem('iva');
    //console.log(iva);

    if (iva === 'true' || iva == 0) {
        total = total * 1.13;
        //checked el checkbox de iva
        document.getElementById('iva').checked = true;
        document.getElementById('totalIva').textContent = (total * 0.13).toFixed(2);

    } else {
        total = cart.reduce((acc, p) => acc + p.price * p.quantity, 0);
        document.getElementById('iva').checked = false;
        document.getElementById('totalIva').textContent = 0;
        localStorage.setItem('iva', false);

    }
    localStorage.setItem('total', total);
    //Mostrar el total
    // acortar a dos decimales
    total = total.toFixed(2);
    document.getElementById('total').textContent = total;
    //Recupera el nombre del cliente
    var clientNameCompra = localStorage.getItem('clientName');
    document.getElementById('clientNameCompra').textContent = clientNameCompra;
}

// Al marcar y desmarcar el checkbox iva, se debe guardar en el local storage.
document.getElementById('iva').addEventListener('change', function () {
    localStorage.setItem('iva', this.checked);
    showCart();
});

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
    localStorage.removeItem('iva');
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
document.getElementById('payButton').addEventListener('click', function () {
    // recupera el carrito del local storage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    // recupera el cliente del local storage
    let clientId = localStorage.getItem('clientId');
    // recupera el nombre del cliente del local storage
    let clientName = localStorage.getItem('clientName');
    // recupera el total del local storage
    let total = localStorage.getItem('total');
    // recupera el iva del local storage
    let iva = localStorage.getItem('iva');
    let ivaTotal = 0.00;
    if (iva == 'true') {
        ivaTotal = total * 0.13;
    }
    //console.log(iva);
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
            ivaTotal,
        })
    }).then(response => response.json())
        .then(data => {
            alert(data.message);
            clearLocalStorage()
            showCart();
            let modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
            modal.hide();
            if (data.id !== '0') {
                //redirige al detalle de venta
                window.location.href = '/sales/' + data.id;
                return;
            }
            window.location.reload();
        });
});
