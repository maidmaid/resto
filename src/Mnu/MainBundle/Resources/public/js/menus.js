var $menus = $('#menus');

$(document).ready(function()
{
    $menus.masonry({
        columnWidth: 250,
        itemSelector: '.menu',
        gutter: 25,
        isFitWidth: true
    });
});