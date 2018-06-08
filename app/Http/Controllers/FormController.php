<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use Auth;
class FormController extends Controller
{
    

   public function __construct()
    {
        $this->middleware('auth');
    }


    public function create(){
    	return view('create');
    }
   

      public function store(Request $request)

    {

        $this->validate($request, [

                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        
        if($request->hasfile('filename'))
         {

            foreach($request->file('filename') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/images/', $name);  
                $data[] = $name;  
            }
         }

         $form= new Form();
         $form->filename=json_encode($data);
        //inserting user id  foreign key in form  
         $userId = Auth::id();
         $form->user_id = $userId; 
        
        $form->save();
        // dd($form);
        return back()->with('success', 'Your images has been successfully uploaded');
    }




}
