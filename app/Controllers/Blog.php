<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;     //USE this line RESTFUL APIS

use CodeIgniter\Controller;                     //note line added
// use App\Models\Blog as BlogModel;            //calling models  - call showing error follow next line
use App\Models\BlogModel;                       //calling models


// class Blog extends BaseController           //while creating website use this BaseController line
class Blog extends ResourceController          //while creating apis use this ResourceController 
{
    use \CodeIgniter\API\ResponseTrait;        //note line added, \ added at first

	public function index()                           // Change as GET while retriving 
	{                                                 // http://localhost/leukpatientapi/blog 
		// return view('welcome_message');            //record will show only if column del is 0000
        // echo "this is a rest api blog method";
        $blogs = new BlogModel;
        $blog=$blogs->findAll();
        if(! $blog){
            return $this->fail('user not found',404);
        }
        return $this->respond($blog);
	}


    public function show($id = null){          // Change as GET while retriving 
                                               // http://localhost/leukpatientapi/blog/1
        echo "show method $id";
        // return $this->respond($id);    
        
        $blogs = new BlogModel;
        $blog=$blogs->find($id);
        if(!$blog){
           return $this->fail('user not found',404);
        }
        return $this->respond($blog);
    }

 
    public function create(){                         // Change as GET while retriving 
        $data = $this->request->getPost();            // http://localhost/leukpatientapi/blog            
        // var_dump( $data);                          // need to pass fields from body >>> form data
            $blog = new BlogModel;
            $id = $blog->insert($data);
            if($blog->errors()){
            //    return $this->failServerError();    //one method to print errors
            return $this->fail($blog->errors());      //one method to print errors with clear message, as per our validations conditions
                                                      //notice the c,u,d dates while adding record del go as 0000 coz when we del the rec that time it will get fill
            }
            if($id === false){
                return $this->failServerError();
            }
            $blogs = $blog->getWhere(['id'=>$id])->getResult();
            return $this->respondCreated($blogs);         //validation errors shown here
    }


    public function update($id = null){                 // Change as PUT while updating
                                                       // http://localhost/leukpatientapi/blog/1
                                                       // now column updation time also changes
                                                       //change to postman url body as form url encoded
        $data = $this->request->getRawInput(); 
        $blog = new BlogModel;
        $updated = $blog->update($id,$data);

        if($blog->errors()){
            return $this->fail->fail($blog->errors());
        }
        if($updated === false){
            return $this->failServerError();
        }
        $blogs = $blog->getWhere(['id'=>$id])->getResult();
        return $this->respondUpdated($blogs);

    }

    public function delete($id = null){                // Change as DELETE while deleting
                                                       // http://localhost/leukpatientapi/blog/1
                                                       //notice the timing in db record
        $blog = new BlogModel;
        $deleted = $blog->delete($id);
        return $this->respondDeleted($deleted);
    }
	//--------------------------------------------------------------------

}
