<?php 

class BasicController extends Controller {


    public function getIndex()
    {
    
    return Response::json(array (
    	             'title'=>'Fifth Avenue Leasing and Rental | Car Leasing and Rental',
    	             'users'=>User::select('name','email','phone','image')->where('type','=','admin')->first(),
    	             'slides'=>Slide::all(),
                     'vehicles'=>Vehicle::where('available','=','1')->where('reserved','=','0')->get()
    	             ));

    }


    public function getNewsletter()
    {
        return Response::json(array(
                        'title'=>'Admin Panel | Fifth Avenue Leasing and Rental',
                        'newsletters'=> Newsletter::orderBy('id','DESC')->paginate(20)
                        ));
    }


    public function AddNewsletter() {

    $data = Input::all();
    $email = trim($data['emailadd']);
    $token = trim($data['token']);

    if($token==Session::token())
    {

    $check_email = Newsletter::where('email_addr','=',$email)->get();
    if(sizeof($check_email) > 0) {
        return Response::json(array('error'=>'Subscription with this email address already done'));
    }

    $newsletter = new Newsletter;
    $newsletter->email_addr= $email;
    $newsletter->save();

    return Response::json(array('success'=>'Email Successfully Added to Newsletter', 'email'=>$newsletter->email_addr, 'id'=>$newsletter->id));
    }

    return Response::json(array('error'=>'Token Mismatch'));
    }

}
