let paginateOrder = {
    orderType: null,
    what: null,

    paginate: () => {
        $(document).on('click', '.pagination a', (event) => {
            event.preventDefault();

            let li = $('.pagination li'),
                pagination = $('.pagination'),
                clicked = $(event.target).closest('li'),
                next = pagination.children().eq(-1),
                prev = pagination.children().eq(0),
                url = $(event.target).attr('href'),
                activatePrev = () => {
                    prev.empty().removeClass('disabled').removeAttr('aria-disabled')
                        .html('<a class="page-link" href="" rel="prev">‹</a>');
                },
                activateOne = () => {
                    pagination.children().eq(1).empty()
                        .html('<a class="page-link" href="'+window.location.href.split('?')[0]+'?page=1">1</a>');
                    activatePrev();
                };

            li.removeClass('active').removeAttr('aria-current');

            if ($(event.target).closest('a').is('[rel]')) {
                if ($(event.target).closest('a').is('[rel="next"]')) {
                    let m = next.find('a').attr('href').replace(window.location.href.split('?')[0] + '?page=', ''),
                        d = next.find('a').attr('href').replace(window.location.href.split('?')[0] + '?page=', '');

                    activatePrev();
                    activateOne();

                    $.each(li, (key, value) => {
                        if ($(value).find('a').text() === m || $(value).find('a').text() === d) {
                            $(value).addClass('active').attr('aria-current', 'page');

                            prev.find('a').attr('href', $(value).prev().find('a').attr('href'));

                            if ($(value).next().find('a').attr('rel') !== 'next') {
                                next.find('a').attr('href', $(value).next().find('a').attr('href'));
                            } else {
                                $('a[rel="next"]').closest('li').addClass('disabled');
                            }
                        }
                    });

                } else if($(event.target).closest('a').is('[rel="prev"]')) {
                    let f = prev.find('a').attr('href').replace(window.location.href.split('?')[0] + '?page=', ''),
                        l= prev.find('a').attr('href').replace(window.location.href.split('?')[0] + '?page=', '');

                    $.each(li, (key, value) => {
                        if ($(value).find('a').text() === f || $(value).find('a').text() === l) {
                            $(value).addClass('active').attr('aria-current', 'page');

                            if ($(value).prev().find('a').attr('rel') !== 'prev') {
                                prev.find('a').attr('href', $(value).prev().find('a').attr('href'));
                            } else {
                                $('a[rel="prev"]').closest('li').addClass('disabled');
                            }
                            $('a[rel="next"]').closest('li').removeClass('disabled');
                            next.find('a').attr('href', $(value).next().find('a').attr('href'));
                        }
                    });
                }
            } else {
                activateOne();

                clicked.addClass('active').attr('aria-current', 'page');

                if (clicked.prev().find('a').attr('rel') !== 'prev') {
                    prev.find('a').attr('href', clicked.prev().find('a').attr('href'));
                } else {
                    prev.find('a').removeAttr('href');
                    $('a[rel="prev"]').closest('li').addClass('disabled');
                }

                if (clicked.next().find('a').attr('rel') !== 'next') {
                    $('a[rel="next"]').closest('li').removeClass('disabled');
                    next.find('a').attr('href', clicked.next().find('a').attr('href'));
                } else {
                    next.find('a').removeAttr('href');
                    $('a[rel="next"]').closest('li').addClass('disabled');
                }
            }

            paginateOrder.getTasks(url, paginateOrder.what, paginateOrder.orderType);
        });
    },

    getTasks: (url, what = null, order = null) => {
        $.ajax({
            url: url,
            data: {order: order, what: what},
            success: (data) => {
                $('.task').html(data);
            }
        })
    },
};

$(document).on('click', '.order', (event) => {
    event.preventDefault();
    let order = $(event.target).closest('.order').attr('data-attribute'),
        what = $(event.target).closest('.order').attr('data-name'),
        th = $(event.target).closest('th');

    if (th.hasClass('dev')) {
        paginateOrder.getTasks('/developer/task', what, order);
    } else {
        paginateOrder.getTasks('/manager/task', what, order);
    }

    paginateOrder.orderType = order;
    paginateOrder.what = what;
});

paginateOrder.paginate();