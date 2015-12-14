<?php ini_set('max_execution_time', 300); ?>

<?php
/**
 * Script to add users from XLSX
 *
 * @package WordPress
 * @subpackage rhd
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<h3>Running...</h3>
					
					<?php $count = 0; ?>
					
					<?php
					$alpha = array(
						'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','uv','w','xyz'
					);
					foreach ( $alpha as $letter ) {
						$handle = fopen( '/home/rhd/public_html/dev.roundhouse-designs.com/public/the-lambs/wp-content/themes/rhd-the-lambs/roster-csv/http_the_lambs_org_past' . $letter . '_htm.csv', 'r' );
					
						$row = 1;
						$arr = array();
						while ( ( $data = fgetcsv( $handle, null, ';' ) ) !== false ) {
							++$row;
							for ($i = 0; $i < 5; ++$i) {
								$val = ( $data[$i] == 'NULL' ) ? null : $data[$i];
								
								$arr[$row][] = $val;
							}
							
							$memb_types = explode( ',', $arr[$row][3] );
							
							foreach ( $memb_types as $type ) {
								$type = strtolower( $type );
								
								if ( stripos( $type, 'cler' ) !== false )
									$type = 'clergy';
								
								elseif ( stripos( $type, 'hon' ) !== false )
									$type = 'honorary-lifetime';
								
								elseif ( stripos( $type, 'jun' ) !== false || stripos( $type, 'jr' ) !== false )
									$type = 'junior-theatrical';
								
								elseif ( stripos( $type, 'res' ) !== false )
									$type = 'non-resident';
								
								elseif ( stripos( $type, 'army' ) !== false || stripos( $type, 'navy' ) !== false )
									$type = 'army-navy';
								
								elseif ( stripos( $type, 'life' ) !== false )
									$type = 'lifetime';
								
								elseif ( stripos( $type, 'non-theat' ) !== false || stripos( $type, 'nontheat' ) !== false )
									$type = 'non-theatrical';
								
								elseif ( stripos( $type, 'theat' ) !== false )
									$type = 'theatrical';
								
								else
									$type = 'uncategorized';
								
								$terms[] = $type;
								unset($type);
							}
							
							$args = array(
								'post_type' => 'club_member',
								'post_title' => $arr[$row][0],
								'post_content' => ' ',
								'post_status' => 'publish'
							);
							$id = wp_insert_post( $args );
							
							if ( $id ) ++$count;
							
							wp_set_object_terms( $id, $terms, 'membership_type', false );
							
							// Year Elected
							add_post_meta( $id, '_ct_text_56382e07e4c3a', $arr[$row][1] );
							
							// Year Died
							add_post_meta( $id, '_ct_text_56382e13b6858', $arr[$row][2] );
							
							//Notes
							add_post_meta( $id, '_ct_text_5638d2dfbf87f', $arr[$row][4] );
							
							unset( $terms );
						}
					fclose($handle);
					echo $count . ' members processed';
				}
				?>
				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>