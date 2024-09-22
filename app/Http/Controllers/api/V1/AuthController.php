<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $token = true;
    public function __construct()
    {
        $this->middleware('jwt.auth')->except(['login', 'register']);
    }


    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'password' => 'required|string',
            ], [
                'required' => 'Поле :attribute обязательно для заполнения.',
                'string' => 'Поле :attribute должно быть строкой.',
                'username.required' => 'Поле "Имя пользователя" обязательно для заполнения.',
                'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $credentials = [
                'password' => $request->password
            ];

            $username = $request->username;

            // Проверяем, является ли введенное значение email или логин.
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $username;
            } else {
                $credentials['login'] = $username;
            }



            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Неккоректные данные',
                ], 401);
            }



            return response()->json([
                'status' => 'success',
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }
        catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }


    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'passportNumber' => ['required', 'string', 'unique:users,passportNumber','min:10', 'max:10', 'regex:/^[0-9]+$/u'],
            'firstName' => ['required', 'string', 'regex:/^[A-ZА-ЯЁ][a-zа-яё]+$/u'],
            'lastName' => ['required', 'string', 'regex:/^[A-ZА-ЯЁ][a-zа-яё]+$/u'],
            'login' => ['required', 'string', 'unique:users,login', 'max:8', 'regex:/^[a-zA-Z0-9]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'pass' => ['required', 'string', 'min:6', 'max:32','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[_#?!@$%^&*-]).{8,32}$/'],
            'address' => ['required', 'string'],
            'phoneNumber' => ['required', 'string', 'max:20'],
            'dateOfBirth' => ['required', 'date', 'before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format( 'Ymd')]
        ],[
            'passportNumber.required' => 'Поле номера паспорта обязательно для заполнения.',
            'passportNumber.string' => 'Поле номера паспорта должно быть строкой.',
            'passportNumber.unique' => 'Такой номер паспорта уже зарегистрирован.',
            'passportNumber.max' => 'Поле номера паспорта должно быть не более 10 цифр.',
            'passportNumber.min' => 'Поле номера паспорта должно быть не мениеее 10 цифр.',
            'passportNumber.regex' => 'Поле номера паспорта должно содержать только буквы и цифры.',
            'firstName.required' => 'Поле имени обязательно для заполнения.',
            'firstName.string' => 'Поле имени должно быть строкой.',
            'firstName.regex' => 'Поле имени должно начинаться с заглавной буквы и содержать только буквы.',
            'lastName.required' => 'Поле фамилии обязательно для заполнения.',
            'lastName.string' => 'Поле фамилии должно быть строкой.',
            'lastName.regex' => 'Поле фамилии должно начинаться с заглавной буквы и содержать только буквы.',
            'login.required' => 'Поле логина обязательно для заполнения.',
            'login.string' => 'Поле логина должно быть строкой.',
            'login.unique' => 'Такой логин уже зарегистрирован.',
            'login.max' => 'Поле логина должно быть не более 8 символов.',
            'login.regex' => 'Поле логина должно содержать только буквы и цифры.',
            'email.required' => 'Поле электронной почты обязательно для заполнения.',
            'email.string' => 'Поле электронной почты должно быть строкой.',
            'email.email' => 'Поле электронной почты должно быть действительным адресом.',
            'email.max' => 'Поле электронной почты должно быть не более 255 символов.',
            'email.unique' => 'Такой адрес электронной почты уже зарегистрирован.',
            'pass.required' => 'Поле пароля обязательно для заполнения.',
            'pass.string' => 'Поле пароля должно быть строкой.',
            'pass.min' => 'Пароль должен содержать не менее 6 символов.',
            'registration-form-pass.max' => 'Пароль должен содержать не более 32 символов.',
            'pass.regex' => 'Пароль должен содержать хотя бы одну цифру, одну заглавную букву и один специальный символ.',
            'address.required' => 'Поле адреса обязательно для заполнения.',
            'address.string' => 'Поле адреса должно быть строкой.',
            'phoneNumber.required' => 'Поле номера телефона обязательно для заполнения.',
            'phoneNumber.string' => 'Поле номера телефона должно быть строкой.',
            'phoneNumber.max' => 'Поле номера телефона должно быть не более 20 символов.',
            'dateOfBirth.required' => 'Поле даты рождения обязательно для заполнения.',
            'dateOfBirth.date' => 'Поле даты рождения должно быть датой.',
            'dateOfBirth.before_or_equal' => 'Вы должны быть старше 18 лет для регистрации.'
        ]);


        // Проверка валидации
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->passportNumber = $request->passportNumber;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->login = $request->login;
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->password = bcrypt($request->pass);
        $user->remember_token = null;
        $user->address = $request->address;
        $user->phoneNumber = $request->phoneNumber;
        $user->dateOfBirth = $request->dateOfBirth;
        $user->role_id = 2;
        $user->save();
        if (!$token = JWTAuth::attempt(['login'=> $request->login,'password' => $request->pass])) {
            return response()->json([
                'success' => false,
                'message' => 'Неккоректные данные',
            ], 401);
        }
        return response()->json([
            'token' => $token,
            'success' => true,
            'data' => $user
        ], 201);
    }


        public function logout()
    {
        $token = request()->query('token'); // Получаем токен из параметра запроса
        JWTAuth::invalidate(JWTAuth::parseToken($token));

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);

    }

    public function getUser()
    {
        try{
            $token = request()->query('token'); // Получаем токен из параметра запроса
            $user = JWTAuth::authenticate($token);
            return response()->json(['user' => $user]);

        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>'something went wrong']);
        }
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => JWTAuth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
