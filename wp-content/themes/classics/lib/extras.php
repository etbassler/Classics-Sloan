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

/**
 * SVG Icons
 */
function icons($icon, $dimensions = null) {
  if ($icon === 'facebook') {
    return '<svg viewBox="0 0 16 16" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M15.117 0H.883A.883.883 0 0 0 0 .883v14.234c0 .488.395.883.883.883h7.663V9.804H6.46V7.39h2.086V5.607c0-2.066 1.262-3.19 3.106-3.19.883 0 1.642.064 1.863.094v2.16h-1.28c-1 0-1.195.476-1.195 1.176v1.54h2.39l-.31 2.416h-2.08V16h4.077a.883.883 0 0 0 .883-.883V.883A.883.883 0 0 0 15.117 0" fill-rule="nonzero"/></svg>';
  } elseif ($icon === 'twitter') {
    return '<svg viewBox="0 0 16 16" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M16 3.038a6.62 6.62 0 0 1-1.885.517 3.299 3.299 0 0 0 1.443-1.816 6.59 6.59 0 0 1-2.085.795 3.273 3.273 0 0 0-2.396-1.036 3.281 3.281 0 0 0-3.197 4.03A9.329 9.329 0 0 1 1.114 2.1 3.243 3.243 0 0 0 .67 3.75c0 1.14.58 2.143 1.46 2.732a3.278 3.278 0 0 1-1.487-.41v.04c0 1.59 1.13 2.918 2.633 3.22a3.336 3.336 0 0 1-1.482.056 3.287 3.287 0 0 0 3.067 2.28 6.592 6.592 0 0 1-4.077 1.404c-.265 0-.526-.015-.783-.045a9.303 9.303 0 0 0 5.032 1.474c6.038 0 9.34-5 9.34-9.338 0-.143-.004-.284-.01-.425a6.67 6.67 0 0 0 1.638-1.7z" fill-rule="nonzero"/></svg>';
  } elseif ($icon === 'youtube') {
    return '<svg viewBox="0 0 16 16" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M0 7.345c0-1.294.16-2.59.16-2.59s.156-1.1.636-1.587c.608-.637 1.408-.617 1.764-.684C3.84 2.36 8 2.324 8 2.324s3.362.004 5.6.166c.314.038.996.04 1.604.678.48.486.636 1.588.636 1.588S16 6.05 16 7.346v1.258c0 1.296-.16 2.59-.16 2.59s-.156 1.102-.636 1.588c-.608.638-1.29.64-1.604.678-2.238.162-5.6.166-5.6.166s-4.16-.037-5.44-.16c-.356-.067-1.156-.047-1.764-.684-.48-.487-.636-1.587-.636-1.587S0 9.9 0 8.605v-1.26zm6.348 2.73V5.58l4.323 2.255-4.32 2.24h-.002z"/></svg>';
  } elseif ($icon === 'pinterest') {
    return '<svg viewBox="0 0 24 24" width="'.$dimensions.'" height="'.$dimensions.'"  xmlns="http://www.w3.org/2000/svg"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>';
  } elseif ($icon === 'instagram') {
    return '<svg viewBox="0 0 16 16" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M8 0C5.827 0 5.555.01 4.702.048 3.85.088 3.27.222 2.76.42a3.908 3.908 0 0 0-1.417.923c-.445.444-.72.89-.923 1.417-.198.51-.333 1.09-.372 1.942C.008 5.555 0 5.827 0 8s.01 2.445.048 3.298c.04.852.174 1.433.372 1.942.204.526.478.973.923 1.417.444.445.89.72 1.417.923.51.198 1.09.333 1.942.372.853.04 1.125.048 3.298.048s2.445-.01 3.298-.048c.852-.04 1.433-.174 1.942-.372a3.908 3.908 0 0 0 1.417-.923c.445-.444.72-.89.923-1.417.198-.51.333-1.09.372-1.942.04-.853.048-1.125.048-3.298s-.01-2.445-.048-3.298c-.04-.852-.174-1.433-.372-1.942a3.908 3.908 0 0 0-.923-1.417A3.886 3.886 0 0 0 13.24.42c-.51-.198-1.09-.333-1.942-.372C10.445.008 10.173 0 8 0zm0 1.44c2.136 0 2.39.01 3.233.048.78.036 1.203.166 1.485.276.374.145.64.318.92.598.28.28.453.546.598.92.11.282.24.705.276 1.485.038.844.047 1.097.047 3.233s-.01 2.39-.048 3.233c-.036.78-.166 1.203-.276 1.485-.145.374-.318.64-.598.92-.28.28-.546.453-.92.598-.282.11-.705.24-1.485.276-.844.038-1.097.047-3.233.047s-2.39-.01-3.233-.048c-.78-.036-1.203-.166-1.485-.276a2.472 2.472 0 0 1-.92-.598 2.472 2.472 0 0 1-.598-.92c-.11-.282-.24-.705-.276-1.485C1.45 10.39 1.44 10.136 1.44 8s.01-2.39.048-3.233c.036-.78.166-1.203.276-1.485.145-.374.318-.64.598-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276C5.61 1.45 5.864 1.44 8 1.44zm0 2.452a4.108 4.108 0 1 0 0 8.215 4.108 4.108 0 0 0 0-8.215zm0 6.775a2.667 2.667 0 1 1 0-5.334 2.667 2.667 0 0 1 0 5.334zm5.23-6.937a.96.96 0 1 1-1.92 0 .96.96 0 0 1 1.92 0z"/></svg>';
  } elseif ($icon === 'tripadvisor') {
    return '<svg viewBox="0 0 24 24" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg"><path d="M23.011 9.532c.281-1.207 1.175-2.416 1.175-2.416h-4.012c-2.251-1.455-4.981-2.226-8.013-2.226-3.14 0-5.978.78-8.214 2.251H.186s.885 1.186 1.17 2.386C.624 10.534.189 11.749.189 13.084c0 3.316 2.697 6.008 6.012 6.008 1.891 0 3.571-.885 4.681-2.254l1.275 1.916 1.291-1.936c.57.736 1.32 1.336 2.205 1.74 1.455.66 3.092.736 4.592.18 3.106-1.154 4.696-4.621 3.556-7.726-.209-.556-.48-1.051-.81-1.485l.02.005zm-3.171 8.072c-1.2.445-2.505.395-3.67-.143-.824-.383-1.503-.982-1.988-1.727-.201-.299-.375-.623-.503-.971-.146-.395-.22-.803-.259-1.215-.074-.832.045-1.673.405-2.453.54-1.164 1.501-2.051 2.701-2.496 2.49-.914 5.25.361 6.166 2.841.916 2.481-.36 5.245-2.835 6.163h-.017zm-9.668-1.834c-.863 1.271-2.322 2.113-3.973 2.113-2.646 0-4.801-2.156-4.801-4.797 0-2.641 2.156-4.802 4.801-4.802s4.798 2.161 4.798 4.802c0 .164-.03.314-.048.479-.081.811-.341 1.576-.777 2.221v-.016zM3.15 13.023c0 1.641 1.336 2.971 2.971 2.971s2.968-1.33 2.968-2.971c0-1.635-1.333-2.964-2.966-2.964-1.636 0-2.971 1.329-2.971 2.964H3.15zm12.048 0c0 1.641 1.329 2.971 2.968 2.971 1.636 0 2.965-1.33 2.965-2.971 0-1.635-1.329-2.964-2.965-2.964-1.635 0-2.971 1.329-2.971 2.964h.003zm-11.022 0c0-1.071.869-1.943 1.936-1.943 1.064 0 1.949.873 1.949 1.943 0 1.076-.869 1.951-1.949 1.951-1.081 0-1.951-.875-1.951-1.951h.015zm12.033 0c0-1.071.869-1.943 1.949-1.943 1.066 0 1.937.873 1.937 1.943 0 1.076-.87 1.951-1.952 1.951-1.079 0-1.949-.875-1.949-1.951h.015zM12.156 5.94c2.161 0 4.111.389 5.822 1.162-.645.018-1.275.131-1.906.36-1.515.555-2.715 1.665-3.375 3.125-.315.66-.48 1.359-.541 2.065-.225-3.076-2.76-5.515-5.881-5.578C7.986 6.34 9.967 5.94 12.112 5.94h.044z"/></svg>';
  } elseif ($icon === 'email') {
    return '<svg viewBox="0 0 32 32" width="'.$dimensions.'" height="'.$dimensions.'" xmlns= "http://www.w3.org/2000/svg"><path d="M29 4h-26c-1.657 0-3 1.343-3 3v18c0 1.656 1.343 3 3 3h26c1.657 0 3-1.344 3-3v-18c0-1.657-1.343-3-3-3zM2.741 25.99l-0.731-0.732 8.249-8.248 0.731 0.732-8.249 8.248zM29.259 25.99l-8.249-8.248 0.731-0.732 8.249 8.248-0.731 0.732zM17 19.325v0.675h-2v-0.675l-12.997-12.050 1.272-1.272 12.725 11.798 12.725-11.798 1.272 1.272-12.997 12.050z"></path></svg>';
  } elseif ($icon === 'toggle-plus') {
    return '<svg viewBox="0 0 34 34"  width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><rect stroke-width="2" x="1" y="1" width="32" height="32" rx="16"></rect><path class="bar-vertical" d="M16.15 8.5h1.7v17h-1.7z"></path><path class="bar-horizontal" d="M8.5 16.15h17v1.7h-17z"></path></g></svg>';
  } elseif ($icon === 'play') {
    return '<svg width="66" height="75" xmlns="http://www.w3.org/2000/svg"><path d="M62.018 32.293L8.744 1.222C3.889-1.613-.027.654 0 6.269l.273 61.674c.025 5.614 3.988 7.9 8.857 5.087l52.868-30.523c4.863-2.807 4.874-7.38.02-10.214z" fill="#FFF" fill-rule="evenodd"/></svg>';
  } elseif ($icon === 'location-pin') {
    return '<svg width="23" height="27" xmlns="http://www.w3.org/2000/svg"><g transform="translate(2 2)" fill="none" fill-rule="evenodd"><path class="stroke-animate" d="M9.5 23c1.757 0 9.5-9.612 9.5-14.375S14.747 0 9.5 0 0 3.862 0 8.625 7.743 23 9.5 23z" stroke="#005784" stroke-width="3"/><ellipse class="fill-animate" fill="#005784" cx="9.5" cy="9" rx="3.5" ry="3"/></g></svg>';
  } elseif ($icon === 'calendar') {
    return '<svg width="25" height="25" xmlns="http://www.w3.org/2000/svg"><g class="stroke-animate" transform="translate(.796 .152)" stroke="#005784" stroke-width="3" fill="none" fill-rule="evenodd"><rect x=".73" y="3.651" width="21.905" height="18.984" rx="3"/><path d="M7.302 6.572V0m15.333 10.222H0m16.064-3.65V0"/></g></svg>';
  } elseif ($icon === 'search') {
    return '<svg viewbox="0 0 25 25" width="'.$dimensions.'" height="'.$dimensions.'" xmlns="http://www.w3.org/2000/svg"><g class="stroke-animate" transform="rotate(-44 12.238 6.812)" stroke="#000000" stroke-width="3" fill="none" fill-rule="evenodd"><circle cx="8.5" cy="8.5" r="8.5"/><path d="M8.5 17.525V25" stroke-linecap="square"/></g></svg>';
  } elseif ($icon === 'share') {
    return '<svg viewBox="0 0 20 20" width="'.$dimensions.'" height="'.$dimensions.'"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 13.442c-0.633 0-1.204 0.246-1.637 0.642l-5.938-3.463c0.046-0.188 0.075-0.384 0.075-0.584s-0.029-0.395-0.075-0.583l5.875-3.429c0.446 0.417 1.042 0.675 1.7 0.675 1.379 0 2.5-1.121 2.5-2.5s-1.121-2.5-2.5-2.5-2.5 1.121-2.5 2.5c0 0.2 0.029 0.396 0.075 0.583l-5.875 3.429c-0.446-0.416-1.042-0.675-1.7-0.675-1.379 0-2.5 1.121-2.5 2.5s1.121 2.5 2.5 2.5c0.658 0 1.254-0.258 1.7-0.675l5.938 3.463c-0.042 0.175-0.067 0.358-0.067 0.546 0 1.342 1.087 2.429 2.429 2.429s2.429-1.088 2.429-2.429-1.087-2.429-2.429-2.429z"></path></svg>';
  } elseif ($icon === 'grid-view') {
    return '<svg width="'.$dimensions.'" height="'.$dimensions.'"  viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M8 12h4V8H8v4zm6 0h4V8h-4v4zm6-4v4h4V8h-4zM8 18h4v-4H8v4zm6 0h4v-4h-4v4zm6 0h4v-4h-4v4zM8 24h4v-4H8v4zm6 0h4v-4h-4v4zm6 0h4v-4h-4v4z"/></svg>';
  } elseif ($icon === 'list-view') {
    return '<svg width="'.$dimensions.'" height="'.$dimensions.'"  viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="6091" d="M8 12h4V8H8v4zm0 6h4v-4H8v4zm0 6h4v-4H8v4zm6-16v4h10V8H14zm0 10h10v-4H14v4zm0 6h10v-4H14v4z"/></svg>';
  } elseif ($icon === 'quote') {
    return '<svg width="'.$dimensions.'" height="'.$dimensions.'"  viewBox="0 0 32 32"><path d="M7.031 14c3.866 0 7 3.134 7 7s-3.134 7-7 7-7-3.134-7-7l-0.031-1c0-7.732 6.268-14 14-14v4c-2.671 0-5.182 1.040-7.071 2.929-0.364 0.364-0.695 0.751-0.995 1.157 0.357-0.056 0.724-0.086 1.097-0.086zM25.031 14c3.866 0 7 3.134 7 7s-3.134 7-7 7-7-3.134-7-7l-0.031-1c0-7.732 6.268-14 14-14v4c-2.671 0-5.182 1.040-7.071 2.929-0.364 0.364-0.695 0.751-0.995 1.157 0.358-0.056 0.724-0.086 1.097-0.086z"></path>
    ';
  } elseif ($icon === 'icon-arrow') {
    return '<svg width="30px" height="20px" viewBox="0 0 25 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="components-1" transform="translate(-838.000000, -5604.000000)" fill="#00061C">
            <polygon id="icon-arrow-down" points="850.5 5618 863 5605.55556 861.4375 5604 850.5 5614.88889 839.5625 5604 838 5605.55556"></polygon>
        </g>
    </g>
    </svg>';

  } elseif ($icon === 'icon-arrow-right') {
    return '
    <svg width="'.$dimensions.'" height="'.$dimensions.'" viewBox="0 0 9 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <title>icon-arrow-right</title>
      <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Desktop---Homepage" transform="translate(-1285.000000, -2584.000000)" stroke="#0F1B41" stroke-width="1.5">
              <polyline id="icon-arrow-right" points="1286 2599 1293 2591.81974 1286 2585"></polyline>
          </g>
      </g>
    </svg>';
  }
}