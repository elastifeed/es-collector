<?php

namespace App\Http\Controllers\API;

use App\Helpers\Error;
use App\Http\Controllers\Controller;
use App\RSSFeed;
use App\User;
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
     * @return RSSFeed[] associated with the current user
     */
    public function getAll(){
        $user = Auth::user();
        return $user->feeds()->get();
    }

    /**
     * Inserts a new RSSFeed into the database (if it does not exist already)
     * and associate it with the current user
     * @param Request $request
     * @return RSSFeed object
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
        if (!$feed->users()->get()->contains($currentUser)){
            $feed->users()->attach($currentUser);
        }
        return $feed;
    }

    /**
     * Detaches a RSSFeed from the current User
     * and deletes the feed if no more users are attached to it
     * @param Request $request
     * @param int $id feed detach from the current user
     * @return mixed
     */
    public function removeFeed(Request $request, int $id){
        $feed = RSSFeed::find($id);
        $currentUser = Auth::user();

        // Returns an error message, if the user does not have
        // the given feed, or the feed does not exist
        if ($feed == null || !$feed->users()->get()->contains($currentUser)){
            return response(Error::new("Feed not found or is not attached to the current user."));
        }

        // Detaches the current user
        // and deletes the feed if no more users are attached
        $attachedUsers = $feed->users();
        $attachedUsers->detach($currentUser);
        if ($attachedUsers->count() === 0){
            $feed->delete();
        }

        return [
            'error' => false,
            'feed' => $feed
        ];
    }
}
