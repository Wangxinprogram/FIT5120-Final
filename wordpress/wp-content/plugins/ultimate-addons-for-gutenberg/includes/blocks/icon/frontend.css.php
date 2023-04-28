<?php
/**
 * Frontend CSS.
 *
 * @since 2.4.0
 *
 * @package uagb
 */

$icon_width       = UAGB_Helper::get_css_value( $attr['iconSize'], $attr['iconSizeUnit'] );
$transformation   = UAGB_Helper::get_css_value( $attr['rotation'], $attr['rotationUnit'] );
$background       = 'classic' === $attr['iconBackgroundColorType'] ? $attr['iconBackgroundColor'] : $attr['iconBackgroundGradientColor'];
$hover_background = 'classic' === $attr['iconHoverBackgroundColorType'] ? $attr['iconHoverBackgroundColor'] : $attr['iconHoverBackgroundGradientColor'];
$drop_shadow      = '';
$shadow_h         = UAGB_Helper::get_css_value( $attr['iconShadowHOffset'], 'px' );
$shadow_v         = UAGB_Helper::get_css_value( $attr['iconShadowVOffset'], 'px' );
$shadow_blur      = UAGB_Helper::get_css_value( $attr['iconShadowBlur'], 'px' );
$drop_shadow      = $shadow_h . ' ' . $shadow_v . ' ' . $shadow_blur . ' ' . $attr['iconShadowColor'];

$box_shadow          = '';
$box_shadow_h        = UAGB_Helper::get_css_value( $attr['iconBoxShadowHOffset'], 'px' );
$box_shadow_v        = UAGB_Helper::get_css_value( $attr['iconBoxShadowVOffset'], 'px' );
$box_shadow_blur     = UAGB_Helper::get_css_value( $attr['iconBoxShadowBlur'], 'px' );
$box_shadow_spread   = UAGB_Helper::get_css_value( $attr['iconBoxShadowSpread'], 'px' );
$box_shadow_position = 'outset' === $attr['iconBoxShadowPosition'] ? '' : $attr['iconBoxShadowPosition'];
$box_shadow          = $box_shadow_h . ' ' . $box_shadow_v . ' ' . $box_shadow_blur . ' ' . $attr['iconBoxShadowColor'] . ' ' . $box_shadow_position;
$t_selectors         = array();
$m_selectors         = array();

$selectors['.uagb-icon-wrapper']                             = array(
	'text-align' => $attr['align'],
);
$selectors['.uagb-icon-wrapper .uagb-svg-wrapper a']         = array(
	'display' => 'contents',
);
$selectors['.uagb-icon-wrapper svg']                         = array(
	'width'      => $icon_width,
	'height'     => $icon_width,
	'transform'  => "rotate($transformation)",
	'box-sizing' => 'content-box',
	'fill'       => $attr['iconColor'],
	'filter'     => $drop_shadow ? "drop-shadow( $drop_shadow )" : '',
);
$selectors['.uagb-icon-wrapper .uagb-svg-wrapper:hover svg'] = array(
	'fill' => $attr['iconHoverColor'],
);
$selectors['.uagb-icon-wrapper .uagb-svg-wrapper']           = array_merge(
	array(
		'display'        => 'inline-flex',
		'background'     => $background,
		// padding.
		'padding-top'    => UAGB_Helper::get_css_value( $attr['iconTopPadding'], $attr['iconPaddingUnit'] ),
		'padding-right'  => UAGB_Helper::get_css_value( $attr['iconRightPadding'], $attr['iconPaddingUnit'] ),
		'padding-bottom' => UAGB_Helper::get_css_value( $attr['iconBottomPadding'], $attr['iconPaddingUnit'] ),
		'padding-left'   => UAGB_Helper::get_css_value( $attr['iconLeftPadding'], $attr['iconPaddingUnit'] ),
		// margin.
		'margin-top'     => UAGB_Helper::get_css_value( $attr['iconTopMargin'], $attr['iconMarginUnit'] ),
		'margin-right'   => UAGB_Helper::get_css_value( $attr['iconRightMargin'], $attr['iconMarginUnit'] ),
		'margin-bottom'  => UAGB_Helper::get_css_value( $attr['iconBottomMargin'], $attr['iconMarginUnit'] ),
		'margin-left'    => UAGB_Helper::get_css_value( $attr['iconLeftMargin'], $attr['iconMarginUnit'] ),
		// border.
		'border-style'   => $attr['iconBorderStyle'],
		'border-color'   => $attr['iconBorderColor'],
		'box-shadow'     => $box_shadow,
	),
	UAGB_Block_Helper::uag_generate_border_css( $attr, 'icon' )
);
$selectors['.uagb-icon-wrapper .uagb-svg-wrapper:hover']     = array(
	'border-color' => $attr['iconBorderHColor'],
	'background'   => $hover_background,
);

