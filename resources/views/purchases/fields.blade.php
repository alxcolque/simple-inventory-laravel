<!-- Agrega el campo de categoría padre aquí -->
<div class="form-group row">

</div>
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="product_id" class="col-sm-3 col-form-label">Producto</label>
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
    <!-- campo cantidad -->
    <div class="col-md-6 form-group row">
        <label for="qty" class="col-sm-3 col-form-label">Cantidad <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="qty" name="qty" placeholder="Cantidad"
                value="{{ old('qty', $purchase->qty ?? '1') }}">
            @error('qty')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<!-- Tres columnas para precio de compra, precio de venta y stock -->
<div class="row">
    <!-- campo precio de compra -->
    <div class="col-md-4 form-group row">
        <label for="price" class="col-form-label">Precio de compra <span class="text-danger">*</span></label>
        <div class="col-sm-12">
            <input type="number" class="form-control" id="price" name="price" placeholder="Precio de compra"
                value="{{ old('price', $purchase->price ?? '0') }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <!-- campo price_sale -->
    <div class="col-md-4 form-group row">
        <label for="price_sale" class="col-form-label">Precio de venta <span class="text-danger">*</span></label>
        <div class="col-sm-12">
            <input type="number" class="form-control" id="price_sale" name="price_sale" placeholder="price_sale"
                value="{{ old('price_sale', $purchase->price_sale ?? '0') }}">
            @error('price_sale')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <!-- campo Ganancia -->
    <div class="col-md-4 form-group row">
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
