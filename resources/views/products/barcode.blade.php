@extends('acc::layouts.app')

@section('css')
    <style>

    </style>
@endsection
@section('content')

    <div class="card">


        <div class="card-body">
            <form id="barcodeForm">
                @csrf
                <table class="table table-hover table-md">
                    <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">
                            Product Code
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="is_product_name" checked>
                            Product Name
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="is_price" checked>

                            Price
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="is_description" checked>

                            Description
                        </th>
                        <th scope="col">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <select name="product_id" id="product_id" class="searchable" style="max-width: 300px">
                                    <option value="" disabled selected></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="code" type="text" name="code" class="form-control ">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="product_name" type="text" name="product_name" class="form-control "
                                       value="">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="price" type="text" name="price" class="form-control "
                                       value="">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="description" type="text" name="description" class="form-control "
                                       value="">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="qnt" type="number" name="qnt" class="form-control" value="10">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Barcode Height (pixel)</label>
                            <input type="number" step="any" class="form-control" id="height" value="0">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Barcode Width (pixel)</label>
                            <input type="number" step="any" class="form-control" id="width" value="0">
                        </div>
                    </div>
                    <div class="col"></div>
                </div>

                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary " {{ ability(\App\Utils\Ability::BARCODE_CREATE) }}>
                        <i class="fa fa-eye"></i>
                        Show Barcode
                    </button>

                    <button type="button" id="print" class="btn btn-light">
                        <i class="fa fa-print"></i>
                        Print
                    </button>
                </div>
            </form>
        </div>

        <div class="printable  border mx-auto mt-4">
            <div id="barcodeList" style="display: flex;flex-wrap: wrap">

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        let barcode_height = "{{ $settings->barcode_height??140 }}"
        let barcode_width = "{{ $settings->barcode_width??244 }}"

        $(document).ready(function () {
            $("#is_product_name").change(function () {
                if (this.checked) {
                    $('#product_name').prop('disabled', false)
                } else {
                    $('#product_name').prop('disabled', true)
                }
                $('#barcodeForm').submit()

            });
            $("#is_price").change(function () {
                if (this.checked) {
                    $('#price').prop('disabled', false)
                } else {
                    $('#price').prop('disabled', true)
                }
                $('#barcodeForm').submit()

            });
            $("#is_description").change(function () {
                if (this.checked) {
                    $('#description').prop('disabled', false)
                } else {
                    $('#description').prop('disabled', true)
                }
                $('#barcodeForm').submit()
            });

            $('.barcode').css('width', barcode_width)
            $('#width').val(barcode_width)
            $('#height').val(barcode_height)
            $('.barcode').css('height', barcode_height)
            $('#product_id').on('change', function () {
                $.ajax({
                    url: route('products.product.show', $(this).val()), success: function (product) {
                        console.log(product);
                        $('#code').val(product.code)
                        $('#product_name').val(product.name)
                        $('#description').val(product.description)
                        $('#price').val(product.sell_price)
                    }
                });
            })

            $('#barcodeForm').validate({
                submitHandler: function (form) {
                    let qnt = $('#qnt').val();
                    $('#barcodeList').empty();
                    for (let i = 0; i <= qnt; i++) {

                        let product_name = $('#is_product_name').is(':checked') ? $('#product_name').val() : '';
                        let price = $('#is_price').is(':checked') ? $('#price').val() : '';
                        let description = $('#is_description').is(':checked') ? $('#description').val() : '';
                        $('#barcodeList').append(`<span style="font: 18px monospace;margin-top: 5px;display: flex;flex-direction: column;color: black" class="barcode-container  text-center"><span><br> ${product_name}</span> <span>${price}</span><span>${description}</span><svg class="barcode"></svg></span>`)
                    }
                    JsBarcode(".barcode", $('#code').val());
                    calculateSize()

                    $('.barcode-container').css('border', '1px dotted #ccc')
                    $.ajax({
                        url: route('products.product.updateBarcode', $('#product_id').val()),
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {

                        }
                    });
                },
                rules: {
                    product_id: {required: true,},
                    code: {required: true},
                    qnt: {required: true},
                },
                messages: {
                    name: {required: "Name is required",},
                    sell_price: {required: "required",},
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });


            $('#print').on('click', function () {
                $('.printable').printThis()
            })
            $('#height,#width').on('input', function () {
                calculateSize()
            })

            $('#height,#width').on('change', function () {
                save_size()
            })
        });

        function calculateSize() {
            let height = $('#height').val() || 0;
            let width = $('#width').val() || 0;
            $('.barcode').css('height', height)
            $('.barcode').css('width', width)
        }

        function save_size() {
            let height = $('#height').val() || 140;
            let width = $('#width').val() || 250;
            $.ajax({

                url: route('products.product.barcode_size', {height: height, width: width}),
                success: function (product) {

                }
            });
        }
    </script>

    <script src="{{ asset('js/product.js') }}"></script>
@endsection

