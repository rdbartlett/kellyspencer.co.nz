<?php get_header() ?>
<?php get_sidebar() ?>

	<div id="content">

  
		<?php the_post(); ?>
		<div id="post-<?php the_ID() ?>" class="post">
			<h2 class="post-title"><?php the_title() ?></h2>								
			<div class="post-content">
				<?php the_content(); ?>
			</div>
      <div class="post-meta">Posted on <?php the_time('F j, Y'); ?> in: <?php the_category(', '); ?><span class="sep">|</span><a href="#comments">Jump To Comments</a></div>
			
		</div><!-- .post -->
    
    	
		<?php comments_template(); ?>		

	</div><!-- #content -->



<!-- /single.php -->