let project = {
    roleValue: $('.roleType'),
    levelSelect: $('#levelSelect'),
    devName: $('.developerName'),
    staticDevName: $('#staticDev'),
    developers: [],
    selectMode: $('#role').val(),
    orderType: null,

    roleChange: (val = null) => {
        let html = '';

        if (project.selectMode !== null && project.selectMode === 'developer' || val ==='developer') {
            html = '<label for="level" class="col-md-4 col-form-label text-md-right">Level</label>\n' +
                    '<div class="col-md-6">\n' +
                        '<select id="level" class="form-control" name="level">\n' +
                            '<option value="junior" class="levelType">Junior</option>\n' +
                            '<option value="middle" class="levelType">Middle</option>\n' +
                            '<option value="senior" class="levelType">Senior</option>\n' +
                        '</select>\n' +
                    '</div>';

            project.levelSelect.html(html);
            project.levelSelect.removeClass('d-none');
        } else if (project.selectMode === 'manager' || val === 'manager') {
            project.levelSelect.addClass('d-none');
        }
    },

    statusChange: (event) => {
        let selectMode = $(event.target).val(),
            dev_id = $('.devs'),
            html = '';

        if (selectMode === 'assigned' && !project.staticDevName.length) {
            html = '<label for="developer_name" class="col-md-4 col-form-label text-md-right">Shearch Developer</label>\n' +
                '\n' +
                '<div class="col-md-6">\n' +
                '<input type="text" id="developer_name" class="position-relative form-control" ' +
                'name="developer_name" autocomplete="off">' +
                '<div class="row mt-3" id="developers"></div>' +
                '<div id="developers_id"></div>\n' +
                '<div class="form-group position-absolute" id="searchSection">\n' +
                '<select multiple class="form-control d-none" id="searchResult"></select>\n' +
                '</div>\n' +
                '</div>';


            project.devName.append(html);
        } else if(selectMode === 'assigned' && project.staticDevName.length) {
            project.staticDevName.removeClass('d-none');
            dev_id.attr('name', 'developers[]');
        } else if(selectMode !== 'assigned' && project.staticDevName.length) {
            project.staticDevName.addClass('d-none');
            dev_id.removeAttr('name');
        } else if(selectMode !== 'assigned' && !project.staticDevName.length) {
            project.devName.empty();
            project.developers = [];
        }
    },

    userAutocomplete: (val) => {
        $.ajax({
            url: '/searchuser',
            method: 'get',
            data: {val: val},
            success: (response) => {
                if (response) {
                    let users = JSON.parse(response)['users'],
                        searchResult = document.getElementById('searchResult'),
                        html = '';

                    $.each(users, (key, value) => {
                        html += '<option value="'+value.first_name+'" class="userOption" ' +
                            'data-id="'+value.id+'">'+ value.first_name + ' (' + value.email + ')' +'</option>';
                        searchResult.classList.remove('d-none');
                        searchResult.innerHTML = html;
                    });
                }
            }
        })
    },

    deadlinePicker: () => {
        let dateTimes = $('input[name="deadline"]');

        dateTimes.daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            minDate: moment().startOf('hour'),
            startDate: moment().startOf('hour'),
            maxDate: '12/31/2030',
            autoUpdateInput: false,
            opens: 'center',
        });

        dateTimes.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.endDate.format('YYYY/MM/DD hh:mm A'));
        });

        dateTimes.on('cancel.daterangepicker', function() {
            $(this).val('');
        });
    },

    initDevelopers: (event) => {
        let div = document.getElementById('developers_id'),
            developers = document.getElementById('developers'),
            id = $(event.target).attr('data-id'),
            html = '',
            done = () => {
                project.developers.push(id);

                for (let i = 0; i < project.developers.length; i++) {
                    html += '<input type="hidden" class="devs" name="developers[]" value="'+ project.developers[i] +'">';
                }
                div.innerHTML = html;

                html = '<div class="ml-3 item" data-id="' + id + '">' + $(event.target).val() +
                    '<i class="fas fa-times ml-2 deleteDeveloper"></i></div>';

                developers.innerHTML += html;
            };

        if (project.developers.length > 0) {
            if (jQuery.inArray(id, project.developers) === -1){
                done();
            } else {
                return false;
            }
        } else {
            done();
        }
    },

    deleteDevelopers: (developer) => {
        let id = developer.attr('data-id');

        project.developers.splice($.inArray(id, project.developers), 1);

        $.each($('.devs'), (key, value) => {
            if ($(value).val() === id) {
                value.remove();
            }
        });

        developer.remove();
    },

    getDevelopers: () => {
        let devs = $('.devs');

        if (devs) {
            $.each(devs, (key, value) => {
                project.developers.push($(value).val());
            });
        }
    },

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
                    console.log(url.indexOf('developer'));
                    if (url.indexOf('manager') > 0) {
                        pagination.children().eq(1).empty()
                            .html('<a class="page-link" href="http://127.0.0.1:8000/manager/task?page=1">1</a>');
                        activatePrev();
                    } else if (url.indexOf('manager') > 0) {
                        pagination.children().eq(1).empty()
                            .html('<a class="page-link" href="http://127.0.0.1:8000/developer/task?page=1">1</a>');
                        activatePrev();
                    }
                };

            li.removeClass('active').removeAttr('aria-current');
            
            if ($(event.target).closest('a').is('[rel]')) {
                if ($(event.target).closest('a').is('[rel="next"]')) {
                    let m = next.find('a').attr('href').replace('http://127.0.0.1:8000/manager/task?page=', ''),
                        d = next.find('a').attr('href').replace('http://127.0.0.1:8000/developer/task?page=', '');

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
                    let f = prev.find('a').attr('href').replace('http://127.0.0.1:8000/manager/task?page=', ''),
                        l= prev.find('a').attr('href').replace('http://127.0.0.1:8000/developer/task?page=', '');

                    activatePrev();
                    activateOne();

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

            if (project.orderType !== null) {
                project.getTasks(url, project.orderType);
            } else {
                project.getTasks(url);
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

$(document).keydown((e) => {
    let searchResult = document.getElementById('searchResult');

    if (searchResult) {
        switch (e.keyCode) {
            case 40:
                searchResult.focus();
                break;
            case 13:
                e.preventDefault();

                $.each($('.userOption'), (key, value) => {

                    if ($(value).val() === $(searchResult).val()[0]) {
                        $(value).trigger('click');
                    }
                });
                break;
        }
    }
});

$(document).on('change', '#role', (event) => {
    project.selectMode = $(event.target).val();
    project.roleChange($(event.target).val());
});

$(document).on('change', '.status', (event) => {
    project.statusChange(event);
});

$(document).on('input', '#developer_name', (event) => {
    event.preventDefault();
    
    let val = $.trim($(event.target).val());
    project.userAutocomplete(val);
});

$(document).on('click', '.userOption', (event) => {
    event.stopPropagation();
    project.initDevelopers(event);

    document.getElementById('developer_name').value = '';
});

$(document).on('click', '.deleteDeveloper', (event) => {
    let developer = $(event.target).closest('.item');
   project.deleteDevelopers(developer);
});

$('body').on('click', () => {
    let searchResult = document.getElementById('searchResult');

    if (searchResult) {
     searchResult.classList.add('d-none');
    }
});

$(document).on('click', '.order', (event) => {
    event.preventDefault();
    let order = $(event.target).closest('.order').attr('data-attribute'),
        th = $(event.target).closest('th');

    if (th.hasClass('dev')) {
        project.getTasks('http://127.0.0.1:8000/developer/task', order);
    } else {
        project.getTasks('http://127.0.0.1:8000/manager/task', order);
    }

    project.orderType = order;
});

project.getDevelopers();

project.deadlinePicker();

project.roleChange();

project.paginate();