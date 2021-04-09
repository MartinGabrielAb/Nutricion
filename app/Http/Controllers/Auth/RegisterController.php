<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
USE App\RolesUsuario;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
    
        $usuario = new User();
        $usuario->name = $data['name'];
        $usuario->email =  $data['email'];
        $usuario->password = bcrypt($data['password']);
        $usuario->save();
        $roles = $data['roles'];
        for ($i=0; $i < count($roles) ; $i++) { 
            $rol = DB::TABLE('roles')->where('nombre_rol',$roles[$i])->First();
            $rolesUsuario = new RolesUsuario();
            $rolesUsuario->UserId = $usuario->id;
            $rolesUsuario->RolId = $rol->id;
            $rolesUsuario->save();
        }
        return false;

        // return User::create([
        //     'name' => ,
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password'])
        // ]);
    }
}
