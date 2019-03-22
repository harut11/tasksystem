let paginateOrder = {
    orderType: null,

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

                    if (url.indexOf('manager') > 0) {
                        pagination.children().eq(1).empty()
                            .html('<a class="page-link" href="'+window.location.protocol+ '//' + window.location.hostname+'/manager/task?page=1">1</a>');
                        activatePrev();
                    } else if (url.indexOf('developer') > 0) {
                        pagination.children().eq(1).empty()
                            .html('<a class="page-link" href="'+window.location.protocol+ '//' + window.location.hostname+'/developer/task?page=1">1</a>');
                        activatePrev();
                    }
                };

            li.removeClass('active').removeAttr('aria-current');

            if ($(event.target).closest('a').is('[rel]')) {
                if ($(event.target).closest('a').is('[rel="next"]')) {
                    console.log(window.location.protocol + '//' + window.location.hostname + '/manager/task?page=');
                    let m = next.find('a').attr('href').replace(window.location.protocol + '//' + window.location.hostname + '/manager/task?page=', ''),
                        d = next.find('a').attr('href').replace(window.location.protocol + '//' + window.location.hostname + '/developer/task?page=', '');

                    activatePrev();
                    activateOne();

                    $.each(li, (key, value) => {
                        if ($(value).find('a').text() === m || $(value).find('a').text() === d) {
                            $(value).addClass('active').attr('aria-current', 'page');

                            next.find('a').attr('href', $(value).next().find('a').attr('href'));
                            prev.find('a').attr('href', $(value).prev().find('a').attr('href'));
                        }
                    });

                } else if($(event.target).closest('a').is('[rel="prev"]')) {
                    let f = prev.find('a').attr('href').replace(window.location.protocol + '//' + window.location.hostname + '/manager/task?page=', ''),
                        l= prev.find('a').attr('href').replace(window.location.protocol + '//' + window.location.hostname + '/developer/task?page=', '');

                    $.each(li, (key, value) => {
                        if ($(value).find('a').text() === f || $(value).find('a').text() === l) {
                            $(value).addClass('active').attr('aria-current', 'page');

                            prev.find('a').attr('href', $(value).prev().find('a').attr('href'));
                            next.find('a').attr('href', $(value).next().find('a').attr('href'));
                        }
                    });
                }
            } else {
                activateOne();

                clicked.addClass('active').attr('aria-current', 'page');
                next.find('a').attr('href', clicked.next().find('a').attr('href'));
                prev.find('a').attr('href', clicked.prev().find('a').attr('href'));
            }

            if (paginateOrder.orderType !== null) {
                paginateOrder.getTasks(url, paginateOrder.orderType);
            } else {
                paginateOrder.getTasks(url);
            }
        });
    },

    getTasks: (url, order = null) => {
        $.ajax({
            url: url,
            data: {order: order},
            success: (data) => {
                $('.task').html(data);
            }
        })
    },
};

$(document).on('click', '.order', (event) => {
    event.preventDefault();
    let order = $(event.target).closest('.order').attr('data-attribute'),
        th = $(event.target).closest('th');

    if (th.hasClass('dev')) {
        paginateOrder.getTasks('/developer/task', order);
    } else {
        paginateOrder.getTasks('/manager/task', order);
    }

    paginateOrder.orderType = order;
});

paginateOrder.paginate();