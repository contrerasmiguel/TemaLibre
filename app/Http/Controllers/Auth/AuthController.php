<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';
    protected $loginPath = 'auth/login';
    protected $redirectAfterLogout = '/auth/login';
    protected $username = 'nombre_usuario';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'getLogout']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
              'nombre_usuario' => 'required|min:2|max:32|unique:usuarios,nombre_usuario'
            , 'clave' => 'required|min:3|max:32|confirmed'
            , 'clave_confirmation' => 'same:clave'
            , 'correo_electronico' => 'required|email|max:255|unique:usuarios,correo_electronico'
            , 'nombre' => 'required|min:2|max:32'
            , 'apellido' => 'required|min:2|max:32'
            , 'pregunta_secreta' => 'required|max:255'
            , 'respuesta_secreta' => 'required|max:255'
        ]);
    }

    protected function create(array $data)
    {
        $data['clave'] = bcrypt($data['clave']);
        $data['fecha_registro'] = Carbon::now();

        return User::create($data);
    }

    public function getRecover()
    {
        return view('auth.recover');
    }

    public function postRecover(Request $request)
    {
        $data = $request->all();

        if (User::all()->where('nombre_usuario', $data['usernameOrEmail'])->count() > 0) {
            $user = User::all()->where('nombre_usuario', $data['usernameOrEmail'])->first();

            return view('auth.change_password', ['user' => $user]);
        }
        else if (User::all()->where('correo_electronico', $data['usernameOrEmail'])->count() > 0) {
            $user = User::all()->where('correo_electronico', $data['usernameOrEmail'])->first();

            return view('auth.change_password', ['user' => $user]);
        }
        else return view('auth.recover')->withErrors(['usernameOrEmail' => 'No se encontraron registros que coincidan con los datos ingresados.']);
    }

    public function postPassword(Request $request)
    {
        $data = $request->all();
        $user = User::findOrFail($data['userId']);

        if ($user->respuesta_secreta == $data['secretAnswerInput']) {
            $validator = Validator::make($data, [
                  'newPassword' => 'required|min:3|max:32|confirmed'
                , 'newPassword_confirmation' => 'same:newPassword'
            ]);

            if ($validator->fails()) {
                return view('auth.change_password', ['user' => $user])->withErrors($validator);
            }
            else {
                $user->update(['clave' => bcrypt($data['newPassword'])]);
                return redirect('/');
            }
        }
        else {
            return view('auth.change_password', ['user' => $user])->withErrors(['Respuesta incorrecta.']);
        }
    }
}
