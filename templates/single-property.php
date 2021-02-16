<?php

get_header();
?>
<div id="content" class="site-content">
	<section class="page-wrapper single-post-wrapper">
		<div class="container">
			<div id="primary" class="content-area">
				<!-- primary-home starting from here -->
				<main id="main" class="site-main">
					<div class="post">
						<figure class="featured-image">
							<?php the_post_thumbnail( 'full' ); ?>
						</figure>
						<header class="entry-header">
							<div class="entry-meta">
								<div class="post-cat-list">
									<?php
									$real_home_property_types = wp_get_post_terms( get_the_ID(), 'property-type' );
									foreach ( $real_home_property_types as $real_home_property_type ) :
										?>
										<span class="cat-links">
                                                <a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) . '?type=' . esc_html( $real_home_property_type->slug ) ); ?>">
                                                    <?php echo esc_html( $real_home_property_type->name ); ?>
                                                </a>
                                            </span>
									<?php endforeach; ?>
								</div>
							</div>
							<h2 class="entry-title">
								<?php
								the_title();
								?>
							</h2>
							<div class="property-location">
								<?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_city', true ) . ',' .esc_html( get_post_meta( get_the_ID(), 'cre_property_state', true )  ) . ',' .esc_html( get_post_meta( get_the_ID(), 'cre_property_country', true ) )); ?>
							
							</div>
							<?php real_home_posted_on( false ); ?>
						</header>
						<div class="entry-content">
							<h4><?php esc_html_e( 'Description', 'real-home' ); ?></h4>
							<?php
							the_content();
							?>
						</div>
						<?php if (get_post_meta( get_the_ID(), 'cre_property_map', true )):?>
							<div class="property-address-wrap">
								<h4><?php esc_html_e( 'Address', 'real-home' ); ?></h4>
								<ul>
									<li>
									<span class="property-address-heading">
                                        <?php esc_html_e( 'address:', 'real-home' ); ?>
									</span>
										<span class="property-address-info">
									<?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_address', true ) ); ?>
									</span>
									</li>
									<li>
									<span class="property-address-heading">
									<?php esc_html_e( 'city:', 'real-home' ); ?>
									</span>
										<span class="property-address-info">
									<?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_city', true ) ); ?>
									</span>
									</li>
									<li>
									<span class="property-address-heading">
									<?php esc_html_e( 'area:', 'real-home' ); ?>

									</span>
										<span class="property-address-info">
									<?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_area', true ) ); ?>
									</span>
									</li>
									<li>
									<span class="property-address-heading">
									<?php esc_html_e( 'state:', 'real-home' ); ?>
									</span>
										<span class="property-address-info">
                                        <?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_state', true ) ); ?>
                                    </span>
									</li>
									<li>
									<span class="property-address-heading">
									<?php esc_html_e( 'zip:', 'real-home' ); ?>
									</span>
										<span class="property-address-info">
									    <?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_zip', true ) ); ?>
									</span>
									</li>
									<li>
									<span class="property-address-heading">
									<?php esc_html_e( 'country:', 'real-home' ); ?>
									</span>
										<span class="property-address-info">
									<?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_country', true ) ); ?>
									</span>
									</li>
									<li class="address-map">
										<a href="<?php echo esc_url( 'https://www.openstreetmap.org/search?query=' . get_post_meta( get_the_ID(), 'cre_property_location', true ) ); ?>"><?php esc_html_e( 'open in google map', 'real-home' ); ?></a>
									</li>
								</ul>
							</div>
						<?php endif;?>
						<div class="property-meta entry-meta">
							<h4><?php esc_html_e( 'Main Detail', 'real-home' ); ?></h4>
							<div class="meta-wrapper">
								<span class="meta-icon">
									<i class="fa fa-bed"></i>
								</span>
								<span class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_bedrooms', true ) ); ?></span>
								<span class="meta-unit"><?php esc_html_e( 'bedroom', 'real-home' ); ?></span>
							</div>
							<div class="meta-wrapper">
								<span class="meta-icon">
									<i class="fa fa-bath"></i>

								</span>
								<span class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_bathrooms', true ) ); ?></span>
								<span class="meta-unit"><?php esc_html_e( 'bathroom', 'real-home' ); ?></span>
							</div>
							<div class="meta-wrapper">
								<span class="meta-icon">
									<i class="fa fa-car"></i>
								</span>
								<span class="meta-value"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_garage', true ) ); ?></span>
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
							<div class="meta-wrapper">
								<span class="meta-icon">
									<i class="fa fa-calendar"></i>
								</span>
								<span class="meta-unit"><?php esc_html_e( 'year built', 'real-home' ); ?></span>
								<span class="meta-unit"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_year_built', true ) ); ?></span>
							</div>
						</div>
						<div class="property-other-detail">
							<h4><?php esc_html_e( 'Others Detail', 'real-home' ); ?></h4>
							<ul>
								<li>
									<span class="other-detail-heading"><?php esc_html_e( 'property Id:', 'real-home' ); ?> </span>
									<span class="other-detail-info"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_id', true ) ); ?></span>
								</li>
								<li>
									<span class="other-detail-heading"><?php esc_html_e( 'price:', 'real-home' ); ?></span>
									<span class="other-detail-info"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_price_prefix', true ) ) . '&nbsp' . cre_get_settings_price_format( get_post_meta( get_the_ID(), 'cre_property_price', true ) ) . '&nbsp' . esc_html( get_post_meta( get_the_ID(), 'cre_property_price_postfix', true ) ); ?></span>
								</li>
								<li>
									<span class="other-detail-heading"><?php esc_html_e( 'property lot size:', 'real-home' ); ?> </span>
									<span class="other-detail-info"><?php echo esc_html( get_post_meta( get_the_ID(), 'cre_property_lot_size', true ) ) . '&nbsp' . esc_html( get_post_meta( get_the_ID(), 'cre_property_lot_size_postfix', true ) ); ?></span>
								</li>
							</ul>
						</div>
						<div class="property-gallery">
							<h4><?php esc_html_e( 'Gallery', 'real-home' ); ?></h4>
							<div class="property-gallery-slider">
								<?php
								$images_id = get_post_meta( get_the_ID(), 'cre_property_images' );
								
								foreach ( $images_id as $image_id ) :
									$image_attr = wp_get_attachment_image_src( $image_id, 'full' );
									?>
									<figure>
										<img src="<?php echo esc_url( $image_attr[0] ); ?>">
									</figure>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
	</section>
</div>

<?php

get_footer()
?>
