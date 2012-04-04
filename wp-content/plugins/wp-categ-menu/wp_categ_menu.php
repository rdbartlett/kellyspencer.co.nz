<?php
/*
Plugin Name: WP Categ Menu
Plugin URI: http://www.wpworking.com/
Description: Widget/shortcodes menu(list or select field) based on posts categories/pages(also for custom post types and custom taxonomies).
Based on Sample Hello World Plugin 2 (http://lonewolf-online.net/) by Tim Trott(http://lonewolf-online.net/)
and WP e-Commerce Featured Product by Zorgbargle | Phenomenoodle http://www.phenomenoodle.com
Version: 7.0.0
Author: Alvaro Neto
Author URI: http://www.wpworking.com/
License: GPL2
*/

/*  Copyright 2011  Alvaro Neto  (email : alvaron8@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_shortcode('wpcm','wpcmenu_short');
//
function wpcmenu_short($atts, $content = null){
   extract(shortcode_atts(array(   	  
	  'tpp' => 'm',
	  'pggo' => 'p',
      'tte' => '',
	  'typep' => 'posts',
	  'catg' => 'category',
	  'subc' => 'false',
	  'sbmn' => 'false',
	  'orient' => 'v',
	  'styatr1' => '',
	  'styatr2' => '',
	  'styatr3' => '',
	  'styatr4' => '',	  
	  'ste' => '',
	  'selcss' => ''	  
    ), $atts));	
    wpcmenu($tte,$typep,$catg,$subc,$sbmn,$orient,$styatr1,$styatr2,$styatr3,$styatr4,$tpp,$ste,$selcss,$pggo);
}
/* tpp - Menu Type - 's' select 'm' menu - default = 'posts'; pggo - Display Pages or Categories? 'c' categories 'p' pages; tte - Widget Title - default = ''; typep - Posts Type - default = 'posts'; catg - Posts Category - default = 'category'; subc - Display subcategories/child pages(one level) - default ='' ; sbmn - Use Jquery drop down subcategory submenu - default ='' ; orient - Menu Orientation(doesn't work for select field) 'h' or 'v' - default ='' ; styatr1 - Main menu(ul) CSS (doesn't work for select field); styatr2 - Main menu(LI) CSS (doesn't work for select field); styatr3 - Sub menu(ul) CSS (doesn't work for select field); styatr4 - Sub menu(LI) CSS (doesn't work for select field); ste - Select first option text(doesn't work for regular menu) - default is "Select One"; selcss - Select field CSS(doesn't work for regular menu) */
 
