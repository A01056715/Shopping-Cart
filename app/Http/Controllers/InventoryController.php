<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Http\Request; // For getting POST request data

use Validator;


/**
 * Description of Inventory
 *
 * @author DavinDeol
 */
class InventoryController {
    /**
     * 
     * @return inventory HTML page
     */
    public function inventoryPage()
    {
        $data = array();
        $data["title"] = "Inventory";
        return view('inventory', compact('data'));
    }
    
    /**
     * 
     * @param Request $request - POST request data from form
     * @param type $index - the number of the first row we want. Without this,
     *                      the function will return the first 'x' rows.
     * @return type
     */
    public function getItems(Request $request, $index = 0)
    {
        $result = "";
        $responseData = "";
        if ($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),
                [
                    'priceMin' => 'min:0|max:99999999999',
                    'priceMax' => 'gte:priceMin|min:0|max:99999999999',
                ]
            );
            if (!$validator->fails())
            {
                /*
                 * $colName = ($request->input('correspondingInputName') !== null) ? $request->input('correspondingInputName') : <default value>;
                 * $results = DB::select('select * from users where id = :id', ['id' => 1]);
                 */
                //$items = array();
                $priceMin = ($request->input('priceMin') == NULL) ? 0 : $request->input('priceMin');
                $priceMax = ($request->input('priceMax') == NULL) ? 9999.99 : $request->input('priceMax');
                $brand = ($request->input('brand') == NULL) ? array() : $request->input('brand');
                // $items = DB::select('SELECT * from Item WHERE itemPrice BETWEEN 0 and 9999.99');
                // return "SELECT * from Item WHERE (itemPrice BETWEEN :barf and :poop) AND (brandName IN (".print_r($brand)."))";
                $items = DB::select('SELECT * from Item WHERE (itemPrice BETWEEN :barf and :poop) AND (brandName IN (:improper))', ['barf' => $priceMin, 'poop' => $priceMax, 'improper' => implode(',',$brand)]);
                $result = "success";
                $responseData = view('item', compact('items'))->render();
            }
            else
            {
                $result = "fail";
                $responseData = $validator->errors()->messages();
            }
        }
        else
        {
            $result = "fail";
            $responseData = "POST request mandatory";
        }
        // return $responseData;
        return response()
            ->json([
                'result' => $result,
                'data' => $responseData
            ]);
    }
}
