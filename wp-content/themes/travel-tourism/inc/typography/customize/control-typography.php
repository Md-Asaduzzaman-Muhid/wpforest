<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class Travel_Tourism_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'travel-tourism-typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'travel-tourism' ),
				'family'      => esc_html__( 'Font Family', 'travel-tourism' ),
				'size'        => esc_html__( 'Font Size',   'travel-tourism' ),
				'weight'      => esc_html__( 'Font Weight', 'travel-tourism' ),
				'style'       => esc_html__( 'Font Style',  'travel-tourism' ),
				'line_height' => esc_html__( 'Line Height', 'travel-tourism' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'travel-tourism' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'travel-tourism-ctypo-customize-controls' );
		wp_enqueue_style(  'travel-tourism-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'travel-tourism' ),
        'Abril Fatface' => __( 'Abril Fatface', 'travel-tourism' ),
        'Acme' => __( 'Acme', 'travel-tourism' ),
        'Anton' => __( 'Anton', 'travel-tourism' ),
        'Architects Daughter' => __( 'Architects Daughter', 'travel-tourism' ),
        'Arimo' => __( 'Arimo', 'travel-tourism' ),
        'Arsenal' => __( 'Arsenal', 'travel-tourism' ),
        'Arvo' => __( 'Arvo', 'travel-tourism' ),
        'Alegreya' => __( 'Alegreya', 'travel-tourism' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'travel-tourism' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'travel-tourism' ),
        'Bangers' => __( 'Bangers', 'travel-tourism' ),
        'Boogaloo' => __( 'Boogaloo', 'travel-tourism' ),
        'Bad Script' => __( 'Bad Script', 'travel-tourism' ),
        'Bitter' => __( 'Bitter', 'travel-tourism' ),
        'Bree Serif' => __( 'Bree Serif', 'travel-tourism' ),
        'BenchNine' => __( 'BenchNine', 'travel-tourism' ),
        'Cabin' => __( 'Cabin', 'travel-tourism' ),
        'Cardo' => __( 'Cardo', 'travel-tourism' ),
        'Courgette' => __( 'Courgette', 'travel-tourism' ),
        'Cherry Swash' => __( 'Cherry Swash', 'travel-tourism' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'travel-tourism' ),
        'Crimson Text' => __( 'Crimson Text', 'travel-tourism' ),
        'Cuprum' => __( 'Cuprum', 'travel-tourism' ),
        'Cookie' => __( 'Cookie', 'travel-tourism' ),
        'Chewy' => __( 'Chewy', 'travel-tourism' ),
        'Days One' => __( 'Days One', 'travel-tourism' ),
        'Dosis' => __( 'Dosis', 'travel-tourism' ),
        'Droid Sans' => __( 'Droid Sans', 'travel-tourism' ),
        'Economica' => __( 'Economica', 'travel-tourism' ),
        'Fredoka One' => __( 'Fredoka One', 'travel-tourism' ),
        'Fjalla One' => __( 'Fjalla One', 'travel-tourism' ),
        'Francois One' => __( 'Francois One', 'travel-tourism' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'travel-tourism' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'travel-tourism' ),
        'Great Vibes' => __( 'Great Vibes', 'travel-tourism' ),
        'Handlee' => __( 'Handlee', 'travel-tourism' ),
        'Hammersmith One' => __( 'Hammersmith One', 'travel-tourism' ),
        'Inconsolata' => __( 'Inconsolata', 'travel-tourism' ),
        'Indie Flower' => __( 'Indie Flower', 'travel-tourism' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'travel-tourism' ),
        'Julius Sans One' => __( 'Julius Sans One', 'travel-tourism' ),
        'Josefin Slab' => __( 'Josefin Slab', 'travel-tourism' ),
        'Josefin Sans' => __( 'Josefin Sans', 'travel-tourism' ),
        'Kanit' => __( 'Kanit', 'travel-tourism' ),
        'Lobster' => __( 'Lobster', 'travel-tourism' ),
        'Lato' => __( 'Lato', 'travel-tourism' ),
        'Lora' => __( 'Lora', 'travel-tourism' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'travel-tourism' ),
        'Lobster Two' => __( 'Lobster Two', 'travel-tourism' ),
        'Merriweather' => __( 'Merriweather', 'travel-tourism' ),
        'Monda' => __( 'Monda', 'travel-tourism' ),
        'Montserrat' => __( 'Montserrat', 'travel-tourism' ),
        'Muli' => __( 'Muli', 'travel-tourism' ),
        'Marck Script' => __( 'Marck Script', 'travel-tourism' ),
        'Noto Serif' => __( 'Noto Serif', 'travel-tourism' ),
        'Open Sans' => __( 'Open Sans', 'travel-tourism' ),
        'Overpass' => __( 'Overpass', 'travel-tourism' ),
        'Overpass Mono' => __( 'Overpass Mono', 'travel-tourism' ),
        'Oxygen' => __( 'Oxygen', 'travel-tourism' ),
        'Orbitron' => __( 'Orbitron', 'travel-tourism' ),
        'Patua One' => __( 'Patua One', 'travel-tourism' ),
        'Pacifico' => __( 'Pacifico', 'travel-tourism' ),
        'Padauk' => __( 'Padauk', 'travel-tourism' ),
        'Playball' => __( 'Playball', 'travel-tourism' ),
        'Playfair Display' => __( 'Playfair Display', 'travel-tourism' ),
        'PT Sans' => __( 'PT Sans', 'travel-tourism' ),
        'Philosopher' => __( 'Philosopher', 'travel-tourism' ),
        'Permanent Marker' => __( 'Permanent Marker', 'travel-tourism' ),
        'Poiret One' => __( 'Poiret One', 'travel-tourism' ),
        'Quicksand' => __( 'Quicksand', 'travel-tourism' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'travel-tourism' ),
        'Raleway' => __( 'Raleway', 'travel-tourism' ),
        'Rubik' => __( 'Rubik', 'travel-tourism' ),
        'Rokkitt' => __( 'Rokkitt', 'travel-tourism' ),
        'Russo One' => __( 'Russo One', 'travel-tourism' ),
        'Righteous' => __( 'Righteous', 'travel-tourism' ),
        'Slabo' => __( 'Slabo', 'travel-tourism' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'travel-tourism' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'travel-tourism'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'travel-tourism' ),
        'Sacramento' => __( 'Sacramento', 'travel-tourism' ),
        'Shrikhand' => __( 'Shrikhand', 'travel-tourism' ),
        'Tangerine' => __( 'Tangerine', 'travel-tourism' ),
        'Ubuntu' => __( 'Ubuntu', 'travel-tourism' ),
        'VT323' => __( 'VT323', 'travel-tourism' ),
        'Varela Round' => __( 'Varela Round', 'travel-tourism' ),
        'Vampiro One' => __( 'Vampiro One', 'travel-tourism' ),
        'Vollkorn' => __( 'Vollkorn', 'travel-tourism' ),
        'Volkhov' => __( 'Volkhov', 'travel-tourism' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'travel-tourism' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'travel-tourism' ),
			'100' => esc_html__( 'Thin',       'travel-tourism' ),
			'300' => esc_html__( 'Light',      'travel-tourism' ),
			'400' => esc_html__( 'Normal',     'travel-tourism' ),
			'500' => esc_html__( 'Medium',     'travel-tourism' ),
			'700' => esc_html__( 'Bold',       'travel-tourism' ),
			'900' => esc_html__( 'Ultra Bold', 'travel-tourism' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'travel-tourism' ),
			'normal'  => esc_html__( 'Normal', 'travel-tourism' ),
			'italic'  => esc_html__( 'Italic', 'travel-tourism' ),
			'oblique' => esc_html__( 'Oblique', 'travel-tourism' )
		);
	}
}
