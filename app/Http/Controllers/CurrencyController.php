<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Currency::where('is_delete', 0)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            's_name' => 'required|max:255',
            'price' => 'required',
        ]);
        try {
            $save = Currency::create($request->all());
        } catch (Exception $e) {
            return $e->getMessage();  
        }
        // return response()->json($save);
        return response()->json([
            'massage' => 'Currency saved successfully.!',
            'update' => $save
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Currency::find($id);
    }

    /**
     * Search the specified resource.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Currency::where('name', 'like', '%'.$name.'%')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            's_name' => 'required|max:255',
            'price' => 'required',
        ]);
        try {
            $currency = Currency::find($id);
            $currency->update($request->all());
        } catch (Exception $e) {
            return $e->getMessage();  
        }
        // return response()->json($currency);
        return response()->json([
            'massage' => 'Currency updated successfully.!',
            'update' => $currency
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $delete = Currency::destroy($id);
        if ($delete) {
            return response()->json([
                'massage' => 'Currency deleted successfully.!'
            ]);
        } else {
            return response()->json([
                'massage' => 'Currency deleted error.!'
            ]);
        }
        
    }

    // public function getRealCurrency() {

    //     $url = 'https://open.er-api.com/v6/latest/LKR';

    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_POST, 0);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //     $response = curl_exec ($curl);
    //     curl_close ($curl);

    //     $data = (array)json_decode($response)->rates;
    //     return $data;

    // }  

    // public function autoUpdate() {

    //     $is_updated = 0;
    //     $exchange_rates = $this->getRealCurrency();
    //     foreach ($exchange_rates as $curency_type => $exchange_rate){ 
    //         $Currency = Currency::where('s_name', $curency_type)->first();
    //         if ($Currency && $Currency['price'] != $exchange_rate) {
    //             $update = Currency::find($Currency['id']);
    //             $update->where('id', $Currency['id'])->update(['price' => $exchange_rate, 'l_price' => $Currency['price']]);
    //             $is_updated++;
    //         }
    //     }
    //     if ($is_updated) {
    //         return response()->json([
    //             'massage' => $is_updated. ' no of currency live updated.!'
    //         ]);
    //     } else { 
    //         return response()->json([
    //             'massage' => 'Done.!'
    //         ]);
    //     }
    // }
}
