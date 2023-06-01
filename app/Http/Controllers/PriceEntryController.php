<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceEntryRequest;
use App\Http\Requests\UpdatePriceEntryRequest;
use App\Models\PriceEntry;

class PriceEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePriceEntryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceEntry $priceEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceEntry $priceEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriceEntryRequest $request, PriceEntry $priceEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceEntry $priceEntry)
    {
        //
    }
}
