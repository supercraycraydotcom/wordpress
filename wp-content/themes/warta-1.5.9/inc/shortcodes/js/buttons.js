/**
 * Adds TinyMCE buttons.
 *
 * @package Warta
 */

+function( $ ) { 'use strict';    
 
        // Register plugin
        tinymce.PluginManager.add( 'warta_shortcodes', function(ed, url) {
                
                function setButtonState(button) {
                        ed.on( 'nodechange', function( event ) {
                                button.disabled( ed.selection.isCollapsed() );
                        });
                }
                
                /**
                 * Columns
                 * =======
                 */
                ed.addButton( 'warta_columns', {
                        title    : ed.getLang('wartaColumns.title'),
                        image    : url + '/../img/columns.gif',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaColumns.title'),
                                        body: [
                                                {
                                                        name: 'columns',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaColumns.numberCol'),
                                                        values: [
                                                                {text: ed.getLang('wartaColumns.col2'), value: '2'}, 
                                                                {text: ed.getLang('wartaColumns.col3'), value: '3'}, 
                                                                {text: ed.getLang('wartaColumns.col4'), value: '4'}
                                                        ]
                                                },
                                                {
                                                        name: 'align',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaGeneral.align'),
                                                        values: [
                                                                {text: '', value: ''},
                                                                {text: ed.getLang('wartaGeneral.alignLeft'), value: 'left'}, 
                                                                {text: ed.getLang('wartaGeneral.alignCenter'), value: 'center'}, 
                                                                {text: ed.getLang('wartaGeneral.alignRight'), value: 'right'}, 
                                                                {text: ed.getLang('wartaGeneral.alignJustify'), value: 'justify'}
                                                        ]
                                                }
                                        ],
                                        onsubmit: function(e) {                                                
                                                var     align   = !!e.data.align ? ' align="' + e.data.align + '"' : '',
                                                        content = ed.selection.getContent().replace( /(^(?:<p>|)\[columns.*?\])(.*?)(\[\/columns\](?:<\/p>|)$)/gi, '$2' );
                                                ed.insertContent('[columns col="' + e.data.columns + align + '"]' + content + '[/columns]');
                                        }
                                });
                        },
                        onPostRender: function() {
                                setButtonState(this);
                        }
                } );

                /**
                 * Dropcaps
                 * ========
                 */
                ed.addButton( 'warta_dropcaps', {
                       title    : ed.getLang('wartaDropcaps.title'),
                       image    : url + '/../img/dropcaps.gif',
                       onclick  : function() {
                               var content = ed.selection.getContent().replace( /(\[dropcaps\])|(\[\/dropcaps\])/gi, '' );
                               ed.insertContent('[dropcaps]' + content + '[/dropcaps]');
                       },
                       onPostRender: function() {
                               setButtonState(this);
                       }
                } );    

                /**
                 * Small font
                 * ==========
                 */
                ed.addButton( 'warta_small', {
                        title    : ed.getLang('wartaSmallFont.title'),
                        image    : url + '/../img/small.png',
                        onclick  : function() {
                                ed.formatter.register('warta_small', {
                                        inline : 'small'
                                });
                                ed.formatter.toggle('warta_small');
                                tinyMCE.triggerSave();
                        },
                        onPostRender: function() {
                                var button = this;
                                ed.on( 'nodechange', function( event ) {
                                        button.active( event.element.nodeName === 'SMALL' && !event.element.name );
                                });
                        }
                } );        

                /**
                 * Button 
                 * ======
                 */
                ed.addButton( 'warta_button', {
                        title    : ed.getLang('wartaButton.title'),
                        image    : url + '/../img/button.png',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaButton.title'),
                                        body: [
                                                {
                                                        name: 'type',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaButton.type'),
                                                        values: [
                                                                {text: ed.getLang('wartaButton.default'),       value: 'default'}, 
                                                                {text: ed.getLang('wartaButton.primary'),       value: 'primary'}, 
                                                                {text: ed.getLang('wartaButton.success'),       value: 'success'},
                                                                {text: ed.getLang('wartaButton.info'),          value: 'info'},
                                                                {text: ed.getLang('wartaButton.warning'),       value: 'warning'},
                                                                {text: ed.getLang('wartaButton.danger'),        value: 'danger'}
                                                        ]
                                                }, {
                                                        name: 'size',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaButton.size'),
                                                        values: [
                                                                {text: ed.getLang('wartaButton.large'),         value: 'lg'}, 
                                                                {text: ed.getLang('wartaButton.default'),       value: '',      selected: true}, 
                                                                {text: ed.getLang('wartaButton.small'),         value: 'sm'}, 
                                                                {text: ed.getLang('wartaButton.extraSmall'),    value: 'xs'}
                                                        ]
                                                }, {
                                                        name    : 'url',
                                                        type    : 'textbox',
                                                        label   : ed.getLang('wartaGeneral.url')
                                                }, {
                                                        name    : 'target',
                                                        type    : 'listbox',
                                                        label   : ed.getLang('wartaGeneral.target'),
                                                        values  : [
                                                                {text: ed.getLang('wartaGeneral.sameWindow'),   value: ''},
                                                                {text: ed.getLang('wartaGeneral.newWindow'),    value: '_blank'}
                                                        ]
                                                }
                                        ],
                                        onsubmit: function(e) {
                                                var     size    = !!e.data.size ? ' size="' + e.data.size + '"' : '',
                                                        target  = !!e.data.target ? ' target="' + e.data.target + '"' : '',
                                                        content = ed.selection.getContent().replace( /(\[button.*?\])|(\[\/button\])/gi, '' );
                                                ed.insertContent('[button type="' + e.data.type + '"' + size + ' url="' + e.data.url + '"' + target + ']' + content + '[/button]');
                                        },
                                        onPostRender: function() {
                                                setButtonState(this);
                                        }
                                });
                        },
                        onPostRender: function() {
                                setButtonState(this);
                        }
                } );

                /**
                 * Label 
                 * =====
                 */
                 ed.addButton( 'warta_label', {
                        title    : ed.getLang('wartaLabel.title'),
                        image    : url + '/../img/label.png',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaLabel.title'),
                                        body: [
                                                {
                                                        name: 'type',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaLabel.type'),
                                                        values: [
                                                                {text: ed.getLang('wartaLabel.default'),       value: 'default'}, 
                                                                {text: ed.getLang('wartaLabel.primary'),       value: 'primary'}, 
                                                                {text: ed.getLang('wartaLabel.success'),       value: 'success'},
                                                                {text: ed.getLang('wartaLabel.info'),          value: 'info'},
                                                                {text: ed.getLang('wartaLabel.warning'),       value: 'warning'},
                                                                {text: ed.getLang('wartaLabel.danger'),        value: 'danger'}
                                                        ]
                                                }
                                        ],
                                        onsubmit: function(e) {                                                
                                                var content = ed.selection.getContent().replace( /(\[label.*?\])|(\[\/label\])/gi, '' );
                                                ed.insertContent('[label type="' + e.data.type + '"]' + content + '[/label]');
                                        }
                                });
                        },                        
                        onPostRender: function() {
                                setButtonState(this);
                        }
                } );

                /**
                 * Alert
                 * =====
                 */
                 ed.addButton( 'warta_alert', {
                        title    : ed.getLang('wartaAlert.title'),
                        image    : url + '/../img/alert.png',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaAlert.title'),
                                        body: [
                                                {
                                                        name: 'type',
                                                        type: 'listbox',
                                                        label: ed.getLang('wartaAlert.type'),
                                                        values: [
                                                                {text: ed.getLang('wartaAlert.success'),       value: 'success'},
                                                                {text: ed.getLang('wartaAlert.info'),          value: 'info'},
                                                                {text: ed.getLang('wartaAlert.warning'),       value: 'warning'},
                                                                {text: ed.getLang('wartaAlert.danger'),        value: 'danger'}
                                                        ]
                                                }
                                        ],
                                        onsubmit: function(e) {
                                                var content = ed.selection.getContent().replace( /(\[alert.*?\])|(\[\/alert\])/gi, '' );        
                                                ed.insertContent('[alert type="' + e.data.type + '"]' + content + '[/alert]');
                                        }
                                });
                        },                        
                        onPostRender: function() {
                                setButtonState(this);
                        }
                 } );

                /**
                 * Quote
                 * =====
                 */
                ed.addButton( 'warta_quote', {
                        title    : ed.getLang('wartaQuote.title'),
                        image    : url + '/../img/quote.png',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaQuote.title'),
                                        body: [
                                                {type: 'textbox', name: 'source_title', label: ed.getLang('wartaQuote.source')},
                                                {type: 'textbox', name: 'source_url', label: ed.getLang('wartaQuote.sourceURL')},
                                                {type: 'checkbox', name: 'style', label: ed.getLang('wartaGeneral.reverse')}
                                        ],
                                        onsubmit: function(e) {
                                                var     content         = ed.selection.getContent().replace( /(\[blockquote.*?\])|(\[\/blockquote\])/gi, '' ),
                                                        source_title    = !!e.data.source_title ? ' source_title="' + e.data.source_title + '"' : '',
                                                        source_url      = !!e.data.source_url ? ' source_url="' + e.data.source_url + '"' : '',
                                                        style           = !!e.data.style ? ' style="reverse"' : '';                                                
                                                ed.insertContent('[blockquote' + source_title + source_url + style + ']' + content + '[/blockquote]');
                                        }
                                });
                        },
                        onPostRender: function() {
                                setButtonState(this);
                        }
                } );

                /**
                 * Embed
                 * =====
                 */
                 ed.addButton( 'warta_embed', {
                        title    : ed.getLang('wartaEmbed.title'),
                        image    : url + '/../img/embed.png',
                        onclick  : function() {
                                ed.windowManager.open({
                                        title: ed.getLang('wartaEmbed.title'),
                                        body: [
                                                {type: 'textbox', name: 'url', label: ed.getLang('wartaGeneral.url')},
                                                {type: 'textbox', name: 'width', label: ed.getLang('wartaGeneral.maxWidth')},
                                                {type: 'textbox', name: 'height', label: ed.getLang('wartaGeneral.maxHeight')}
                                        ],
                                        onsubmit: function(e) {
                                                var     width   = !!e.data.width ? ' width="' + e.data.width + '"' : '',
                                                        height  = !!e.data.height ? ' height="' + e.data.height + '"' : '';
                                                ed.insertContent('[embed' + width + height + ']' + e.data.url + '[/embed]');
                                        }
                                });
                        }
                 } );

                /**
                 * Icons
                 * =====
                 */
                ed.addButton( 'warta_icons', {
                        title    : ed.getLang('wartaIcons.title'),
                        image    : url + '/../img/icons.png',
                        onclick  : function() {
                                var $modal = $('#warta-modal-fontawesome-select').fsmhBsModal('show');
                                
                                $modal.off('click.warta.faShortcode').on('click.warta.faShortcode', '.fa', function() {
                                        ed.insertContent('[font_awesome icon="' + $(this).data('value') + '"]');
                                        $modal.fsmhBsModal('hide');
                                });
                        }
                } );

                /**
                 * Tabs
                 * ====
                 */
                ed.addButton( 'warta_tabs', {
                        title    : ed.getLang('wartaTabs.title'),
                        image    : url + '/../img/tabs.gif',
                        onclick  : function() {
                                $('#warta-modal-shortcode-tabs').fsmhBsModal('show');
                        }
                } );

                /**
                 * Accordion 
                 * =========
                 */
                 ed.addButton( 'warta_accordion', {
                        title    : ed.getLang('wartaAccordion.title'),
                        image    : url + '/../img/accordion.gif',
                        onclick  : function() {
                                $('#warta-modal-shortcode-accordion').fsmhBsModal('show');
                        }
                 } );

                /**
                 * Spoiler
                 * =======
                 */
                 ed.addButton( 'warta_spoiler', {
                        title    : ed.getLang('wartaSpoiler.title'),
                        image    : url + '/../img/spoiler.png',
                        onclick  : function() {
                                $('#warta-modal-shortcode-spoiler').fsmhBsModal('show');
                        },                                               
                        onPostRender: function() {
                                setButtonState(this);
                        }
                 } );

                /**
                 * Next Page
                 * =========
                 */
                 ed.addButton( 'warta_next_page', {
                        title    : ed.getLang('wartaNextPage.title'),
                        image    : url + '/../img/next-page.png',
                        cmd     : "WP_Page"
                 } );

                /**
                 * Carousel
                 * ========
                 */
                ed.addButton( 'warta_carousel', {
                        title    : ed.getLang('wartaCarousel.title'),
                        image    : url + '/../img/carousel.png',
                        onclick  : function() {
                                var file_frame;

                                // If the media frame already exists, reopen it.
                                if ( file_frame ) {
                                        file_frame.open();
                                        return;
                                }

                                // Create the media frame.
                                file_frame = wp.media.frames.file_frame = wp.media({
                                        title: ed.getLang('wartaCarousel.title'),
                                        button: {
                                                text: ed.getLang('wartaCarousel.create'),
                                        },
                                        library: {
                                                type: "image"
                                        },
                                        multiple: true // Set to true to allow multiple files to be selected
                                });

                                // When an image is selected, run a callback.
                                file_frame.on( 'select', function() {                                
                                        var attachment  = file_frame.state().get('selection').toJSON(), //  Get selection from the uploader
                                            output      = '';

                                        // Do something with attachment.id and/or attachment.url here
                                        $.each( attachment, function() {
                                                output += this.id + ',';
                                        });

                                        ed.insertContent('[carousel ids="' + output.replace(/,$/, '') + '"]');
                                });

                                // Finally, open the modal
                                file_frame.open();                         
                        }
                } );


        });
    
} ( jQuery );