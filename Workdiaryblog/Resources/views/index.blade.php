@extends('workdiaryblog::layouts.master')



@section('page_title')
    Hello World    
@stop

@section('content')

	@include('workdiaryblog::inc.carousel')

	<div class="add_space"></div>

    <div class="content_area all_area">
        <div class="container">
           <div class="row">
             <div class="col-sm-12">                 
              <h2 class="heading" >Work category</h2>
             </div>
               <div class="add_space"></div>  
			</div>

			<div class="add_draw"></div>
			<div class="add_space"></div>

            <div class="row">
@php
 $post_tarm = $tarmmodel->get_tarm_query(['tarm-type' => 'work-category' ]);
@endphp

@foreach($post_tarm as $tarm)
@php
$tarm = json_decode(json_encode($tarm),true);
$tarmmeta = $tarmmodel->get_tarm_meta($tarm['id'], 'cat_image');
$image      = $media->get_image_src('slider_image', @$tarmmeta);
@endphp
                <div class="col-sm-4">
                    <figure class="work_category">
                        <a href="{!! 'route()' !!}"><img src="{!! $image[0] !!}" alt="php"></a>
                        <figcaption>
                            <a href="{!! 'route()' !!}"><h3 class="work_title">{{$tarm['tarm-name']}}</h3></a>
                            <p>{!! $tarm['description'] !!}</p>
                        </figcaption>
                    </figure>
                </div>
@endforeach


            </div>   
           
        </div>
    </div>

@stop
