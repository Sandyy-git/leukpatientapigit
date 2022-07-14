<?php namespace App\Controllers;

class Welcome extends BaseController
{
	public function index()
	{
		// return view('welcome_message');
        echo "hi this is a wel controller";
	}


    public function test(){
        echo "this is a test method";
    }


    // public function _remap($method){    //override its default routing behavior
    //     echo $method;
    // }

	//--------------------------------------------------------------------

}
