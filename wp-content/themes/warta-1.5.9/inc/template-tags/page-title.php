<?php
/**
 * Print page title
 * 
 * @package Warta
 */

if( !function_exists('warta_page_title') ) :
/**
 * Print page title
 * 
 * @param string $primary   Title
 * @param string $secondary Subtitle
 * @param boolean $one_line TRUE if want to display 1 line and false if 2 lines
 */
function warta_page_title( $primary, $secondary, $one_line = false ) {
?> 

    <div id="title">
        <div class="image-light"></div>
        <div class="container">
            <div class="title-container col-md-12">
                
                <?php if($one_line) : ?>
                
                    <h1>
                        <?php if( !empty($secondary) ) : ?>
                            <span class="secondary"><?php echo $secondary ?></span>
                        <?php endif ?>
                            
                        <?php if( !empty($primary) ) : ?>
                            <span class="primary"><?php echo $primary ?></span>
                        <?php endif ?>
                    </h1>
                
                <?php elseif (is_single()) : ?>
                
                    <?php if( !empty($primary) ) : ?>
                        <h1 class="primary" style="color: black !important;"><?php echo $primary ?></h1>
                    <?php endif ?>
                    
                <?php else : ?>
                
                    <?php if( !empty($primary) ) : ?>
                        <h1 class="primary"><?php echo $primary ?></h1>
                    <?php endif ?>

                    <?php if( !empty($secondary) ) : ?>
                        <p class="secondary"><?php echo $secondary ?></p>
                    <?php endif ?>        
                <?php endif ?>
                    
            </div>
        </div>
    </div>

    <?php
}
endif; // warta_page_title


