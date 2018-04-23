<?php

namespace Modules\Workdiaryblog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Workdiaryblog\Entities\utility;
use App\BlogPost;
use App\mediaModel;
use App\post_type;
use App\TarmModel;


class WorkdiaryblogController extends Controller{
	private $utility = '';
	private $postmodel = '';
	private $mediaModel = '';
	private $post_type = '';
	private $tarmmodel = '';

	public function __construct(){
		$this->utility = new utility();
		$this->postmodel    = new BlogPost(); 
	    $this->mediaModel   = new mediaModel();  
	    $this->post_type   = new post_type();  
	    $this->tarmmodel   = new TarmModel();  
	}

    public function index(){
        return view('workdiaryblog::index', [
        	'header_menu' 	=> $this->utility->wdb_get_header_menu(1),
        	'latest_works' 	=> utility::work_get()->where('status', '=', '1')->orderby('id', 'DESC')->limit(20)->get(),
        	'work_meta'	   	=> $this->postmodel,
        	'media'	   		=> $this->mediaModel,
        	'post'	   		=> $this->post_type,
        	'tarmmodel'	    => $this->tarmmodel,
        ]);
    }

 
}

