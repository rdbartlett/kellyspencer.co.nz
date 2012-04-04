        <!-- #sidebar -->



          <?php  
            $currentPageType = get_post_type();
            
            $args=array(
              'public'   => true,
              '_builtin' => false
            ); 
            $output = 'names'; // names or objects, note names is the default
            $operator = 'and'; // 'and' or 'or'
            $post_types=get_post_types($args,$output,$operator); ?>
            


            
        <div class="unit sidebar hide-text">     
          <div class="unitRight sitenav">
          <?php        
            //$categories = (get_categories());
            //$newCat = array();
            echo "<h1 class='title'><a href='" . get_bloginfo('url') . "'>Kelly Spencer</a></h1>";
            echo "<h2 class='portfolio'>portfolio</h2>";
            
            $paintingsCat = get_categories(array('parent'=>'10', 'order' => 'desc'));
            $digitalCat = get_categories(array('parent'=>'13', 'order' => 'desc'));
            $commercialCat = get_categories(array('parent'=>'9', 'order' => 'desc'));
            $projectsCat = get_categories(array('parent'=>'16'));                
            $cats = array($paintingsCat, $digitalCat, $commercialCat, $projectsCat);
            
            foreach($cats as $cat){
              $parent = get_the_category_by_ID($cat[0]->parent);
              $link = get_bloginfo(url) . "/category/" . $cat[0]->slug . "/?post_type=" . $parent;              
              if($parent == $_GET['post_type']){
                echo "<li class='" . $parent . "'><a class='current' href='" . $link . "'>" . $parent . "</a></li>";
                echo "<div class='unit subnav show-text'>";
                echo "<ul>";                
                foreach ($cat as $subcat){
                  $sublink = get_bloginfo(url) . "/category/" . $subcat->slug . "/?post_type=" . $parent;
                  if($sublink == curPageURL())
                    echo "<li class='current' ><a href='" . $sublink . "'>" . $subcat->name . "</a></li>";
                  else echo "<li><a href='" . $sublink . "'>" . $subcat->name . "</a></li>";
                }                
                echo "</ul>";
                echo "</div>";
              }
              else echo "<li class='" . $parent . "'><a href='" . $link . "'>" . $parent . "</a></li>";                
            }
            
            echo "<h2 class='bonus-trivia'>bonus trivia</h2>";
            echo "<ul>";
            
            $cats = array('bio', 'press', 'boutique', 'blog', 'contact');
            foreach($cats as $cat){
              $link = get_bloginfo(url) . "/" . $cat . "/";  
              if($cat == 'blog') $link = get_bloginfo(url) . "/category/blog/?post_type=blog";  
              if(curPageURL() == $link) echo "<li class='" . $cat ."' ><a class='current' href='" . $link . "'>" . $cat ."</a></li>";
              else echo "<li class='" . $cat ."'><a href='" . $link . "'>" . $cat ."</a></li>";
            
            }
            
            
            

            
            
            echo "</ul>";
            ?>
            
            
              
            
            
            
            
            
          
          </div><!-- end .sitenav -->
          
          <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
          <?php endif; ?>
          
          <?php //if(get_post_type( $post->ID ) == 'painting') get_sidebar('painting'); ?>
        </div><!-- end .sidebar -->