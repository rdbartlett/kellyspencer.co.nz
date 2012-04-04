<?php get_header() ?> 
<?php get_sidebar() ?>	



      <div class="unit content <?php if(get_post_type( $post->ID ) == ('painting') || ('digital')) echo 'gallery';?>">


        <?php while ( have_posts() ) : the_post() ?>        
          <div id="post-<?php the_ID() ?>" class="post">
          
          
   
          <!-- .post -->          
          <?php
                     


            if ( has_post_thumbnail()) {
              $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
              echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
              echo get_the_post_thumbnail($post->ID, 'gallery'); 
              echo '</a>';
            }

            $custom_fields = get_post_custom($post->ID);
            echo "<ul class='caption'>";
              echo "<li>" . the_title() . "</li>";
            foreach ( $custom_fields as $key => $value ){                
              if(($key != '_edit_last') && ($key != '_edit_lock') && ($key != '_thumbnail_id'))
                echo "<li>"  . $value[0] . "</li>";
            }              
            echo "</ul>";
            
            
          ?>
          <div class="clear">&nbsp;</div>
          
        </div><!-- /.post -->
        <?php endwhile ?>          
      </div><!-- /.content -->             
    </div><!-- /.page -->
  </body>
</html>
<!-- end index.php -->