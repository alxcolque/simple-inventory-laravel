<!-- Agrega el campo de categoría padre aquí -->
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nombres <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                value="{{ old('name', $user->name ?? '') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group row">
        <label for="email" class="col-sm-3 col-form-label">Correo electrónico <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico"
                value="{{ old('email', $user->email ?? '') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="password" class="col-sm-3 col-form-label">Contraseña <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña"
                value="{{ old('password','') }}">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group row">
        <label for="password_confirm" class="col-sm-3 col-form-label">Contraseña <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Contraseña"
                value="{{ old('password_confirm', '') }}">
            @error('password_confirm')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group row">
        <label for="role" class="col-sm-3 col-form-label">Rol <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select class="form-select" id="role" name="role">
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>Trabajador</option>
            </select>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<!-- Subir avatar con previsuallizacion -->
<div class="form-group row">
    <label for="avatar" class="col-sm-3 col-form-label">Avatar</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" onchange="previewImage(event, '#imgPreview')" id="avatar" name="avatar" accept="image/*">

        @isset($user->avatar)
            <img class="img-thumbnail mt-2" id="imgPreview" src="{!!old('avatar', $user->avatar ?? '')!!}" width="100">
        @else
            <img class="img-thumbnail mt-2" id="imgPreview" src="{!!old('avatar', $user->avatar ?? 'https://cdn.iconscout.com/icon/free/png-256/free-avatar-380-456332.png%22')!!}" width="100">
        @endisset
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
