// Import external dependencies
import "bootstrap";

// Import local dependencies
import Router from "./util/Router";
import common from "./routes/common";
import home from "./routes/home";
import samplePage from "./routes/samplePage";

import "lazysizes";
import "picturefill";

// Populate Router instance with DOM routes (NOTE: page slugs must be camelCased)
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // Sample page
  samplePage
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
