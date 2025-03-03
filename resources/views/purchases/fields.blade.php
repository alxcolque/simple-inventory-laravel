<!-- Agrega el campo de categoría padre aquí -->
<div class="form-group row">

</div>
<div class="row">
    <div class="col-md-3 form-group">
        <label for="product_id" class="col-form-label">Producto<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select class="js-example-basic-single" name="product_id" id="product_id">
                @isset($purchase)
                    <option value="{{ old('product_id', $purchase->product_id ?? '') }}"
                        {{ old('product_id') == $purchase->product_id ? 'selected' : '' }}>
                        {{ $purchase->product->name }}</option>
                @else
                    <option value="">Seleccione una categoría</option>
                @endisset
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id', $purchase->product_id ?? '') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}</option>
                @endforeach
            </select>
            @error('product_id')
                <br>
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    {{-- Campo unit --}}
    <div class="col-md-3 form-group">
        <label for="unit" class="col-form-label">Unidad de medida<span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="unit" name="unit" placeholder="Unidad"
                value="{{ old('unit', $purchase->unit ?? 'Unidad') }}">
        </div>
    </div>
    {{-- Fecha de expiracion --}}
    <div class="col-md-3 form-group">
        <label for="expiration_date" class="col-form-label">Fecha de expiración</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="expiration_date" name="expiration_date"
                placeholder="Fecha de expiración"
                value="{{ old('expiration_date', $purchase->expiration_date ?? '') }}">
        </div>
    </div>
    <!-- campo cantidad -->
    <div class="col-md-3 form-group">
        <label for="qty" class="col-form-label">Cantidad <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="decimal" min="0" class="form-control" id="qty" name="qty"
                placeholder="Cantidad" value="{{ old('qty', $purchase->qty ?? '1') }}">
            @error('qty')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<!-- Tres columnas para precio de compra, precio de venta y stock -->
<div class="row">
    <!-- campo iva -->
    <div class="col-md-3 form-group row">
        <label for="iva" class="col-form-label">Marca si es con IVA</label>
        <div class="col-sm-12">
            {{-- Añadir un checkbox para el campo iva --}}
            <input type="checkbox" class="form-check-input" id="iva" name="iva" placeholder="IVA"
                value="{{ old('iva', $purchase->iva ?? '0') }}"
                {{ old('iva', $purchase->iva ?? '0') ? 'checked' : 'checked' }}>
        </div>
    </div>
    <!-- campo precio de compra -->
    <div class="col-md-3 form-group row">
        <label for="price" class="col-form-label">Precio de compra <span class="text-danger">*</span></label>
        <div class="col-sm-12">
            <input type="decimal" min="0" class="form-control" id="price" name="price"
                placeholder="Precio de compra" value="{{ old('price', $purchase->price ?? '0') }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    {{-- Fecha de creacion --}}
    <div class="col-md-3 form-group row">
        <label for="created_at" class="col-form-label">Fecha de creación</label>
        <div class="col-sm-12">
            @isset($purchase)
                @php
                    //Only date
                    $dateCreated = date('Y-m-d', strtotime($purchase->created_at));
                @endphp
            @else
                @php
                    $dateCreated = '';
                @endphp
            @endisset
            <input type="date" class="form-control" id="created_at" name="created_at" placeholder="Fecha de creación"
                value="{{ old('created_at', $dateCreated ?? '') }}">
        </div>
    </div>
    <!-- campo price_sale -->
    <div class="col-md-3 form-group row" hidden>
        <label for="price_sale" class="col-form-label">Precio de venta en (%) <span class="text-danger">*</span></label>
        <div class="col-sm-12">
            <input type="decimal" min="0" class="form-control" id="price_sale" name="price_sale"
                placeholder="Precio de venta (%)"
                value="{{ old('price_sale', isset($purchase) ? $purchase->price + $purchase->revenue : '0') }}">
            @error('price_sale')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-3 form-group row" hidden>
        <label for="revenue" class="col-form-label">Ganancia</label>
        <div class="col-sm-12">
            <b id="revenue" class="text-success">Bs. 0.00</b>
        </div>
    </div>

</div>
<!-- Un campo select para proveedores -->
<div class="form-group row">
    <label for="supplier_id" class="col-sm-3 col-form-label">Proveedor <span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <select class="js-example-basic-single" name="supplier_id" id="supplier_id">
            @isset($purchase)
                <option value="{{ old('supplier_id', $purchase->supplier_id ?? '') }}"
                    {{ old('supplier_id') == $purchase->supplier_id ? 'selected' : '' }}>
                    {{ $purchase->supplier->full_name }}</option>
            @else
                <option value="">Seleccione un proveedor</option>
            @endisset
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}"
                    {{ old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->full_name }}</option>
            @endforeach
        </select>
        @error('supplier_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
{{-- Comentario de compra --}}
<div class="form-group row">
    <label for="comment" class="col-sm-3 col-form-label">Comentario de la compra (Opcional)</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="comment" name="comment" placeholder="Comentario"
            value="{{ old('comment', $purchase->comment ?? '') }}">
    </div>
</div>
