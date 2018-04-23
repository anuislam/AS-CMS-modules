(function() {
    tinymce.PluginManager.add('wptuts', function( editor, url ) {
        editor.addButton('workdiary_shortcode', {
            text: 'All shortcode',
            icon: false,
            type: 'menubutton',
            
            menu: [
                {
                    text: 'Youtube',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Youtube Video Shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_youtube_id',
                                    label: 'Place Your Youtube Video id',
                                    value: '',
                                    minWidth: 300
                                },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[youtube]'+ e.data.workdiary_youtube_id+'[/youtube]');
                            }
                        } );
                    }
                },
                {
                    text: 'Insert code Sample',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Place Your code name',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_code_name',
                                    label: 'Place Your code name',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_code_s',
                                    label: 'Place Your code Sample',
                                    value: '',
                                    minWidth: 300,
                                    minHeight: 100,
                                    multiline: true
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[add_code type="'+
                                    e.data.workdiary_code_name
                                    +'"]'+
                                    e.data.workdiary_code_s
                                    +'[/add_code]');
                            }
                        } );
                    }
                },
                {
                    text: 'Add heading tag',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Place Your tag name and title',
                            body: [

                                {
                                    type: 'listbox',
                                    name: 'workdiary_tag_name',
                                    label: 'List Box',
                                    'values': [
                                        {text: 'H1', value: 'h1'},
                                        {text: 'H2', value: 'h2'},
                                        {text: 'H3', value: 'h3'},
                                        {text: 'H4', value: 'h4'},
                                        {text: 'H5', value: 'h5'},
                                        {text: 'H6', value: 'h6'}
                                    ]
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_tag_titile',
                                    label: 'Place title',
                                    value: '',
                                    minWidth: 300
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[heading tag="'+
                                        e.data.workdiary_tag_name
                                    +'"]'+
                                        e.data.workdiary_tag_titile
                                    +'[/heading]');
                            }
                        } );
                    }
                },

                {
                    text: 'Paragraph Tag',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Place Your Paragraph Tag',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_paragraph_tag',
                                    label: 'Place Your Paragraph Tag',
                                    value: '',
                                    minWidth: 400,
                                    minHeight: 200,
                                    multiline: true
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[paragraph_tag]'+

                                    e.data.workdiary_paragraph_tag

                                    +'[/paragraph_tag]');
                            }
                        } );
                    }
                },

                {
                    text: 'Add image',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Place Your image',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_sample_image',
                                    label: 'Place Your image url',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_sample_alt',
                                    label: 'Place Your image alt text',
                                    value: '',
                                    minWidth: 300
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[sample_image url="'+
                                        e.data.workdiary_sample_image
                                    +'" alt="'+
                                            e.data.workdiary_sample_alt
                                    +'"][/sample_image]');
                            }
                        } );
                    }
                },

                {
                    text: 'Anchor Tag',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Get Anchor Tag',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_anchor_tag_url',
                                    label: 'Place Your Anchor Tag url',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_anchor_tag_text',
                                    label: 'Place Your Anchor Tag Text',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'listbox',
                                    name: 'workdiary_anchor_tag_rel',
                                    label: 'Select Relation Attribute',
                                    'values': [
                                        {text: 'Nofollow', value: 'nofollow'},
                                        {text: 'Dofollow', value: 'dofollow'}
                                    ]
                                },

                                {
                                    type   : 'textbox',
                                    name: 'workdiary_anchor_tag_color',
                                    label: 'Place A Color Code',
                                    value: '#000000',
                                }
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[anchor_tag url="'+
                                        e.data.workdiary_anchor_tag_url
                                    +'" rel="'+
                                        e.data.workdiary_anchor_tag_rel
                                    +'" color="'+
                                        e.data.workdiary_anchor_tag_color
                                    +'"]'+
                                        e.data.workdiary_anchor_tag_text
                                    +'[/anchor_tag]');
                            }
                        } );
                    }
                },
                {
                    text: 'Add Source Code',
                    icon: false,                        
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Place Source Code format',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_img_url',
                                    label: 'Place Your Image URL',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_img_alt',
                                    label: 'Place Your Image ALT',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_title',
                                    label: 'Place Your Title',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_desc',
                                    label: 'Place Your Description',
                                    value: '',
                                    minWidth: 300,                                    
                                    minHeight: 200,
                                    multiline: true
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_download_text',
                                    label: 'Place Your Download Text',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_download_url',
                                    label: 'Place Your Download URL',
                                    value: '',
                                    minWidth: 300
                                },
                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_demo_text',
                                    label: 'Place Your Demo text',
                                    value: '',
                                    minWidth: 300
                                },

                                {
                                    type: 'textbox',
                                    name: 'workdiary_source_demo_url',
                                    label: 'Place Your Demo url',
                                    value: '',
                                    minWidth: 300
                                },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '[code_content img_url="'+
                                    e.data.workdiary_source_img_url
                                    +'" img_alt="'+
                                    e.data.workdiary_source_img_alt
                                    +'" title="'+
                                    e.data.workdiary_source_title
                                    +'" btn_url="'+
                                    e.data.workdiary_source_download_url
                                +'" btn_title="'+
                                e.data.workdiary_source_download_text
                                +'" demo_url="'+
                                e.data.workdiary_source_demo_url
                                +'" demo_title="'+
                                e.data.workdiary_source_demo_text
                                +'"]'+e.data.workdiary_source_desc+'[/code_content]');
                            }
                        } );
                    }
                },
            ]//menu end

        });
    });
})();





