<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CookBooks;
use App\Models\ItemModel;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\test;

class recipeController extends Controller
{
    //
    public function addToCookBook(Request $data)
    {
        $recipeId = $data->input('recipe_id');

        $user = users::where('username', "=", $data->username)->first();
        $cookbook = CookBooks::firstOrNew(['user_id' => $user->id]);

        // Deserialize the saved_recipes JSON data into an array
        $savedRecipes = $cookbook->saved_recipes ? json_decode($cookbook->saved_recipes, true) : [];

        if (!in_array($recipeId, $savedRecipes)) {
            $savedRecipes[] = $recipeId;
            $cookbook->user_id = $user->id;
            $cookbook->saved_recipes = json_encode($savedRecipes); // Serialize the array back to JSON
            $saveSuccessful = $cookbook->save();

            if ($saveSuccessful) {
                $requestedRecipe = test::find($recipeId);
                $requestedRecipe->update(
                    [
                        'likes' => $requestedRecipe->likes + 1
                    ]
                );
            }
        }

        // Return a success response
        return response()->json([
            'message' => 'Recipe added to cookbook',
            'data' => $cookbook
        ]);
    }
    public function getCookBook($email)
    {
        $user = users::where('email', $email)->first();
        $user_id = $user->id;

        $cookbook = CookBooks::where('user_id', $user_id)->first();
        $recipes = test::whereIn('id', array_map('intval', json_decode($cookbook->saved_recipes)))->get();
        return response()->json(['data' => $recipes],  200);
    }
}
