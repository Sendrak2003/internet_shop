<?php

namespace App\Http\Controllers;
use App\Http\Controllers\api\V1\AuthController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('jwt.auth')->except('index');
    }

    public function index()
    {
        return view('welcome');
    }
    public function home(Request $request)
    {
        $token = request()->query('token');
       // $token = $request->header('Authorization');
        $user = JWTAuth::parseToken()->authenticate();
        $passportNumber=$user->passportNumber;
        $categories = Categories::select('name')->get();
        $products = Products::select('brand','model','price')->get();

        $data = [
            'token' => $token,
            'passportNumber' => $passportNumber,
            'categories' => $categories,
            'products' => $products,
        ];

        return view('home', compact('data'));
    }
//    public function logout()
//    {
//        //redirect()->route('index');
//        return redirect()->route('index');
//    }
    public function login(Request $request)
    {
        $credentials = [
            'username' => 'user1', // Replace with the actual username or email
            'password`' => 'password', // Replace with the actual password
        ];

        // Send a POST request to the login API endpoint
        $response = Http::post( url('/api/V1/login'), $credentials);

        // Check if the request was successful
        if ($response->successful()) {
            // Authentication successful, retrieve the user and token from the response
            $responseData = $response->json();
            $user = $responseData['user'];
            $token = $responseData['authorization'];

            // You can perform any necessary actions here, such as storing the token in the session or redirecting the user

          return $responseData;
        } else {
            // Authentication failed, handle the error response
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
    }


}
