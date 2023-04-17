<?php

namespace App\Http\Controllers;


use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        /*return response('Hallo, Welt!');*/
        return Inertia::render('Chirps/Index' , [

            /*Return the id and name property from the user */
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
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
     * In the code below, we ensure that the user provides a message and that it won't exceed the 255 character limit of the database column we'll be creating.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request -> validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

 

        $validated = $request->validate([

            'message' => 'required|string|max:255',

        ]);

 

        $chirp->update($validated);

 

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);

 

        $chirp->delete();

 

        return redirect(route('chirps.index'));
    }
}