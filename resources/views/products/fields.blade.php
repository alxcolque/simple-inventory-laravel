<!-- Agrega el campo de categoría padre aquí -->
<div class="form-group row">
    <label for="category_id" class="col-sm-3 col-form-label">Categoría</label>
    <div class="col-sm-9">
        <select class="js-example-basic-single" name="category_id" id="category_id">
            @isset($product)
                <option value="{{ old('category_id', $product->category_id ?? '') }}"
                    {{ old('category_id') == $product->category_id ? 'selected' : '' }}>
                    {{ $product->category->title }}</option>
            @else
                <option value="">Seleccione una categoría</option>
            @endisset
            @foreach ($categories as $item)
                <option value="{{ $item->id }}"
                    {{ old('category_id', $category->id ?? '') == $item->id ? 'selected' : '' }}>
                    {{ $item->title }}</option>
            @endforeach
        </select>
        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nombre <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                value="{{ old('name', $product->name ?? '') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <!-- campo codigo -->
    <div class="col-md-6 form-group row">
        <label for="code" class="col-sm-3 col-form-label">Código <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="code" name="code" placeholder="Código"
                value="{{ old('code', $product->code ?? $code) }}">
            @error('code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<label for="description" class="col-sm-3 col-form-label">Descripción</label>
<div class="col-sm-12">
    <textarea class="form-control editor" id="description" name="description"
        placeholder="Descripción">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<!-- Subir imagen con previsuallizacion -->
<div class="form-group row">
    <label for="image" class="col-sm-3 col-form-label">Imagen</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" onchange="previewImage(event, '#imgPreview')" id="image" name="image" accept="image/*">

        @isset($product)
            <img class="img-thumbnail mt-2" id="imgPreview" src="{!!old('image', $product->image ?? '')!!}" width="100">
        @else
            <img class="img-thumbnail mt-2" id="imgPreview" src="{!!old('image', $product->image ?? 'https://e7.pngegg.com/pngimages/854/638/png-clipart-computer-icons-preview-batch-miscellaneous-angle-thumbnail.png')!!}" width="100">
        @endisset
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
