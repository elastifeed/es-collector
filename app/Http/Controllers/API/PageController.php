<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Helpers\Error;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class PageController extends Controller{

    public function pushNew(Request $request){

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
           return Category::where('name', '=', $name)->first();
        }, $cats);

        $data = [
            'url' => $request->get('url'),
            'categories' => $cats
        ];

        // Push data
        $this->pushPageToSystem($data);

        return response([
            'error' => false,
            'data' => $data
        ], 200);
    }

    /**
     * Pushes the given data into the elastifeed pusher
     * @param array $data
     * @todo finalize implementation
     */
    private function pushPageToSystem(array $data){
        return;
        $client = new Client();
        $res = $client->post($_ENV['SYSTEM_PUSH_PAGE'], [
           'form_params' => $data
        ]);
    }

}
