<?php

namespace App\Http\Controllers\RestAPI\v1;


use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Models\ShopName;


class ShopNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            // Get all ShopName
            $ShopName = ShopName::all();
            return response()->json([
                'message' => 'Displaying all available ShopName',
                'data' => $ShopName
            ], 200);
        } catch (\Exception $e) {
            // Return an error response if fetching ShopNames fails
            return response()->json(['message' => 'An error occurred while fetching shop names.'], 500);
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
    public function store(Request $request)
    {
//
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopName $ShopName)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
//
}



    /**
     * Remove the specified resource from storage.
     */    public function destroy($id)
    {

}
}