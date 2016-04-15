(function($){
    $(document).ready(function(){

        var get_template_value = function() {
            return $("#page_template").val();
        };

        var page_metabox_visibililty = function() {
            var template = get_template_value();
            // console.log("Template : " + template + " - Page Template : " + jpageoption.pagetemplate);

            if (template === 'template-home.php' ) {
                $("#postdivrich, #commentstatusdiv").hide();
                $("#jeg_slider_metabox, #jeg_popularpost_metabox, #jeg_blogcontent_metabox, #jeg_sidebar_metabox").show();
            } else if ( template === 'default' ) {
                $('#jeg_slider_metabox, #jeg_popularpost_metabox, #jeg_blogcontent_metabox, #jeg_sidebar_metabox').hide();
                $("#postdivrich, #commentstatusdiv").show();
            }
        };

        setTimeout(function(){ page_metabox_visibililty(); }, 500);
        $("#page_template").bind('change', page_metabox_visibililty); });
})(jQuery);
