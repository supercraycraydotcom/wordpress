+function($) { 'use strict';
    
        var $body = $('body');

        var WartaReview = function() {        
                this.total();
        };
    
        WartaReview.prototype.calculateTotal = function() {
                var $this       = $( this ),
                    scores      = $this.find( '[name="warta_review_scores[]"]' ),
                    total       = 0.0,
                    $total      = $this.find('.review-total-score'),
                    scoreText   = $this.find( '#warta_review_score_text' );
            
                if(!scoreText.length) {
                        return;
                }
            
                var scoreTexts  = scoreText.data('score-text').split(',');

                if( scores.is(':hidden') ) {
                        total = parseFloat( $total.val() );
                } else {
                        scores.each( function(index, element) {
                                var value = parseFloat( $(this).val() );
                                value = value ? value : 0.0;

                                if( value > 5 ) { 
                                        value = 5.0;
                                        $(this).val(5.0);
                                }

                                total += value;
                        } );

                        total = total / scores.length;
                }

                $this.find('.review-total-score').val( total.toFixed(1) );
                scoreText.val( scoreTexts[ Math.ceil(total) - 1 ].trim() );
        };
    
        WartaReview.prototype.total = function() {
                var self = this;

                $body.on('added.fsmh.tab removed.fsmh.tab', '#warta_review_meta_box .fsmh-container', function() {
                        self.calculateTotal.call(this);
                });
                $body.on('change', '#warta_review_meta_box [name="warta_review_scores[]"], #warta_review_meta_box  .review-total-score', function() {
                        self.calculateTotal.call( $(this).closest('.fsmh-container') );
                });
        };

        new WartaReview();
    
}(jQuery);
            