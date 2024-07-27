@extends('layouts.back-end.app')

@section('title', translate('Product Add'))

@push('css_or_js')
    <link href="{{asset('assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #addnewType button.close {
            padding: 0;
            background-color: transparent;
            border: 0;
            -webkit-appearance: none;
        }
        #addnewType .modal-header .close {
            padding: 1rem;
            margin: -1rem -1rem -1rem 0px;
        }
        #addnewType .close:not(:disabled):not(.disabled) {
            cursor: pointer;
        }
        #addnewType .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }
        #addnewType .modal-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
        }

        .inner.show[role="listbox"]{
            max-height: 120px !important;
        }
    </style>
@endpush

@section('content')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{url('public/select/')}}/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css">


    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">{{translate('Add')}} {{translate('New')}} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" action="{{route('admin.products.store')}}" method="POST"
                      style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                      enctype="multipart/form-data"
                      id="product_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs mb-4">
                                @foreach ($languages as $lang)
                                    <li class="nav-item">
                                <span class="nav-link text-capitalize form-system-language-tab {{ $lang == $defaultLanguage ? 'active' : '' }} cursor-pointer"
                                      id="{{ $lang }}-link">{{ getLanguageName($lang) . '(' . strtoupper($lang) . ')' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            @foreach ($languages as $lang)
                                <div class="{{ $lang != $defaultLanguage ? 'd-none' : '' }} form-system-language-form"
                                     id="{{ $lang }}-form">
                                    <div class="form-group">
                                        <label class="title-color"
                                               for="{{ $lang }}_name">{{ translate('product_name') }}
                                            ({{ strtoupper($lang) }})
                                        </label>
                                        <input type="text" {{ $lang == $defaultLanguage ? 'required' : '' }} name="name[]"
                                               id="{{ $lang }}_name" class="form-control" placeholder="New Product">
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{ $lang }}">
                                    <div class="form-group pt-2">
                                        <label class="title-color"
                                               for="{{ $lang }}_description">{{ translate('description') }}
                                            ({{ strtoupper($lang) }})</label>
                                        <textarea class="summernote" name="description[]">{{ old('details') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>{{translate('General Info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">{{translate('Category')}}</label>
                                        <select
                                            class="js-example-basic-multiple form-control"
                                            name="category_id"
                                            onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-category-select','select')"
                                            required>
                                            <option value="{{old('category_id')}}" selected disabled>---Select---</option>
                                            @foreach($categories as $c)
                                                <option value="{{$c['id']}}" {{old('name')==$c['id']? 'selected': ''}}>
                                                    {{$c['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">{{translate('Sub Category')}}</label>
                                        <select class="js-example-basic-multiple form-control"
                                                name="sub_category_id" id="sub-category-select"
                                                onchange="getRequest('{{url('/')}}/admin/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">{{translate('Sub Sub Category')}}</label>
                                        <select
                                            class="js-example-basic-multiple form-control"
                                            name="sub_sub_category_id" id="sub-sub-category-select">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{translate('Brand')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="brand_id" required>
                                            <option value="{{null}}" selected disabled>---{{translate('Select')}}---</option>
                                            @foreach($brands as $b)
                                                <option value="{{$b['id']}}">{{$b['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4" id="quantity">
                                        <label
                                            class="control-label">{{translate('total')}} {{translate('Quantity')}}</label>
                                        <input type="number" min="0" value="0" step="1"
                                               placeholder="{{translate('Quantity')}}"
                                               name="current_stock" class="form-control" required>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>{{translate('Variations')}}</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="colors">
                                            {{translate('Colors')}} :
                                        </label>
                                        <label class="switch">
                                            <input type="checkbox" class="status" value="{{old('colors_active')}}"
                                                   name="colors_active">
                                            <span class="slider round"></span>
                                        </label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                            name="colors[]" multiple="multiple" id="colors-selector" disabled>
                                            @foreach (\App\Models\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                <option value="{{ $color->code }}">
                                                    {{$color['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="attributes" style="padding-bottom: 3px">
                                            {{translate('Attributes')}} :
                                        </label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                            @foreach (\App\Models\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                                                <option value="{{ $a['id']}}">
                                                    {{$a['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-2">
                                        <div class="customer_choice_options" id="customer_choice_options"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>{{translate('Product price & stock')}}</h4>
                        </div>
                        <div class=" price-list">
                            <div class="card-body item-price">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">{{translate('Sort')}}</label>
                                            <input type="number" min="1" step="1"
                                                   name="prdoctPrice[0][order]"
                                                   class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">{{translate('Unit')}}</label>
                                            <div class="col-12 row">
                                                <select
                                                    class="col-10 js-example-basic-multiple form-control select-unit"
                                                    data-live-search="true"
                                                    name="prdoctPrice[0][unit]" >
                                                    @foreach(units() as $x)
                                                        <option
                                                            value="{{$x}}" {{old('unit')==$x? 'selected':''}}>{{$x}}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button class="btn btn-primary"></button> --}}
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewType">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">{{translate('Unit price')}}</label>
                                            <input type="number" min="0" step="0.01"
                                                   placeholder="{{translate('Unit price')}}"
                                                   name="prdoctPrice[0][unit_price]" value="{{old('unit_price')}}" class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-4" id="numberOfPieces">
                                            <label
                                                class="control-label">{{translate('numberOfPieces')}}</label>
                                            <input type="number" min="1" value="1" step="1"
                                                   placeholder="{{translate('Quantity')}}"
                                                   name="prdoctPrice[0][numberOfPieces]" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="control-label">{{translate('Purchase price')}}</label>
                                            <input type="number" min="0" step="0.01"
                                                   placeholder="{{translate('Purchase price')}}"
                                                   value="{{old('purchase_price')}}"
                                                   name="prdoctPrice[0][purchase_price]" class="form-control" required>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label">{{translate('Tax')}}</label>
                                            <label class="badge badge-info">{{translate('Percent')}} ( % )</label>
                                            <input type="number" min="0" value="0" step="0.01"
                                                   placeholder="{{translate('Tax')}}}" name="prdoctPrice[0][tax]"
                                                   value="{{old('tax')}}"
                                                   class="form-control">
                                            <input name="prdoctPrice[0][tax_type]" value="percent" style="display: none">
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label">{{translate('Discount')}}</label>
                                            <input type="number" min="0" value="{{old('discount')}}" step="0.01"
                                                   placeholder="{{translate('Discount')}}" name="prdoctPrice[0][discount]"
                                                   class="form-control" required>
                                        </div>
                                        <div class="col-md-2" style="padding-top: 30px;">
                                            <select style="width: 100%"
                                                    class="js-example-basic-multiple js-states js-example-responsive demo-select2"
                                                    name="prdoctPrice[0][discount_type]">
                                                <option value="flat">{{translate('Flat')}}</option>
                                                <option value="percent">{{translate('Percent')}}</option>
                                            </select>
                                        </div>
                                        {{-- <div class="pt-4 col-12 sku_combination" id="sku_combination">

                                        </div> --}}
                                        <div class="col-sm-12 col-md-12 col-lg-12" id="shipping_cost">
                                            <label
                                                class="control-label">{{translate('description')}} </label>
                                            <textarea placeholder="{{translate('description')}}"
                                                      name="prdoctPrice[0][description]" class="form-control" required></textarea>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-4" id="shipping_cost">
                                            <label
                                                class="control-label">{{translate('shipping_cost')}} </label>
                                            <input type="number" min="0" value="0" step="1"
                                                   placeholder="{{translate('shipping_cost')}}"
                                                   name="prdoctPrice[0][shipping_cost]" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 col-lg-4 mt-sm-1" id="shipping_cost_multy">
                                            <div>
                                                <label
                                                    class="control-label">{{translate('shipping_cost_multiply_with_quantity')}} </label>

                                            </div>
                                            <div>
                                                <label class="switch">
                                                    <input type="checkbox" name="prdoctPrice[0][multiplyQTY]"
                                                           id="" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-danger remove-product">Remove</button>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary add-more">Add More</button>
                        </div>

                    </div>

                    <div class="card mt-2 mb-2 rest-part">
                        <div class="card-header">
                            <h4>{{translate('seo_section')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="control-label">{{translate('Meta Title')}}</label>
                                    <input type="text" name="meta_title" placeholder="" class="form-control">
                                </div>

                                <div class="col-md-8 mb-4">
                                    <label class="control-label">{{translate('Meta Description')}}</label>
                                    <textarea rows="10" type="text" name="meta_description" class="form-control"></textarea>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>{{translate('Meta Image')}}</label>
                                    </div>
                                    <div class="border border-dashed">
                                        <div class="row" id="meta_img"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="control-label">{{translate('Youtube video link')}}</label>
                                    <small class="badge badge-soft-danger"> ( {{translate('optional, please provide embed link not direct link')}}. )</small>
                                    <input type="text" name="video_link" placeholder="{{translate('EX')}} : https://www.youtube.com/embed/5R06LRdUCSE" class="form-control" required>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{translate('Upload product images')}}</label><small
                                            style="color: red">* ( {{translate('ratio')}} 1:1 )</small>
                                    </div>
                                    <div class="p-2 border border-dashed coba-area" style="max-width:430px;">
                                        <div class="row" id="coba"></div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{translate('Upload thumbnail')}}</label><small
                                            style="color: red">* ( {{translate('ratio')}} 1:1 )</small>
                                    </div>
                                    <div style="max-width:200px;">
                                        <div class="row" id="thumbnail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-footer">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 20px">
                                <button type="submit"  class="btn btn-primary float-right">{{translate('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal " id="addnewType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{translate('Add')}} {{translate('Unit')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form class="col-12" id="unitForm">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{translate('unit')}}</label>
                                    <input type="hidden" class="form-control" name="_token" id="unit_name" value="{{ csrf_token() }}">
                                    <input type="text" class="form-control" name="name" id="unit_name">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button id="btn-unitForm" type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{url('select/')}}/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="{{url('select/')}}/bootstrap-select-1.13.14/dist/js/i18n/defaults-en_US.js"></script>
    <script>
        var index_list = 0;
        $(document).ready(function(){
            $('.select-unit').selectpicker();
        })
        $('body').on('click' ,'.remove-product', function(e){
            $(this).parents('.item-price').remove();
        });
        $('.add-more').on('click' , function(e){
            index_list += 1 ;
            e.preventDefault();
            $('.price-list').append(
                `
                    <div class="card-body item-price">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">{{translate('Sort')}}</label>
                                    <input type="number" min="1" step="1"
                                            name="prdoctPrice[`+index_list+`][order]" class="form-control"
                                            required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{translate('Unit')}}</label>
                                    <div class="col-12 row">
                                        <select
                                            class="col-10 js-example-basic-multiple form-control select-unit"
                                            data-live-search="true"
                                            name="prdoctPrice[`+index_list+`][unit]" >
                                            @foreach(units() as $x)
                <option
                    value="{{$x}}" {{old('unit')==$x? 'selected':''}}>{{$x}}</option>
                                            @endforeach
                </select>
{{-- <button class="btn btn-primary"></button> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewType">+</button>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">{{translate('Unit price')}}</label>
                                    <input type="number" min="0" step="0.01"
                                            placeholder="{{translate('Unit price')}}"
                                            name="prdoctPrice[`+index_list+`][unit_price]" value="{{old('unit_price')}}" class="form-control"
                                            required>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4" id="quantity">
                                    <label
                                        class="control-label">{{translate('numberOfPieces')}}</label>
                                    <input type="number" min="1" value="1" step="1"
                                            placeholder="{{translate('numberOfPieces')}}"
                                            name="prdoctPrice[`+index_list+`][numberOfPieces]" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="control-label">{{translate('Purchase price')}}</label>
                                    <input type="number" min="0" step="0.01"
                                            placeholder="{{translate('Purchase price')}}"
                                            value="{{old('purchase_price')}}"
                                            name="prdoctPrice[`+index_list+`][purchase_price]" class="form-control" required>
                                </div>

                                <div class="col-md-5">
                                    <label class="control-label">{{translate('Tax')}}</label>
                                    <label class="badge badge-info">{{translate('Percent')}} ( % )</label>
                                    <input type="number" min="0" value="0" step="0.01"
                                            placeholder="{{translate('Tax')}}}" name="prdoctPrice[`+index_list+`][tax]"
                                            value="{{old('tax')}}"
                                            class="form-control">
                                    <input name="prdoctPrice[`+index_list+`][tax_type]" value="percent" style="display: none">
                                </div>

                                <div class="col-md-5">
                                    <label class="control-label">{{translate('Discount')}}</label>
                                    <input type="number" min="0" value="{{old('discount')}}" step="0.01"
                                            placeholder="{{translate('Discount')}}" name="prdoctPrice[`+index_list+`][discount]"
                                            class="form-control" required>
                                </div>
                                <div class="col-md-2" style="padding-top: 30px;">
                                    <select style="width: 100%"
                                        class="js-example-basic-multiple js-states js-example-responsive demo-select2"
                                        name="prdoctPrice[`+index_list+`][discount_type]">
                                        <option value="flat">{{translate('Flat')}}</option>
                                        <option value="percent">{{translate('Percent')}}</option>
                                    </select>
                                </div>
                                {{-- <div class="pt-4 col-12 sku_combination" id="sku_combination">

                                </div> --}}
                <div class="col-sm-12 col-md-12 col-lg-12" id="shipping_cost">
                    <label
                        class="control-label">{{translate('description')}} </label>
                                    <textarea placeholder="{{translate('description')}}"
                                           name="prdoctPrice[`+index_list+`][description]" class="form-control" required></textarea>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4" id="shipping_cost">
                                    <label
                                        class="control-label">{{translate('shipping_cost')}} </label>
                                    <input type="number" min="0" value="0" step="1"
                                            placeholder="{{translate('shipping_cost')}}"
                                            name="prdoctPrice[`+index_list+`][shipping_cost]" class="form-control" required>
                                </div>
                                <div class="col-md-6 col-lg-4 mt-sm-1" id="shipping_cost_multy">
                                    <div>
                                        <label
                                        class="control-label">{{translate('shipping_cost_multiply_with_quantity')}} </label>

                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="prdoctPrice[`+index_list+`][multiplyQTY]"
                                                    id="" >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger remove-product">Remove</button>
                    </div>
                `
            )
            $('.select-unit').selectpicker();
        })
        $('#btn-unitForm').on('click',function(e){
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "{{route('admin.products.add-type')}}",
                data:$('#unitForm').serialize(),
                dataType: "json",
                success: function (response) {
                    var name = $('#unitForm [name="name"]').val();
                    if(response.status){
                        $('select.select-unit').append(`<option value="`+name+`">`+name+`</option>`);
                        $('select.select-unit').selectpicker('refresh');
                    }
                    $('#addnewType').modal('hide');

                }
            });
        })
        $('body').on('click','[data-target="#addnewType"]',function(e){
            e.preventDefault();
            $('#addnewType').modal('show');
        });
        $(function () {
            console.log('Initializing coba picker');
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 10,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: '280px',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '90%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });


        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{trans('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{trans('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }


        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            update_sku();
        });

        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('admin.products.sku-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        $(document).ready(function () {
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>

    <script>
        function check(){
            Swal.fire({
                title: '{{translate('Are you sure')}}?',
                text: '',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                var formData = new FormData(document.getElementById('product_form'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.products.store')}}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                toastr.error(data.errors[i].message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        } else {
                            toastr.success('{{translate('product added successfully')}}!', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            $('#product_form').submit();
                        }
                    }
                });
            })
        };
    </script>

    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$defaultLanguage}}') {
                $(".rest-part").removeClass('d-none');
            } else {
                $(".rest-part").addClass('d-none');
            }
        })
    </script>

    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('.textarea').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
    {{--ck editor--}}
@endpush
