<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //

    // Show all listings
    public function index() {
        //dd(request()->tag);
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
            
            // Simpler paginate option
            //'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(4)
        ]);
    }

    // Show a single listing 
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create() {

        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {

        //dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
           
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $formFields['user_id'] = auth()->id();


        // Saves data to database
        Listing::create($formFields);



        return redirect('/')->with('message', 'Listing created successfully');

        //dd($request->all());
    }

    // Show Edit Form
    public function edit(Listing $listing) {
        //dd($listing->title);

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {

            abort(403, 'Unauthorized Action');
        }

        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing data
    public function update(Request $request, Listing $listing) {



        //dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
           
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Saves data to database
        $listing->update($formFields);



        return back()->with('message', 'Listing updated successfully');

        //dd($request->all());
    }

    // Delete Listing
    public function destroy(Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {

            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }


    // Manage Listings
    public function manage() {

        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    } 
}
