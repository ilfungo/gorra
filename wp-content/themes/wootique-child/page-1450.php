<?php get_header(); ?><?php global $woo_options; ?><?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>    <?php woo_breadcrumbs(); ?><?php } ?>    <div id="content" class="page col-full">        <div id="main" class="col-left">            <?php if (have_posts()) : $count = 0; ?>                <?php while (have_posts()) : the_post(); $count++; ?>                    <div <?php post_class(); ?>>                        <h1 class="title"><?php the_title(); ?></h1>                        <?php // the_content(); ?>                        <ul class="products">                            <?php                            $args = array( 'post_type' => 'product', 'posts_per_page' => 1000, 'product_cat' => 'sedum-crassulaceae', 'orderby' => 'name' );                            $loop = new WP_Query( $args );                            $i=0;$html_class="";                            while ( $loop->have_posts() ) : $loop->the_post(); global $product;                                $i++;                                switch ($i) {                                    case 1:                                        $html_class = "first";                                        break;                                    case 2:                                        $html_class = "";                                        break;                                    case 3:                                        $html_class = "last";                                        break;                                }                            ?>                                <li class="product <?php echo $html_class?>">                                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">                                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>                                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>                                        <h3><?php the_title(); ?></h3>                                    </a>                                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>                                </li>                            <?php                            if($i==3){$i=0;}                            endwhile; ?>                            <?php wp_reset_query(); ?>                        </ul><!--/.products-->                        <?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>                    </div><!-- /.post -->                    <?php $comm = $woo_options[ 'woo_comments' ]; if ( ($comm == "page" || $comm == "both") ) : ?>                        <?php comments_template(); ?>                    <?php endif; ?>                <?php endwhile; else: ?>                <div <?php post_class(); ?>>                    <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ) ?></p>                </div><!-- /.post -->            <?php endif; ?>        </div><!-- /#main -->        <?php get_sidebar(); ?>    </div><!-- /#content --><?php get_footer(); ?>