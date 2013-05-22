jQuery(document).ready(function () {
    var pID = jQuery('#post_ID').val();
    jQuery('#upload_image_button').click(function () {
        window.send_to_editor = function (html) {
            imgurl = jQuery('img', html).attr('src');
            jQuery('#upload_image').val(imgurl);
            tb_remove();
        }
        tb_show('', 'media-upload.php?post_id=' + pID + '&type=image&TB_iframe=true');
        return false;
    });
});