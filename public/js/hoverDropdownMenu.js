
// Hover Dropdown Menu

$(document).ready(
    function () {
        $(".dropdown").hover(
          function () {
              console.log('heloo');
             $(this).find('ul').finish().slideDown('fast');
          }, 
          function () {
             $(this).find('ul').finish().slideUp('fast');
          }
    );
});
