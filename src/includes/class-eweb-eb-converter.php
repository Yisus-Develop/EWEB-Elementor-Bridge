<?php
/**
 * Elementor Data Converter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class EWEB_EB_Converter {

	public static function convert( $elements ) {
		$elementor_data = [];
		foreach ( $elements as $element ) {
			$processed = self::process_element( $element );
			if ( ! empty( $processed ) && isset( $processed['elType'] ) ) {
				// Final safety: recursively check all children for elType
				$processed = self::ensure_el_type( $processed );
				
				// Safety: If top-level element is a widget, wrap it in a container
				if ( 'widget' === $processed['elType'] ) {
					$processed = [
						'id' => wp_generate_password( 7, false, false ),
						'elType' => 'container',
						'settings' => [],
						'elements' => [
							[
								'id' => wp_generate_password( 7, false, false ),
								'elType' => 'container', // Inner container for structure
								'settings' => [ 'content_width' => 'full' ],
								'elements' => [ $processed ]
							]
						]
					];
				}
				$elementor_data[] = $processed;
			}
		}
		return array_values( array_filter( $elementor_data ) );
	}

	private static function process_element( $el ) {
		// Safety: If input is not an array, return empty
		if ( ! is_array( $el ) || empty( $el ) ) return [];

		$id = wp_generate_password( 7, false, false );
		$type = $el['type'] ?? $el['elType'] ?? '';

		// 1. Recursive child processing (The critical fix)
		$elements = [];
		$input_elements = $el['children'] ?? $el['elements'] ?? [];
		if ( is_array( $input_elements ) ) {
			foreach ( $input_elements as $child ) {
				$proc = self::process_element( $child );
				// ONLY add if it's a valid element with elType
				if ( ! empty( $proc ) && isset( $proc['elType'] ) ) {
					$elements[] = $proc;
				}
			}
		}

		// 2. Map types to Elementor structure
		switch ( $type ) {
			case 'section':
			case 'container':
				return [
					'id'       => $id,
					'elType'   => 'container',
					'indicator' => 'flex', 
					'settings' => array_merge( [
						'content_width' => 'boxed',
						'flex_direction' => 'column',
						'flex_justify_content' => 'center',
						'padding' => [ 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ],
					], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'heading':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'heading',
					'settings' => array_merge( [ 'title' => 'Heading', 'header_size' => 'h2', 'align' => 'center', 'typography_font_family' => 'Lalezar' ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'text':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'text-editor',
					'settings' => array_merge( [ 'editor' => 'Sample content', 'typography_font_family' => 'Kulim Park' ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'button':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'button',
					'settings' => array_merge( [ 'text' => 'Click Here', 'align' => 'center', 'typography_font_family' => 'Kulim Park', 'border_radius' => [ 'unit' => 'px', 'size' => 30 ] ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'image':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'image',
					'settings' => array_merge( [ 'image' => [ 'url' => '', 'id' => '' ], 'align' => 'center' ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'video':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'video',
					'settings' => array_merge( [ 'youtube_url' => 'https://www.youtube.com/watch?v=XHOmBV4js_E' ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'icon-box':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'icon-box',
					'settings' => array_merge( [ 'selected_icon' => [ 'value' => 'fas fa-cog', 'library' => 'fa-solid' ] ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'counter':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'counter',
					'settings' => array_merge( [ 'starting_number' => 0, 'ending_number' => 100 ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'nav_menu':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => 'nav-menu',
					'settings' => array_merge( [ 'layout' => 'horizontal' ], $el['settings'] ?? [] ),
					'elements' => $elements,
				];

			case 'widget':
			case 'cps_hero_liquid':
			case 'cps_modern_projects':
			case 'cps_creative_hero':
			case 'cps_modern_intro':
			case 'cps_services_asymmetric':
				return [
					'id'       => $id, 'elType' => 'widget', 'widgetType' => $el['widgetType'] ?? $type,
					'settings' => $el['settings'] ?? [],
					'elements' => $elements,
				];

			default:
				// If it's a generic widget type or already has elType specified
				$elType = $el['elType'] ?? 'widget';
				if ( ! empty( $type ) ) {
					return [
						'id'       => $id, 'elType' => (string)$elType, 'widgetType' => $el['widgetType'] ?? $type,
						'settings' => $el['settings'] ?? [],
						'elements' => $elements,
					];
				}
				break;
		}
		return [];
	}

	private static function ensure_el_type( $el ) {
		if ( ! is_array( $el ) ) return $el;
		
		// Ensure elType exists
		if ( ! isset( $el['elType'] ) ) {
			$el['elType'] = 'widget'; // Default safety
		}
		
		// Preserve widgetType if it's a widget
		if ( $el['elType'] === 'widget' && ! isset( $el['widgetType'] ) ) {
			$el['widgetType'] = 'text-editor'; // Safe default
		}
		
		// Recursively process children
		if ( isset( $el['elements'] ) && is_array( $el['elements'] ) ) {
			$valid_elements = [];
			foreach ( $el['elements'] as $child ) {
				$proc = self::ensure_el_type( $child );
				if ( ! empty( $proc ) && isset( $proc['elType'] ) ) {
					$valid_elements[] = $proc;
				}
			}
			$el['elements'] = $valid_elements;
		}
		return $el;
	}
}
