@extends('layouts.back-end.app')

@section('title', translate('ShopName'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('Shop Names_Setup') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-start">
                        <form action="{{ route('admin.Shop-Name.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>

                                        <div class="form-group ">
                                            <label for="exampleInputEmail1">Shop Name Name* (EN)</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                                            <button type="reset" id="reset"
                                                class="btn btn-secondary">{{ translate('reset') }}</button>
                                            <button type="submit"
                                                class="btn btn--primary">{{ translate('submit') }}</button>
                                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-20" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
                            <div class="">
                                <h5 class="text-capitalize d-flex gap-1">
                                    {{ translate('Shop Name_list') }}
                                </h5>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="" type="search" name="searchValue" class="form-control"
                                            placeholder="{{ translate('search_by_category_name') }}"
                                            value="{{ request('searchValue') }}">
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                                <div>
                                    <button type="button" class="btn btn-outline--primary text-nowrap btn-block"
                                        data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{ translate('export') }}
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            {{--  <a class="dropdown-item"
                                                href="{{ route('admin.category.export', ['searchValue' => request('searchValue')]) }}">
                                                <img width="14"
                                                    src="{{ asset('/public/assets/back-end/img/excel.png') }}"
                                                    alt="">
                                                {{ translate('excel') }}
                                            </a>  --}}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th class="custom-header">{{ translate('ID') }}</th>
                                    <th class="custom-header">{{ translate('name') }}</th>
                                    <th class="text-center">{{ translate('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 0;

                                @endphp




                                @forelse ($ShopName as $key => $category)
                                    @php
                                        $counter++;
                                    @endphp
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ $category['name'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-10">
                                                <a class="btn btn-outline-info btn-sm square-btn "
                                                    title="{{ translate('edit') }}"
                                                    href="{{ route('admin.Shop-Name.edit', [$category['id']]) }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.Shop-Name.destroy', $category['id']) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm square-btn"
                                                        title="{{ translate('delete') }}">
                                                        <i class="tio-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="3" class="text-center font-weight-bold text-danger bg-warning">
                                        No Payment-Methods defined
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush
