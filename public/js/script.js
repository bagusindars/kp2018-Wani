$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    wrapping: false
                });
            });



if($(".komentar-form").val() < 1 )
	 $(".submit-komentar").attr('disabled', true);

    $('.komentar-form').keyup(function(){
    	if ($(".komentar-form").val() != null) {
             $(".submit-komentar").removeAttr('disabled');
         } 

         if ($(".komentar-form").val() == '') {
             $(".submit-komentar").attr('disabled', true);
         }
})


$('#tag_select').on('change',function(){
       if($(this).val() == 7 ){
            $('.tag_bebas').show();
            $(this).attr('disabled',true);
            $('.input-tagbebas').prop('disabled',false);
            $('.centangtag').on('change',function(){
                if($('.centangtag:checked')){
                    $('#tag_select').removeAttr('disabled');
                    $('.tag_bebas').hide(); 
                    $('.centangtag').prop('checked',false);
                    $('.tag_bebas').prop('disabled',true);
                    $('.input-tagbebas').prop('disabled',true);
                    $('#tag_select').val('');
                }else{
                   
                }
            })
       }else{
            $('.tag_bebas').hide();
       }
});

$(".kiri").stick_in_parent();

$('#toTop').click(function(){
    $('html,body').animate({
        scrollTop: 0
    },1000);
})

$(document).on('click touchstart' , '.love-like',function(){
     var _this = $(this);

     var _url = '/like/'+ _this.attr('data-type')+"/"+_this.attr('data-model-id');
    
     $.get(_url,function(data){
        _this.addClass('love-danger love-unlike').removeClass('love-like love-primary');
        var likeNumber = _this.parent('.like_wrapper').find('.like_number');
        likeNumber.html( parseInt(likeNumber.html()) + 1 );
     });
});

$(document).on('click touchstart' , '.love-unlike',function(){
     var _this = $(this);

     var _url = '/unlike/'+ _this.attr('data-type')+"/"+_this.attr('data-model-id');
    
     $.get(_url,function(data){
        _this.removeClass('love-danger love-unlike').addClass('love-like love-primary');
        var likeNumber = _this.parent('.like_wrapper').find('.like_number');
        likeNumber.html( parseInt(likeNumber.html()) - 1 );
     });
});


var editor = new MediumEditor('.editable', {
            buttonLabels: 'fontawesome'
        });


// var counter = 0;

// $('#add_img').click(function(){
//     counter++;

//     if(counter < 5 ){
//         $('#input_img').clone().val("").appendTo('#input_file');
//     } 


// })



var abc = 0;
        $('#add_more').click(function ()
            {
                $(this).before($("<div/>",{id: 'filediv'}).fadeIn('slow').append($("<input/>",
                            {
                                name: 'featured_img[]',
                                type: 'file',
                                id: 'file'
                            }),
                            $("<br/>")
                        ));
                 
                
            });
        $('body').on('change', '#file', function ()
            {
                if (this.files && this.files[0])
                {
                    abc += 1; //increementing global variable by 1
                    var z = abc - 1;
                    var x = $(this)
                        .parent()
                        .find('#previewimg' + z).remove();
                    $(this).before("<div id='abcd" + abc + "' class='abcd'><img class='imgpreview' id='previewimg" + abc + "' src=''/></div>");
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                    $(this)
                        .hide();
                    $("#abcd" + abc).append($("<br><span class='delete_img_create'> Hapus </span><br><br>",{
                                id: 'img',
                                // src: '../img/close.png', //the remove icon
                                // alt: 'delete',
                                // width: '100px',
                            }) .click(function ()
                            {
                                $(this)
                                    .parent()
                                    .parent()
                                    .remove();
                            }));
                }
            });
        //image preview
        function imageIsLoaded(e)
        {
            $('#previewimg' + abc)
                .attr('src', e.target.result);
        };


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.form-group .preview_img')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}






$('.carousel').carousel();

