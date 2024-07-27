@extends('layouts.back-end.app')

@section('title', translate('Edit PaymentMethods'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('Update payment Methods_Setup') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-start">
                        <form action="{{ route('admin.payment-methods.update', [$paymentMethod['id']]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- أو @method('PATCH') إذا كنت تفضل استخدام PATCH -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">payment Methods Name* (EN)</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $paymentMethod['name'] }}">
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                                            <button type="reset" id="reset"
                                                class="btn btn-secondary">{{ translate('reset') }}</button>
                                            <button type="submit"
                                                class="btn btn--primary">{{ translate('submit') }}</button>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush
