<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <meta name="keywords" content="keywords">
        <title>@yield('page_title') | page title</title>
        {!! do_action('site_header') !!}
        @yield('style')
    </head>
    <body>
<div class="workdiary_preloader" style="display: none;">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
</div>


    <div class="black_border"></div>
    <div class="header_aerea all_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <figure class="header_logo">
                            <a href="{!! url('/') !!}"><img src="http://woocommerceweb/wp-content/themes/workdiary/image/bg.png" alt="Woocommerce"></a>
                    </figure>                   
                    <!--<div class="header_logo">
                        <h2><a href="">Work daire</a></h2>
                    </div>-->
                </div>
                <div class="col-sm-6">
                   <form method="get" class="search_bar form-inline" action="http://woocommerceweb/">
                         <div class="form-group">
                            <input class="form-control" type="text" value="" name="s" placeholder="Search" > 
                            <input type="hidden" name="post_type" value="work_diary" >
                         </div>
                         <input type="submit" value="Search" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="menu_area all_area">
        <div class="container">
            <div class="row">
				@if($header_menu)
				<div id="mobile_menu" class="header_menu">
					<ul>
						@foreach($header_menu as $menu)
							<li><a href="{!! sanitize_url($menu->url) !!}">{{$menu->title}}</a></li>
						@endforeach
					</ul>
				</div>
				@endif
            </div>
        </div>
    </div>
    
    <div class="add_space"></div>

    @yield('content')



    <div class="add_space"></div>
    <div class="add_space"></div>

    <div class="footer_area_top all_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
            </div>            
            <div class="add_space"></div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--
                <div class="col-sm-4">
                    <div class="footer_link">
                        <ul>
                            <li><a href="">home</a></li>
                            <li><a href="">page</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                            <li><a href="">page one</a></li>
                        </ul>
                    </div>
                </div>
-->


    <div class="footer_area all_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p id="footer_main_copy_text" class="copy_text" >&copy;  Anu islam shohag</p>
                </div>
                <div class="col-sm-6">
                    <ul class="social_area">
                        <li><a href=""><span class="hb hb-xs"><i class="fa fa-facebook"></i></span></a></li>
                        <li><a href=""><span class="hb hb-xs"><i class="fa fa-twitter"></i></span></a></li>
                        <li><a href=""><span class="hb hb-xs"><i class="fa fa-google-plus"></i></span></a></li>
                        <li><a href=""><span class="hb hb-xs"><i class="fa fa-youtube"></i></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="black_border"></div>
<script>
	var global_site = {
		share_url : '{{ url('/') }}',
		share_text : 'some text'
	}
</script>
	{!! do_action('site_footer') !!}
	@yield('script')
    </body>
</html>
