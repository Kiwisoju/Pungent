if (!jQuery) {
    console.log('jquery.popupoverlay - jQuery not defined.');
}
require(['jquery.popupoverlay.js']);
require(['formValidation.min.js']);

$(document).ready(function () {

    $('.popup').popup({
      color: 'white',
      autoopen: true,
      opacity: 1,
      transition: '0.3s',
      scrolllock: true
    });
});