<?php
/**
 * Welcome class.
 *
 * @since 1.8.1
 *
 * @package Envira_Gallery
 * @author  Envira Gallery Team
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome Class
 *
 * @since 1.7.0
 *
 * @package Envira_Gallery
 * @author  Envira Gallery Team <support@enviragallery.com>
 */
class Envira_Welcome {

	/**
	 * Envira Welcome Pages.
	 *
	 * @var array
	 */
	public $pages = array(
		'envira-gallery-lite-get-started',
		'envira-gallery-lite-welcome',
		'envira-gallery-lite-partners',
		'envira-gallery-lite-upgrade',
		'envira-gallery-lite-litevspro',
	);

	/**
	 * Holds the submenu pagehook.
	 *
	 * @since 1.7.0
	 *
	 * @var string`
	 */
	public $hook;

	/**
	 * Helper method for installed plugins
	 *
	 * @since 1.7.0
	 *
	 * @var array
	 */
	public $installed_plugins;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.8.1
	 */
	public function __construct() {

		if ( ( defined( 'ENVIRA_WELCOME_SCREEN' ) && false === ENVIRA_WELCOME_SCREEN ) || apply_filters( 'envira_whitelabel', false ) === true ) {
			return;
		}

		// Add custom addons submenu.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 15 );

		// Add custom CSS class to body.
		add_filter( 'admin_body_class', array( $this, 'admin_welcome_css' ), 15 );

		// Add scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'admin_head', array( $this, 'envira_menu_styles' ) );

		// Misc.
		add_action( 'admin_print_scripts', array( $this, 'disable_admin_notices' ) );

	}

	/**
	 * Add custom CSS to admin body tag.
	 *
	 * @since 1.8.1
	 * @param array $classes CSS Classes.
	 * @return array
	 */
	public function admin_welcome_css( $classes ) {

		if ( ! is_admin() ) {
			return;
		}

		$classes .= ' envira-welcome-enabled ';

		return $classes;

	}

	/**
	 * Register and enqueue addons page specific JS.
	 *
	 * @since 1.5.0
	 */
	public function enqueue_admin_scripts() {
		if ( isset( $_GET['post_type'] ) && isset( $_GET['page'] ) && 'envira' === wp_unslash( $_GET['post_type'] ) && in_array( wp_unslash( $_GET['page'] ), $this->pages ) ) { // @codingStandardsIgnoreLine

			wp_register_script( ENVIRA_SLUG . '-welcome-script', plugins_url( 'assets/js/welcome.js', ENVIRA_FILE ), array( 'jquery' ), ENVIRA_VERSION, true );
			wp_enqueue_script( ENVIRA_SLUG . '-welcome-script' );
			wp_localize_script(
				ENVIRA_SLUG . '-welcome-script',
				'envira_gallery_welcome',
				array(
					'activate_nonce'   => wp_create_nonce( 'envira-gallery-activate-partner' ),
					'active'           => __( 'Status: Active', 'envira-gallery-lite' ),
					'activate'         => __( 'Activate', 'envira-gallery-lite' ),
					'get_addons_nonce' => wp_create_nonce( 'envira-gallery-get-addons' ),
					'activating'       => __( 'Activating...', 'envira-gallery-lite' ),
					'ajax'             => admin_url( 'admin-ajax.php' ),
					'deactivate'       => __( 'Deactivate', 'envira-gallery-lite' ),
					'deactivate_nonce' => wp_create_nonce( 'envira-gallery-deactivate-partner' ),
					'deactivating'     => __( 'Deactivating...', 'envira-gallery-lite' ),
					'inactive'         => __( 'Status: Inactive', 'envira-gallery-lite' ),
					'install'          => __( 'Install', 'envira-gallery-lite' ),
					'install_nonce'    => wp_create_nonce( 'envira-gallery-install-partner' ),
					'installing'       => __( 'Installing...', 'envira-gallery-lite' ),
					'proceed'          => __( 'Proceed', 'envira-gallery-lite' ),
				)
			);
		}
	}

	/**
	 * Register and enqueue addons page specific CSS.
	 *
	 * @since 1.8.1
	 */
	public function enqueue_admin_styles() {

		if ( isset( $_GET['post_type'] ) && isset( $_GET['page'] ) && 'envira' === wp_unslash( $_GET['post_type'] ) && in_array( wp_unslash( $_GET['page'] ), $this->pages ) ) { // @codingStandardsIgnoreLine

			wp_register_style( ENVIRA_SLUG . '-welcome-style', plugins_url( 'assets/css/welcome.css', ENVIRA_FILE ), array(), ENVIRA_VERSION );
			wp_enqueue_style( ENVIRA_SLUG . '-welcome-style' );

		}

		// Run a hook to load in custom styles.
		do_action( 'envira_gallery_addons_styles' );

	}

