function logout() {
    $.post('/user/security/logout/');
}



function searchAll() {
    $('.top__search .search_result').remove();
    $.ajax({
        url: "/ajax/product-search",
        type: 'POST',
        // Form data
        data: {
            'search' : $('input#search').val()
        },
        dataType: 'json',
        success: function (data) {
            $('.top__search').append('<div class="search_result"></div>');
            if(data['products'].length>0) {
                data['products'].forEach(function(el) {
                    cat = '<div class="bread">';
                    el['category'].forEach(function(c) {
                        cat+= '<span>'+c['name']+'</span>';
                    });
                    cat +='</div>';
                    $('.search_result').append('<div class="row"><div class="col-md-4"><img src="'+el['image']+'"></div><div class="col-md-8"><a href="'+el['url']+'">'+el['name']+'</a>'+cat+'</div></div>');
                });
            } else {
                $('.search_result').append('<div class="no-result">No results</div>');
            }
            CategoryIdSelector();
        }
    });
}

jQuery(document).ready(function () {
    let title;
    $('input.fancy[type="file"]:not(.nolabel)').each(function () {
        title = $(this).attr('attr-title');
        if(!title) title = 'Select File';
        $(this).inputfile({
            uploadText: '<div class="select_file"><span class="glyphicon glyphicon-upload"></span>'+title+'</div>',
            removeText: '<span class="glyphicon glyphicon-trash"></span>',
            restoreText: '<span class="glyphicon glyphicon-remove"></span>',

            uploadButtonClass: 'btn btn-primary',
            removeButtonClass: 'btn btn-default'
        });
    });
    $('input.fancy.nolabel[type="file"]').each(function () {
        title = $(this).attr('attr-title');
        if(!title) title = 'Select File';
        $(this).inputfile({
            uploadText: '<div class="select_file"><span class="glyphicon glyphicon-upload"></span>'+title+'</div>',
            removeText: '',
            restoreText: '',

            uploadButtonClass: 'btn btn-primary',
            removeButtonClass: 'btn btn-default',
        });
    });


    $('#search').keypress(function() {
        if (typeof timerSearchProduct !== 'undefined') {
            clearTimeout(timerSearchProduct);
        }

        timerSearchProduct = setTimeout(searchAll, 500);
    });


});

