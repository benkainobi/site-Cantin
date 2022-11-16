<?php
/**
 * Outputs the green Envira Gallery Header
 *
 * @since   1.5.0
 *
 * @package Envira_Gallery
 * @author     David Bisset, Envira Team
 */

$upgrade_link = Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/pricing', 'topbar', 'goPro' );

?>
<div id="envira-header-temp"></div>

	<div id="envira-top-notification" class="envira-header-notification">
		<p>You're using Envira Gallery Lite. To unlock more features, <a href="<?php echo esc_url( $upgrade_link ); ?>" target="_blank"><strong>consider upgrading to Pro.</strong></a></p>
	</div>

<div id="envira-header" class="envira-header">
	<h1 class="envira-logo" id="envira-logo">
		<img src="<?php echo esc_url( $data['logo'] ); ?>" alt="<?php esc_attr_e( 'Envira Gallery', 'envira-gallery-lite' ); ?>" width="339"/>
	</h1>

	<?php do_action( 'envira_admin_in_header', $data ); ?>

</div>
