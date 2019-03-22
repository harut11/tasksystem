let createOrUpdate = {
    developers: [],
    staticDevName: $('#staticDev'),
    devName: $('.developerName'),

    userAutocomplete: (val) => {
        $.ajax({
            url: '/manager/searchuser',
            method: 'get',
            data: {val: val},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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

    initDevelopers: (event) => {
        let div = document.getElementById('developers_id'),
            developers = document.getElementById('developers'),
            id = $(event.target).attr('data-id'),
            html = '',
            done = () => {
                createOrUpdate.developers.push(id);

                for (let i = 0; i < createOrUpdate.developers.length; i++) {
                    html += '<input type="hidden" class="devs" name="developers[]" value="'+ createOrUpdate.developers[i] +'">';
                }
                div.innerHTML = html;

                html = '<div class="ml-3 item" data-id="' + id + '">' + $(event.target).val() +
                    '<i class="fas fa-times ml-2 deleteDeveloper"></i></div>';

                developers.innerHTML += html;
            };

        if (createOrUpdate.developers.length > 0) {
            if (jQuery.inArray(id, createOrUpdate.developers) === -1){
                done();
            } else {
                return false;
            }
        } else {
            done();
        }
    },

    getDevelopers: () => {
        let devs = $('.devs');

        if (devs) {
            $.each(devs, (key, value) => {
                createOrUpdate.developers.push($(value).val());
            });
        }
    },

    deleteDevelopers: (developer) => {
        let id = developer.attr('data-id');

        createOrUpdate.developers.splice($.inArray(id, createOrUpdate.developers), 1);

        $.each($('.devs'), (key, value) => {
            if ($(value).val() === id) {
                value.remove();
            }
        });

        developer.remove();
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

    statusChange: (event) => {
        let selectMode = $(event.target).val(),
            dev_id = $('.devs'),
            html = '';

        if (selectMode === 'assigned' && !createOrUpdate.staticDevName.length) {
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


            createOrUpdate.devName.append(html);
        } else if(selectMode === 'assigned' && createOrUpdate.staticDevName.length) {
            createOrUpdate.staticDevName.removeClass('d-none');
            dev_id.attr('name', 'developers[]');
        } else if(selectMode !== 'assigned' && createOrUpdate.staticDevName.length) {
            createOrUpdate.staticDevName.addClass('d-none');
            dev_id.removeAttr('name');
        } else if(selectMode !== 'assigned' && !createOrUpdate.staticDevName.length) {
            createOrUpdate.devName.empty();
            createOrUpdate.developers = [];
        }
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

$(document).on('input', '#developer_name', (event) => {
    event.preventDefault();

    let val = $.trim($(event.target).val());
    createOrUpdate.userAutocomplete(val);
});

$(document).on('click', '.userOption', (event) => {
    event.stopPropagation();
    createOrUpdate.initDevelopers(event);

    document.getElementById('developer_name').value = '';
});

$('body').on('click', () => {
    let searchResult = document.getElementById('searchResult');

    if (searchResult) {
        searchResult.classList.add('d-none');
    }
});

$(document).on('click', '.deleteDeveloper', (event) => {
    let developer = $(event.target).closest('.item');
    createOrUpdate.deleteDevelopers(developer);
});

createOrUpdate.getDevelopers();

createOrUpdate.deadlinePicker();

$(document).on('change', '.status', (event) => {
    createOrUpdate.statusChange(event);
});