function wpcmenu($tte,$typep,$catg,$subc,$sbmn,$orient,$styatr1,$styatr2,$styatr3,$styatr4,$tpp,$ste,$selcss,$pggo){
	if($styatr1==''){
		$styatr1 = 'list-style: none outside none;';
	}
	if($styatr2==''){
		$styatr2 = 'min-width:100px;border:1px #eee solid;background-color:#f4f4f4;padding: 2px 5px 2px 10px;';
	}
	if($styatr3==''){
		$styatr3 = 'list-style: none outside none;padding: 5px 0px 0px 0px;';
	}
	if($styatr4==''){
		$styatr4 = 'padding: 2px 5px 2px 0px;';
	}
	if($typep==''){
		$typep = "posts";
	}
	if($catg==''){
		$catg = "category";
	}
	if($orient==''){
		$orient = "v";
	}
	if($tpp==''){
		$tpp = "m";
	}
	if($selcss==''){
		$selcss = "background-color:#f9f9f9;";
	}
	if($pggo==''){
		$pggo = "p";
	}
	if($subc==''){
		$subc = false;
	}
	else{
		$subc = true;
	}
	if($sbmn==''){
		$sbmn = false;
	}
	else{
		$sbmn = true;
	}
	//echo "teste" . $subc;
	// 	
	if($pggo == "c"):
		$args = array(
		'type'                     => ''.$typep.'',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'hierarchical'             => 1,
		'taxonomy'                 => ''.$catg.'',
		'pad_counts'               => false );
		
		$categories = get_categories($args);
		if($tpp == "m"):
			if($subc && $sbmn):
			?>
			<script language="javascript">
				// controle de submenu
				<?
				if(count($categories)>0):		
					foreach ($categories as $category) {
						?>
						var div<?=str_replace("-","_",$category->slug)?> = "#ulsubcateg_<?=str_replace("-","_",$category->slug)?>";
						<?				
					}
				endif;
				?>		
				var dntgo = false;
				function dnt(valgo){
					dntgo = valgo;
				}
				function dispSb(info,id){
					//alert("teste");								
					if(info){
						<?
						if(count($categories)>0):		
							foreach ($categories as $category) {
								?>
								jQuery("#ulsubcateg_<?=str_replace("-","_",$category->slug)?>").fadeOut("fast");
								<?				
							}
						endif;
						?>					
						jQuery(id).fadeIn("fast");				
					}
					else{
						if(!dntgo){
							jQuery(id).fadeOut("fast");
						}
					}
				}
			</script>
		   <?
			endif;
			//
			if($orient=="h"):
				$styatr2 .= "float:left";
				$styatr4 .= "clear:both";
			endif;
			//				 
			if(count($categories)>0):		
				$htmlcateg = '<div id="divcateg">'."\n";
				if($tte!=""):
					$htmlcateg .= "<div id='titcateg'><h3 class='widget-title'>".$tte."</h3></div>"."\n";
				endif;
				$htmlcateg .= '<ul id="ulcateg" style="'.$styatr1.'">'."\n";
				foreach ($categories as $category) {
					if($subc && $sbmn):
						$htmlcateg .= '<li id="licateg_'.str_replace("-","_",$category->slug).'" style="'.$styatr2.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug).'" onmouseover="javascript:dispSb(true,div'.str_replace("-","_",$category->slug).');dnt(true);" onmouseout="setTimeout(\'javascript:dispSb(false,div'.str_replace("-","_",$category->slug).')\',2000);dnt(false);">'.$category->cat_name.'</a>';
					else:
						$htmlcateg .= '<li id="licateg_'.str_replace("-","_",$category->slug).'" style="'.$styatr2.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug).'">'.$category->cat_name.'</a>';
					endif;
					if($subc):
						if($sbmn):
							$htmlcateg .= '<ul id="ulsubcateg_'.str_replace("-","_",$category->slug).'" style="display:none;'.$styatr3.'" onmouseover="dnt(true)" onmouseout="setTimeout(\'javascript:dispSb(false,div'.str_replace("-","_",$category->slug).')\',200);dnt(false);">';
						else:
							$htmlcateg .= '<ul id="ulsubcateg_'.str_replace("-","_",$category->slug).'" style="'.$styatr3.'">';
						endif;
						$subcategories=  get_categories('child_of='.intval($category->cat_ID));
						foreach ($subcategories as $subcategory) {	
							$htmlcateg .= '<li id="licateg_'.$subcategory->slug.'" style="'.$styatr4.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug)."/".$subcategory->slug.'">'.$subcategory->cat_name.'</a></li>';					
						}
						$htmlcateg .= '</li>'."\n";
						$htmlcateg .= '</ul>'."\n";
					endif;					
				}
				$htmlcateg .= '</ul></div>'."\n";			
			endif;
		else:
			//		
			?>
			<script language="javascript">
				function goUrl(val){
					window.location = val;
					return false;
				}
			</script>
			<?		 
			if(count($categories)>0):		
				$htmlcateg = '<div id="divcateg">'."\n";
				if($tte!=""):
					$htmlcateg .= "<div id='titcateg'><h3 class='widget-title'>".$tte."</h3></div>"."\n";
				endif;
				$htmlcateg .= '<select id="selcateg" style="'.$selcss.'" onchange="goUrl(this.value);">'."\n";
				$htmlcateg .= '<option value="">'.$ste."</option>\n";
				if($subc):				
					foreach ($categories as $category) {
						//$htmlcateg .= '<optgroup label="'.$category->cat_name.'">';
						$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".$category->slug.'">'.$category->cat_name.'</option>'; 
						// onclick="window.location(/'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug).'/)"
						$subcategories=  get_categories('child_of='.intval($category->cat_ID));
						foreach ($subcategories as $subcategory) {
							$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".$subcategory->slug.'">'.$subcategory->cat_name.'</option>';
						//$htmlcateg .= '</optgroup>';
						}
						$subcategories="";
					}
				else:
					foreach ($categories as $category) {
						$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug).'">'.$category->cat_name.'</option>';
					}
				endif;
				$htmlcateg .= '</select></div>'."\n";			
			endif;
		endif;	
		echo $htmlcateg;
	else:
		// pages menu
		$pargs = array(
			'child_of' => 0,
			'sort_order' => 'DESC',
			'sort_column' => 'post_date',
			'hierarchical' => '0',
			'parent' => 0,
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		//$arrpages = get_pages($pargs);
		/*foreach ($arrpages as $arrpg) {
			echo $arrpg->post_title."<br>";
		}*/
		
		$categories = get_pages($pargs);
		if($tpp == "m"):
			if($subc && $sbmn):
			?>
			<script language="javascript">
				// controle de submenu
				<?
				if(count($categories)>0):		
					foreach ($categories as $category) {
						?>
						var div<?=str_replace("-","_",$category->post_name)?> = "#ulsubcateg_<?=str_replace("-","_",$category->post_name)?>";
						<?				
					}
				endif;
				?>		
				var dntgo = false;
				function dnt(valgo){
					dntgo = valgo;
				}
				function dispSb(info,id){
					//alert("teste");								
					if(info){
						<?
						if(count($categories)>0):		
							foreach ($categories as $category) {
								?>
								jQuery("#ulsubcateg_<?=str_replace("-","_",$category->post_name)?>").fadeOut("fast");
								<?				
							}
						endif;
						?>					
						jQuery(id).fadeIn("fast");				
					}
					else{
						if(!dntgo){
							jQuery(id).fadeOut("fast");
						}
					}
				}
			</script>
		   <?				
			endif;
			//
			if($orient=="h"):
				$styatr2 .= "float:left";
				$styatr4 .= "clear:both";
			endif;
			//				 
			if(count($categories)>0):		
				$htmlcateg = '<div id="divcateg">'."\n";
				if($tte!=""):
					$htmlcateg .= "<div id='titcateg'><h3 class='widget-title'>".$tte."</h3></div>"."\n";
				endif;
				$htmlcateg .= '<ul id="ulcateg" style="'.$styatr1.'">'."\n";
				foreach ($categories as $category) {
					if($subc && $sbmn):
						$htmlcateg .= '<li id="licateg_'.str_replace("-","_",$category->post_name).'" style="'.$styatr2.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->post_name).'" onmouseover="javascript:dispSb(true,div'.str_replace("-","_",$category->post_name).');dnt(true);" onmouseout="setTimeout(\'javascript:dispSb(false,div'.str_replace("-","_",$category->post_name).')\',2000);dnt(false);">'.$category->post_title.'</a>';
					else:
						$htmlcateg .= '<li id="licateg_'.str_replace("-","_",$category->post_name).'" style="'.$styatr2.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->post_name).'">'.$category->post_title.'</a>';
					endif;
					if($subc):
						if($sbmn):
							$htmlcateg .= '<ul id="ulsubcateg_'.str_replace("-","_",$category->post_name).'" style="display:none;'.$styatr3.'" onmouseover="dnt(true)" onmouseout="setTimeout(\'javascript:dispSb(false,div'.str_replace("-","_",$category->post_name).')\',200);dnt(false);">';
						else:
							$htmlcateg .= '<ul id="ulsubcateg_'.str_replace("-","_",$category->post_name).'" style="'.$styatr3.'">';
						endif;
						$sargs = array(
							'child_of' => $category->ID,
							'sort_order' => 'DESC',
							'sort_column' => 'post_date',
							'hierarchical' => '0',
							'parent' => $category->ID,
							'offset' => 0,
							'post_type' => 'page',
							'post_status' => 'publish'
						); 
						//$arrpages = get_pages($pargs);
						$subcategories=  get_pages($sargs);
						foreach ($subcategories as $subcategory) {	
							$htmlcateg .= '<li id="licateg_'.$subcategory->post_name.'" style="'.$styatr4.'"><a href="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->post_name)."/".$subcategory->post_name.'">'.$subcategory->post_title.'</a></li>';					
						}
						$htmlcateg .= '</li>'."\n";
						$htmlcateg .= '</ul>'."\n";
					endif;					
				}
				$htmlcateg .= '</ul></div>'."\n";			
			endif;
		else:
			//		
			?>
			<script language="javascript">
				function goUrl(val){
					window.location = val;
					return false;
				}
			</script>
			<?		 
			if(count($categories)>0):		
				$htmlcateg = '<div id="divcateg">'."\n";
				if($tte!=""):
					$htmlcateg .= "<div id='titcateg'><h3 class='widget-title'>".$tte."</h3></div>"."\n";
				endif;
				$htmlcateg .= '<select id="selcateg" style="'.$selcss.'" onchange="goUrl(this.value);">'."\n";
				$htmlcateg .= '<option value="">'.$ste."</option>\n";
				if($subc):				
					foreach ($categories as $category) {
						//$htmlcateg .= '<optgroup label="'.str_replace("-","_",$category->post_name).'">'; 
						// onclick="window.location(/'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->slug).'/)"
						$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".$category->post_name.'">'.$category->post_title.'</option>';
						$sargs = array(
							'child_of' => $category->ID,
							'sort_order' => 'DESC',
							'sort_column' => 'post_date',
							'hierarchical' => '0',
							'parent' => -1,
							'offset' => 0,
							'post_type' => 'page',
							'post_status' => 'publish'
						); 
						//$arrpages = get_pages($pargs);
						$subcategories=  get_pages($sargs);
						foreach ($subcategories as $subcategory) {
							$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".$subcategory->post_name.'">- '.$subcategory->post_title.'</option>';
						//$htmlcateg .= '</optgroup>';
						}
						$subcategories="";
					}
				else:
					foreach ($categories as $category) {
						$htmlcateg .= '<option value="'.get_bloginfo('siteurl')."/".str_replace("-","_",$category->post_name).'">'.$category->post_title.'</option>';
					}
				endif;
				$htmlcateg .= '</select></div>'."\n";			
			endif;
		endif;	
		echo $htmlcateg;
	endif;
}

 
function widget_wpcmenu($args) {
  extract($args);
 
  $options = get_option("widget_wpcmenu");
  if (!is_array( $options ))
{
$options = array(
	  'tte' => '',
	  'typep' => '',
	  'catg' => '',
	  'subc' => '',
	  'sbmn' => '',
	  'orient' => '',
	  'styatr1' => '',
	  'styatr2' => '',
	  'styatr3' => '',
	  'styatr4' => '',
	  'tpp' => '',
	  'ste' => '',
	  'selcss' => '',
	  'pggo' => ''
      );
  }
 
    wpcmenu($options['tte'],$options['typep'],$options['catg'],$options['subc'],$options['sbmn'],$options['orient'],$options['styatr1'],$options['styatr2'],$options['styatr3'],$options['styatr4'],$options['tpp'],$options['ste'],$options['selcss'],$options['pggo']);
}
 
