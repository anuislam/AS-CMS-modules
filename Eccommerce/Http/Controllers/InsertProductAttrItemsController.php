<?php

namespace Modules\Eccommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\TarmModel;
use App\notifications;
use App\UserModel;
use Validator;
use DataTables;
use Modules\Eccommerce\Entities\Product;
use App\UserPermission;

class InsertProductAttrItemsController extends Controller
{
	private $tarm = '';
	private $notification = '';
    private $usermodel = '';
	private $permission = '';

	public function __construct(){
		$this->tarm = new TarmModel();
		$this->notification    = new notifications(); 
        $this->usermodel    = new UserModel();
		$this->permission    = new UserPermission();
		$this->middleware('auth');
	}
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($tarm_id){

        if (url_gard('integer', $tarm_id) === false) {
             return abort(404);
        }

        if ($this->tarm->get_tarms($tarm_id) === false) {
        	return abort(404);
        }

        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('add_product', $current_user['id']) === false) {
            return abort(404);
        }

        return view('eccommerce::productAttrInsert', [
        	'current_user'        => $current_user,
            'tarm_id'             => $tarm_id,
        	'notification'		  => $this->notification->get_header_notification(),
        ]);
    }

    public function create(Request $data, $tarm_id){

        if (url_gard('integer', $tarm_id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid Attribute');
        }

        if ($this->tarm->get_tarms($tarm_id) === false) {
            return redirect()->back()->with('error_msg', 'Attribute Not Found.');
        }

        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('add_product', $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You Have No Permission.');
        }

        Validator::make($data->all(), [
                'item_name'         => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,100}$/|unique:product_attr,item_name',
                'item_slug'         => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,100}$/|unique:product_attr,item_slug',
                'item_description'  => 'nullable',
            ]
        )->validate();

        $data = $data->all();
        Product::attr_items()->insert([
            'attr_id'           => (int)$tarm_id,
            'item_name'         => sanitize_text($data['item_name']),
            'item_slug'         => sanitize_text($data['item_slug']),
            'item_description'  => sanitize_text($data['item_description']),
        ]);

        return redirect()->back()->with('success_msg', 'Item insert successful.');        
    }

    public function datatable(Request $data, $tarm_id) {
        return DataTables::of(Product::attr_items()->select('*')->where('attr_id', '=', (int)$tarm_id))
        ->addColumn('action', function ($item) {
            return '<a href="'.route('product_attr_items_edit', $item->id).'" class="btn bg-purple btn-flat">Edith</a> <a
        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete this?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'
        href="'.route('product_attr_items_delete', $item->id).'" class="btn bg-maroon btn-flat">Delete</a>';
        })        
        ->escapeColumns(['*'])
        ->make(true);
    }

    public function edit($item_id){
        if (url_gard('integer', $item_id) === false) {
            return abort(404);
        }

        if (Product::attr_item_exists($item_id) === false) {
            return abort(404);
        }

        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('add_product', $current_user['id']) === false) {
            return abort(404);
        }


        return view('eccommerce::productAttrEdit', [
            'current_user'        => $current_user,
            'value'               => Product::attr_items()->select('*')->where('id', '=', $item_id)->first(),
            'notification'        => $this->notification->get_header_notification(),
        ]);
    }


    public function update(Request $data, $item_id) {
        if (url_gard('integer', $item_id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid Attribute Item');
        }

        if (Product::attr_item_exists($item_id) === false) {
            return redirect()->back()->with('error_msg', 'Attribute Item Not Found.');
        }

        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('add_product', $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You Have No Permission.');
        }

        Validator::make($data->all(), [
                'item_name'         => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,100}$/|unique:product_attr,item_name,'.$item_id,
                'item_slug'         => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,100}$/|unique:product_attr,item_slug,'.$item_id,
                'item_description'  => 'nullable',
            ]
        )->validate();

        Product::attr_items()
            ->where('id',  (int)$item_id)
            ->update([
                'item_name'         => sanitize_text($data['item_name']),
                'item_slug'         => sanitize_text($data['item_slug']),
                'item_description'  => sanitize_text($data['item_description']),
        ]);

        return redirect()->back()->with('success_msg', 'Item update successful.');

    }

    public function delete(Request $data, $item_id){
        if (url_gard('integer', $item_id) === false) {
             return redirect()->back()->with('error_msg', 'Invalid Attribute Item');
        }

        if (Product::attr_item_exists($item_id) === false) {
            return redirect()->back()->with('error_msg', 'Attribute Item Not Found.');
        }

        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('delete_product', $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You Have No Permission.');
        }

        Product::attr_items()->where('id',  (int)$item_id)->delete();
        return redirect()->back()->with('success_msg', 'Item delete successful.');
    }

}
