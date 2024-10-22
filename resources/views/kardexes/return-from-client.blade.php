{{-- modal #returnFromClientModal tiene los campos: cantidad, motivo, precio unitario--}}
<div class="modal fade" id="returnFromClientModal" tabindex="-1" aria-labelledby="returnFromClientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnFromClientModalLabel">Devolucion del cliente</h5>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('return-from-client') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Cantidad <span class="text-danger">*</span></label>
                                <input type="decimal" name="quantity" id="quantity" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_price">Precio unitario <span class="text-danger">*</span></label>
                                <input type="decimal" name="unit_price" id="unit_price" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unidad <span class="text-danger">*</span></label>
                                <input type="text" name="unit" id="unit" value="Unidad" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiration_date">Fecha de expiración</label>
                                <input type="date" name="expiration_date" id="expiration_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reason">Motivo</label>
                            <input type="text" name="reason" id="reason" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="supplier_id">Proveedor</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                @foreach ($supplier as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
