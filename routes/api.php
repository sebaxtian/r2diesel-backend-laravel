<?php

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Tema;
use App\Noticia;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


function buildJSONResponse($data, $success, $error)
{
    $response = array('data' => $data, 'success' => $success, 'error' => $error);
    return json_decode(json_encode($response));
}


Route::middleware('api')->get('/hello', function (Request $request) {
    $attrs = $request->all();
    array_push($attrs, 'Hola', 'Mundo');
    return $attrs;
});


Route::middleware('api')->post('/user', function (Request $request) {
    $user = new User;
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->api_token = Str::random(60);
    try {
        $user->save();
        $user = User::where('email', $user->email)->first();
        return response()->json(buildJSONResponse($user, true, null), 200);
    } catch (Exception $err) {
        return response()->json(buildJSONResponse(null, false, $err->errorInfo), 500);
    }
});


Route::middleware('api')->post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, true)) {
        // Authentication passed...
        return response()->json(buildJSONResponse(Auth::user(), true, null), 200);
    }

    return response()->json(buildJSONResponse(null, false, null), 500);
});


Route::middleware('api')->post('/logout', function (Request $request) {
    return Auth::logout();
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    // $request->user() returns an instance of the authenticated user...
    return $request->user();
});


Route::middleware('auth:api')->get('/users', function (Request $request) {
    return App\User::all();
});


Route::middleware('auth:api')->post('/tema', function (Request $request) {
    $tema = new Tema;
    $tema->nombre = $request->input('nombre');
    $tema->descripcion = $request->input('descripcion');
    try {
        $tema->save();
        $tema = Tema::where('nombre', $tema->nombre)->first();
        return response()->json(buildJSONResponse($tema, true, null), 200);
    } catch (Exception $err) {
        return response()->json(buildJSONResponse(null, false, $err->errorInfo), 500);
    }
});


Route::middleware('auth:api')->post('/suscripcion', function (Request $request) {
    $id_user = $request->input('id_user');
    $id_tema = $request->input('id_tema');
    try {
        $user = User::find($id_user);
        if ($user) {
            $temas = $user->temas;
            $existe = false;
            foreach ($temas as $tema) {
                if ($tema->id == $id_tema) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $user->temas()->attach($id_tema);
            }
            $user = User::find($id_user);
            return response()->json(buildJSONResponse($user->temas, true, null), 200);
        }
        return response()->json(buildJSONResponse(null, false, null), 500);
    } catch (Exception $err) {
        return response()->json(buildJSONResponse(null, false, $err->errorInfo), 500);
    }
});


Route::middleware('auth:api')->get('/temas', function (Request $request) {
    return App\Tema::all();
});


Route::middleware('auth:api')->post('/temas/noticia', function (Request $request) {
    $noticia = new Noticia;
    $id_tema = $request->input('id_tema');
    $noticia->titular = $request->input('titular');
    $noticia->url = $request->input('url');
    try {
        $tema = Tema::find($id_tema);
        if ($tema) {
            $tema->noticias()->save($noticia);
            $noticia = Noticia::where('url', $noticia->url)->first();
            return response()->json(buildJSONResponse($noticia, true, null), 200);
        }
        return response()->json(buildJSONResponse($request->all(), false, null), 500);
    } catch (Exception $err) {
        return response()->json(buildJSONResponse(null, false, $err->errorInfo), 500);
    }
});


Route::middleware('auth:api')->get('/noticias', function (Request $request) {
    return App\Noticia::all();
});
