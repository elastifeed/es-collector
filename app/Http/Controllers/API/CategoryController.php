<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Helpers\Error;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class CategoryController extends Controller{

    /**
     * Returns all categories of the current user
     * @return Category[]
     */
    public function getAll(){
        $user = Auth::user();
        return $user->categories()->get();
    }


    /**
     * Adds a new category to the current user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function insertNew(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'meta' => 'filled'
        ]);

        // If valdiation fails respond with an error object
        if ($validator->fails()) {
            return response(Error::new($validator->getMessageBag()->toArray()), 400);
        }
        if (count($user->categories()->where('name', '=', $request->get('name'))->get())) {
            return response(Error::new([
                'name' => [
                    'Category with this name already exists for the current user.'
                ]
            ]), 400);
        }

        $meta = $request->get('meta');
        if ($meta === null){
            $meta = [];
        }

        // Create and save the new category
        return $user->categories()->create([
            'name' => $request->get('name'),
            'meta' => $meta
        ]);
    }

    /**
     * Removes the given category
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function removeCategory(Request $request, int $id){
        $user = Auth::user();
        $cat = $user->categories()->find($id);
        if ($cat === null){
            return response(Error::new(sprintf('Category with the id %d could not be found', $id)), 400);
        }
        $cat->delete();
        return $cat;
    }
}
