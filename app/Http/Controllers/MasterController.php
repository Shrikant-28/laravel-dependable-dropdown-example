<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Country, State, City};

class MasterController extends Controller
{
    function fetchCountries(Request $request){
        $data = Country::get(['id','name']);
        return $data;
    }

     /**
     * @param id - Country Id
     * @return States
     *
     */
    // Passed Country ID
    function fetchState(Request $request){
        if(!empty($request->id))    {
            $data =State::where('country_id','=',$request->id)->get(['id','name']);
        }else{
            $data =State::get(['id','name']);
        }
        return response()->json($data);
    }

    /**
     * @param id - State Id
     * @return Cities
     *
     */
    // Passed State ID
    function fetchCity(Request $request){
        if(!empty($request->id))    {
            $data =City::where('state_id','=',$request->id)->get(['id','name']);
        }else{
            $data =State::get(['id','name']);
        }
        return response()->json($data);
    }


}