// Generates css for tablet devices.
$t_icon_width                                        = UAGB_Helper::get_css_value( $attr['iconSizeTablet'], $attr['iconSizeUnit'] );
$t_selectors['.uagb-icon-wrapper']                   = array(
	'text-align' => $attr['alignTablet'],
);
$t_selectors['.uagb-icon-wrapper svg']               = array(
	'width'  => $t_icon_width,
	'height' => $t_icon_width,
);
$t_selectors['.uagb-icon-wrapper .uagb-svg-wrapper'] = array_merge(
	array(
		'display'        => 'inline-flex',
		'padding-top'    => UAGB_Helper::get_css_value( $attr['iconTopTabletPadding'], $attr['iconTabletPaddingUnit'] ),
		'padding-right'  => UAGB_Helper::get_css_value( $attr['iconRightTabletPadding'], $attr['iconTabletPaddingUnit'] ),
		'padding-bottom' => UAGB_Helper::get_css_value( $attr['iconBottomTabletPadding'], $attr['iconTabletPaddingUnit'] ),
		'padding-left'   => UAGB_Helper::get_css_value( $attr['iconLeftTabletPadding'], $attr['iconTabletPaddingUnit'] ),
		'margin-top'     => UAGB_Helper::get_css_value( $attr['iconTopTabletMargin'], $attr['iconTabletMarginUnit'] ),
		'margin-right'   => UAGB_Helper::get_css_value( $attr['iconRightTabletMargin'], $attr['iconTabletMarginUnit'] ),
		'margin-bottom'  => UAGB_Helper::get_css_value( $attr['iconBottomTabletMargin'], $attr['iconTabletMarginUnit'] ),
		'margin-left'    => UAGB_Helper::get_css_value( $attr['iconLeftTabletMargin'], $attr['iconTabletMarginUnit'] ),
	),
	UAGB_Block_Helper::uag_generate_border_css( $attr, 'icon', 'tablet' )
);

// Generates css for mobile devices.
$m_icon_width                                        = UAGB_Helper::get_css_value( $attr['iconSizeMobile'], $attr['iconSizeUnit'] );
$m_selectors['.uagb-icon-wrapper']                   = array(
	'text-align' => $attr['alignMobile'],
);
$m_selectors['.uagb-icon-wrapper svg']               = array(
	'width'  => $m_icon_width,
	'height' => $m_icon_width,
);
$m_selectors['.uagb-icon-wrapper .uagb-svg-wrapper'] = array_merge(
	array(
		'display'        => 'inline-flex',
		'padding-top'    => UAGB_Helper::get_css_value( $attr['iconTopMobilePadding'], $attr['iconMobilePaddingUnit'] ),
		'padding-right'  => UAGB_Helper::get_css_value( $attr['iconRightMobilePadding'], $attr['iconMobilePaddingUnit'] ),
		'padding-bottom' => UAGB_Helper::get_css_value( $attr['iconBottomMobilePadding'], $attr['iconMobilePaddingUnit'] ),
		'padding-left'   => UAGB_Helper::get_css_value( $attr['iconLeftMobilePadding'], $attr['iconMobilePaddingUnit'] ),
		'margin-top'     => UAGB_Helper::get_css_value( $attr['iconTopMobileMargin'], $attr['iconMobileMarginUnit'] ),
		'margin-right'   => UAGB_Helper::get_css_value( $attr['iconRightMobileMargin'], $attr['iconMobileMarginUnit'] ),
		'margin-bottom'  => UAGB_Helper::get_css_value( $attr['iconBottomMobileMargin'], $attr['iconMobileMarginUnit'] ),
		'margin-left'    => UAGB_Helper::get_css_value( $attr['iconLeftMobileMargin'], $attr['iconMobileMarginUnit'] ),
	),
	UAGB_Block_Helper::uag_generate_border_css( $attr, 'icon', 'mobile' )
);

$combined_selectors = array(
	'desktop' => $selectors,
	'tablet'  => $t_selectors,
	'mobile'  => $m_selectors,
);

return UAGB_Helper::generate_all_css( $combined_selectors, ' .uagb-block-' . $id );
