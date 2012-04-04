<?php get_header() ?> 
<?php get_sidebar() ?>	



      <div class="unit content">
      <div id="slideshow"></div>
        <div id="thumbs">
          <ul class="thumbs noscript">
          <?php $count=0; ?>

          <?php while ( have_posts() ) : the_post() ?>        
            <!-- .post -->          
            <li id="post-<?php the_ID() ?>">
            
            <?php
              $count++;
              if (has_post_thumbnail($post->ID)) {                
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'gallery' );
                echo "<a class='thumb' href='" . $image[0] . "' title='All rights reserved'>&nbsp;</a>";
                               
                $custom_fields = get_post_custom($post->ID);
                echo "<div class='caption'>";
                  echo "<ul>";
                    echo "<li>" . the_title() . "</li>";
                foreach ( $custom_fields as $key => $value ){                
                  if(($key != '_edit_last') && ($key != '_edit_lock') && ($key != '_thumbnail_id'))
                    echo "<li>"  . $value[0] . "</li>";
                }   
                  echo "</ul>";
                echo "</div>";                
                
              }
            ?>
            
          </li>
          <!-- /.post -->
          <?php endwhile ?>          
          </ul><!-- /.thumbs -->
          <div class="clear"></div>
        </div><!-- /#thumbs -->
        <div id="loading"></div>
        <div id="controlsOFF"></div>
        <div id="caption"></div>        
        
      </div><!-- /.content -->             
    </div><!-- /.page -->
    
    

    
    
    <?php 
    if($count>1){
    echo "  
    <script type='text/javascript'>
			// We only want these styles applied when javascript is enabled
			//$('div.navigation').css({'width' : '300px', 'float' : 'left'});
			//$('div.content').css('display', 'block');
      
      

			$(document).ready(function() {				
				// Initialize Minimal Galleriffic Gallery
        
				$('#thumbs').galleriffic({
					imageContainerSel:      '#slideshow',
					controlsContainerSel:   '#controls',
          loadingContainerSel: '#loading',
          captionContainerSel: '#caption',  
          autoStart: false,
          delay: 3000,
          numThumbs: 99
				});        
        
			});
		</script>";}
    else{
    echo "  
    <script type='text/javascript'>
			// We only want these styles applied when javascript is enabled
			//$('div.navigation').css({'width' : '300px', 'float' : 'left'});
			//$('div.content').css('display', 'block');
      
      

			$(document).ready(function() {				
				// Initialize Minimal Galleriffic Gallery
        
				$('#thumbs').galleriffic({
					imageContainerSel:      '#slideshow',
					controlsContainerSel:   '#controls',
          loadingContainerSel: '#loading',
          captionContainerSel: '#caption',  
          autoStart: false,
          delay: 3000,
          numThumbs: 99
				});        
        
			});
		</script>";}
    
    ?>
  </body>
</html>
<!-- end category.php -->