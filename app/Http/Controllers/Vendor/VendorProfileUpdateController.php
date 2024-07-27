<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Storage;
class VendorProfileUpdateController extends Controller
{
     /**
     * Update the specified seller in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



      // Update the seller profile
      public function update(Request $request, $id)
      {
          // Validate the incoming request data
          $request->validate([
              'f_name' => 'required|string|max:255',
              'l_name' => 'required|string|max:255',
              'phone' => 'nullable|string|max:20',
              'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,bmp,tiff|max:2048',
              'email' => 'required|string|email|max:255|unique:sellers,email,' . $id,
          ]);

          // Find the seller by ID
          $vendor = Seller::findOrFail($id);

          // Handle image upload
          if ($request->hasFile('image')) {
              // Delete the old image if it exists
              if ($vendor->image) {
                  Storage::delete('public/seller/' . $vendor->image);
              }
              // Store the new image
              $image = $request->file('image');
              $imagePath = $image->store('public/seller');
              $imageName = basename($imagePath);
              $vendor->image = $imageName;
          }

          // Update the seller with new data
          $vendor->f_name = $request->input('f_name');
          $vendor->l_name = $request->input('l_name');
          $vendor->phone = $request->input('phone');
          $vendor->email = $request->input('email');

          // Save the updated seller
          $vendor->save();

          // Return back to the same page with a success message
          return redirect()->back()->with('success', 'Seller updated successfully.');
      }


    // public function update(Request $request, $id)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'f_name' => 'required|string|max:255',
    //         'l_name' => 'required|string|max:255',
    //         'phone' => 'nullable|string|max:20',
    //         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,bmp,tiff|max:2048',
    //         'email' => 'required|string|email|max:255|unique:sellers,email,' . $id,
    //     ]);

    //     // Find the seller by ID
    //     $vendor = Seller::findOrFail($id);

    //     // Handle image update if provided
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');

    //         if (!$image->isValid()) {
    //             throw new \Exception('Invalid image file.');
    //         }

    //         $imageName = $validatedData['f_name'] . '.' . $image->getClientOriginalExtension();
    //         Storage::delete($vendor->image);
    //         $imagePath = $image->storeAs('', $imageName, 'vendors');
    //         $vendor->image = $imagePath;
    //     }

    //     // Update the seller with new data
    //     $vendor->f_name = $request->input('f_name');
    //     $vendor->l_name = $request->input('l_name');
    //     $vendor->phone = $request->input('phone');
    //     $vendor->email = $request->input('email');

    //     // Save the updated seller
    //     $vendor->save();

    //     // Return back to the same page with a success message
    //     return redirect()->back()->with('success', 'Seller updated successfully.');
    // }






}
