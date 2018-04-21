<?php

namespace Modules\AllStor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use App\UserPermission;
use Carbon;
use App\UserModel;
use App\BlogPost;

class HomeController extends Controller
{
	private $permission = '';
	private $usermodel = '';
	private $post = '';
	private $comment = '';

	public function __construct(){
		$this->permission   = new UserPermission();
		$this->usermodel    = new UserModel();
		$this->post    		= new BlogPost();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request){
        return view('allstor::home', [
        	'curent_user' => $request->user()
        ]);
    }

    
}
