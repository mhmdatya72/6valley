<div class="second-el d--none">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">{{translate('create_an_account')}}</h3>
                        <div class="border p-3 p-xl-4 rounded">
                            <h4 class="mb-3">{{translate('vendor_information')}}</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label  for="f_name">{{translate('first_name')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="f_name" placeholder="{{translate('ex').': John'}}" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label  for="l_name">{{translate('last_name')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="l_name" placeholder="{{translate('ex').': Doe'}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex flex-column gap-3 align-items-center">
                                        <div class="upload-file">
                                            <input type="file" class="upload-file__input" name="image" accept="image/*" required>
                                            <div class="upload-file__img">
                                                <div class="temp-img-box">
                                                    <div class="d-flex align-items-center flex-column gap-2">
                                                        <i class="tio-upload fs-30"></i>
                                                        <div class="fs-12 text-muted text-capitalize">{{translate('upload_file')}}</div>
                                                    </div>
                                                </div>
                                                <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column gap-1 upload-img-content text-center">
                                            <h6 class="text-uppercase mb-1 fs-14">{{translate('vendor_image')}}</h6>
                                            <div class="text-muted text-capitalize fs-12">{{translate('image_ratio').' '.'1:1'}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 p-xl-4 rounded mt-4">
                            <h4 class="mb-3 text-capitalize">{{translate('shop_information')}}</h4>

                            <div class="form-group mb-4">
                                <label for="store_name" class="text-capitalize">{{translate('shop_Name')}} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="shop_name"  name="shop_name" placeholder="{{translate('Ex: XYZ store')}}" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="store_address" class="text-capitalize">{{translate('shop_address')}} <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="shop_address" id="shop_address" rows="4" placeholder="{{translate('shop_address')}}" required></textarea>
                            </div>




                            <div class="form-group mb-4">
                                <label for="holidays" class="text-capitalize">{{translate('holidays')}} <span class="text-danger">*</span></label>
                                <select class="form-control" id="holidays" name="holidays[]" required>
                                    <option value="" disabled selected>{{translate('Select a day')}}</option>
                                    <option value="monday">{{translate('Monday')}}</option>
                                    <option value="tuesday">{{translate('Tuesday')}}</option>
                                    <option value="wednesday">{{translate('Wednesday')}}</option>
                                    <option value="thursday">{{translate('Thursday')}}</option>
                                    <option value="friday">{{translate('Friday')}}</option>
                                    <option value="saturday">{{translate('Saturday')}}</option>
                                    <option value="sunday">{{translate('Sunday')}}</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="payment_method" class="text-capitalize">{{translate('payment_method')}} <span class="text-danger">*</span></label>
                                <select class="form-control" id="payment_method" name="payment_method[]" required>
                                    <option value="" disabled selected>{{translate('Select a payment method')}}</option>
                                    <!-- Options will be dynamically added here -->
                                </select>
                            </div>




                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    fetch('/payment-methods')
                                        .then(response => response.json())
                                        .then(data => {
                                            let select = document.getElementById('payment_method');
                                            // The default option will be retained if data fetch fails
                                            // Clearing existing options if data is loaded
                                            select.innerHTML = '<option value="" disabled selected>{{translate('Select a payment method')}}</option>';
                                            data.forEach(method => {
                                                let option = document.createElement('option');
                                                option.value = method.name; // Assuming 'name' contains the value for the option
                                                option.textContent = method.name;
                                                select.appendChild(option);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching payment methods:', error));
                                });
                            </script>




                            <div class="form-group mb-4">
                                <label for="shipping_time" class="text-capitalize">{{translate('shipping_time')}} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="shipping_time"  name="shipping_time" placeholder="{{ translate('ex') }}: {{ translate('تسليم الطلبات بعد الساعة 5 المغرب إلي 5 الفجر') }}" required>
                            </div>


                            <div class="form-group mb-4">
                                <label for="returned" class="text-capitalize">{{translate('returned')}} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="returned"  name="returned" placeholder="{{ translate('ex') }}: {{ 'قبل إنتهاء الصلاحية ب 15 يوم' }}" required>
                            </div>


                            <div class="form-group mb-4">
                                <label for="minimum_order_amount" class="text-capitalize">{{translate('minimum_order_amount')}} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="minimum_order_amount"  name="minimum_order_amount" placeholder="{{ translate('ex') }}: {{ ' 1000 ج.م  ' }}" required>
                            </div>





                            <div class="border p-3 p-xl-4 rounded mb-4">
                                <div class="d-flex flex-column gap-3 align-items-center">
                                    <div class="upload-file">
                                        <input type="file" class="upload-file__input" name="logo" accept="image/*" required>
                                        <div class="upload-file__img">
                                            <div class="temp-img-box">
                                                <div class="d-flex align-items-center flex-column gap-2">
                                                    <i class="tio-upload fs-30"></i>
                                                    <div class="fs-12 text-muted text-capitalize">{{translate('upload_file')}}</div>
                                                </div>
                                            </div>
                                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-1 upload-img-content text-center">
                                        <h6 class="text-uppercase mb-1 fs-14">{{translate('upload_logo')}}</h6>
                                        <div class="text-muted text-capitalize fs-12">{{translate('image_ratio').' '.'1:1'}}</div>
                                        <div class="text-muted text-capitalize fs-12">{{translate('Image Size : Max 2 MB')}}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="border p-3 p-xl-4 rounded">
                                <div class="d-flex flex-column gap-3 align-items-center">
                                    <div class="upload-file">
                                        <input type="file" class="upload-file__input" name="banner" accept="image/*" required>
                                        <div class="upload-file__img style--two">
                                            <div class="temp-img-box">
                                                <div class="d-flex align-items-center flex-column gap-2">
                                                    <i class="tio-upload fs-30"></i>
                                                    <div class="fs-12 text-muted text-capitalize">{{translate('upload_file')}}</div>
                                                </div>
                                            </div>
                                            <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-1 upload-img-content text-center">
                                        <h6 class="text-uppercase mb-1 fs-14">{{translate('upload_banner')}}</h6>
                                        <div class="text-muted text-capitalize fs-12">{{translate('image_ratio').' '.'2:1'}}</div>
                                        <div class="text-muted text-capitalize fs-12">{{translate('Image Size : Max 2 MB')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php($recaptcha = getWebConfig(name: 'recaptcha'))
                        @if(isset($recaptcha) && $recaptcha['status'] == 1)
                            <div id="recaptcha-element-vendor-register" class="w-100" data-type="image"></div>
                            <br/>
                        @else
                            <div class="mt-2">
                                <div class="row py-2">
                                    <div class="col-6 pr-0">
                                        <input type="text" class="form-control __h-40" name="default_recaptcha_id_seller_regi" id="default-recaptcha-id-vendor-register" value=""
                                               placeholder="{{translate('enter_captcha_value')}}" autocomplete="off" required>
                                    </div>
                                    <div class="col-6 input-icons mb-2 w-100 rounded bg-white">
                                    <span class="d-flex align-items-center align-items-center get-vendor-regi-recaptcha-verify"
                                          data-link="{{ route('vendor.auth.recaptcha', ['tmp'=>':dummy-id']) }}">
                                        <img src="{{ route('vendor.auth.recaptcha', ['tmp'=>1]).'?captcha_session_id=sellerRecaptchaSessionKey' }}" alt="" class="rounded __h-40" id="default_recaptcha_id">
                                        <i class="tio-refresh position-relative cursor-pointer p-2"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="d-flex justify-content-start mt-2">
                            <label class="custom-checkbox align-items-center">
                                <input type="checkbox" class="" id="terms-checkbox">
                                <span class="form-check-label">{{ translate('i_agree_with_the') }} <a
                                        href="{{route('terms')}}" target="_blank" class="text-underline color-bs-primary-force">
                                        {{ translate('terms_&_conditions') }}
                                    </a>
                                </span>
                            </label>
                        </div>
                        <div class="d-flex justify-content-end mb-2 gap-2">
                            <button type="button" class="btn btn-secondary back-to-main-page"> {{translate('back')}} </button>
                            <button type="button" class="btn btn--primary disabled" id="vendor-apply-submit"> {{translate('submit')}} </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
