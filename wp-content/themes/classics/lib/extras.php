<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Get excerpt from ACF component pages
 */
function acf_excerpt($id, $wordCount = 45) {
  $components = get_field('components', $id);
  if($components) {
    foreach ($components as $component) {
      if($component['acf_fc_layout'] == 'text') {
        $excerpt = $component['text'];
        break;
      } else {
        $excerpt = '';
      }
    }
  }
  else {
    $excerpt = get_page($id)->post_content;
  }
  $excerpt = rtrim(rtrim(implode(' ', array_slice(explode(' ', $excerpt), 0, $wordCount)), ','), '.');
  $excerpt = strip_tags($excerpt);
  return strlen($excerpt) ? $excerpt.'&hellip;' : '';
}

/**
 * Make arbitrary strings acceptable as class names
 */
function classify($string) {
  $string = strtolower($string);
  $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
  $string = preg_replace("/[\s-]+/", " ", $string);
  $string = preg_replace("/[\s_]/", "-", $string);
  return $string;
}

/**
 * Backbone of Cuberis components
 */
function componify($prefix = null) {
  if($prefix) {
    $prefix = $prefix .'_';
  }

  if(function_exists('have_rows') && have_rows($prefix .'components') && !post_password_required()) {
    while(have_rows($prefix .'components')) {
      the_row();
      $type = classify(get_row_layout());
?>
  <section class="component component--<?= $type ; ?>">
    <?= get_template_part('components/component', $type); ?>
  </section>
<?php
    }
  }
}

/**
 * Output utility elements for isBreakpoint detection (JS)
 * @source http://getbootstrap.com/docs/4.0/utilities/display/#hiding-elements
 */
function bootstrap_current_breakpoint() {
  $breakpoints = [
    'xs' => 'is-visible-xs d-block d-sm-none',
    'sm' => 'is-visible-sm d-none d-sm-block d-md-none',
    'md' => 'is-visible-md d-none d-md-block d-lg-none',
    'lg' => 'is-visible-lg d-none d-lg-block d-xl-none',
    'xl' => 'is-visible-xl d-none d-xl-block'
  ];

  foreach ($breakpoints as $breakpoint => $classes) {
    echo "<div class='{$classes}'></div>";
  }
}
