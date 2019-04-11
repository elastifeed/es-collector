<?php

namespace App\Http\Controllers\API;

use App\Helpers\Error;
use App\Http\Controllers\Controller;
use App\RSSFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Handles request for the RSS-Feeds
 * @package App\Http\Controllers
 */
class FeedController extends Controller{

    /**
     * Returns all RSSFeeds associated with the current user
     * @param Request $request
     * @return returns all RSSFeeds associated with the current user
     */
    public function getAll(){
        $user = Auth::user();
        return $user->feeds()->get();
    }

    /**
     * Inserts a new RSSFeed into the database (if it does not exist already)
     * and associate it with the current user
     * @param Request $request
     * @return a
     */
    public function insertNew(Request $request){
        $currentUser = Auth::user();
        $validator = Validator::make($request->all(), [
            'link' => 'required'
        ]);
        // If valdiation fails respond with an error object
        if ($validator->fails()) {
            return response(Error::new($validator->getMessageBag()->toArray()), 400);
        }

        $data = $request->all();
        $hash = sha1($data['link']);
        $feed = RSSFeed::where('hashedLink', '=', $hash)->first();

        // If there is no feed having the same hashedLink
        // a new one will be created
        if ($feed == null) {
            $feed = new RSSFeed([
                'link' => $data['link'],
                'hashedLink' => $hash
            ]);
            $feed->save();
        }

        // If the current user is not yet associated with
        // the feed, he will be attached to it here
        print_r($currentUser->toArray());
        if (!$feed->users()->get()->contains($currentUser)){
            $feed->users()->attach($currentUser);
        }
        die();
        return $feed;
    }
}
