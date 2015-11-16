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
					
					<?php
					date_default_timezone_set('America/New_York');

					include 'phpexcel/Classes/PHPExcel/IOFactory.php';
					
					$inputFileName = '/home/rhd/public_html/dev.roundhouse-designs.com/public/the-lambs/wp-content/themes/rhd-the-lambs/lambs-logins.xlsx';
					
					//  Read your Excel workbook
					try {
					    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
					    $objPHPExcel = $objReader->load($inputFileName);
					} catch (Exception $e) {
					    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
					    . '": ' . $e->getMessage());
					}
					
					//  Get worksheet dimensions
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();
					
					//  Loop through each row of the worksheet in turn
					for ($row = 2; $row <= $highestRow; $row++) {
					    //  Read a row of data into an array
					    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
					    NULL, TRUE, FALSE);
					    
					    // Rows: 0 - acct, 1 - fname, 2 - lname, 3 - email, 4 - "exp"
						    
						  if ( $rowData[0][3] && $rowData[0][3] != 'none' ) {
						    $login = strtolower( substr( $rowData[0][1], 0, 1 ) . $rowData[0][2] );
						    
						    $userdata = array(
							    'user_login' => $login,
							    'user_email' => $rowData[0][3],
							    'first_name' => $rowData[0][1],
							    'last_name' => $rowData[0][2],
							    'user_pass' => $rowData[0][0],
							    'role'	=> 'subscriber'
						    );

					    	$user_id = wp_insert_user( $userdata );
						    $exp = ( $rowData[0][4] ) ? 1 : 0;
						    
						    add_user_meta( $user_id, '_exp', $exp );
					    }
					}
					?>

				<?php endwhile; ?>

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>