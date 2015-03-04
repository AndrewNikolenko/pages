$(document).ready(function() {

    //Menu
    $(document).on('click', '#saveMenu', function(e) {
        e.preventDefault();

        var pages = [];
        $('.menuPages li').each(function() {
            var li = $(this);
            pages.push(li.attr('data-key'));
        });
        $.post( "/pages/admin/menu", { pages: JSON.stringify(pages) }, function(data) {
            $.pjax.reload({container : '#menuContainer', timeout: 5000});
            $(document).on('pjax:end', '#menuContainer', function() {
                $.pjax.reload({container : '#allPagesContainer', timeout: 5000});
            });
        });
    });

    $(document).on('click', '.dropMenu', function() {
        $(this).remove();
    });

    $('body').tooltip({
        selector: '.actionButtons a, .actionButtons i'
    });

    //Delete Page
    $(document).on('click','.deletePage', function(e) {
        e.preventDefault();

        var link = $(this);
        var url = link.attr('href');
        $.post( url, function(data) {
            if(data) {
                if(data == 1) {
                    link.parent('p').parent('li').fadeOut(250);
                    $.pjax.reload({container : '#inactivePagesContainer', timeout: 5000});
                }
            }
        });
    });

    //InactivePages - Remove Page
    $(document).on('click', '.removePage', function(e) {
        e.preventDefault();

        var link = $(this);
        var url = link.attr('href');
        $.post( url, function(data) {
            if(data) {
                link.parent('p').parent('li').fadeOut(250);
                $.pjax.reload({container : '#inactivePagesContainer', timeout: 5000});
            }
        });
    });

    //InactivePages - Restore Page
    $(document).on('click', '.restorePage', function(e) {
        e.preventDefault();

        var link = $(this);
        var url = link.attr('href');
        $.post( url, function(data) {
            if(data) {
                link.parent('p').parent('li').fadeOut(250);
                $.pjax.reload({container : '#inactivePagesContainer', timeout: 5000});
                $(document).on('pjax:end', '#inactivePagesContainer', function() {
                    $.pjax.reload({container : '#allPagesContainer', timeout: 5000});
                });
            }
        });
    });

    //Редактировать страницу
    var url = '';
    $(document).on('click', '.updatePage', function(e) {
        e.preventDefault();

        var link = $(this);
        url = link.attr('href');
        $.get( url, function(data) {
            if(data) {
                $('.formContainer').html(data);
                $('html, body').stop().animate({
                    scrollTop: $('#formContainer').offset().top
                }, 1000);
            }
        });
    });

    //Сохраняем обновленную страницу
    $(document).on('submit', '#update-form', function(e) {
        e.preventDefault();

        $.post( url, { filename: $('#page-filename').val(), filecontent: $('#page-filecontent').val() }, function(data) {
            if(data) {
                if(data==1) {
                    $('.formContainer').html('');
                    $('html, body').stop().animate({
                        scrollTop: $('#allPagesContainer').offset().top
                    }, 1000);
                }
            }
        });
    });

    //Добавляем новую страницу
    $(document).on('click', '.createPageLink', function(e) {
        e.preventDefault();

        var link = $(this);
        url = link.attr('href');
        $.get( url, function(data) {
            if(data) {
                $('.formContainer').html(data);
                $('html, body').stop().animate({
                    scrollTop: $('#formContainer').offset().top
                }, 1000);
            }
        });
    });
    
    //Обработка добавления новой страницы
    $(document).on('submit', '#create-page-form', function(e) {
        e.preventDefault();

        $.post( url, { filename: $('#page-filename').val(), filecontent: $('#page-filecontent').val() }, function(data) {
            if(data) {
                if(data==1) {
                    $.pjax.reload({container : '#allPagesContainer', timeout: 5000});
                    $('.formContainer').html('');
                    $('html, body').stop().animate({
                        scrollTop: $('#allPagesContainer').offset().top
                    }, 1000);
                }
            }
        });
    });

});