<?php


namespace App\Helpers;


use Illuminate\Contracts\Support\MessageBag;

/**
 * Wrapper for API
 * @package App\Helpers
 */
final class Error{
    private function __construct(){
    }

    public static function new($messages){
        return [
            'error' => true,
            'messages' => $messages
        ];
    }
}