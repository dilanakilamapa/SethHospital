<?php

namespace App\Http\Controllers;

use App\Models\registration;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class frontend extends Controller
{
    public function store(Request $request){
        
        $request->validate(
            [
                'MobileNumber' => 'required|numeric|unique:registrations,PhoneNumber',
                'FirstName' => 'required|string',
                'LastName' => 'required|string',
                'Address' => 'required|string',
                'Age' => 'required|numeric',
                'gender' => 'required|in:male,female',
            ],
            [
                'MobileNumber.reuired' => 'Mobile Number is Required',
                'MobileNumber.unique' => 'Mobile Number is Already Exists',
            ]
            );

        $mobileNumber = $request->input('MobileNumber');
        $firstName = $request->input('FirstName');
        $lastName = $request->input('LastName');
        $address = $request->input('Address');
        $age = $request->input('Age');
        $gender = $request->input('gender');
        
        $OTP_number = strval(rand(100000, 999999));
        
        $registration = new registration();
        $registration->PhoneNumber = $mobileNumber;
        $registration->first_name = $firstName;
        $registration->last_name = $lastName;
        $registration->address = $address;
        $registration->age = $age;
        $registration->gender = $gender;
        $registration->OTP = $OTP_number;
        $registration->OTP_verify = 'false';
        $registration->save();

        //send sms
        $siteKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ODMzMCwiaWF0IjoxNjg5NzY3NDg0LCJleHAiOjQ4MTM5Njk4ODR9.zkaRimNFmzBJ0JCzxagtyYkHuWtT0KKB5KqgzhMZ6CY';
        $phoneNumbers = $mobileNumber; // Comma-separated phone numbers
        $message = 'Thank you for choosing SUWAYA HOSPITAL for your healthcare needs. To ensure the security of your personal information and provide you with a seamless experience, we have generated a One-Time Password (OTP) for your access to our hospital services.

        OTP: ' . $OTP_number.' 
        ';

        $url = "https://e-sms.dialog.lk/api/v1/message-via-url/create/url-campaign";
        $queryData = http_build_query([
            'esmsqk' => $siteKey,
            'list' => $phoneNumbers,
            'message' => $message,
        ]);

        $client = new Client();
        $response = $client->get($url . '?' . $queryData);

        $statusCode = $response->getStatusCode();
        $responseText = $response->getBody()->getContents();

        return response()->json([
            'status_code' => $statusCode,
            'response' => $responseText,
        ]);

    }

    
    
}