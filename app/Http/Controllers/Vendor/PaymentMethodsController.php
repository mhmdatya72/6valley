<?php

namespace App\Http\Controllers\Vendor;



use App\Models\PaymentMethods;
use App\Http\Controllers\Controller;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethods::all();
        return response()->json($paymentMethods);
    }

}