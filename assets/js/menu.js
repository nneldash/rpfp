$(document).ready(function(){
    $('#sidebar-menu ul.side-menu li a').click(function() {
        setTimeout(function(){
            $('#loading-wrapper').removeClass('loading');
        }, 2000);


        var dis = $(this);
        var hashtag = dis.attr("href").substr(0, 1);        
        if (hashtag == "#") {
            var link = dis.attr("href").substr(1);
            $.ajax({
                url: (base_url + link),
                method: "POST",
                cache: false
            }).complete(function(html_data) {
                $(".x_content").html(html_data.responseText);
            });
        }
    });

    if (window.hasOwnProperty( "default_tab" )) {
        setTimeout(function(){
            $('#loading-wrapper').removeClass('loading');
        }, 2000);

        var active_a = $('ul.nav.side-menu li a[href="' + default_tab + '"]')[0];
        active_a.click();
        var active_li = $(active_a.parentElement);
        active_li.addClass('active');
    }
});