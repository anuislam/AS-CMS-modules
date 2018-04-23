<div class="slider_section all_area">
    <div class="container">
        <div class="row">
           <div class="col-sm-12">
                <div id="slider_one" class="owl-carousel owl-theme">              
                @if(count($latest_works) > 0)
                    @foreach($latest_works as $work_key => $work_value)
                    @php
                        $work_meta  = $work_meta->get_all_post_metas($work_value->id);
                        $image      = $media->get_image_src('slider_image', @$work_meta['work_image']);
                    @endphp
                        <div class="item">
                            <figure>
                                <a href="{!! 'route();' !!}"><img width="400" height="200" src="{!! $image[0] !!}" class="attachment-workdiary_work_image size-workdiary_work_image wp-post-image" alt="{{$work_value->post_title}}" /></a>
                            </figure>
                            <article>
                               <a href="{!! 'route();' !!}"><h4>{!! read_more(8, $work_value->post_title) !!}...</h4></a>
                                <p>{!! read_more(25, $work_value->post_content) !!}</p>
                            </article>
                        </div>   
                    @endforeach
                @endif       
                </div>
            </div>
        </div>
    </div>
</div>
