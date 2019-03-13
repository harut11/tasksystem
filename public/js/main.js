let project = {
    roleValue: $('.roleType'),
    levelSelect: $('#levelSelect'),
    devName: $('#developerName'),

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
            html = '';

        if (selectMode === 'assigned') {
            html = '<label for="developer_name" class="col-md-4 col-form-label text-md-right">Developer Name</label>\n' +
                '\n' +
                '<div class="col-md-6">\n' +
                '<input type="text" id="developer_name" class="position-relative form-control" name="developer_name">' +
                '<input type="hidden" name="developer_id" id="developer_id">\n' +
                '<div class="form-group position-absolute" id="searchSection">\n' +
                '<select multiple class="form-control d-none" id="searchResult"></select>\n' +
                '</div>\n' +
                '</div>';

            project.devName.append(html);
        } else {
            project.devName.empty();
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
                        searchResult = document.getElementById('searchResult');

                    if (users.length !== 0) {
                        $.each(users, (key, value) => {
                            let html = '<option value="'+value.first_name+'" class="userOption" data-id="'+value.id+'">'+ value.first_name + ' (' + value.email + ')' +'</option>';
                            searchResult.classList.remove('d-none');
                            searchResult.innerHTML = html;
                        });
                    } else {
                        $('.assigned').attr('disabled', true);
                        $('#status').val('created');
                        project.devName.empty();
                    }
                }
            }
        })
    }
};

$(document).on('change', '#role', (event) => {
    project.roleChange(event);
});

$(document).on('change', '#status', (event) => {
    project.statusChange(event);
});

$(document).on('keyup', '#developer_name', (event) => {
    event.preventDefault();
    let val = $(event.target).val();
    project.userAutocomplete(val);
});

$(document).on('click', '.userOption', (event) => {
    event.stopPropagation();
    document.getElementById('developer_name').value = $(event.target).val();
    document.getElementById('developer_id').value = $(event.target).attr('data-id');
});

// $('body').on('click', () => {
//     document.getElementById('searchResult').classList.add('d-none');
// });