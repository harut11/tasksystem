let project = {
    roleValue: $('.roleType'),
    levelSelect: $('#levelSelect'),
    devName: $('.developerName'),
    staticDevName: $('#staticDev'),
    developers: [],

    roleChange: (event) => {
        let selectMode = $(event.target).val(),
            html = '';

        if (selectMode === 'developer') {
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
        } else if (selectMode === 'manager') {
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
    }
};

$(document).on('change', '#role', (event) => {
    project.roleChange(event);
});

$(document).on('change', '.status', (event) => {
    project.statusChange(event);
});

$(document).on('keyup', '#developer_name', (event) => {
    event.preventDefault();
    let val = $(event.target).val();
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

project.getDevelopers();

project.deadlinePicker();