<?php 

namespace Modules\Eccommerce\Entities;
/**
* Product Attribute
*/
use App\TarmModel;
use App\mediaModel;
use App\post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use DataTables;

class product_attr extends TarmModel
{
	
	function __construct(){
		parent::__construct();
	}

	public function pate_tab_title(){
    	return 'Product Attributes';
    }
    public function pate_title(){
    	return 'Add Product Attributes';
    }
    public function page_icon(){
    	return 'fa fa-pencil';
    }
    public function pate_sub_title(){
        return 'Attributes';
    }


    public function tarm_form_output($errors){
        $this->tarm_html_out_put($errors, 'stor-tarms');
    }

    public function tarm_edit_form_output($value = '', $errors) {
        $value = json_decode(json_encode($value),true);
        $this->tarm_html_out_put($errors, 'edit-tarm-update', [
            'id' => $value['id'],
            'cat_name' => $value['tarm-name'],
            'cat_slug' => $value['tarm-slug'],
            'cat_description' => $value['description'],
        ], 'patch');
    }

    public function tarm_html_out_put($errors, $route, $value = "", $methos = 'POST'){
        $routeid = 'product-attr';
        if (empty($value) === false) {
            $routeid = $value['id'];
        }
        echo Form::open(['url' => route($route, $routeid), 'method' => $methos]); 
            text_field([
                'name' => 'cat_name',
                'title' => 'Attribute Name',
                'value' => (empty($value['cat_name']) === false) ? $value['cat_name'] : old('cat_name') ,
                'atts' =>  ['placeholder' => 'Attribute Name', 'class' => 'form-control']
            ], $errors);

            text_field([
                'name' => 'cat_slug',
                'title' => 'Attribute Slug',
                'value' => (empty($value['cat_slug']) === false) ? $value['cat_slug'] : old('cat_slug') ,
                'atts' =>  ['placeholder' => 'Attribute Slug', 'class' => 'form-control']
            ], $errors);

            textarea_field([
                'name' => 'cat_description',
                'title' => 'Attribute Description',
                'value' => (empty($value['cat_description']) === false) ? $value['cat_description'] : old('cat_description') ,
                'atts' =>  ['placeholder' => 'Attribute Description','class' => 'form-control']
            ], $errors);

                
            if (empty($value) === false) {
                do_action('product_attribute_meta', [
                    'tarm_id' => $value['id'],
                    'errors' => $errors,
                ]);
            }else{
                do_action('product_attribute_meta', $errors);
            }
            echo    Form::submit('Save', ['class' => 'btn bg-olive btn-flat',]);
        echo Form::close();
    }

    public function tarm_data_process($request, $tarm_type){
        $this->tarm_validation($request->all())->validate();        
        do_action('product_attribute_meta_validation', $request->all());
        return $this->tarm_data_save($request, $tarm_type);
    }

    public function tarm_validation($data){
        return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,100}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,100}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
            ], [
                'cat_name.regex'    => 'The Attribute name format is invalid.',
                'cat_name.required' => 'The Attribute name field is required.',
                'cat_name.max'      => 'The Attribute name may not be greater than 255 characters.',
                'cat_name.unique'   => 'The Attribute name has already been taken.',
                'cat_name.string'   => 'The Attribute name must be given string.',

                'cat_slug.regex'    => 'The Attribute slug format is invalid.',
                'cat_slug.required' => 'The Attribute slug field is required.',
                'cat_slug.max'      => 'The Attribute slug may not be greater than 255 characters.',
                'cat_slug.unique'   => 'The Attribute slug has already been taken.',
                'cat_slug.string'   => 'The Attribute slug must be given string.',
            ]);
    }

    public function tarm_data_save($data, $tarm_type){
        $data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
        $id = DB::table('tarms')->insertGetId([
            'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
            'tarm-name' => sanitize_text($data['cat_name']),
            'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
            'tarm-type' => sanitize_text('product-attr'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        if ($id) {
            do_action('product_attribute_meta_save', $data);
            return redirect()->back()->with('success_msg', 'Attribute create successful.');
        }
        return redirect()->back()->with('error_msg', 'Operation failed.');
    }


    public function all_tarms_out_put(){
        
        ?>
          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', 'product-attr'); ?>' tarms-data='<?php echo json_encode([
            ['data' => 'tarm-name'],
            ['data' => 'tarm-slug'],
            [
                'data'       => 'action',
                'searchable' => 'false',
                'orderable'  => 'false',
            ]
        ]);?>'>
            <thead>
              <tr>
                <th>Attribute name</th>
                <th>Attribute Slug</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Attribute name</th>
                <th>Attribute Slug</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
        <?php
    }

    public function tarm_data_for_datatable($tarm_type){
        return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', 'product-attr'))
        ->addColumn('action', function ($tarm) {
            return '<a href="'.route('product_attr', $tarm->id).'" class="btn bg-olive btn-flat">Add items</a>

            <a href="'.route('edit-tarm', [$tarm->id, 'product-attr']).'/" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete this?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('delete-tarm', $tarm->id).'" class="btn bg-maroon btn-flat">Delete</a>';
        })        
        ->escapeColumns(['*'])
        ->make(true);
    }


    public function tarm_edit_validation($data, $tarm_id){
        return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
                'cat_name.regex'    => 'The Attribute name format is invalid.',
                'cat_name.required' => 'The Attribute name field is required.',
                'cat_name.max'      => 'The Attribute name may not be greater than 255 characters.',
                'cat_name.unique'   => 'The Attribute name has already been taken.',
                'cat_name.string'   => 'The Attribute name must be given string.',

                'cat_slug.regex'    => 'The Attribute slug format is invalid.',
                'cat_slug.required' => 'The Attribute slug field is required.',
                'cat_slug.max'      => 'The Attribute slug may not be greater than 255 characters.',
                'cat_slug.unique'   => 'The Attribute slug has already been taken.',
                'cat_slug.string'   => 'The Attribute slug must be given string.',
            ]);
    }


    public function tarm_edit_data_update($data, $tarm_id){
        $data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
        $data = DB::table('tarms')
                    ->where('id',  $tarm_id)
                    ->update([
                        'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
                        'tarm-name' => sanitize_text($data['cat_name']),
                        'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
                        'updated_at' => new \DateTime(),
                    ]);
        do_action('product_attributes_meta_update', $tarm_id);
        return redirect()->back()->with('success_msg', 'Update successful.');
    }



}