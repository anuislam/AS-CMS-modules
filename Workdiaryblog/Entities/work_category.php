<?php

namespace Modules\Workdiaryblog\Entities;

use App\TarmModel;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use DataTables;
use App\mediaModel;

class work_category extends TarmModel
{
    private $media = '';
    function __construct()
    {
       parent::__construct();
       $this->media = new mediaModel();
    }

	public function pate_tab_title(){
    	return 'Work Category';
    }
    public function pate_title(){
    	return 'Add Work Category';
    }
    public function page_icon(){
    	return 'fa fa-pencil';
    }
    public function pate_sub_title(){
        return 'Work Category';
    }
    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-tarms', 'work-category'), 'method' => 'POST']); 
			text_field([
				'name' => 'cat_name',
				'title' => 'Work Category Name',
				'value' => old('cat_name'),
				'atts' =>  [
                    'placeholder' => 'Work Category Name',
                    'class' => 'form-control'
                ]
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Work Category Slug',
				'value' => old('cat_slug'),
				'atts' =>  [
                    'placeholder' => 'Tag Slug', 
                    'class' => 'form-control'
                ]
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Work Category Description',
				'value' => old('cat_description'),
				'atts' =>  [
                    'placeholder' => 'Tag Description', 
                    'class' => 'form-control'
                ]
			], $errors);

            media_uploader([
                'name' => 'cat_image',
                'title' => 'Upload Image',
                'value' => old('cat_image'),
                'atts' =>  [
                    'class'      => 'btn bg-purple btn-flat media_uploader_active'
                ]
                ], $errors); 

			do_action('wdb_work_cat_meta', $errors);
			echo 	Form::submit('Add tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function tarm_data_process($request, $tarm_type){
    	$this->tarm_validation($request->all())->validate();    	
    	do_action('wdb_work_cat_meta_validation', $request->all());
    	return $this->tarm_data_save($request, $tarm_type);
    }

