<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function site()
    {
        $cards = Card::all();
        return view('site', compact('cards'));
    }
    // Display all cards

    public function index()
    {
        // If you want to return the cards to your Blade view
        $cards = Card::all();
        return view('your_view_name', compact('cards'));
    }

    // Store a new card
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'price' => 'required|numeric',  // Price is required
            'value' => 'required|string',   // Value (COD Points) is required
        ]);

        // Create a new card with validated data
        $card = Card::create([
            'price' => $validated['price'],
            'value' => $validated['value'],
        ]);

        // Return to the previous page with success message
        return redirect()->back()->with('success', 'Package created successfully.');
    }

    // Update an existing card
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'value' => 'required|string',
            'price' => 'required|numeric',
        ]);
    
        $card->update($validated);
        return redirect()->back()->with('success', 'Package edited successfully.');
    }
    

    // Delete a card
    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json(null, 204);
    }
}