	/**
	 * Add custom CSS to block out certain menu items ONLY when welcome screen is activated.
	 *
	 * @since 1.8.1
	 */
	public function envira_menu_styles() {

		if ( is_admin() ) {

			?>

			<style>

			/* ==========================================================================
			Menu
			========================================================================== */
			li#menu-posts-envira ul li:last-child,
			li#menu-posts-envira ul li:nth-last-child(2),
			li#menu-posts-envira ul li:nth-last-child(3),
			li#menu-posts-envira ul li:nth-last-child(4) {
				display: none;
			}

			</style>

			<?php

		}

	}

	/**
	 * Making page as clean as possible
	 *
	 * @since 1.8.1
	 */
	public function disable_admin_notices() {

		global $wp_filter;

		if ( isset( $_GET['post_type'] ) && isset( $_GET['page'] ) && 'envira' === wp_unslash( $_GET['post_type'] ) && in_array( wp_unslash( $_GET['page'] ), $this->pages ) ) { // @codingStandardsIgnoreLine

			if ( isset( $wp_filter['user_admin_notices'] ) ) {
				unset( $wp_filter['user_admin_notices'] );
			}
			if ( isset( $wp_filter['admin_notices'] ) ) {
				unset( $wp_filter['admin_notices'] );
			}
			if ( isset( $wp_filter['all_admin_notices'] ) ) {
				unset( $wp_filter['all_admin_notices'] );
			}
		}

	}

	/**
	 * Helper Method to get partner plugins
	 *
	 * @since 1.8.5
	 *
	 * @return array
	 */
	public function get_partners() {

		$partners = array(
			'shortpixel'            => array(
				'name'        => 'ShortPixel Image Optimizer',
				'description' => 'Speed up your website & boost your SEO by compressing old & new images and PDFs. AVIF & WebP convert and optimize support.',
				'icon'        => plugins_url( 'assets/images/partners/shortpixel.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/shortpixel-image-optimiser.zip',
				'basename'    => 'shortpixel-image-optimiser/wp-shortpixel.php',
			),
			'soliloquy'             => array(
				'name'        => 'Slider by Soliloquy – Responsive Image Slider for WordPress',
				'description' => 'The best WordPress slider plugin. Drag & Drop responsive slider builder that helps you create a beautiful image slideshows with just a few clicks.',
				'icon'        => plugins_url( 'assets/images/partners/soliloquy.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/soliloquy-lite.zip',
				'basename'    => 'soliloquy-lite/soliloquy-lite.php',
			),
			'envira-gallery-lite'   => array(
				'name'        => 'PDF Embedder',
				'description' => 'Embed PDF files directly into your posts and pages, with intelligent responsive resizing, and no third-party services or iframes.',
				'icon'        => plugins_url( 'assets/images/partners/pdf-embedder.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/pdf-embedder.zip',
				'basename'    => 'pdf-embedder/pdf_embedder.php',
			),
			'google_drive_embedder' => array(
				'name'        => 'Google Drive Embedder',
				'description' => 'Browse for Google Drive documents and embed directly in your posts/pages. This WordPress plugin extends the Google Apps Login plugin so no extra user …',
				'icon'        => plugins_url( 'assets/images/partners/google-drive.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/google-drive-embedder.zip',
				'basename'    => 'google-drive-embedder/google_drive_embedder.php',
			),
			'google_apps_login'     => array(
				'name'        => 'Google Apps Login',
				'description' => 'Simple secure login and user management through your Google Workspace for WordPress (uses secure OAuth2, and MFA if enabled)',
				'icon'        => plugins_url( 'assets/images/partners/google-apps.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/google-apps-login.zip',
				'basename'    => 'google-apps-login/google_apps_login.php',

			),
			'all_in_one'            => array(
				'name'        => 'All-In-One Intranet',
				'description' => 'Instantly turn your WordPress installation into a private corporate intranet',
				'icon'        => plugins_url( 'assets/images/partners/allinone.png', ENVIRA_FILE ),
				'url'         => 'https://downloads.wordpress.org/plugin/all-in-one-intranet.zip',
				'basename'    => 'all-in-one-intranet/basic_all_in_one_intranet.php',

			),

		);
		return $partners;
	}

	/**
	 * Register the Welcome submenu item for Envira.
	 *
	 * @since 1.8.1
	 */
	public function admin_menu() {
		$whitelabel = apply_filters( 'envira_whitelabel', false ) ? '' : __( 'Envira Gallery ', 'envira-gallery-lite' );
		// Register the submenus.
		add_submenu_page(
			'edit.php?post_type=envira',
			$whitelabel . __( 'Get Started', 'envira-gallery-lite' ),
			'<span style="color:#FFA500"> ' . __( 'Get Started', 'envira-gallery-lite' ) . '</span>',
			apply_filters( 'envira_gallery_menu_cap', 'manage_options' ),
			ENVIRA_SLUG . '-get-started',
			array( $this, 'help_page' )
		);

		add_submenu_page(
			'edit.php?post_type=envira',
			$whitelabel . __( 'Upgrade Envira Gallery', 'envira-gallery-lite' ),
			'<span style="color:#FFA500"> ' . __( 'Upgrade Envira Gallery', 'envira-gallery-lite' ) . '</span>',
			apply_filters( 'envira_gallery_menu_cap', 'manage_options' ),
			ENVIRA_SLUG . '-upgrade',
			array( $this, 'upgrade_page' )
		);

		add_submenu_page(
			'edit.php?post_type=envira',
			$whitelabel . __( 'Lite vs Pro', 'envira-gallery-lite' ),
			'<span style="color:#FFA500"> ' . __( 'Lite vs Pro', 'envira-gallery-lite' ) . '</span>',
			apply_filters( 'envira_gallery_menu_cap', 'manage_options' ),
			ENVIRA_SLUG . '-litevspro',
			array( $this, 'lite_vs_pro_page' )
		);

		add_submenu_page(
			'edit.php?post_type=envira',
			$whitelabel . __( 'Welcome', 'envira-gallery-lite' ),
			'<span style="color:#FFA500"> ' . __( 'Welcome', 'envira-gallery-lite' ) . '</span>',
			apply_filters( 'envira_gallery_menu_cap', 'manage_options' ),
			ENVIRA_SLUG . '-welcome',
			array( $this, 'welcome_page' )
		);

		add_submenu_page(
			'edit.php?post_type=envira',
			$whitelabel . __( 'Partners', 'envira-gallery-lite' ),
			'<span style="color:#FFA500"> ' . __( 'Partners', 'envira-gallery-lite' ) . '</span>',
			apply_filters( 'envira_gallery_menu_cap', 'manage_options' ),
			ENVIRA_SLUG . '-partners',
			array( $this, 'partners_page' )
		);

	}

	/**
	 * Output welcome text and badge for What's New and Credits pages.
	 *
	 * @since 1.8.1
	 */
	public static function welcome_text() {

		// Switch welcome text based on whether this is a new installation or not.
		$welcome_text = ( self::is_new_install() )
			? esc_html__( 'Thank you for installing Envira Lite! Envira provides great gallery features for your WordPress site!', 'envira-gallery-lite' )
			: esc_html__( 'Thank you for updating! Envira Lite has many recent improvements that you will enjoy.', 'envira-gallery-lite' );

		?>
		<?php /* translators: %s: version */ ?>
		<h1 class="welcome-header"><?php printf( esc_html__( 'Welcome to %1$s Envira Gallery Lite %2$s', 'envira-gallery-lite' ), '<span class="envira-leaf"></span>&nbsp;', esc_html( self::display_version() ) ); ?></h1>

		<div class="about-text">
			<?php
			if ( self::is_new_install() ) {
				echo esc_html( $welcome_text );
			} else {
				printf( $welcome_text, self::display_version() ); // @codingStandardsIgnoreLine
			}
			?>
		</div>

		<?php
	}

	/**
	 * Output tab navigation
	 *
	 * @since 2.2.0
	 *
	 * @param string $tab Tab to highlight as active.
	 */
	public static function tab_navigation( $tab = 'whats_new' ) {
		?>

		<h3 class="nav-tab-wrapper">
			<a class="nav-tab
			<?php
			if ( isset( $_GET['page'] ) && 'envira-gallery-lite-welcome' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) : // @codingStandardsIgnoreLine
				?>
				nav-tab-active<?php endif; ?>" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'post_type' => 'envira',
								'page'      => 'envira-gallery-lite-welcome',
							),
							'edit.php'
						)
					)
				);
				?>
														">
				<?php esc_html_e( 'What&#8217;s New', 'envira-gallery-lite' ); ?>
			</a>
			<a class="nav-tab
			<?php
			if ( isset( $_GET['page'] ) && 'envira-gallery-lite-get-started' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) : // @codingStandardsIgnoreLine
				?>
				nav-tab-active<?php endif; ?>" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'post_type' => 'envira',
								'page'      => 'envira-gallery-lite-get-started',
							),
							'edit.php'
						)
					)
				);
				?>
														">
				<?php esc_html_e( 'Get Started', 'envira-gallery-lite' ); ?>
			</a>
			<a class="nav-tab
			<?php
			if ( isset( $_GET['page'] ) && 'envira-gallery-lite-litevspro' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) : // @codingStandardsIgnoreLine
				?>
				nav-tab-active<?php endif; ?>" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'post_type' => 'envira',
								'page'      => 'envira-gallery-lite-litevspro',
							),
							'edit.php'
						)
					)
				);
				?>
														">
				<?php esc_html_e( 'Lite vs Pro', 'envira-gallery-lite' ); ?>
			</a>
			<a class="nav-tab
			<?php
			if ( isset( $_GET['page'] ) && 'envira-gallery-lite-upgrade' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) : // @codingStandardsIgnoreLine
				?>
				nav-tab-active<?php endif; ?>" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'post_type' => 'envira',
								'page'      => 'envira-gallery-lite-upgrade',
							),
							'edit.php'
						)
					)
				);
				?>
														">
				<?php esc_html_e( 'Unlock Pro', 'envira-gallery-lite' ); ?>
			</a>
			<a class="nav-tab
			<?php
			if ( isset( $_GET['page'] ) && 'envira-gallery-lite-partners' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) : // @codingStandardsIgnoreLine
				?>
				nav-tab-active<?php endif; ?>" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'post_type' => 'envira',
								'page'      => 'envira-gallery-lite-partners',
							),
							'edit.php'
						)
					)
				);
				?>
														">
				<?php esc_html_e( 'Partners', 'envira-gallery-lite' ); ?>
			</a>
		</h3>

		<?php
	}

	/**
	 * Output the about screen.
	 *
	 * @since 1.8.5
	 */
	public function welcome_page() {
		?>
		<?php self::tab_navigation( __METHOD__ ); ?>
		<div class="envira-welcome-wrap envira-welcome">

				<div class="envira-welcome-main">

					<div class="envira-welcome-panel">
					<div class="wraps upgrade-wrap">
					<h2 class="headline-title">

						<?php
						/* translators: %s: plugin version */
						printf( esc_html__( 'Welcome to Envira Gallery Lite %1$s', 'envira-gallery-lite' ), esc_html( self::display_version() ) );
						?>
					</h2>

					<h4 class="headline-subtitle"><?php esc_html_e( 'Envira Gallery is the most beginner-friendly drag &amp; drop WordPress gallery plugin.', 'envira-gallery-lite' ); ?></h2>
				</div>
						<div class="wraps about-wsrap">

							<div class="envira-panel envira-lite-updates-panel">
								<h3 class="title"><?php esc_html_e( 'Recent Updates To Envira Lite:', 'envira-gallery-lite' ); ?></h3>

								<div class="envira-recent envirathree-column">
									<div class="enviracolumn">
											<h4 class="title"><?php esc_html_e( 'Bug Fixes', 'envira-gallery-lite' ); ?> <span class="badge updated">UPDATED</span></h4>
											<?php /* translators: %1$s: link */ ?>
											<p><?php printf( esc_html__( 'Bugs involving automatic and column galleries on the same page, certain character displaying in the admin, and Gutenberg Block tweaks.' ) ); ?></p>
									</div>
									<div class="enviracolumn">
											<h4 class="title"><?php esc_html_e( 'Gutenberg Block', 'envira-gallery-lite' ); ?></h4>
											<?php /* translators: %1$s: link */ ?>
											<p><?php printf( esc_html__( 'Improved support and additional features for the Envira Lite Gutenberg block. Bug fixes involving the gallery preview and items that were appearing out of order.' ) ); ?></p>
									</div>

									<div class="enviracolumn">
											<h4 class="title"><?php esc_html_e( 'Enhancements', 'envira-gallery-lite' ); ?></h4>
											<p><?php printf( esc_html__( 'Ability to set margins for Automatic Layouts. Also better workings with various popular WordPress plugins and themes.', 'envira-gallery-lite' ) ); ?></p>
									</div>
								</div>

							</div>


							<div class="envira-panel envira-pro-updates-panel">

								<h3>Recent Updates To Envira Pro:</h3>
								<div class="envira-pro-updates-features">
								<div class="envira-feature">
									<img class="icon" src="<?php echo esc_url( trailingslashit( ENVIRA_URL ) . 'assets/images/drag-drop-icon.png' ); ?>" />
									<h4 class="feature-title"><?php esc_html_e( 'Getting Better And Better!', 'envira-gallery-lite' ); ?></h4>
									<?php /* translators: %1$s: url, %2$s url */ ?>
									<p><?php printf( esc_html__( 'This latest update contains enhancements and improvements - some of which are based on your user feedback! Check out %1$s.', 'envira-gallery-lite' ), '<a target="_blank" href="' . esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/docs/how-to-configure-your-gallery-settings', 'whatsnewtab', 'checkoutourchangelog', '#envira-changelog' ) . '">our changelog</a>' ) ); ?></p>
								</div>

								<div class="envira-feature opposite">
									<img class="icon" src="<?php echo esc_url( trailingslashit( ENVIRA_URL ) . 'assets/images/proofing-icon.png' ); ?>" />
									<h4 class="feature-title">
										<?php esc_html_e( 'Proofing Addon', 'envira-gallery-lite' ); ?>
									</h4>
									<p>
										<?php /* translators: %1$s: url, %2$s url */ ?>
										<?php printf( esc_html__( 'New and improved features and functions make client image proofing even easier for your photography business.', 'envira-gallery-lite' ) ); ?>
										</p>
								</div>

								<div class="envira-feature">
								<img class="icon" src="<?php echo esc_url( plugins_url( 'assets/images/icons/automatic-layout.png', ENVIRA_FILE ) ); ?>" />
								<h4 class="feature-title"><?php esc_html_e( 'Gallery Layouts', 'envira-gallery-lite' ); ?> <span class="badge updated">NEW</span> </h4>
								<?php /* translators: %1$s: button */ ?>
								<p><?php printf( esc_html__( 'New and improved features and functions make client image proofing even easier for your photography business.' ) ); ?></p>
								</div>

								<div class="envira-feature opposite">
								<img class="icon" src="<?php echo esc_url( trailingslashit( ENVIRA_URL ) . 'assets/images/audio_icon.png' ); ?>" style="border: 1px solid #000;" />
								<h4 class="feature-title"><?php esc_html_e( 'Audio Addon', 'envira-gallery-lite' ); ?> <span class="badge updated">NEW</span> </h4>
								<?php /* translators: %1$s: button */ ?>
								<p><?php printf( esc_html__( 'This addon allows you to easily add an audio track (such as background music or a narration) to the lightboxes in your Envira galleries. %s', 'envira-gallery-lite' ), '<a target="_blank" href="' . esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/audio-addon/', 'whatsnewtab', 'audioaddonreadmore', '' ) . '">Read More</a>' ) ); ?></p>
								</div>
								</div>
							</div>

						</div>

					</div>

				</div>

		</div> <!-- wrap -->

		<?php
	}

	/**
	 * Output the about screen.
	 *
	 * @since 1.8.1
	 */
	public function help_page() {
		?>
		<?php self::tab_navigation( __METHOD__ ); ?>

		<div class="envira-welcome-wrap envira-help">

			<div class="envira-get-started-main">

				<div class="envira-get-started-section">

						<div class="envira-admin-get-started-panel envira-panel">

							<div class="section-text text-left">
								<h3>Creating your first gallery</h3>
								<h2>Welcome to Envira Gallery</h2>

								<p>Want to get started creating your first gallery? By following the step by step instructions in this walkthrough, you can easily publish your first gallery on your site. To begin, you’ll need to be logged into the WordPress admin area. Once there, click on Envira Gallery in the admin sidebar to go the Add New page. This will launch the Envira Gallery Builder.</p>

								<a href="" class="button envira-button envira-secondary-button">
								<svg
	xmlns="http://www.w3.org/2000/svg"
	width="15px"
	height="15px"
	fill="#7cc048"
	viewBox="0 0 512 512"
	>
	<path d="M0 96l160-64v384L0 480zM192 16l160 96v368l-160-80zM384 112l128-96v384l-128 96z"></path>
	</svg>
								Read the Setup Guide</a>

							</div>

							<div class="feature-photo-column">
									<img class="feature-photo" src="<?php echo esc_url( plugins_url( 'assets/images/get-started/creating.png', ENVIRA_FILE ) ); ?>" />
							</div>

						</div> <!-- panel -->

						<div class="envira-admin-upgrade-panel envira-panel">

							<div class="section-text-column text-left">

								<h2>Upgrade to a complete Envira Gallery experience</h2>

								<p>Get the most out of Envira Gallery by <a target="_blank" href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( false, 'gettingstartedtab', 'upgradetounlockallitspowerfulfeatures' ) ); ?>">upgrading to unlock all of its powerful features</a>.</p>

								<p>With Envira Gallery Pro, you can unlock amazing features like:</p>

								<ul>
									<li>Get your gallery set up in minutes with pre-built customizable templates </li>
									<li>Have more people find you on Google by making your galleries SEO friendly </li>
									<li>Display your photos in all their glory on mobile with a true full-screen experience. No bars, buttons or small arrows</li>
									<li>Tag your images for better organization and gallery display</li>
									<li>Improve load times and visitor experience by splitting your galleries into multiple pages </li>
									<li>Streamline your workflow by sharing your gallery images directly on your favorite social media networks </li>
									</li>
								</ul>
								<a href="#" class="button envira-button envira-primary-button">Unlock Pro</a>
							</div>

							<div class="feature-photo-column">
									<img class="feature-photo" src="<?php echo esc_url( plugins_url( 'assets/images/envira-admin.png', ENVIRA_FILE ) ); ?>" />
							</div>

						</div> <!-- panel -->

						<div class="envira-admin-get-started-banner bottom">

							<div class="banner-text">
								<h3>Start Creating Responsive Photo Galleries</h3>
								<p>Customize and Publish in Minutes... What are you waiting for?</p>
							</div>
							<div class="banner-button">
								<a target="_blank" href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( false, 'getstartedtab', 'getenviragallerynowbutton' ) ); ?>" class="button button-primary">Get Envira Gallery Now</a>
							</div>

						</div> <!-- banner -->
						<div class="envira-admin-3-col envira-help-section">
							<div class="envira-cols">
							<svg
	xmlns="http://www.w3.org/2000/svg"
	width="50px"
	viewBox="0 0 512 512"
	fill="#454346"
	>
	<path d="M432 0H48C21.6 0 0 21.6 0 48v416c0 26.4 21.6 48 48 48h384c26.4 0 48-21.6 48-48V48c0-26.4-21.6-48-48-48zm-16 448H64V64h352v384zM128 224h224v32H128zm0 64h224v32H128zm0 64h224v32H128zm0-192h224v32H128z"></path>
	</svg>
								<h3>Help and Documention</h3>
								<p>The Envira Gallery wiki has helpful documentation, tips, tricks, and code snippets to help you get started.</p>
								<a href="#" class="button envira-button envira-primary-button">Browse the docs</a>
							</div>
							<div class="envira-cols">
							<svg
	xmlns="http://www.w3.org/2000/svg"
	width="50px"
	viewBox="0 0 512 512"
	fill="#A32323"

	>
	<path d="M256 0C114.615 0 0 114.615 0 256s114.615 256 256 256 256-114.615 256-256S397.385 0 256 0zm-96 256c0-53.02 42.98-96 96-96s96 42.98 96 96-42.98 96-96 96-96-42.98-96-96zm302.99 85.738l-88.71-36.745C380.539 289.901 384 273.355 384 256s-3.461-33.901-9.72-48.993l88.71-36.745C473.944 196.673 480 225.627 480 256s-6.057 59.327-17.01 85.738zM341.739 49.01l-36.745 88.71C289.902 131.461 273.356 128 256 128s-33.901 3.461-48.993 9.72l-36.745-88.711C196.673 38.057 225.628 32 256 32c30.373 0 59.327 6.057 85.739 17.01zM49.01 170.262l88.711 36.745C131.462 222.099 128 238.645 128 256s3.461 33.901 9.72 48.993l-88.71 36.745C38.057 315.327 32 286.373 32 256s6.057-59.327 17.01-85.738zM170.262 462.99l36.745-88.71C222.099 380.539 238.645 384 256 384s33.901-3.461 48.993-9.72l36.745 88.71C315.327 473.942 286.373 480 256 480s-59.327-6.057-85.738-17.01z"></path>
	</svg>
								<h3>Get Support</h3>
								<p>Submit a support ticket and our world class support will be in touch.</p>
								<a href="#" class="button envira-button envira-primary-button">Unlock Pro</a>
							</div>
							<div class="envira-cols">
							<svg
	xmlns="http://www.w3.org/2000/svg"
	x="0"
	y="0"
	version="1.1"
	viewBox="0 0 256 256"
	xmlSpace="preserve"
	width="50px"
	>
	<path
		fill="#7CC048"
		d="M87.59 183.342c42.421 33.075 82.686 19.086 101.079 17.141l33.107 32.912H234l-38.011-37.781C195.696 172.965 247.988 26.3 23 26.3c24.504 84.486 22.163 123.991 64.59 157.042m40.886-62.735c10.723 19.952 29.62 50.381 42.937 60.168 13.302 9.789 27.772 16.947-2.893 4.004-30.661-12.982-53.056-49.711-67.895-77.54-11.414-21.39-21.243-40.903-42.528-55.348-21.284-14.479 2.477-4.298 2.477-4.298 38.9 18.989 53.003 45.217 67.902 73.014"
	></path>
	</svg>
								<h3>Enjoying Envira Gallery?</h3>
								<p>Submit a support ticket and our world class support will be in touch.</p>
								<a href="#" class="button envira-button envira-primary-button">Leave a Review</a>
							</div>
						</div>
			</div>

		</div> <!-- wrap -->


		<?php
	}

	/**
	 * Output the upgrade screen.
	 *
	 * @since 1.8.1
	 */
	public function upgrade_page() {
		?>
		<?php self::tab_navigation( __METHOD__ ); ?>

		<div class="envira-welcome-wrap envira-help">

			<div class="envira-get-started-main">


				<div class="envira-get-started-panel">

					<div class="wraps upgrade-wrap">

						<h2 class="headline-title"><?php esc_html_e( 'Make Your Galleries Amazing!', 'envira-gallery-lite' ); ?></h2>

						<h4 class="headline-subtitle"><?php esc_html_e( 'Upgrade To Envira Pro and can get access to our full suite of features.', 'envira-gallery-lite' ); ?></h4>

						<a target="_blank" href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( false, 'upgradeenviragallerytab', 'upgradetoenviraprobutton' ) ); ?>" class="button envira-button envira-primary-button">Upgrade To Envira Pro</a>

					</div>

					<div class="upgrade-list">

							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/albums-addon/', 'upgradeenviragallerytab', 'albumsaddon', '' ) ); ?>">
									<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/albums-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Albums Addon</h5>
									<p>Organize your galleries in Albums, choose cover photos and more.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/elementor-addon/', 'upgradeenviragallerytab', 'elementor', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/logo-elementor.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Elementor Addon</h5>
									<p>Sync your image and video galleries directly inside the Elementor page builder.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/demo/envira-gallery-theme-demo/', 'upgradeenviragallerytab', 'gallerythemesandlayouts', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/gallery-templates-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Gallery Themes/Layouts</h5>
									<p>Build responsive WordPress galleries that work on mobile, tablet and desktop devices.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/videos-addon/', 'upgradeenviragallerytab', 'videogalleries', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/videos-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Video Galleries</h5>
									<p>Not just for photos! Embed YouTube, Vimeo, Wistia, DailyMotion, Facebook, Instagram, Twitch, VideoPress, and self-hosted videos in your gallery.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/social-addon/', 'upgradeenviragallerytab', 'socialaddon', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/social-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Social Addon</h5>
									<p>Allows users to share photos via email, Facebook, Twitter, Pinterest, LinkedIn and WhatsApp.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/proofing-addon/', 'upgradeenviragallerytab', 'imageproofing', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/proofing-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Image Proofing</h5>
									<p>Client image proofing made easy for your photography business.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/woocommerce-addon/', 'upgradeenviragallerytab', 'ecommerce', '' ) ); ?>">
								<div class="feature-icon">

										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/woo-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Ecommerce</h5>
									<p>Instantly display and sell your photos with our native WooCommerce integration.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/deeplinking-addon/', 'upgradeenviragallerytab', 'deeplinking', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/deeplinking-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Deeplinking</h5>
									<p>Make your gallery SEO friendly and easily link to images with deeplinking.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/slideshow-addon/', 'upgradeenviragallerytab', 'slideshows', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/slideshow-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Slideshows</h5>
									<p>Enable slideshows for your galleries, controls autoplay settings and more.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/lightroom-addon/', 'upgradeenviragallerytab', 'lightroomintegration', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/lightroom-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Lightroom Integration</h5>
									<p>Automatically create & sync photo galleries from your Adobe Lightroom collections.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/addons/protection-addon/', 'upgradeenviragallerytab', 'downloadprotection', '' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/protection-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Download Protection</h5>
									<p>Prevent visitors from downloading your images without permission.</p>
								</div>
								</a>
							</div>
							<div>
								<div class="interior">
								<a href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( 'https://enviragallery.com/features/image-compression/', 'upgradeenviragallerytab', 'imagecompression' ) ); ?>">
								<div class="feature-icon">
										<img src="<?php echo esc_url( plugins_url( 'assets/images/features/image-compress-icon.png', ENVIRA_FILE ) ); ?>" />
									</div>
									<h5>Image Compression</h5>
									<p>Reduce the file size of your images and make your site run fast.</p>
								</div>
								</a>
							</div>
						</ul>

					</div>

				</div>

			</div>

		</div> <!-- wrap -->


		<?php
	}

	/**
	 * Output the upgrade screen.
	 *
	 * @since 1.8.1
	 */
	public function lite_vs_pro_page() {
		?>
		<?php self::tab_navigation( __METHOD__ ); ?>

		<div class="envira-welcome-wrap envira-help">

			<div class="envira-get-started-main">


				<div class="envira-get-started-panel">

				<div id="envira-admin-litevspro" class="wrap envira-admin-wrap">

				<div class="wraps upgrade-wrap">
					<h2 class="headline-title">
						<strong>Lite</strong> vs <strong>Pro</strong>
					</h2>

					<h4 class="headline-subtitle">Get the most out of Envira by upgrading to Pro and unlocking all of the powerful features.</h2>
				</div>

				<div class="envira-admin-litevspro-section no-bottom envira-admin-litevspro-section-table">

						<table cellspacing="0" cellpadding="0" border="0">
							<thead>
								<th>Feature</th>
								<th>Lite</th>
								<th>Pro</th>
							</thead>
							<tbody>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Gallery Themes And Layouts</p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-partial">
											<strong>Basic Gallery Theme</strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Gallery Themes &amp; Layouts</strong>
											More themes to make your Galleries unique and professional.
										</p>
									</td>
								</tr>

								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Lightbox Features</p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-partial">
											<strong>Basic Lightbox</strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Advanced Lightbox Features</strong>
											Multiple themes for your Gallery Lightbox display, Titles, Transitions, Fullscreen, Counter, Thumbnails
										</p>
									</td>
								</tr>

								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Mobile Features</p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-partial">
											<strong>Basic Mobile Gallery  </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Advanced Mobile Settings</strong>Customize all aspects of your user's mobile gallery display experience to be different than the default desktop</p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Import/Export Options </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong>Limited Import/Export </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Import/Export </strong> Instagram, Dropbox, NextGen, Flickr, Zip and more</p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Video Galleries  </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong> No Videos  </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Videos Gallery </strong> Import your own videos or from any major video sharing platform</p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Social Sharing   </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong>No Social Sharing     </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Social Sharing Features</strong>Share your photos on any major social sharing platform</p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Advanced Gallery Features  </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong>  No Advanced Features     </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong>All Advanced Features</strong>Albums, Ecommerce, Pagination, Deeplinking, and Expanded Gallery Configurations</p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Envira Gallery Addons      </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong>  No Addons Included  </strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong> All Addons Included</strong>WooCommerce, Tags and Filters, Proofing, Schedule, Password Protection, Lightroom, Slideshows, Watermarking and more (28 total)            </p>
									</td>
								</tr>
								<tr class="envira-admin-columns">
									<td class="envira-admin-litevspro-first-column">
										<p>Customer Support </p>
									</td>
									<td class="envira-admin-litevspro-lite-column">
										<p class="features-none">
											<strong>Limited Customer Support</strong>
										</p>
									</td>
									<td class="envira-admin-litevspro-pro-column">
										<p class="features-full">
											<strong> Priority Customer Support</strong>Dedicated prompt service via email from our top tier support team. Your request is assigned the highest priority</p>
									</td>
								</tr>

							</tbody>
						</table>

				</div>

				<div class="envira-admin-litevspro-section envira-admin-litevspro-section-hero">
					<div class="envira-admin-about-section-hero-main no-border">
						<h3 class="call-to-action">
						<a class="button envira-button envira-primary-button" href="<?php echo esc_url( Envira_Gallery_Common_Admin::get_instance()->get_upgrade_link( false, 'litevsprotab', 'getenviragalleryprotoday' ) ); ?>" target="_blank" rel="noopener noreferrer">Get Envira Pro Today and Unlock all the Powerful Features!</a>
					</h3>

						<p>
							<strong>Bonus:</strong> Envira Lite users get <span class="envira-deal 20-percent-off">special discount</span>, using the code in the link above.
						</p>
					</div>
				</div>

				</div>

				</div>

			</div>

		</div> <!-- wrap -->


		<?php
	}

	/**
	 * Helper method to render partners page.
	 *
	 * @return void
	 */
	public function partners_page() {

		self::tab_navigation( __METHOD__ );

		$this->installed_plugins = get_plugins();

		?>

		<div class="envira-welcome-wrap envira-help">

			<div class="envira-get-started-main">


				<div class="envira-get-started-panel">

					<div class="wraps upgrade-wrap">

						<h2 class="headline-title"><?php esc_html_e( 'See Our Partners!', 'envira-gallery-lite' ); ?></h2>

						<h4 class="headline-subtitle"><?php esc_html_e( 'We have partnered with these amazing companies for further enhancement to your Envira Gallery experience.', 'envira-gallery-lite' ); ?></h4>
						<div class="lionsher-partners-wrap">
						<?php
						foreach ( $this->get_partners() as $partner ) :

							$this->get_plugin_card( $partner );

						endforeach;
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

	}

	/**
	 * Helper method to get plugin card
	 *
	 * @param mixed $plugin False or plugin data array.
	 * @return void
	 */
	public function get_plugin_card( $plugin = false ) {

		if ( ! $plugin ) {
			return;
		}
		$this->installed_plugins = get_plugins();

		if ( ! isset( $this->installed_plugins[ $plugin['basename'] ] ) ) {
			?>
			<div class="lionsher-partners">
				<div class="lionsher-partners-main">
					<div>
						<img src="<?php echo esc_attr( $plugin['icon'] ); ?>" width="64px" />
					</div>
					<div>
						<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
						<p class="lionsher-partner-excerpt"><?php echo esc_html( $plugin['description'] ); ?></p>
					</div>
				</div>
					<div class="lionsher-partners-footer">
					<div class="lionsher-partner-status">Status:&nbsp;<span>Not Installed</span></div>
						<div class="lionsher-partners-install-wrap">
							<a href="#" target="_blank" class="button button-primary lionsher-partners-button lionsher-partners-install" data-url="<?php echo esc_url( $plugin['url'] ); ?>" data-basename="<?php echo esc_attr( $plugin['basename'] ); ?>">Install Plugin</a>
							<span class="spinner lionsher-gallery-spinner"></span>
						</div>
					</div>
				</div>
			<?php
		} else {
			if ( is_plugin_active( $plugin['basename'] ) ) {
				?>
							<div class="lionsher-partners">
							<div class="lionsher-partners-main">
								<div>
									<img src="<?php echo esc_attr( $plugin['icon'] ); ?>" width="64px" />
								</div>
								<div>
									<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
								<p class="lionsher-partner-excerpt"><?php echo esc_html( $plugin['description'] ); ?></p>
								</div>
							</div>
								<div class="lionsher-partners-footer">
							<div class="lionsher-partner-status">Status:&nbsp;<span>Active</span></div>
								<div class="lionsher-partners-install-wrap">
							<a href="#" target="_blank" class="button button-primary lionsher-partners-button lionsher-partners-deactivate" data-url="<?php echo esc_url( $plugin['url'] ); ?>" data-basename="<?php echo esc_attr( $plugin['basename'] ); ?>">Deactivate</a>
							<span class="spinner lionsher-gallery-spinner"></span>
						</div>
				</div>
						</div>
			<?php } else { ?>
				<div class="lionsher-partners">
							<div class="lionsher-partners-main">
								<div>
									<img src="<?php echo esc_attr( $plugin['icon'] ); ?>" width="64px" />
								</div>
								<div>
									<h3><?php echo esc_html( $plugin['name'] ); ?></h3>
								<p class="lionsher-partner-excerpt"><?php echo esc_html( $plugin['description'] ); ?></p>
								</div>
							</div>
							<div class="lionsher-partners-footer">
							<div class="lionsher-partner-status">Status:&nbsp;<span>Inactive</span></div>
							<div class="lionsher-partners-install-wrap">
							<a href="#" target="_blank" class="button button-primary lionsher-partners-button lionsher-partners-activate" data-url="<?php echo esc_url( $plugin['url'] ); ?>" data-basename="<?php echo esc_attr( $plugin['basename'] ); ?>">Activate</a>
							<span class="spinner lionsher-gallery-spinner"></span>
						</div>
				</div>
						</div>
				<?php
			}
		}
	}

	/**
	 * Return true/false based on whether a query argument is set.
	 *
	 * @return bool
	 */
	public static function is_new_install() {

		if ( get_transient( '_envira_is_new_install' ) ) {
			delete_transient( '_envira_is_new_install' );
			return true;
		}

		if ( isset( $_GET['is_new_install'] ) && 'true' === strtolower( sanitize_text_field( wp_unslash( $_GET['is_new_install'] ) ) ) ) { // @codingStandardsIgnoreLine
			return true;
		} elseif ( isset( $_GET['is_new_install'] ) ) { // @codingStandardsIgnoreLine
			return false;
		}

	}

	/**
	 * Return a user-friendly version-number string, for use in translations.
	 *
	 * @since 2.2.0
	 *
	 * @return string
	 */
	public static function display_version() {

		return ENVIRA_VERSION;

	}


}


$envira_welcome = new Envira_Welcome();
