<?php

namespace Modules\Workdiaryblog\Entities;

use App\TarmModel;
use App\mediaModel;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use DataTables;

class work_series extends TarmModel
{

	public function pate_tab_title(){
    	return 'Work Series';
    }
    public function pate_title(){
    	return 'Add Work Series';
    }
    public function page_icon(){
    	return 'fa fa-pencil';
    }

    public function pate_sub_title(){
        return 'Work Series';
    }

    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-tarms', 'work-series'), 'method' => 'POST']); 
			text_field([
				'name' => 'series_name',
				'title' => 'Series Name',
				'value' => old('series_name'),
				'atts' =>  [
                    'placeholder' => 'Series Name',
                    'class' => 'form-control'
                ]
			], $errors);

			text_field([
				'name' => 'series_slug',
				'title' => 'Series Slug',
				'value' => old('series_slug'),
				'atts' =>  [
                    'placeholder' => 'Series Slug',
                    'class' => 'form-control'
                ]
			], $errors);

			textarea_field([
				'name' => 'description',
				'title' => 'Description',
				'value' => old('description'),
				'atts' =>  [
                    'placeholder' => 'Description',
                    'class' => 'form-control'
                ]
			], $errors);
			do_action('work_series_meta', $errors);
			echo Form::submit('Add tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function tarm_data_process($request, $tarm_type){
    	$this->tarm_validation($request->all())->validate();    	
    	do_action('work_series_meta_validation', $request->all());
    	return $this->tarm_data_save($request, $tarm_type);
    }

    public function tarm_validation($data){
    	$cur_user = Auth::user();

    	return Validator::make($data, [
                'series_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'series_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'description'      => 'nullable',
            ], [
			    'series_name.regex' 	=> 'The Series name format is invalid.',
			    'series_name.required' => 'The Series name field is required.',
			    'series_name.max' 		=> 'The Series name may not be greater than 255 characters.',
			    'series_name.unique' 	=> 'The Series name has already been taken.',
			    'series_name.string' 	=> 'The Series name must be given string.',

			    'series_slug.regex' 	=> 'The Series slug format is invalid.',
			    'series_slug.required' => 'The Series slug field is required.',
			    'series_slug.max' 		=> 'The Series slug may not be greater than 255 characters.',
			    'series_slug.unique' 	=> 'The Series slug has already been taken.',
			    'series_slug.string' 	=> 'The Series slug must be given string.',
			]);
    }

    public function tarm_data_save($data, $tarm_type){
    	$data['series_slug'] = sunatize_slug_text($data['series_slug']);
    	$id = DB::table('tarms')->insertGetId([
    		'tarm-slug' => sanitize_text(strtolower($data['series_slug'])),
    		'tarm-name' => sanitize_text($data['series_name']),
    		'description' => Purifier::clean($data['description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
    		'tarm-type' => sanitize_text($tarm_type),
    		'created_at' => new \DateTime(),
    		'updated_at' => new \DateTime(),
    	]);
    	if ($id) {
    		do_action('work_series_meta_save', $data);
    		return redirect()->back()->with('success_msg', 'Series create successful.');
    	}
    	return redirect()->back()->with('error_msg', 'Operation failed.');
    }



    public function all_tarms_out_put(){
    	
		?>
	      <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', 'work-series'); ?>' tarms-data='<?php echo json_encode([
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
	            <th>Series name</th>
	            <th>Series Slug</th>
	            <th>Actions</th>
	          </tr>
	        </thead>
	        <tfoot>
	          <tr>
	            <th>Series name</th>
	            <th>Series Slug</th>
	            <th>Actions</th>
	          </tr>
	        </tfoot>
	      </table>
		<?php
    }

    public function tarm_edit_form_output($value = '', $errors) {
    	$value = json_decode(json_encode($value),true);
		echo Form::open(['url' => route('edit-tarm-update', [$value['id'], 'work-series']), 'method' => 'PATCH']);
			text_field([
				'name' => 'series_name',
				'title' => 'Series Name',
				'value' => $value['tarm-name'],
				'atts' =>  [
                    'placeholder' => 'Series Name', 
                    'class' => 'form-control'
                ]
			], $errors);

			text_field([
				'name' => 'series_slug',
				'title' => 'Series Slug',
				'value' => $value['tarm-slug'],
				'atts' =>  [
                    'placeholder' => 'Series Slug', 
                    'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'description',
				'title' => 'Description',
				'value' => $value['description'],
				'atts' =>  [
                    'placeholder' => 'Description',
                    'class' => 'form-control'
                ]
			], $errors);

			do_action('work_series_meta_edit', [
                'tarm_id' => $value['id'],
                'errors' => $errors,
            ]);
			echo 	Form::submit('Update tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function tarm_edit_data_process($request, $tarm_id ) {
    	$this->tarm_edit_validation($request->all(), $tarm_id)->validate();	
    	do_action('work_series_meta_edit_validation', $request->all());
    	return $this->tarm_edit_data_update($request, $tarm_id);
    }

    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'series_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'series_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'description'      => 'nullable',
            ], [
			    'series_name.regex' 	=> 'The Series name format is invalid.',
			    'series_name.required' => 'The  Series name field is required.',
			    'series_name.max' 		=> 'The Series name may not be greater than 255 characters.',
			    'series_name.unique' 	=> 'The Series name has already been taken.',
			    'series_name.string' 	=> 'The Series name must be given string.',

			    'series_slug.regex' 	=> 'The Series slug format is invalid.',
			    'series_slug.required' => 'The  Series slug field is required.',
			    'series_slug.max' 		=> 'The Series slug may not be greater than 255 characters.',
			    'series_slug.unique' 	=> 'The Series slug has already been taken.',
			    'series_slug.string' 	=> 'The Series slug must be given string.',
			]);
    }

    public function tarm_data_for_datatable($tarm_type){
        return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', $tarm_type))
        ->addColumn('action', function ($tarm) {
            return '<a href="'.route('edit-tarm', [$tarm->id, 'work-series']).'/" class="btn bg-purple btn-flat">Edith</a> <a

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
    public function tarm_edit_data_update($data, $tarm_id){
        $data['series_slug'] = sunatize_slug_text($data['series_slug']);
    	DB::table('tarms')
                    ->where('id',  $tarm_id)
                    ->update([
			    		'tarm-slug' => sanitize_text(strtolower($data['series_slug'])),
			    		'tarm-name' => sanitize_text($data['series_name']),
			    		'description' => Purifier::clean($data['description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
			    		'updated_at' => new \DateTime(),
                    ]);
        do_action('work_series_meta_edit_update', $tarm_id);
    	return redirect()->back()->with('success_msg', 'Update successful.');
    }


}
