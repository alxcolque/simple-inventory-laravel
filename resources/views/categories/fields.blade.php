<div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Nombre <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Nombre" value="{{ old('title', $category->title?? '') }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="icon" class="col-sm-3 col-form-label">Icono <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="js-example-basic-single" style="width: 100%" name="icon" id="icon">
                                        @isset($category)
                                        <option value="{{ old('icon', $category->icon ?? '') }}" {{ old('icon') == $category->icon ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @else
                                        <option value="">Seleccione un icono</option>
                                        @endisset
                                        <option value="mdi mdi-home"><i class="mdi mdi-home"></i> Hogar</option>
                                        <option value="mdi mdi-food"><i class="mdi mdi-food"></i> Comida</option>
                                        <option value="mdi mdi-cart"><i class="mdi mdi-cart"></i> Compras</option>
                                        <option value="mdi mdi-car"><i class="mdi mdi-car"></i> Transporte</option>
                                        <option value="mdi mdi-medical-bag"><i class="mdi mdi-medical-bag"></i> Salud
                                        </option>
                                        <option value="mdi mdi-school"><i class="mdi mdi-school"></i> Educación</option>
                                        <option value="mdi mdi-briefcase"><i class="mdi mdi-briefcase"></i> Trabajo</option>
                                        <option value="mdi mdi-beach"><i class="mdi mdi-beach"></i> Vacaciones</option>
                                        <option value="mdi mdi-dumbbell"><i class="mdi mdi-dumbbell"></i> Deporte</option>
                                        <option value="mdi mdi-gamepad-variant"><i class="mdi mdi-gamepad-variant"></i>
                                            Entretenimiento</option>
                                        <option value="mdi mdi-cash-multiple"><i class="mdi mdi-cash-multiple"></i> Finanzas
                                        </option>
                                        <option value="mdi mdi-gift"><i class="mdi mdi-gift"></i> Regalos</option>
                                        <option value="mdi mdi-tshirt-crew"><i class="mdi mdi-tshirt-crew"></i> Ropa
                                        </option>
                                        <option value="mdi mdi-cellphone"><i class="mdi mdi-cellphone"></i> Tecnología
                                        </option>
                                        <option value="mdi mdi-palette"><i class="mdi mdi-palette"></i> Arte</option>

                                    </select>
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="color" class="col-sm-3 col-form-label">Color <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="color" class="form-control" id="color" name="color"
                                        value="{{ old('color', $category->color?? '') }}">
                                    @error('color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
