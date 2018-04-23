<?php 
namespace Modules\Workdiaryblog\Entities;
use App\post_type;
use App\UserModel;
use App\UserPermission;
use App\mediaModel;
use App\BlogPost;
use App\TarmModel;
use Form;
use DB;
use Validator;
use Purifier;
use DataTables;
use Carbon;

class work extends post_type
{
	
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    private $tarmmodel = '';

	function __construct(){
		parent::__construct();

        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
        $this->tarmmodel    = new TarmModel();  

	}
    public function post_type_setting(){
      return [
        'add_new_title'            => 'Add New Work',
        'all_post_title'            => 'All Works',
        'edit_post_title'            => 'Edit Work',
        'page_sub_title'        => 'Work',
      ];
    }

  public function post_content_output($error_msg = ''){
    $this->post_type_output(route('stor_post', ['work']), $error_msg);
  } 

  public function post_type_edit_output($data, $error_msg){
  	$meta = $this->postmodel->get_all_post_metas($data->id);
      $this->post_type_output(
        route('post_type_update', [$data->id, 'work']), 
        $error_msg, [
          'work_title' => $data->post_title,
          'post_id' => $data->id,
          'work_slug' => $data->post_slug,
          'work_content' => $data->post_content,
          'status' => $data->status,
          'source_code_link' => (empty($meta['source_code_link']) === false) ? $meta['source_code_link'] : '' ,
          'source_code_link_text' => (empty($meta['source_code_link_text']) === false) ? $meta['source_code_link_text'] : '' ,
          'work_image' => (empty($meta['work_image']) === false) ? $meta['work_image'] : '' ,
          'work_series' => (empty($meta['work_series']) === false) ? explode(',', $meta['work_series']) : '' ,
          'work_tags' => (empty($meta['work_tags']) === false) ? explode(',', $meta['work_tags']) : '' ,
          'work_category' => (empty($meta['work_category']) === false) ? explode(',', $meta['work_category']) : '' ,
        ]);
    }


  public function post_type_edit_data_process($request, $post_type, $post_id){
    $this->post_type_edit_validation($request->all(), $post_id)->validate();
    do_action('work_validation', $request->all());
    return $this->post_type_edit_data_uppdate( $request, $post_id, $post_type);
  }

  public function post_type_edit_validation($request , $post_id){
      return $this->post_type_validation($request);
  }



