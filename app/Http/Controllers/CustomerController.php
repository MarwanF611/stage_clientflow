<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Klant::simplePaginate(20);

        $customers->withPath('klanten');

        return view('customers.index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'street_name' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'vat_number' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        try {
            $klant = new Klant();
            $klant->first_name = $request->first_name;
            $klant->last_name = $request->last_name;
            $klant->email = $request->email;
            $klant->phone_number = $request->phone_number;
            $klant->street_name = $request->street_name;
            $klant->house_number = $request->house_number;
            $klant->postcode = $request->postcode;
            $klant->country = $request->country;
            $klant->company_name = $request->company_name;
            $klant->vat_number = $request->vat_number;
            $klant->iban = $request->iban;
            $klant->save();
        } catch (\Exception $e) {
            dd($e);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Klant is succesvol aangemaakt.');
    }
}
