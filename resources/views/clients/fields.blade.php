<!-- Agrega el campo de categoría padre aquí -->
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nombres <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                value="{{ old('name', $client->name ?? '') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group row">
        <label for="email" class="col-sm-3 col-form-label">Correo electrónico </label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico"
                value="{{ old('email', $client->email ?? '') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="cinit" class="col-sm-3 col-form-label">CI/NIT <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="cinit" name="cinit" placeholder="CI/NIT"
                value="{{ old('cinit', $client->cinit ?? '') }}">
            @error('cinit')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group row">
        <label for="phone" class="col-sm-3 col-form-label">Celular </span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Contraseña"
                value="{{ old('phone', $client->phone ?? '') }}">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
