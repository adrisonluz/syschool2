<?php

namespace App\Http\Controllers;

use App\Usuario;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Usuario $usuario) {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->usuario = $usuario;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'email' => 'required|email|max:255|unique:usuarios',
                    'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return Usuario::create([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'password' => $data['password'],
        ]);
    }

    public function postLogin(Request $request) {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
        );

        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/login')
                            ->withErrors($validator)
                            ->withInput($request->all());
        }

        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $userLogado = $this->usuario->getUsuarioByEmail($email);
            return redirect('/');
        }

        return redirect('/login')
                        ->withErrors(array('email' => 'Registro não encontrado ou senha inválida.'))
                        ->withInput($request->all());
    }

    public function logout() {
        Auth::logout();

        return redirect('/login');
    }

}
