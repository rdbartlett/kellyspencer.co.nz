<?php get_header() ?> 
<?php get_sidebar() ?>	



      <div class="unit content">
	
        <?php while ( have_posts() ) : the_post() ?>
        <div id="post-<?php the_ID() ?>" class="post">
          <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>								
          <div class="post-content">
            <?php the_content('Click here to read more &raquo;'); ?>
          </div>
          <div class="post-meta">Posted on <?php the_time('F j, Y'); ?> in: <?php the_category(', '); ?><span class="sep">|</span><?php comments_popup_link('Post Comment', '1 Comment', '% Comments') ?></div>
        </div><!-- .post -->
        <?php endwhile ?>

        <div class="navigation">
          <div class="navleft"><?php next_posts_link('&laquo; Older Posts', '0') ?></div>
          <div class="navright"><?php previous_posts_link('Newer Posts &raquo;', '0') ?></div>
        </div>

	
        
      </div><!-- /.content -->             
    </div><!-- /.page -->
    
    

  </body>
</html>
<!-- end category-blog.php -->