function wpcmenu_control()
{
  $options = get_option("widget_wpcmenu");
  if (!is_array( $options ))
{
$options = array(
	  'tte' => '',
	  'typep' => '',
	  'catg' => '',
	  'subc' => '',
	  'sbmn' => '',
	  'orient' => '',
	  'styatr1' => '',
	  'styatr2' => '',
	  'styatr3' => '',
	  'styatr4' => '',
	  'tpp' => '',
	  'ste' => '',
	  'selcss' => '',
	  'pggo' => ''
      );
  }
 
  if ($_POST['wpcmenu-Submit'])
  {
	$options['tte'] = htmlspecialchars($_POST['wpcmenu-WidgetTte']);
	$options['typep'] = htmlspecialchars($_POST['wpcmenu-WidgetTypep']);
	$options['catg'] = htmlspecialchars($_POST['wpcmenu-WidgetCatg']);
	$options['subc'] = $_POST['wpcmenu-WidgetSubc'];
	$options['sbmn'] = $_POST['wpcmenu-WidgetSbmn'];
	$options['orient'] = $_POST['wpcmenu-WidgetOrient'];
	$options['styatr1'] = $_POST['wpcmenu-WidgetSty1'];
	$options['styatr2'] = $_POST['wpcmenu-WidgetSty2'];
	$options['styatr3'] = $_POST['wpcmenu-WidgetSty3'];
	$options['styatr4'] = $_POST['wpcmenu-WidgetSty4'];
	$options['tpp'] = $_POST['wpcmenu-WidgetTpp'];
	$options['ste'] = htmlspecialchars($_POST['wpcmenu-WidgetSte']);
	$options['selcss'] = htmlspecialchars($_POST['wpcmenu-WidgetScs']);
	$options['pggo'] = htmlspecialchars($_POST['wpcmenu-WidgetPggo']);
    update_option("widget_wpcmenu", $options);
  }
 
?>
  <p> 
  <?
  	 	//          
        if($options['pggo']=="p"){
            $pcchk = "";
            $ppchk = "checked";
        }
        else{
            $pcchk = "checked";
            $ppchk = "";
        }
		//           
        if($options['orient']=="h"){
            $wvchk = "";
            $whchk = "checked";
        }
        else{
            $wvchk = "checked";
            $whchk = "";
        }
		//          
        if($options['tpp']=="s"){
            $tmchk = "";
            $tschk = "checked";
        }
        else{
            $tmchk = "checked";
            $tschk = "";
        }
		//
        if($options['subc']){
            $schk = "checked";
        }
        else{
            $schk = "";
        }		    
		//
        if($options['sbmn']){
            $sbck = "checked";
        }
        else{
            $sbck = "";
        }		    
		//
		if($options['styatr1']==''){
			$options['styatr1'] = 'list-style: none outside none;';
		}
		if($options['styatr2']==''){
			$options['styatr2'] = 'min-width:100px;border:1px #eee solid;background-color:#f4f4f4;padding: 2px 5px 2px 10px;';
		}
		if($options['styatr3']==''){
			$options['styatr3'] = 'list-style: none outside none;padding: 5px 0px 0px 0px;';
		}
		if($options['styatr4']==''){
			$options['styatr4'] = 'padding: 2px 5px 2px 0px;';
		}
		//
		if($options['ste']==''){
			$options['ste'] = 'Select One';
		}
		//
		if($options['selcss']==''){
			$options['selcss'] = 'background-color:#f9f9f9;';
		}
  ?>   
  	<label for="wpcmenu-WidgetOrient">Menu Type: </label><br />
    <input type="radio" id="wpcmenu-WidgetTpp" name="wpcmenu-WidgetTpp" value="m" <?=$tmchk?> />Regular Menu 
     <input type="radio" id="wpcmenu-WidgetTpp" name="wpcmenu-WidgetTpp" value="s" <?=$tschk?>/>Select Field    <br /><br />
     <label for="wpcmenu-WidgetPggo">Display Pages or Categories? </label><br />
    <input type="radio" id="wpcmenu-WidgetPggo" name="wpcmenu-WidgetPggo" value="c" <?=$pcchk?> />Categories 
     <input type="radio" id="wpcmenu-WidgetPggo" name="wpcmenu-WidgetPggo" value="p" <?=$ppchk?>/>Pages   <br /><br />
    <label for="wpcmenu-WidgetTte">Widget Title: </label><br />
    <input type="text" id="wpcmenu-WidgetTte" name="wpcmenu-WidgetTte" value="<?php echo $options['tte'];?>" size="20"/>   
    <br />
    <label for="wpcmenu-WidgetTypep">Posts Type(default='posts' you can also use a custom type): </label><br />
    <input type="text" id="wpcmenu-WidgetTypep" name="wpcmenu-WidgetTypep" value="<?php echo $options['typep'];?>" size="20"/>   
    <br />
    <label for="wpcmenu-WidgetCatg">Posts Custom Taxonomy(for custom post types, for regular posts default='category'): </label><br />    
  	<input type="text" id="wpcmenu-WidgetCatg" name="wpcmenu-WidgetCatg" value="<?php echo $options['catg'];?>" size="20"/> 
    <br />
    <label for="wpcmenu-WidgetSubc">Display subcategories/child pages(one level): </label><br />
    <input type="checkbox" id="wpcmenu-WidgetSubc" name="wpcmenu-WidgetSubc"  <?=$schk?> />
    <br /><br />
    <label>Select Field Menu Options(doesn't work for regular menu)</label>    
    <hr><br />
    <label for="wpcmenu-WidgetSte">Select first option text(default is "Select One"): </label><br />
    <input type="text" id="wpcmenu-WidgetSte" name="wpcmenu-WidgetSte" value="<?php echo $options['ste'];?>" size="20"/> 
    <br />Select field CSS(leave it blank to restore default values):<br />
    <textarea id="wpcmenu-WidgetScs" name="wpcmenu-WidgetScs" cols="30" rows="4" style='clear:both'><?php echo $options['selcss'];?></textarea>
    <br /><br />
    <label>Drop Down Menu Options(doesn't work for select field)</label>
     <hr><br />
    <label for="wpcmenu-WidgetOrient">Orientation: </label><br />
    <input type="radio" id="wpcmenu-WidgetOrient" name="wpcmenu-WidgetOrient" value="v" <?=$wvchk?> />Vertical 
     <input type="radio" id="wpcmenu-WidgetOrient" name="wpcmenu-WidgetOrient" value="h" <?=$whchk?>/>Horizontal    <br /><br />
    <label for="wpcmenu-WidgetSbmn">Use Jquery drop down subcategory submenu: </label><br />
    <input type="checkbox" id="wpcmenu-WidgetSbmn" name="wpcmenu-WidgetSbmn"  <?=$sbck?> />(this option requires Jquery, so you have to set the ".js" library file properly on your theme)
    <br /><br />
    <table cellpadding="3" cellspacing="3">
    	<tr>
    		<td colspan="2"><label for="wpcmenu-WidgetSty1">CSS(leave it blank to restore default values): </label></td>
         </tr>
         <tr>
         	<td>Main menu(ul)</td>
         	<td>Main menu(li)</td>
         </tr>
         <tr>
         	<td><textarea id="wpcmenu-WidgetSty1" name="wpcmenu-WidgetSty1" cols="30" rows="4" style='clear:both'><?php echo $options['styatr1'];?></textarea></td>
         	<td><textarea id="wpcmenu-WidgetSty2" name="wpcmenu-WidgetSty2" cols="30" rows="4" style='clear:both'><?php echo $options['styatr2'];?></textarea></td>
         </tr>
    	<tr>
         	<td>Sub menu(ul)</td>
            <td>Sub menu(li)</td>
         </tr>
   		<tr>
         	<td><textarea id="wpcmenu-WidgetSty3" name="wpcmenu-WidgetSty3" cols="30" rows="4" style='clear:both'><?php echo $options['styatr3'];?></textarea></td>
           	<td><textarea id="wpcmenu-WidgetSty4" name="wpcmenu-WidgetSty4" cols="30" rows="4" style='clear:both'><?php echo $options['styatr4'];?></textarea></td>
         </tr>
    </table>
    <br /> 
    <input type="hidden" id="wpcmenu-Submit" name="wpcmenu-Submit" value="1" />
  </p>
<?php
}
 
function wpcmenu_init()
{
  register_sidebar_widget(__('WP-Categ-Menu'), 'widget_wpcmenu');  
  register_widget_control(   'WP-Categ-Menu', 'wpcmenu_control', 550, 550 );
}
add_action("plugins_loaded", "wpcmenu_init");
?>