    public function tarm_validation($data){
    	$cur_user = Auth::user();

    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
                'cat_image'      => 'nullable|integer',
            ], [
			    'cat_name.regex' 	=> 'The Work Category name format is invalid.',
			    'cat_name.required' => 'The Work Category name field is required.',
			    'cat_name.max' 		=> 'The Work Category name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The Work Category name has already been taken.',
			    'cat_name.string' 	=> 'The Work Category name must be given string.',

			    'cat_slug.regex' 	=> 'The Work Category slug format is invalid.',
			    'cat_slug.required' => 'The Work Category slug field is required.',
			    'cat_slug.max' 		=> 'The Work Category slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The Work Category slug has already been taken.',
                'cat_slug.string'   => 'The Work Category slug must be given string.',

			    'cat_image.integer' 	=> 'The Work Category image must be given integer.',
			]);
    }

    public function tarm_data_save($data, $tarm_type){
    	$data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
    	$id = DB::table('tarms')->insertGetId([
    		'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
    		'tarm-name' => sanitize_text($data['cat_name']),
    		'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
    		'tarm-type' => sanitize_text('work-category'),
    		'created_at' => new \DateTime(),
    		'updated_at' => new \DateTime(),
    	]);
    	if ($id) {
    		do_action('wdb_work_cat_meta_save', $data);
            $this->update_tarm_meta($id, 'cat_image', (int)$data['cat_image']);
    		return redirect()->back()->with('success_msg', 'Work Category create successful.');
    	}
    	return redirect()->back()->with('error_msg', 'Operation failed.');
    }



    public function all_tarms_out_put(){
    	
		?>
	      <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', 'work-category'); ?>' tarms-data='<?php echo json_encode([
            ['data' => 'image'],
    		['data' => 'tarm-name'],
    		['data' => 'tarm-slug'],
    		[
    			'data' 		 => 'action',
    			'searchable' => 'false',
    			'orderable'  => 'false',
    		]
    	]);?>'>
	        <thead>
	          <tr>
                <th>Image</th>
	            <th>Tag name</th>
	            <th>Tag Slug</th>
	            <th>Actions</th>
	          </tr>
	        </thead>
	        <tfoot>
	          <tr>
                <th>Image</th>
	            <th>Tag name</th>
	            <th>Tag Slug</th>
	            <th>Actions</th>
	          </tr>
	        </tfoot>
	      </table>
		<?php
    }



    public function tarm_edit_form_output($value = '', $errors) {
    	$value = json_decode(json_encode($value),true);
		echo Form::open(['url' => route('edit-tarm-update', [$value['id'], 'work-category']), 'method' => 'PATCH']);

            text_field([
                'name' => 'cat_name',
                'title' => 'Work Category Name',
                'value' => $value['tarm-name'],
                'atts' =>  [
                    'placeholder' => 'Work Category Name',
                    'class' => 'form-control'
                ]
            ], $errors);

            text_field([
                'name' => 'cat_slug',
                'title' => 'Work Category Slug',
                'value' => $value['tarm-slug'],
                'atts' =>  [
                    'placeholder' => 'Tag Slug', 
                    'class' => 'form-control'
                ]
            ], $errors);

            textarea_field([
                'name' => 'cat_description',
                'title' => 'Work Category Description',
                'value' => $value['description'],
                'atts' =>  [
                    'placeholder' => 'Tag Description', 
                    'class' => 'form-control'
                ]
            ], $errors);

            media_uploader([
                'name' => 'cat_image',
                'title' => 'Upload Image',
                'value' => $this->get_tarm_meta($value['id'], 'cat_image'),
                'atts' =>  [
                    'class'      => 'btn bg-purple btn-flat media_uploader_active'
                ]
                ], $errors);


			do_action('wdb_work_cat_meta_edit', [
                'tarm_id' => $value['id'],
                'errors' => $errors,
            ]);
			echo 	Form::submit('Update tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function tarm_edit_data_process($request, $tarm_id ) {
    	$this->tarm_edit_validation($request->all(), $tarm_id)->validate();	
    	do_action('wdb_work_cat_meta_edit_validation', $request->all());
    	return $this->tarm_edit_data_update($request, $tarm_id);
    }


    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The Category name format is invalid.',
			    'cat_name.required' => 'The Category name field is required.',
			    'cat_name.max' 		=> 'The Category name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The Category name has already been taken.',
			    'cat_name.string' 	=> 'The Category name must be given string.',

			    'cat_slug.regex' 	=> 'The Category slug format is invalid.',
			    'cat_slug.required' => 'The Category slug field is required.',
			    'cat_slug.max' 		=> 'The Category slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The Category slug has already been taken.',
			    'cat_slug.string' 	=> 'The Category slug must be given string.',
			]);
    }

    public function tarm_data_for_datatable($tarm_type){
        return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', $tarm_type))
        ->addColumn('action', function ($tarm) {
            return '<a href="'.route('edit-tarm', [$tarm->id, 'work-category']).'/" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete this?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('delete-tarm', $tarm->id).'" class="btn bg-maroon btn-flat">Delete</a>';
        })      
        ->addColumn('image', function ($tarm) {
            return '<img src="'.$this->media->get_image_src('thumbnail', $this->get_tarm_meta($tarm->id, 'cat_image'))[0].'" alt="tarm">';
        }) 
        ->escapeColumns(['*'])
        ->make(true);
    }

    public function tarm_edit_data_update($data, $tarm_id){
        $data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
    	DB::table('tarms')
                    ->where('id',  $tarm_id)
                    ->update([
			    		'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
			    		'tarm-name' => sanitize_text($data['cat_name']),
			    		'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
			    		'updated_at' => new \DateTime(),
                    ]);

        $this->update_tarm_meta($tarm_id, 'cat_image', (int)$data['cat_image']);
        do_action('wdb_work_cat_meta_edit_update', $tarm_id);
    	return redirect()->back()->with('success_msg', 'Update successful.');
    }


}
