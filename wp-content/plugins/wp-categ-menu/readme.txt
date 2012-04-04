=== WP Categ Menu ===
Contributors: alvaron
Donate link: http://www.wpworking.com/
Tags: posts, categories, menu, list, subcategories
Requires at least: 3.2
Tested up to: 3.2
Stable tag: 7.0.0

== Description ==

Description: Widget/shortcodes menu(list or select field) based on posts categories/pages(also for custom post types and custom taxonomies). You can display subcategories(one level) and configure CSS, with optional jquery dropdown effect.
Based on Sample Hello World Plugin 2 (http://lonewolf-online.net/) by Tim Trott(http://lonewolf-online.net/)
and WP e-Commerce Featured Product by Zorgbargle | Phenomenoodle http://www.phenomenoodle.com

More info about the plugin:http://www.wpworking.com/


== Installation ==

* After the steps bellow, go to the permalink settings page and update it without changing, it flushes
WordPress permalink settings and make the product permalink work.

1. Upload `wp_categ_menu` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Version 7.0.0 supports short codes, like this: 
[wpcm tpp='s' pggo='c' tte='' typep='posts' catg='category' subc='false' orient='' styatr1='' styatr2='' styatr3='' styatr4='' ste='Select a Category' selcss='']
/*
tpp - Menu Type - 's' select 'm' menu - default = 'posts';
pggo - Display Pages or Categories? 'c' categories 'p' pages;
tte - Widget Title - default = '';
typep -  Posts Type - default = 'posts';
catg -  Posts Category - default = 'category';
subc - Display subcategories/child pages(one level) - default ='' ;
sbmn - Use Jquery drop down subcategory submenu - default ='' ;
orient - Menu Orientation(doesn't work for select field) 'h' or 'v' - default ='' ;
styatr1 - Main menu(ul) CSS (doesn't work for select field);
styatr2 - Main menu(LI) CSS (doesn't work for select field);
styatr3 - Sub menu(ul) CSS (doesn't work for select field);
styatr4 - Sub menu(LI) CSS (doesn't work for select field);
ste - Select first option text(doesn't work for regular menu) - default is "Select One";
selcss - Select field CSS(doesn't work for regular menu)
	*/
	
Or

3. Register a widget sidebar on your functions file, for example, just paste the code below on your theme functions.php

/*if ( function_exists('register_sidebar') )
register_sidebar(array(
	'name' => 'wp_categ_menu',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));*/

4. Go to the permalink settings page and update it without changing

Or

You if you have already registered any sidebar, you can drag the `WP Categ Menu` widget inside it, at wp-admin

4. Configure the widget on your wp-admin pannel and save(see screenshot 1)
5. Use the PHP code bellow where you want the widget to show, on your theme pages
/* if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('wp_categ_menu')) : endif; */
6. You can also play with its CSS styles, so using the ids divcateg, ulcateg and the dynamic generated licateg_[category slug], you may change the category menu appearance. If you choose to use the select field menu, use the element selcateg to change CSS.	
7. Go to the permalink settings page and update it without changing

== Frequently Asked Questions ==

If you have any questions, please let me know  alvaron8@gmail.com

== Screenshots ==

1. Configuring widget parameters on wp-admin
2. Live demo on http://www.wpworking.com/posts-list/

== Changelog ==
On version 7.0.0 works with shortcodes
On version 6.0.2 fixed javascritp bug
On version 6.0.1 fixed bug for categories or pages with "-" on the name
On version 6.0.0 you can choose pages or categories to display on the menu
bug fixed on ul-li menu


== Upgrade Notice ==
Version 7.0.0 supports short codes, like this: 
[wpcm tpp='s' pggo='c' tte='' typep='posts' catg='category' subc='false' orient='' styatr1='' styatr2='' styatr3='' styatr4='' ste='Select a Category' selcss='']
/*
tpp - Menu Type - 's' select 'm' menu - default = 'posts';
pggo - Display Pages or Categories? 'c' categories 'p' pages;
tte - Widget Title - default = '';
typep -  Posts Type - default = 'posts';
catg -  Posts Category - default = 'category';
subc - Display subcategories/child pages(one level) - default ='' ;
sbmn - Use Jquery drop down subcategory submenu - default ='' ;
orient - Menu Orientation(doesn't work for select field) 'h' or 'v' - default ='' ;
styatr1 - Main menu(ul) CSS (doesn't work for select field);
styatr2 - Main menu(LI) CSS (doesn't work for select field);
styatr3 - Sub menu(ul) CSS (doesn't work for select field);
styatr4 - Sub menu(LI) CSS (doesn't work for select field);
ste - Select first option text(doesn't work for regular menu) - default is "Select One";
selcss - Select field CSS(doesn't work for regular menu)
	*/
On version 6.0.0 you can choose pages or categories to display on the menu
bug fixed on ul-li menu

== Arbitrary section ==
You can also use this hack instead of the plugin http://wp.me/p1fZU8-7A
If you have any questions, please let me know  alvaron8@gmail.com

This readme file were validated at http://wordpress.org/extend/plugins/about/validator/