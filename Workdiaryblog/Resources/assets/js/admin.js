jQuery(document).ready(function($){
    $('#workdiary-id').click(function(e) {
	    e.preventDefault();
	    var image = wp.media({
	        title: 'Upload Work Category Image',
	        // mutiple: true if you want to upload multiple files at once
	        multiple: false
	    }).open()
	    .on('select', function(e){
	        // This will return the selected image from the Media Uploader, the result is an object
	        var as_uploaded_image = image.state().get('selection').first();
	        // We convert uploaded_image to a JSON object to make accessing it easier
	        // Output to the console uploaded_image
	        // Let's assign the url value to the input field
	        console.log(as_uploaded_image.id);
	        $('input.workdiary_image').val(as_uploaded_image.id);
	        $('div.set_image').html('<img src="'+as_uploaded_image.toJSON().url+'" alt="#" />').show(0);
	    });
    });    

    $('#workdiary_social_default_image').click(function(e) {
	    e.preventDefault();
	    var image = wp.media({
	        title: 'Upload social share default Image',
	        // mutiple: true if you want to upload multiple files at once
	        multiple: false
	    }).open()
	    .on('select', function(e){
	        // This will return the selected image from the Media Uploader, the result is an object
	        var as_uploaded_image = image.state().get('selection').first();
	        // We convert uploaded_image to a JSON object to make accessing it easier
	        // Output to the console uploaded_image
	        // Let's assign the url value to the input field
	        console.log(as_uploaded_image.id);
	        $('input#workdiary_social_set_image').val(as_uploaded_image.id);
	        $('div.set_image').html('<img src="'+as_uploaded_image.toJSON().url+'" alt="#" />').show(0);
	    });
    });

    $('#workdiary_pro_image_default_image').click(function(e) {
	    e.preventDefault();
	    var image = wp.media({
	        title: 'Please Upload Your Profile Picture',
	        // mutiple: true if you want to upload multiple files at once
	        multiple: false
	    }).open()
	    .on('select', function(e){
	        // This will return the selected image from the Media Uploader, the result is an object
	        var as_uploaded_image = image.state().get('selection').first();
	        // We convert uploaded_image to a JSON object to make accessing it easier
	        // Output to the console uploaded_image
	        // Let's assign the url value to the input field
	        console.log(as_uploaded_image.id);
	        $('input#workdiary_pro_image').val(as_uploaded_image.id);
	        $('div.set_image').html('<img src="'+as_uploaded_image.toJSON().url+'" alt="#" />').show(0);
	    });
    });

    $('#workdiary_pro_image_remove_image').click(function(e) {
	    e.preventDefault();
        $('input#workdiary_pro_image').val('');
        $('div.set_image').hide(0);
	});

    wp.customize('workdiray_copy_text', function(workval){
    	workval.bind(function(get){
    		$("iframe").contents().find("#footer_main_copy_text").html(get);
    	});
    });


});