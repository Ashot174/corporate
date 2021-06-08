jQuery(document).ready(function () {

    jQuery('.commentlist li').each(function (i) {
        //console.log(i);
        jQuery(this).find('div.commentNumber').text('#' + (i + 1));
    });

jQuery('#commentform').on('click', '#submit',function (e) {
    e.preventDefault();
    let comParent = jQuery(this);
    jQuery('.wrap_result').css('color', 'green').text('Save Comment').fadeIn(500, function () {
        let data = jQuery('#commentform').serializeArray();
        jQuery.ajax({
            url:jQuery('#commentform').attr('action'),
            data: data,
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'JSON',
            // beforeSend: function(){
            //     // Handle the beforeSend event
            // },
            success: function (html) {
                if (html.error){
                    jQuery('.wrap_result').css('color', 'red').append('<br><strong>Ошибка: </strong>' + html.error.join('<br>'));
                    jQuery('.wrap_result').delay(2000).fadeOut(500);
                }else if (html.success){
                    jQuery('.wrap_result')
                        .append('<br><strong>Saved</strong>')
                        .delay(2000)
                        .fadeOut(500, function () {
                            if (html.data.parent_id > 0){
                                comParent.parents('div#respond').prev().after('<ul class="children">' + html.comment + '</ul>');
                            }else{
                                if (jQuery.contains('#comments', 'ol.commentlist')){
                                    jQuery('ol.commentlist').append(html.comment);
                                }else{
                                    jQuery('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');
                                }
                            }

                            jQuery('#cancel-comment-reply-link').click();

                        });
                }

            },
            error:function () {
                jQuery('.wrap_result').css('color', 'red').append('<br><strong>Ошибка!</strong>');
                jQuery('.wrap_result').delay(2000).fadeOut(500, function () {
                    jQuery('#cancel-comment-reply-link').click();
                })
            },
            // complete: function(){
            //     // Handle the complete event
            // }
        });
    });
});
});

// jQuery(document).ready(function() {
//     jQuery('#commentform').on('click', '#submit',function (e) {
//         e.preventDefault();
//         let id = $(this).attr('id');
//         // let token = $('meta[name="csrf-token"]').attr('content');
//         if(confirm("Are you sure you want to Delete this article?"))
//         {
//             jQuery.ajax({
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 url:"/admin/article/"+id,
//                 method:'Post',
//                 data:{
//                     id:id,
//                     // // _token:token,
//                     _method:'delete'
//                 },
//                 cache: false,
//                 success:function()
//                 {
//                     $('.article'+id).remove();
//                     // alert('hubhhg');
//                 },
//                 error: function(xhr) {
//                     console.log(xhr.responseText);
//                 }
//             })
//         }
//         else
//         {
//             return false;
//         }
//     });
//
// });


