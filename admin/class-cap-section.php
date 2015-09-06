<?php
/**
 * Capability section class for use in the edit capabilities tabs.
 *
 * @package    Members
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/plugins/members
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Cap section class.
 *
 * @since  1.0.0
 * @access public
 */
final class Members_Cap_Section {

	/**
	 * Stores the cap tabs object.
	 *
	 * @see    Members_Cap_Tabs
	 * @since  1.0.0
	 * @access public
	 * @var    object
	 */
	public $manager;

	/**
	 * ID of the section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $section = '';

	/**
	 * Dashicons icon for the section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $icon = 'dashicons-admin-generic';

	/**
	 * Label for the section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $label = '';

	/**
	 * Array of data to pass as a json object to the Underscore template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $json = array();

	/**
	 * Creates a new section object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $section
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $section, $args = array() ) {

		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {

			if ( isset( $args[ $key ] ) )
				$this->$key = $args[ $key ];
		}

		$this->manager = $manager;
		$this->section = $section;
	}

	/**
	 * Returns the json array.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function json() {
		$this->to_json();
		return $this->json;
	}

	/**
	 * Adds custom data to the json array.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {

		$is_editable = $this->manager->role ? members_is_role_editable( $this->manager->role->name ) : true;

		$this->json['id']    = $this->section;
		$this->json['class'] = 'members-tab-content' . ( $is_editable ? ' editable-role' : '' );

		$this->json['labels'] = array(
			'cap'   => esc_html__( 'Capability', 'members' ),
			'grant' => esc_html__( 'Grant',      'members' ),
			'deny'  => esc_html__( 'Deny',       'members' )
		);
	}

	/**
	 * Outputs the Underscore template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function template() { ?>

		<div id="members-tab-{{ data.id }}" class="{{ data.class }}">

			<table class="wp-list-table widefat fixed members-roles-select">

				<thead>
					<tr>
						<th class="column-cap">{{ data.labels.cap }}</th>
						<th class="column-cb">{{ data.labels.grant }}</th>
						<th class="column-cb">{{ data.labels.deny }}</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th class="column-cap">{{ data.labels.cap }}</th>
						<th class="column-cb">{{ data.labels.grant }}</th>
						<th class="column-cb">{{ data.labels.deny }}</th>
					</tr>
				</tfoot>

				<tbody></tbody>
			</table>
		</div>
	<?php }
}
