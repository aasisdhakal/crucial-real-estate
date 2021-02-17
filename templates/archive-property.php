<?php
/**
 * The template for displaying properties list.
 *
 * @see https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Real_Home
 */

get_header()
?>
<div id="content" class="site-content">
    <section class="page-wrapper">
        <div class="container">
            <div id="primary" class="content-area">
                <!-- primary-home starting from here -->
                <main id="main" class="site-main">
                    <div class="post-layout-matches-wrap">
                        <div class="row">
                            <div class="custom-col-3">
                                <div class=" post-matches-wrap">
									<?php
									$real_home_count_properties = wp_count_posts( 'property' );
									$real_home_total_books      = $real_home_count_properties->publish;
									?>
                                    <span class="post-matches-count"><?php echo absint( $real_home_total_books ); ?></span>
                                    <span class="post-matcher-text"> <?php esc_html_e( 'Properties', 'real-home' ); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class='post-filter-wrap'>
                            <div class='post-filter-item'>
								<?php
								$real_home_args = array(
									'taxonomy'   => 'property-type',
									'order'      => 'ASC',
									'hide_empty' => false,
								
								);
								
								$real_home_cats = get_categories( $real_home_args );
								
								if (empty( $_GET['filter-type'])){
								    $_GET['filter-type'] = 'default';
                                }
								?>
                                <form name='property' action='<?php echo get_post_type_archive_link( 'property' ); ?>'
                                      method='get'>
                                    <select name='filter-type'>
                                        <option value='<?php
										echo esc_attr( 'default' )
										?>'><?php esc_attr_e( 'Default', 'real-home' ); ?></option>
										<?php foreach ( $real_home_cats as $real_home_cat ) : ?>
                                            <option value='<?php
											echo esc_attr( $real_home_cat->slug )
											?>' <?php selected( $_GET['filter-type'], $real_home_cat->slug ); ?>>
												<?php echo esc_html( ( $real_home_cat->name ) ) . ' (' . esc_html( $real_home_cat->count ) . ')'; ?>
                                            </option>
										<?php endforeach; ?>
                                    </select>
                                    <input type='submit' value='<?php esc_attr_e( 'Search', 'real-home' ) ?>'/>
                                </form>
                            </div>
                        </div>
                        <div class="post-wrapper post-grid-view">
							<?php
							$real_home_args = array(
								'post_type' => 'property',
							
							
							);
							if ( ( ! isset( $_GET['filter-type'] ) ) || ( isset( $_GET['filter-type'] ) && $_GET['filter-type'] == 'default' ) ) {
								$paged            = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
								$real_home_args[] = [
									'paged' => $paged,
								];
							} else {
								$real_home_args['posts_per_page'] = - 1;
							} ?>
							<?php
							
							
							if ( ( isset( $_GET['filter-type'] ) && ! empty( $_GET['filter-type'] ) ) && ( $_GET['filter-type'] != 'default' ) ) {
								$real_home_args['tax_query'] = array(
									array(
										'taxonomy' => 'property-type',
										'field'    => 'slug',
										'terms'    => sanitize_text_field( $_GET['filter-type'] ),
									),
								);
							}
							
							$real_home_slider_query = new WP_Query( $real_home_args );
							
							while ( $real_home_slider_query->have_posts() ) :
								$real_home_slider_query->the_post();
								?>
                                <div class="post">
                                    <figure class="featured-image">
										<?php the_post_thumbnail( 'full' ); ?>
                                    </figure>
                                    <div class="post-detail-wrap">
                                        <header class="entry-header">
                                            <h3 class="entry-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                        </header>
                                        <div class="entry-content">
											<?php
											real_home_content_type();
											?>
                                        </div>
                                        <div class="property-meta entry-meta">
                                            <div class="meta-wrapper">
											<span class="meta-icon">
												<i class="fa fa-bed"></i>
											</span>
                                                <span
                                                        class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_bedrooms', true ) ); ?></span>
                                                <span
                                                        class="meta-unit"><?php esc_html_e( 'bedroom', 'real-home' ); ?></span>
                                            </div>
                                            <div class="meta-wrapper">
											<span class="meta-icon">
												<i class="fa fa-bath"></i>
												<span
                                                        class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_bathrooms', true ) ); ?></span>
												<span
                                                        class="meta-unit"><?php esc_html_e( 'bathroom', 'real-home' ); ?></span>
                                            </div>
                                            <div class="meta-wrapper">
											<span class="meta-icon">
												<i class="fa fa-car"></i>
											</span>
                                                <span
                                                        class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_garage', true ) ); ?></span>
                                                <span class="meta-unit"><?php esc_html_e( 'garage', 'real-home' ); ?></span>
                                            </div>
                                            <div class="meta-wrapper">
											<span class="meta-icon">
												<i class="fa fa-home"></i>
											</span>
                                                <span class="meta-value">
												<?php
												echo esc_html( get_post_meta( get_the_ID(), 'cre_property_size', true ) );
												echo "\x20\x20\x20";
												echo esc_html( get_post_meta( get_the_ID(), 'cre_property_size_postfix', true ) );
												?>
											</span>
                                                <span class="meta-unit"><?php esc_html_e( 'Area', 'real-home' ); ?></span>
                                            </div>
                                        </div>
                                        <div class="property-meta-info">
                                            <div class="properties-price">
												<?php
												$price = get_post_meta( get_the_ID(), 'cre_property_price', true );
												echo cre_get_settings_price_format( $price )
												?>
                                            </div>
                                        </div>
                                        <div class="post-tags-wrap">
											<?php
											$real_home_property_types = wp_get_post_terms( get_the_ID(), 'property-type' );
											foreach ( $real_home_property_types as $real_home_property_type ) :
												?>
                                                <label class="post-tags">
													<?php echo esc_html( $real_home_property_type->name ); ?>
                                                </label>
											<?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
							<?php
							endwhile;
							?>
							<?php if ( ( ! isset( $_GET['filter-type'] ) ) || ( isset( $_GET['filter-type'] ) && $_GET['filter-type'] == 'default' ) ) : ?>
                                <div class="pagination">
									<?php the_posts_pagination(); ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</div>

<?php
get_footer(); ?>
