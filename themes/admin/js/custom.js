$(document).ready(function(){

     $("a").tooltip({
	placement: $(this).data("placement") || 'top'
     });

     $("#sidebar ul li").each(function(){
            var href = $(this).find('a').attr('href');

            var url = document.location.href;

            if(url.indexOf(href) >=0)
            {
                  $(this).find('a').addClass('active');
            }
     });

     resizeTheme();

     $(window).resize(function(){
            resizeTheme();
     });

     function resizeTheme()
     {
            if($(window).width() <= 350)
            {
                  $("#sidebar ul li i").hide();
            }
            else
            {
                  $("#sidebar ul li i").show();
            }
     }

});