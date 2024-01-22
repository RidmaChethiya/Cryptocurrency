<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        's_name',
        'price',
        'l_price'
    ];


    public function getRealCurrency() {

        $url = 'https://open.er-api.com/v6/latest/LKR';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($curl);
        curl_close ($curl);

        $data = (array)json_decode($response)->rates;
        return $data;

    }  

    public function autoUpdate() {

        $is_updated = 0;
        $exchange_rates = $this->getRealCurrency();
        foreach ($exchange_rates as $curency_type => $exchange_rate){ 
            $Currency = Currency::where('s_name', $curency_type)->first();
            if ($Currency && $Currency['price'] != $exchange_rate) {
                $update = Currency::find($Currency['id']);
                $update->where('id', $Currency['id'])->update(['price' => $exchange_rate, 'l_price' => $Currency['price']]);
                $is_updated++;
            }
        }
        if ($is_updated) {
            return response()->json([
                'massage' => $is_updated. ' no of currency live updated.!'
            ]);
        } else { 
            return response()->json([
                'massage' => 'Done.!'
            ]);
        }
    }
}
