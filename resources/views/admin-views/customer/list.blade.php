@php use Illuminate\Support\Str; @endphp
@extends('layouts.back-end.app')

@section('title', translate('customer_List'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #377dff;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }
        .city-non-active{
            display: none;
        }
        .city-active{

            display: block;
        }
        li.select2-selection__choice {
            color: #000 !important;
        }
    </style>
@endpush
@section('content')
    <div class="content container-fluid">
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/customer.png')}}" alt="">
                {{translate('customer_list')}}
                <span class="badge badge-soft-dark radius-50">{{$customers->total()}}</span>
            </h2>

        </div>
        <div class="card">
            <div class="px-3 py-4">
                <div class="row gy-2 align-items-center">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="searchValue" class="form-control"
                                       placeholder="{{translate('search_by_Name_or_Email_or_Phone')}}"
                                       aria-label="Search orders" value="{{ request('searchValue') }}">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                        <div class="d-flex justify-content-sm-end">
                            <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <a href="{{route('admin.customer.manage')}}">
                                <button class="btn btn-primary ml-5">
                                    {{ translate('add-new')}}
                                </button>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item"
                                       href="{{route('admin.customer.export',['searchValue'=>request('searchValue')])}}">
                                        <img width="14" src="{{dynamicAsset(path: 'public/assets/back-end/img/excel.png')}}" alt="">
                                        {{translate('excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="px-3 py-4">
                <div class="row gy-2 align-items-center">
                    <div class="col-md-12">
                        <!-- Search -->
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="row">
                                <div class="col-2">
                                    <label>{{translate('Search by Name or Email or Phone')}}</label>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Name or Email or Phone')}}" aria-label="Search orders" value="{{ $search }}">
                                </div>
                                <div class="col-2">
                                    <label>{{translate('fromDate')}}</label>
                                    <input type="date" name="fromDate" value="{{$seaerchData['fromDate'] ? $seaerchData['fromDate'] : ""}}"  id="from_date"
                                           class="form-control" >
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('toDate')}}</label>
                                    <input type="date"  name="toDate" value="{{$seaerchData['toDate'] ? $seaerchData['toDate'] : ""}}" id="to_date"
                                           class="form-control" >
                                </div>
                                <div class="col-2">
                                    <label>{{translate('fromOrder')}}</label>
                                    <input type="number" name="fromOrder" value="{{$seaerchData['fromOrder'] ? $seaerchData['fromOrder'] : ""}}"  id="from_date"
                                           class="form-control" >
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('toOrder')}}</label>
                                    <input type="number"  name="toOrder" value="{{$seaerchData['toOrder'] ? $seaerchData['toOrder'] : ""}}" id="to_date"
                                           class="form-control" >
                                </div>
                                <div class="col-2">
                                    <label>{{translate('fromOrderprice')}}</label>
                                    <input type="number" name="fromOrderprice" value="{{$seaerchData['fromOrderprice'] ? $seaerchData['fromOrder'] : ""}}"  id="from_date"
                                           class="form-control" >
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('toOrderprice')}}</label>
                                    <input type="number"  name="toOrderprice" value="{{$seaerchData['toOrderprice'] ? $seaerchData['toOrder'] : ""}}" id="to_date"
                                           class="form-control" >
                                </div>

                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('city')}}</label>
                                    <select class="form-select form-control city-select-area" name="city[]" type="city" id="si-city"
                                             style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    >
                                        <option></option>
                                        @foreach ($governorates as $governorate)
                                            <option {{(  in_array($governorate->id ,$seaerchData['city'] ) ) ? "selected" : ""}} value="{{$governorate->id}}">{{$governorate->governorate_name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('area')}}</label>
                                    <select class="form-select form-control city-select-area" name="area" type="country" id="si-area"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                        <option selected></option>
                                        @foreach ($cities as $city)
                                            <option {{($seaerchData['area'] == $city->id) ? "selected" : ""}}
                                                    data-parent="{{$city->governorate_id}}" value="{{$city->id}}">{{$city->city_name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>{{translate('Type')}}</label>
                                    <select class="form-select form-control" name="type" type="type" id="si-Type"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    >
                                        <option selected></option>
                                        @foreach ($customertypes as $customertype)
                                            <option {{($seaerchData['type'] == $customertype->id) ? "selected" : ""}} value="{{$customertype->id}}">{{$customertype->ar_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 mt-2 mt-sm-0">
                                    <label>
                                        {{translate('Salesperson')}}
                                    </label>
                                    <select class="form-select form-control" name="salesPersonId" type="salesPersonId" id="si-salesPersonId"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    >
                                        <option selected></option>
                                        @foreach ($Salesperson as $_Salesperson)
                                            <option {{($seaerchData['salesPersonId'] == $_Salesperson->id) ? "selected" : ""}} value="{{$_Salesperson->id}}">{{$_Salesperson->f_name.' '.$_Salesperson->l_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            <button id="btn-export" class="btn btn-primary btn-export">{{translate('export')}}</button>
                        </form>
                        <!-- End Search -->
                    </div>

                    <div class="col-sm-8 col-md-6 col-lg-4">
                    </div>
                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                        <div class="d-flex justify-content-sm-end">
                            <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item" href="{{route('admin.customer.export')}}">{{translate('excel')}}</a></li>
                                <div class="dropdown-divider"></div>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('customer_name')}}</th>
                        <th>{{translate('contact_info')}}</th>

                        <th>{{translate('Salesperson')}}</th>
                        <th>{{translate('city')}}</th>
                        <th>{{translate('area')}}</th>
                        <th>{{translate('Type')}}</th>
                        <th>{{translate('getFrom')}}</th>
                        <th>{{translate('RegisterDate')}}</th>


                        <th>{{translate('Total')}} {{translate('Order')}} </th>
                        <th>{{translate('seller_amount')}}  </th>
                        <th>{{translate('block')}} / {{translate('unblock')}}</th>
                        <th class="text-center">{{translate('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $key=>$customer)
                        <tr>
                            <td>
                                {{$customers->firstItem()+$key}}
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10">
                                    <img src="{{getValidImage(path: 'storage/app/public/profile/'.$customer->image,type:'backend-profile')}}"
                                         class="avatar rounded-circle " alt="" width="40">
                                    {{Str::limit($customer['f_name']." ".$customer['l_name'],20)}}
                                </a>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <strong><a class="title-color hover-c1"
                                               href="mailto:{{$customer->email}}">{{$customer->email}}</a></strong>

                                </div>
                                <a class="title-color hover-c1" href="tel:{{$customer->phone}}">{{$customer->phone}}</a>

                            </td>
                            <td>
                                {{isset($customer['salesPerson']) ? $customer['salesPerson']->f_name." ".$customer['salesPerson']->l_name : ""}}
                            </td>
                            <td>
                                {{ isset($customer['cityName']->governorate_name_ar) ? $customer['cityName']->governorate_name_ar : "" }}
                            </td>
                            <td>
                                {{ isset($customer['areaName']->city_name_ar) ? $customer['areaName']->city_name_ar : "" }}
                            </td>
                            <td>
                                {{ isset($customer['_type']->ar_name) ? $customer['_type']->ar_name : "" }}
                            </td>
                            <td>
                                {{translate($customer['getFrom'])}}
                            </td>
                            <td>
                                {{$customer['created_at']}}
                            </td>
                            <td>
                                <label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12">
                                    {{$customer->orders->count()}}
                                </label>
                            </td>
                            <td>
                                <label class="badge badge-soft-info">
                                    {{$customer->orders->sum('order_amount')}}
                                </label>
                            </td>
                            <td>
                                @if($customer['email'] == 'walking@customer.com')
                                    <div class="text-center">
                                        <div class="badge badge-soft-version">{{ translate('default') }}</div>
                                    </div>
                                @else
                                    <form action="{{route('admin.customer.status-update')}}" method="post"
                                          id="customer-status{{$customer['id']}}-form" class="customer-status-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$customer['id']}}">
                                        <label class="switcher mx-auto">
                                            <input type="checkbox" class="switcher_input toggle-switch-message"
                                                   id="customer-status{{$customer['id']}}" name="status" value="1"
                                                   {{ $customer['is_active'] == 1 ? 'checked':'' }}
                                                   data-modal-id = "toggle-status-modal"
                                                   data-toggle-id = "customer-status{{$customer['id']}}"
                                                   data-on-image = "customer-block-on.png"
                                                   data-off-image = "customer-block-off.png"
                                                   data-on-title = "{{translate('want_to_unblock').' '.$customer['f_name'].' '.$customer['l_name'].'?'}}"
                                                   data-off-title = "{{translate('want_to_block').' '.$customer['f_name'].' '.$customer['l_name'].'?'}}"
                                                   data-on-message = "<p>{{translate('if_enabled_this_customer_will_be_unblocked_and_can_log_in_to_this_system_again')}}</p>"
                                                   data-off-message = "<p>{{translate('if_disabled_this_customer_will_be_blocked_and_cannot_log_in_to_this_system')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </form>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a title="{{translate('view')}}"
                                       class="btn btn-outline-info btn-sm square-btn"
                                       href="{{route('admin.customer.view',[$customer['id']])}}">
                                        <i class="tio-invisible"></i>
                                    </a>
                                    @if($customer['id'] != '0')
                                        <a title="{{translate('delete')}}"
                                           class="btn btn-outline-danger btn-sm delete square-btn delete-data" href="javascript:"
                                           data-id="customer-{{$customer['id']}}">
                                            <i class="tio-delete"></i>
                                        </a>
                                    @endif
                                </div>
                                <form action="{{route('admin.customer.delete',[$customer['id']])}}"
                                      method="post" id="customer-{{$customer['id']}}">
                                    @csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    {!! $customers->links() !!}
                </div>
            </div>
            @if(count($customers)==0)
                @include('layouts.back-end._empty-state',['text'=>'no_customer_found'],['image'=>'default'])
            @endif
        </div>
    </div>
@endsection
