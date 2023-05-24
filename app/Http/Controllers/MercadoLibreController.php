<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;
class MercadoLibreController extends BaseController
{
    public function autorize(Request $request)
    {
        $clientId = env('MELI_CLIENT_ID');
       // dd(env('APP_NAME'));
       // dd(env($clientId));

        $clientSecret = env('MELI_CLIENT_SECRET');
        $redirectUri = env('MELI_REDIRECT_URI');

        // Obtener URL de autorización
        $authUrl = 'https://auth.mercadolibre.com.mx/authorization?response_type=code&client_id='.$clientId.'&redirect_uri='.urlencode($redirectUri);
        //dd($authUrl);
        // Redirigir al usuario a la URL de autorización de Mercado Libre
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $clientId = env('MELI_CLIENT_ID');
        $clientSecret = env('MELI_CLIENT_SECRET');
        $redirectUri = env('MELI_REDIRECT_URI');
        $code = $request->get('code');

        // Intercambiar el código de autorización por un token de acceso
        $tokenUrl = 'https://api.mercadolibre.com/oauth/token?grant_type=authorization_code&client_id=' . $clientId . '&client_secret=' . $clientSecret . '&code=' . $code . '&redirect_uri=' . urlencode($redirectUri);

        $client = new Client();

        try {
            // Realizar la solicitud para obtener el token de acceso
            $response = $client->post($tokenUrl);
            $data = json_decode($response->getBody(), true);

            $accessToken = $data['access_token'];

            // Ejemplo: Obtener información del usuario autenticado
            $userUrl = 'https://api.mercadolibre.com/users/me?access_token=' . $accessToken;

            $response = $client->get($userUrl);
            $user = json_decode($response->getBody(), true);

            // Utilizar la respuesta de la API de Mercado Libre en tu lógica de negocio
            // Ejemplo: Mostrar el nombre del usuario
            $name = $user['first_name'] . ' ' . $user['last_name'];
            return "Bienvenido, $name!";
        } catch (\Exception $e) {
            // Manejar errores
            return "Error: " . $e->getMessage();
        }
    }
}
 
  