<?php

namespace App\Http\Controllers\RestAPI\v1;


use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Models\PaymentMethods;


class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            // Get all PaymentMethods
            $paymentMethods = PaymentMethods::all();
            return response()->json([
                'message' => 'Displaying all available payment methods.',
                'data' => $paymentMethods
            ], 200);
        } catch (\Exception $e) {
            // Return an error response if fetching payment methods fails
            return response()->json(['message' => 'An error occurred while fetching payment methods.'], 500);
        }
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
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|max:255|unique:payment_methods',
            ]);

            // Create a new PaymentMethods record
            $paymentMethod = PaymentMethods::create([
                'name' => $validatedData['name'],
            ]);

            return response()->json([
                'message' => 'A new payment method has been added successfully.',
                'data' => $paymentMethod
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get the validation errors
            $errors = $e->errors();

            // Prepare a response indicating the required data
            $requiredData = [];
            foreach ($errors as $field => $errorMessages) {
                $requiredData[$field] = $errorMessages[0]; // Assuming you want to return only the first error message
            }

            return response()->json(['message' => 'Validation failed', 'required_data' => $requiredData], 422);
        } catch (\Exception $e) {
            // Return an error response if creating PaymentMethods fails
            return response()->json(['message' => 'Failed to create PaymentMethods: ' . $e->getMessage()], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            // Find PaymentMethods by ID
            $paymentMethod = PaymentMethods::findOrFail($id);
            return response()->json([
                'message' => 'Payment method retrieved successfully.',
                'data' => $paymentMethod
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a custom error response if the ID is not found
            return response()->json(['message' => 'The specified ID does not exist.'], 404);
        } catch (\Exception $e) {
            // Return a general error response if fetching the PaymentMethods fails
            return response()->json(['message' => 'An error occurred while fetching the PaymentMethods.'], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethods $paymentMethods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id): \Illuminate\Http\JsonResponse
{
    try {
        // Find PaymentMethods by ID
        $paymentMethod = PaymentMethods::findOrFail($id);

        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:payment_methods,name,' . $id,
        ]);

        // Update PaymentMethods details
        $paymentMethod->name = $validatedData['name'];
        $paymentMethod->save();

        return response()->json([
            'message' => 'Payment method updated successfully.',
            'data' => $paymentMethod
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Return a custom error response if the ID is not found
        return response()->json(['message' => 'The specified ID does not exist.'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Get the validation errors
        $errors = $e->errors();

        // Prepare a response indicating the required data
        $requiredData = [];
        foreach ($errors as $field => $errorMessages) {
            $requiredData[$field] = $errorMessages[0]; // Assuming you want to return only the first error message
        }

        return response()->json(['message' => 'Validation failed', 'required_data' => $requiredData], 422);
    } catch (\Exception $e) {
        // Return an error response if updating PaymentMethods fails
        return response()->json(['message' => 'Failed to update PaymentMethods: ' . $e->getMessage()], 422);
    }
}



    /**
     * Remove the specified resource from storage.
     */    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            // Find PaymentMethods by ID and delete it
            $PaymentMethods = PaymentMethods::findOrFail($id);
            $PaymentMethods->delete();

            return response()->json(['message' => 'PaymentMethods deleted.'], 200);

        } catch (\Exception $e) {
            // Return an error response if PaymentMethods not found
            return response()->json(['message' => 'PaymentMethods not found.'], 404);
        }
    }
}