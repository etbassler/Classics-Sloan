// JavaScript to be fired on the home page

import smoothScrollLinks from "../util/smoothScrollLinks";
import carouselNormalization from "../util/carouselNormalization";

export default {
  init() {
    // Initialize smooth scroll "jump links"
    smoothScrollLinks();
    $(".carousel").carousel({
      interval: 10000
    });
    carouselNormalization();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  }
};
