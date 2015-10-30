
<?php print_r(have_posts()); ?>

<?php get_header(); /* BAU */?>

<div id="content" class="col-full">
    <div id="main" class="fullwidth"> 

        <?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
            <?php woo_breadcrumbs(); ?>
        <?php } ?>

        <?php if (have_posts()) : $count = 0; ?>

            <span class="archive_header"><?php _e( 'Risultati ricerca :', 'woothemes' ) ?> <?php the_search_query();?></span>
 
            <?php while (have_posts()) : the_post(); $count++; ?>
                <?php $template = get_post_meta( get_the_ID(), '_wp_page_template', TRUE );
                        print_r($template);
                ?>
                <!-- Post Starts -->
                <div <?php post_class(); ?>>

                    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

                    <?php woo_post_meta(); ?>

                    <div class="entry">
                        <?php the_excerpt(); ?>
                    </div><!-- /.entry -->

                </div><!-- /.post -->

            <?php endwhile; else: ?>
                <div class="archive_header">
                    <?php echo 'Spiacente nessun risultato trovato con i seguenti criteri di ricerca.'; ?>
                </div>
        <?php endif; ?>

        <?php woo_pagenav(); ?>

    </div><!-- /#main -->

    <?php get_sidebar(); ?>

</div><!-- /#content -->

<?php get_footer(); ?>
