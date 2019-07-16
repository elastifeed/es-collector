<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Helpers\Error;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PageController extends Controller{

    public function pushNew(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'categories' => 'filled'
        ]);
        if ($validator->fails()) {
            return response(Error::new($validator->getMessageBag()->toArray()), 400);
        }

        $cats = $request->get('categories');

        // Handle optional fields
        if (is_null($cats))
            $cats = [];

        // Fill categories with the model-object
        $cats = array_map(function($name){
           $cat =  Category::where('name', '=', $name)->first();
           return $cat['name'];
        }, $cats);

        $data = [
            'url' => $request->get('url'),
            'categories' => $cats,
            'indexes' => [$user->id]
        ];

        // Push data
        $res = $this->pushPageToSystem($data);
        return response([
            'error' => false,
            'data' => $data,
            'response' => json_decode($res->getBody())
        ], 200);
    }

    /**
     * Pushes the given data into the elastifeed pusher
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function pushPageToSystem(array $data){
        $client = new Client();
        $res = $client->post($_ENV['SYSTEM_PUSH_PAGE'], [
           'json' => $data
        ]);
        return $res;
    }

}
