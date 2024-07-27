<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\ShopName;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
class ShopNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ShopName=ShopName::all();
        return view("admin-views.ShopName.view",compact('ShopName'));
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
                'name' => 'required|unique:shop_names|max:255',
            ], [
                'name.required' => "Please enter the department name",
                'name.unique' => "The department name is already registered",
            ]);

            ShopName::create([
                'name' => $request->name,
            ]);

            session()->flash('Add', 'Successfully added');
            return redirect::route('admin.Shop-Name.index'); // Redirect back to the previous page
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
        $ShopName = ShopName::findOrFail($id);
        return view('admin-views.ShopName.ShopName-edit', compact('ShopName'));
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
                'name.required' => "Please enter the ShopName",
                'name.unique' => "The ShopName is already registered",
            ]);

            $ShopName = ShopName::findOrFail($id);
            $ShopName->update([
                'name' => $request->name,
            ]);

            session()->flash('Update', 'Successfully updated');
            return redirect::route('admin.Shop-Name.index'); // Redirect back to the previous page

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating Shop Name: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating'); // Redirect back with error message
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Find and delete the payment method
        $ShopName = ShopName::find($id);

        if ($ShopName) {
            $ShopName->delete();
            session()->flash('delete', 'Shop Name successfully deleted');
        } else {
            session()->flash('error', 'Shop Name not found');
        }

        // Redirect back to the previous page
        return redirect()->back();
    }



    public function getallShopName()
    {
        $ShopName=ShopName::all();
        return view("vendor-views.profile.update-view",compact('ShopName'));
    }

}