  public function post_type_output( $route, $error_msg , $value = '' ){
    if (empty($value) === false) {
      $method = 'PATCH';
    }else{
      $method = 'POST';
    }
    echo Form::open(['url' =>  $route, 'method' => $method]);
?>
	<div class="row">
		<div class="col-md-8">
			<?php heml_card_open('fa fa-pencil', 'Work Titile'); ?>

				<?php echo text_field([
				                    'name' => 'work_title',
				                    'title' => 'Work title',
				                    'value' => (empty($value['work_title']) === false) ? $value['work_title'] : old('work_title'),
				                    'atts' =>  [
				                      'placeholder' => 'Work title',
				                      'class' => 'form-control',
				                    ]
				                  ], $error_msg);

				    if (empty($value) === false) {

				      post_type_slug_checker(route('chack-slug'), $value['work_slug'], [
				          'title' => 'work slug',
				          'atts'  => [
				            'data-post-id' => $value['post_id']
				          ]
				      ]);

				    }
				?>
							<?php heml_card_close(); ?>

			<?php heml_card_open('fa fa-pencil', 'Work Content'); ?>

			  <?php
			        textarea_editor([
			            'name' => 'work_content',
			            'title' => 'Description',
			            'value' => (empty($value['work_content']) === false) ? $value['work_content'] : old('work_content'),
			            'atts' =>  [
			              'style' => 'min-height:600px;width:100%;'
			              ]
			          ], $error_msg); 
			    ?>    

			<?php heml_card_close(); ?>

<?php 
//************************************************
//Work Meta
//************************************************
 ?>

			<?php heml_card_open('fa fa-pencil', 'Work Meta'); ?>
			  <?php
			        url_field([
			            'name' => 'source_code_link',
			            'title' => 'Source code link',
			            'value' => (empty($value['source_code_link']) === false) ? $value['source_code_link'] : old('source_code_link'),
			            'atts' =>  [
			              'placeholder' => 'Source code link',
			              'class' => 'form-control',
			              ]
			          ], $error_msg); 
			    ?>    
			  <?php
			        text_field([
			            'name' => 'source_code_link_text',
			            'title' => 'Source code link text',
			            'value' => (empty($value['source_code_link_text']) === false) ? $value['source_code_link_text'] : old('source_code_link_text'),
			            'atts' =>  [
			              'placeholder' => 'Source code link text',
			              'class' => 'form-control',
			              ]
			          ], $error_msg); 
			    ?>    
			<?php heml_card_close(); ?>


		</div>
		<div class="col-md-4">
			<?php heml_card_open('fa fa-pencil', 'Work Status'); ?>
                <?php select_field([
                    'name' => 'status',
                    'title' => 'Status',
                    'value' => (empty($value['status']) === false) ? $value['status'] : old('status'),
                    'atts' =>  [ 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                      ],
                    'items' =>  [   
                      '1' => 'Publish',                   
                      '0' => 'Pending',
                      '2' => 'Trush',
                      '3' => 'Poned',
                    ],
                  ], $error_msg); ?>

                  <?php echo Form::submit('Publish', ['class' => 'btn bg-olive btn-flat pull-right']); ?>
			<?php heml_card_close(); ?>

      		<?php heml_card_open('fa fa-pencil', 'Work tags'); ?>
                <?php echo  select_field([
                    'name' => 'work_tags[]',
                    'title' => 'Work Tags',
                    'value' => (empty($value['work_tags']) === false) ? $value['work_tags'] : old('work_tags'),
                    'atts' =>  [
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                        'multiple' => 'multiple',
                      ],
                    'items' =>  $this->get_post_type_tarm([
                          'tarm-type' => 'tags'
                        ]),
                  ], $error_msg); ?>
            <?php heml_card_close(); ?>

			<?php heml_card_open('fa fa-pencil', 'Work categorys'); ?>
				<?php select_field([
					'name' => 'work_category[]',
					'title' => 'Category',
					'value' => (empty($value['work_category']) === false) ? $value['work_category'] : old('work_category'),
					'atts' =>  [
						'class' => 'form-control select2', 
						'style' => 'width: 100%;',
						'multiple' => 'multiple',
					],
						'items' =>  $this->get_post_type_tarm([
						'tarm-type' => 'work-category'
					]),
					], $error_msg); ?>
			<?php heml_card_close(); ?>

			<?php heml_card_open('fa fa-pencil', 'Work series'); ?>
				<?php select_field([
					'name' => 'work_series[]',
					'title' => 'Work series',
					'value' => (empty($value['work_series']) === false) ? $value['work_series'] : old('work_series'),
					'atts' =>  [
						'class' => 'form-control select2', 
						'style' => 'width: 100%;',
						'multiple' => 'multiple',
					],
						'items' =>  $this->get_post_type_tarm([
						'tarm-type' => 'work-series'
					]),
					], $error_msg); ?>
			<?php heml_card_close(); ?>


              <?php heml_card_open('fa fa-image', 'Work image'); ?>
                <?php media_uploader([
	                'name' => 'work_image',
	                'title' => 'Upload Image',
	                'value' => (empty($value['work_image']) === false) ? $value['work_image'] : old('work_image'),
	                'atts' =>  [
	                'class'      => 'btn bg-purple btn-flat media_uploader_active'
	                ]
                	], $error_msg); ?>
              <?php heml_card_close(); ?>

		</div>
	</div>
<?php echo Form::close();
  }


	public function post_type_validation($data){
	  return Validator::make($data, [
	            'work_title'      => 'required|string|max:255',
	            'work_content'    => 'nullable|string',
	            'status'     	  => 'required|integer',
	            'source_code_link'     	  => 'nullable|url',
	            'source_code_link_text'     	  => 'nullable|string|max:50',
	            'work_tags'     	  => 'nullable|array',
	            'work_category'     	  => 'nullable|array',
	            'work_series'     	  => 'nullable|array',
	            'work_image'     	  => 'nullable|integer',
	        ]);
	}


  public function post_type_data_process($request, $post_type){
    $this->post_type_validation($request->all())->validate();    
    do_action('work_validation', $request->all());    
    return $this->post_type_data_save($request, $post_type);
  }

