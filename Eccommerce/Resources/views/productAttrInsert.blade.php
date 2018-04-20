@extends('layouts.dashboard')

@section('dashboard_tab_title')
Adding Product Attributes
@endsection



@section('dashboard_content')
    <section class="content-header">
      <h1>
        Adding Product 
        <small>Attributes</small>
      </h1>
       {{ Breadcrumbs::render('product-attr') }}
    </section>

  <section class="content">
        @if(Session::get('error_msg'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ Session::get('error_msg') }}
        </div>

        @endif

        @if(Session::get('success_msg'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ Session::get('success_msg') }}
              </div>
        @endif
        
    <div class="row">
      <div class="col-md-5">

{{ heml_card_open('fa fa-pencil', 'Adding Product Attribute') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     

  
        {!! Form::open(['url' => route('product_attr_item_create', $tarm_id), 'method' => 'post']) !!} 
            {{ text_field([
                'name' => 'item_name',
                'title' => 'Item Name',
                'value' => (empty($value['item_name']) === false) ? $value['item_name'] : old('item_name') ,
                'atts' =>  ['placeholder' => 'Item Name', 'class' => 'form-control']
            ], $errors) }}

            {{ text_field([
                'name' => 'item_slug',
                'title' => 'Item Slug',
                'value' => (empty($value['item_slug']) === false) ? $value['item_slug'] : old('item_slug') ,
                'atts' =>  ['placeholder' => 'Item Slug', 'class' => 'form-control']
            ], $errors) }}

            {{ textarea_field([
                'name' => 'item_description',
                'title' => 'Item Description',
                'value' => (empty($value['item_description']) === false) ? $value['item_description'] : old('item_description') ,
                'atts' =>  ['placeholder' => 'Item Description','class' => 'form-control']
            ], $errors) }}
            {!! Form::submit('Save', ['class' => 'btn bg-olive btn-flat',]) !!}
        {!! Form::close() !!}
              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
      
      <div class="col-md-7">

{{ heml_card_open('fa fa-pencil', 'All Product Attributes') }}

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('product_attr_items_datatable', $tarm_id); ?>' tarms-data='<?php echo json_encode([
                  ['data' => 'item_name'],
                  ['data' => 'item_slug'],
                  [
                      'data'       => 'action',
                      'searchable' => 'false',
                      'orderable'  => 'false',
                  ]
              ]);?>'>
                  <thead>
                    <tr>
                      <th>Item name</th>
                      <th>Item Slug</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Item name</th>
                      <th>Item Slug</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>
</section>
@endsection