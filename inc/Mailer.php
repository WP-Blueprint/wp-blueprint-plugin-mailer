<?php
/**
 * WordPress Theme Feature: Mailer
 *
 * @since   1.0
 * @package wp-blueprint/shared-classes
 * @link    https://github.com/WP-Blueprint/WPBlueprint-Classic-Classes
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Plugins;

/**
 * This class handles the configuration of SMTP settings for the mailer functionality.
 */
class Mailer {

	/**
	 * Register mailer functionalities.
	 *
	 * @return void
	 */
	public function register() {
		// Hook into the admin_menu action to create the settings page.
		add_action( 'admin_menu', array( $this, 'create_settings_page' ) );

		add_action( 'phpmailer_init', array( $this, 'init_phpmailer' ) );
	}

	/**
	 * Create settings page for mailer.
	 *
	 * @return void
	 */
	public function create_settings_page() {
		if ( null !== get_page_by_path( 'wpblueprint_plugins_settings' ) ) {
			add_submenu_page( 'wpblueprint_plugins_settings', 'Mailer', 'Mailer', 'manage_options', 'my_theme_mailer', array( $this, 'render_mailer_settings' ) );
		} else {
			add_menu_page( 'WP Blueprint Plugins', 'WP Blueprint Plugins', 'manage_options', 'wpblueprint_plugins_settings', array( $this, 'render_wpblueprint_plugins_settings' ), 'dashicons-admin-generic' );
			add_submenu_page( 'wpblueprint_plugins_settings', 'Mailer', 'Mailer', 'manage_options', 'my_theme_mailer', array( $this, 'render_mailer_settings' ) );
		}
	}

	/**
	 * Render settings for mailer.
	 *
	 * @return void
	 */
	public function render_mailer_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$smtp_host_set   = isset( $_ENV['SMTP_HOST'] );
		$smtp_auth_set   = isset( $_ENV['SMTP_AUTH'] );
		$smtp_port_set   = isset( $_ENV['SMTP_PORT'] );
		$smtp_user_set   = isset( $_ENV['SMTP_USER'] );
		$smtp_pass_set   = isset( $_ENV['SMTP_PASS'] );
		$smtp_secure_set = isset( $_ENV['SMTP_SECURE'] );

		if ( isset( $_POST['test_email'] ) && isset( $_POST['test_email_nonce'] ) && wp_verify_nonce( $_POST['test_email_nonce'], 'test_email' ) ) {
			$to      = isset( $_POST['test_email_address'] ) ? sanitize_email( $_POST['test_email_address'] ) : wp_get_current_user()->user_email;
			$subject = 'Test Email';
			$message = 'This is a test email. If you received it, the SMTP configuration is set up correctly.';
			$headers = 'From: ' . $_ENV['SMTP_USER'] . "\r\n";

			if ( wp_mail( $to, $subject, $message, $headers ) ) {
				echo '<div class="notice notice-success"><p>Test email sent successfully!</p></div>';
			} else {
				echo '<div class="notice notice-error"><p>Failed to send the test email.</p></div>';
			}
		}

		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<?php if ( ! $smtp_host_set || ! $smtp_auth_set || ! $smtp_port_set || ! $smtp_user_set || ! $smtp_pass_set || ! $smtp_secure_set ) : ?>
				<p><strong style="color: red">Warning:</strong> The Mailer settings are not complete. To setup the mailer functionality, you should add the following settings to your .env file:</p>
				<pre style="border: 1px solid grey; padding: 20px; margin: 0;">
SMTP_HOST=your_smtp_host
SMTP_AUTH=smtp_auth
SMTP_PORT=smtp_port
SMTP_USER=your_smtp_username
SMTP_PASS=your_smtp_password
SMTP_SECURE=smtp_secure</pre>
				<p>Replace 'your_smtp_host', 'smtp_auth', 'smtp_port', 'your_smtp_username', 'your_smtp_password', and 'smtp_secure' with your actual SMTP settings.</p>
				<p>Ensure that your .env file is not publicly accessible to protect your sensitive data.</p>
			<?php else : ?>
				<p>Mailer settings are set properly. If you want to change them, you can update your .env file with the new values:</p>
				<pre style="border: 1px solid grey; padding: 20px; margin: 0;">
SMTP_AUTH=new_smtp_auth
SMTP_PORT=new_smtp_port
SMTP_USER=new_smtp_username
SMTP_PASS=new_smtp_password
SMTP_SECURE=new_smtp_secure</pre>
				<p>Replace 'new_smtp_host', 'new_smtp_auth', 'new_smtp_port', 'new_smtp_username', 'new_smtp_password', and 'new_smtp_secure' with your new SMTP settings.</p>
				<p>Ensure that your .env file is not publicly accessible to protect your sensitive data.</p>

			<h2>Test Email</h2>
			<form method="post">
				<?php wp_nonce_field( 'test_email', 'test_email_nonce' ); ?>
				<input type="hidden" name="test_email" value="1" />
				<p><label for="test_email_address">Recipient Email:</label></p>
				<p><input type="email" id="test_email_address" name="test_email_address" value="<?php echo isset( $_POST['test_email_address'] ) ? esc_attr( $_POST['test_email_address'] ) : ''; ?>" /></p>
				<p>Click the button below to send a test email:</p>
				<p><button type="submit" class="button button-primary">Send Test Email</button></p>
			</form>
		</div>
				<?php
		endif;
	}

	/**
	 * Initialize PHPMailer with SMTP settings.
	 *
	 * @param PHPMailer $phpmailer The PHPMailer instance.
	 *
	 * @return void
	 */
	public static function init_phpmailer( $phpmailer ) {
		if (
			isset( $_ENV['SMTP_HOST'] ) &&
			isset( $_ENV['SMTP_AUTH'] ) &&
			isset( $_ENV['SMTP_PORT'] ) &&
			isset( $_ENV['SMTP_USER'] ) &&
			isset( $_ENV['SMTP_PASS'] ) &&
			isset( $_ENV['SMTP_SECURE'] )
		) {
			$phpmailer->isSMTP();
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->Host = $_ENV['SMTP_HOST'];
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->SMTPAuth = ( 'true' === $_ENV['SMTP_AUTH'] );
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->Port = intval( $_ENV['SMTP_PORT'] );
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->Username = $_ENV['SMTP_USER'];
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->Password = $_ENV['SMTP_PASS'];
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$phpmailer->SMTPSecure = $_ENV['SMTP_SECURE'];
		}
	}
}
