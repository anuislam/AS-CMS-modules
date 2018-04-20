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
      <div class="col-md-8">

{{ heml_card_open('fa fa-pencil', 'Adding Product Attribute') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     
  
        {!! Form::open(['url' => route('product_attr_items_update', $value->id), 'method' => 'put']) !!} 
            {{ text_field([
                'name' => 'item_name',
                'title' => 'Item Name',
                'value' => $value->item_name ,
                'atts' =>  ['placeholder' => 'Item Name', 'class' => 'form-control']
            ], $errors) }}

            {{ text_field([
                'name' => 'item_slug',
                'title' => 'Item Slug',
                'value' => $value->item_slug,
                'atts' =>  ['placeholder' => 'Item Slug', 'class' => 'form-control']
            ], $errors) }}

            {{ textarea_field([
                'name' => 'item_description',
                'title' => 'Item Description',
                'value' => $value->item_description ,
                'atts' =>  ['placeholder' => 'Item Description','class' => 'form-control']
            ], $errors) }}
            {!! Form::submit('Save', ['class' => 'btn bg-olive btn-flat',]) !!}
        {!! Form::close() !!}              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>
</section>
@endsection