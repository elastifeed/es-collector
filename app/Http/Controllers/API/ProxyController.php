<?php

namespace App\Http\Controllers\API;

use App\Helpers\Error;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProxyController extends Controller{

    public function fetchUrl(Request $request){
        $url = $request->get('url');
        if (!$url){
            return response(Error::new("No url provided"), 400);
        }
        try{
            $client = new Client();
            $res = $client->get($url);

            if ($res->getStatusCode() != 200){
                throw new \Exception();
            }
            return [
                'error' => false,
                'body' => (string) $res->getBody()
            ];
        } catch (\Exception $e){
            return response(Error::new("An error occured accessing the url provided"), 500);
        }
    }

}
