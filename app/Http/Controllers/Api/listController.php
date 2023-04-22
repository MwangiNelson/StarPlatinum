<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\List_;

class listController extends Controller
{


    //auxilliary methods section
    //This method is to simplify the json return in each for each method shortening the codebase
    public function apiDeliver($statusCode, $message)
    {
        return response()->json([
            'status' => $statusCode,
            'data' => $message
        ], $statusCode);
    }

    //initalising validation rules to be used in this list class
    //I have bundled their respective error messages when not met
    public $rules = [
        'title' => 'required|string|max:100'
    ];
    public $customMessages = [
        'title.required' => 'Please enter a title',
        'title.string' => 'Please use alphabet letters',
        'title.max' => 'Title should have a maximum of 100 characters',
    ];


    //consumer methods section
    //this is the main method that's going to return all list items available in the database
    public function index()
    {
        //queries the db for all items using the Laravel query syntax 
        $lists = ListModel::all();

        //this conditional statement checks whethe there are any records in the databse and returns the findings
        if ($lists->count() > 0) {
            return $this->apiDeliver(200, $lists);
        } else {
            return $this->apiDeliver(404, "No records found");
        }
    }


    //this  method adds a new item to the db for the POST api 
    public function save(Request $data)
    {
        //validates whether the received data meets requirements
        $validator = Validator::make($data->all(), $this->rules, $this->customMessages);

        //conditional statement that checks whether the data has been properly validated
        if ($validator->fails()) {
            return $this->apiDeliver(422, $validator->customMessages);
        } else {

            //if data is valid , then insert into db
            $new_list = ListModel::create([
                'title' => $data->title,
            ]);

            //if it's inserted, return an OK response else ERROR response
            if ($new_list) {
                return $this->apiDeliver(200, "Record inserted successfully");
            } else {
                return $this->apiDeliver(404, "Record could not be inserted");
            }
        }
    }

    //This method deletes data using the id passed as an arg
    public function delete($id)
    {
        //First the passed id is validated whether it's in the db and the boolean result is stored in a variable
        $selected = ListModel::find($id);
        if ($selected) {
            //then it's deleted returning a 200 OK response
            $selected->delete();
            return $this->apiDeliver(200, "Item deleted successfully");
        } else {

            //else an error response is returned
            return $this->apiDeliver(404, "No such record was found");
        }
    }

    //this method gets a specific list using it's id that has been passed as an argument
    public function select($id)
    {
        //The db is queried
        //if the data is found, it's stored in the selected var that is true in boolean
        $selected = ListModel::find($id);

        //the selected data is reyurned as data in the API json
        return $this->apiDeliver(200, $selected);
    }


    //This method updates the selected list item and takes the new data and id as arguments
    public function edit(Request $request, $id)
    {
        //First I find the data to be updated in the Db using the id passed as an argument
        $selected = ListModel::find($id);

        //if found(Once again, if data is returned, it's evaluated as true in boolean because data exists)
        if ($selected) {

            //the new data is now validated
            //the earlier stored rules are used here
            $validator = Validator::make($request->all(), $this->rules, $this->customMessages);

            //if it fails, it returns an error message
            if ($validator->fails()) {
                return $this->apiDeliver(422, $validator->customMessages);
            } else {
                //else it updates the data in the db
                $new_list = $selected->update([
                    'title' => $request->title,
                ]);

                //if uodate was successful,return an OK message or an ERROR message otherwise
                if ($new_list) {
                    return $this->apiDeliver(200, "Record updated successfully");
                } else {
                    return $this->apiDeliver(404, "Record could not be updated");
                }
            }
        } else {
            return $this->apiDeliver(404, "No such record was found");
        }
    }

    public function getItemsFromList($id)
    {
        $data = ItemModel::where('list_id', '=', $id)->get();


        return $this->apiDeliver(200, $data);
    }
}
