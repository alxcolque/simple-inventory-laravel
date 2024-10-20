@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Editar compra </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">compras</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar compra</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('purchases.update', $purchase->id) }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('purchases.fields')

                            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                            <a href="{{ route('purchases.index') }}" class="btn btn-dark">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
@endsection
@section('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    /* Realiza una operacion entre los campos precio de venta menos el precio de compra, el resultado en la etiqueta revenue */
    $('#price_sale, #price').on('change, keyup', function() {
        var price = $('#price').val();
        var price_sale = $('#price_sale').val();
        var revenue = (price * price_sale / 100);
        $('#revenue').html('Bs. '+revenue);
    });

</script>
{{-- Al hacer clic sobre el input de unit sugerir unidades de medida de farmacia--}}
<script>
    //Cuando se edita en el campo unit sugerir unidades de medida
    $('#unit').on('keyup change', function() {
        var unit = $('#unit').val();
        //autocomplete
        var units = ['caja', 'tableta', 'unidad', 'gramos', 'mililitros', 'miligramos', 'microgramos'];
        $('#unit').autocomplete({
            source: units
        });
    });
</script>
@endsection
