@extends('layouts.app')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Nueva compra </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Compras</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva compra</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('purchases.store') }}"
                            autocomplete="off">
                            @csrf
                            @include('purchases.fields')

                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
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
@endsection
@section('js')
<script>
    /* Realiza una operacion entre los campos precio de venta menos el precio de compra, el resultado en la etiqueta revenue */
    $('#price_sale, #price').on('change, keyup', function() {
        var price = $('#price').val();
        var price_sale = $('#price_sale').val();
        var revenue = price_sale - price;
        $('#revenue').html('Bs. '+revenue);
    });

</script>
@endsection
