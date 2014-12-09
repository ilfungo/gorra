<?php
/**
 * Header Template
 *
 * Here we setup all logic and HTML that is required for the header section of all screens.
 *
 */
global $woo_options, $woocommerce;
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
    <title><?php woo_title(); ?></title>
    <?php woo_meta(); ?>

    <!-- CSS  -->

    <!-- The main stylesheet -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

    <!-- /CSS -->

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php $GLOBALS['feedurl'] = get_option('woo_feed_url'); if ( !empty($feedurl) ) { echo $feedurl; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php wp_head(); ?>
    <?php woo_head(); ?>

</head>
<?php
$slug="";

global $wp;
$permalink_str = str_replace("/", " ", $wp->request);
//echo $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
/*
if (is_single()) {
    global $post;
    $cat='';
    //print_r($post);
    $cats = get_the_category($post->ID);
    foreach ( $cats as $c ) {
        $cat .= $c->category_nicename.' ';
    }
    echo $cat;
}
*/
    global $product;
    $slug2="";
    //if(isset($product)){
        $product_cats = get_the_terms($product->id, 'product_cat');
        //print_r($product_cats);
        $slug1 = "";$id=0;$css_color="";$superCategoryCss = "";
        foreach($product_cats as $product_cat){
            $slug1 = $slug1 ." ". $product_cat->slug;
            $id = $product_cat->term_id;
        }
        //echo $slug1;

        $slug2 = get_term_all_parents($id,$product->id,'product_cat');
        $slug2 = $permalink_str." ".$slug2." ".$slug1;
        if (strpos($slug2,'aster') !== false) {
            $slug2 = "aster";
        }elseif(strpos($slug2,'graminacee') !== false) {
            $slug2 = "graminacee";
        }elseif(strpos($slug2,'sedum-crassulaceae') !== false) {
            $slug2 = "sedum-crassulaceae";
        }

    //}
echo "slug2".$slug2;


?>

<body <?php body_class(get_option('woo_site_layout') . " " . $slug2); ?>>
<?php woo_top(); ?>

<div id="wrapper">

    <?php if ( function_exists( 'has_nav_menu') && has_nav_menu( 'top-menu' ) ) { ?>

        <div id="top">
            <div class="col-full">
                <?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'top-nav', 'menu_class' => 'nav fl', 'theme_location' => 'top-menu' ) ); ?>
            </div>
        </div><!-- /#top -->

    <?php } ?>

    <div class="header">

        <div id="logo">
            <?php
            if ($woo_options['woo_texttitle'] != 'true' ) :
                $logo = $woo_options['woo_logo'];
                if ( is_ssl() ) { $logo = preg_replace("/^http:/", "https:", $woo_options['woo_logo']); }
                ?>
                <h1>
                    <a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'description' ); ?>">
                        <img src="<?php if ($logo) echo $logo; else { echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo( 'name' ); ?>" />
                    </a>
                </h1>
            <?php endif; ?>

            <?php if( is_singular() && !is_front_page() ) : ?>
                <span class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></span>
            <?php else : ?>
                <h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <?php endif; ?>
            <span class="site-description"><?php bloginfo( 'description' ); ?></span>
        </div><!-- /#logo -->

        <?php woo_nav_before(); ?>
        <br>


        <div id="navigation" class="col-full">
            <div id="navigation-one">

                <?php
                if ( function_exists( 'has_nav_menu') && has_nav_menu( 'categoriesMenu') ) {
                    wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav-tops', 'menu_class' => 'nav fl', 'theme_location' => 'categoriesMenu' ) );
                }
                ?>
            </div>
            <div id="navigation-two">
                <?php
                if ( function_exists( 'has_nav_menu') && has_nav_menu( 'primary-menu') ) {
                    wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
                } else {
                    ?>
                    <ul id="main-nav" class="nav fl">
                        <?php
                        if ( isset($woo_options[ 'woo_custom_nav_menu' ]) AND $woo_options[ 'woo_custom_nav_menu' ] == 'true' ) {
                            if ( function_exists( 'woo_custom_navigation_output') )
                                woo_custom_navigation_output();
                        } else { ?>
                            <?php if ( is_page() ) $highlight = "page_item"; else $highlight = "page_item current_page_item"; ?>
                            <li class="<?php echo $highlight; ?>"><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'woothemes' ) ?></a></li>
                            <?php
                            wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' );
                        }
                        ?>
                    </ul><!-- /#nav -->
                <?php } ?>
            </div>
            <?php woo_nav_after(); ?>

        </div><!-- /#navigation -->

    </div>


    <div id="container" class="col-full">

        <?php woo_content_before(); ?>
