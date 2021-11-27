<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\MasterController;
use App\Models\User;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $masterController = new MasterController();
        $countries = $masterController->fetchCountries($request);
        return view('register',compact('countries'));
    }

    // Store User
    public function register(Request $request)
    {
        print_r($request->checkRequest);
        if (empty($request->checkRequest)) {
            $validator = \Validator::make($request->all(), [
                'first_name'    => ['required', 'max:50'],
                'last_name'     => ['required', 'max:50'],
                'phone_number'  => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'digits:10', 'unique:users,phone_number,' . $request->phone_number],
                'email_address' => ['required', 'string', 'email', 'max:255', 'unique:users,email_address,' . $request->email_address],
                'address'       => ['required' , 'string'],
                'country_id'       => ['required' , 'numeric'],
                'state_id'         => ['required', 'numeric'],
                'city_id'          => ['required', 'numeric'],
                'username'      => ['required', 'string', 'max:100', 'unique:users,username,' . $request->username],
                'password'      => ['required', 'string', 'min:8', 'max:100', ],
                'captcha_input' => ['required'],
            ]);

            if ($validator->passes()) {

                $user = User::create([
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'phone_number'  => $request->phone_number,
                    'email_address' => $request->email_address,
                    'address'       => $request->address,
                    'country_id'    => $request->country_id,
                    'state_id'      => $request->state_id,
                    'city_id'       => $request->city_id,
                    'username'      => $request->username,
                    'password'      => bcrypt($request->password),
                ]);

                $extraSettings = [
                    'username'  => $request->username,
                    'password'  => $request->password,
                ];

                self::sendNotification($request->email_address, $extraSettings);

                return response()->json(['status' => true, 'user_id' => $user->id]);
            } else {
                return response()->json(['status' => false, 'error' => $validator->errors()->all()]);
            }
        } else {
            return response()->json(['status' => false, 'error' => 'Something went wrong']);
        }
    }

    static function sendNotification($email_address, $extraSettings = [])
    {
        // Send Notification to register user.
        try {
            \Mail::to($email_address)->send(new \App\Mail\RegisterMail($extraSettings));
            return ;
        }catch(\Exception $ex){
            //Log::log("level", $ex->getMessage());
             print_r($ex->getMessage());
            // print_r($ex->getLine());
        }
    }
}
