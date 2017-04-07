jQuery(function($){
    $("#fCDNForm").submit(function(e){
        e.preventDefault();
        var $f = $(this);
        $.ajax({
            type: $f.attr("method"),
            url: $f.attr("action"),
            data: $f.serialize(),
            success: function(msg){
                $("#message").html(msg).show();
                goTop();
            }
        });
    });
});

function goTop() 
{
    var t;
    if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0){
        window.scrollBy(0, -50);
        t = setTimeout('goTop()', 10);
    }
    else clearTimeout(t);
}