  public function post_type_data_save($data, $post_type) {
    $current_user      = $this->usermodel->current_user(); 
    $data['work_slug'] = $this->postmodel->slug_format($data['work_title']);
    if (isset($data['work_tags'])) {
      $data['work_tags']      = implode(',', $data['work_tags']);
    }
    if (isset($data['work_category'])) {
      $data['work_category']  = implode(',', $data['work_category']);
    }      
    if (isset($data['work_series'])) {
      $data['work_series']  = implode(',', $data['work_series']);
    }   

      $id = DB::table('posts')->insertGetId([
        'post_title'   => sanitize_text($data['work_title']),
        'status'  => (int)$data['status'],
        'post_slug'    => sanitize_text(strtolower($data['work_slug'])),
        'post_author'  => (int)$current_user['id'],
        'post_content' => Purifier::clean($data['work_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'post_type'    => 'work',
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
      ]);
      if ($id) {
        $this->postmodel->update_post_meta($id, 'source_code_link', sanitize_url($data['source_code_link']));
        $this->postmodel->update_post_meta($id, 'source_code_link_text', sanitize_text($data['source_code_link_text']));
        $this->postmodel->update_post_meta($id, 'work_tags', sanitize_text($data['work_tags'] ));
        $this->postmodel->update_post_meta($id, 'work_category', sanitize_text($data['work_category']));
        $this->postmodel->update_post_meta($id, 'work_series', sanitize_text($data['work_series']));
        $this->postmodel->update_post_meta($id, 'work_image', (int)$data['work_image']);
        do_action('work_save', $id);
        return redirect()->route('edit_post_type', [$id, 'work'])->with('success_msg', 'Work create successful.');
      }
      return redirect()->back()->with('error_msg', 'Failed to create Work.');
  }


  public function post_type_edit_data_uppdate($data , $post_id, $post_type){
    $current_user      = $this->usermodel->current_user(); 
    $data['work_slug'] = $this->postmodel->slug_format($data['post_slug'], $post_id);
    if (isset($data['work_tags'])) {
      $data['work_tags']      = implode(',', $data['work_tags']);
    }
    if (isset($data['work_category'])) {
      $data['work_category']  = implode(',', $data['work_category']);
    }      
    if (isset($data['work_series'])) {
      $data['work_series']  = implode(',', $data['work_series']);
    }   


      DB::table('posts')
      ->where('id', $post_id)
      ->where('post_type', $post_type)
      ->update([
        'post_title'   => sanitize_text($data['work_title']),
        'status'        => (int)$data['status'],
        'post_slug'    => sanitize_text($data['work_slug']),
        'post_content' => Purifier::clean($data['work_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )),
        'updated_at' => new \DateTime(),
      ]);

    $this->postmodel->update_post_meta($post_id, 'source_code_link', sanitize_url($data['source_code_link']));
    $this->postmodel->update_post_meta($post_id, 'source_code_link_text', sanitize_text($data['source_code_link_text']));
    $this->postmodel->update_post_meta($post_id, 'work_tags', sanitize_text($data['work_tags'] ));
    $this->postmodel->update_post_meta($post_id, 'work_category', sanitize_text($data['work_category']));
    $this->postmodel->update_post_meta($post_id, 'work_series', sanitize_text($data['work_series']));
    $this->postmodel->update_post_meta($post_id, 'work_image', (int)$data['work_image']);

      do_action('work_save', $post_id);
      return redirect()->back()->with('success_msg', 'Work Update successful.');

  }
  

  public function show_all_post_type_output(){
   ?>
<?php echo heml_card_open('fa fa-user', 'All works'); ?>

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="<?php echo route('get-all-posts', 'work'); ?>"
            tarms-data='<?php echo json_encode([
                            ['data' => 'post_title'],
                            ['data' => 'post_author'],
                            [
                              'data'     => 'created_at',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data' => 'status',
                              'searchable' => 'true',
                              'orderable'  => 'false',
                            ],
                           [
                             'data'     => 'action',
                             'searchable' => 'false',
                             'orderable'  => 'false',
                           ]
                          ]); ?>'
          >
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>

<?php echo heml_card_close(); ?>

   <?php
  }


  public function get_post_for_datatable($data_query = array()){
      
      $post_query = DB::table('posts')->select('id','post_title', 'post_slug', 'post_content', 'status', 'post_type', 'post_author', 'created_at')->where('post_type','work');
    return DataTables::of($post_query)    
    ->addColumn('post_author', function ($post) {
      $author = $this->usermodel->get_user($post->post_author);
            if ($author) {
              return '<a href="'.route('user.edit', $author->id).'" class="label label-info">'.$author->fname.' '.$author->lname.'</a>';
            }

        })   
    ->addColumn('status', function ($post) {

            return format_status_tag($post->status, [
              'info'    => '3',
              'success' => '1',
              'warning' => '0',
              'danger'  => '2',
            ]);

        })   
    ->addColumn('created_at', function ($post) {
            return '<small class="label label-info">'.Carbon\Carbon::parse($post->created_at)->format('Y/m/d - h:i').'</small>';
        })
    ->addColumn('action', function ($post) {
            return '<a href="'.route('edit_post_type', [$post->id, 'work']).'" class="btn bg-purple btn-flat">Edith</a> 
              <a target="_blank" href="" class="btn bg-navy btn-flat margin">View</a>
            <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('post_type_delete', [$post->id, 'work']).'" class="btn bg-maroon btn-flat margin">Delete</a>';
        })
    ->escapeColumns(['*'])
    ->make(true);

  }



}