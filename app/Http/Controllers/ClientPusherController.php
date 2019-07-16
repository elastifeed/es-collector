<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;


class ClientPusherController extends Controller
{
    public function webApp(Request $request){
        $url = $request->get('url');
        if (!isset($url)){
            return redirect(url('/'));
        }
        JavaScript::put([
            'routes' => [
                'push' => url('/api/v1/page'),
                'login' => url('/api/v1/login'),
                'profile' => url('/api/v1/me'),
                'proxy' => url('/api/v1/proxy'),
                'categories' => url('/api/v1/categories'),
                'feeds' => url('/api/v1/feeds'),
                'target' => $url,
            ]
        ]);
        return view('push');
    }

    public function bookmarklet(){
        $jsPath = resource_path('js/bookmarklet.js');
        $jsContent = file_get_contents($jsPath);
        $jsContent = preg_replace('/\/\/.*/', ' ', $jsContent); // remove comments
        $jsContent = preg_replace('/\s+/', ' ', $jsContent); // remove whitespaces
        $jsContent = str_replace('{{url}}', url('/'), $jsContent); // replace url

        return view('bookmark', [
            'bookmarklet' => $jsContent
        ]);
    }
}
