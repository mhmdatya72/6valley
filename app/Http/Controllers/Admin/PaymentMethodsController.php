<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PaymentMethods=PaymentMethods::all();
        return view("admin-views.PaymentMethods.view",compact('PaymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:payment_methods|max:255',
            ], [
                'name.required' => "Please enter the department name",
                'name.unique' => "The department name is already registered",
            ]);

            PaymentMethods::create([
                'name' => $request->name,
            ]);

            session()->flash('Add', 'Successfully added');
            return redirect::route('admin.payment-methods.index'); // Redirect back to the previous page
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error storing payment method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding'); // Redirect back with error message
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethods::findOrFail($id);
        return view('admin-views.PaymentMethods.payment-methods-edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:payment_methods,name,' . $id . '|max:255',
            ], [
                'name.required' => "Please enter the department name",
                'name.unique' => "The department name is already registered",
            ]);

            $paymentMethod = PaymentMethods::findOrFail($id);
            $paymentMethod->update([
                'name' => $request->name,
            ]);

            session()->flash('Update', 'Successfully updated');
            return redirect::route('admin.payment-methods.index'); // Redirect back to the previous page

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating payment method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating'); // Redirect back with error message
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Find and delete the payment method
        $paymentMethod = PaymentMethods::find($id);

        if ($paymentMethod) {
            $paymentMethod->delete();
            session()->flash('delete', 'Payment method successfully deleted');
        } else {
            session()->flash('error', 'Payment method not found');
        }

        // Redirect back to the previous page
        return redirect()->back();
    }



    public function getallpaymentmethods()
    {
        $PaymentMethods=PaymentMethods::all();
        return view("vendor-views.profile.update-view",compact('PaymentMethods'));
    }

}