let register = {
    selectMode: $('#role').val(),
    levelSelect: $('#levelSelect'),

    roleChange: (val = null) => {
        let html = '';

        if (register.selectMode !== null && register.selectMode === 'developer' || val ==='developer') {
            html = '<label for="level" class="col-md-4 col-form-label text-md-right">Level</label>\n' +
                '<div class="col-md-6">\n' +
                '<select id="level" class="form-control" name="level">\n' +
                '<option value="junior" class="levelType">Junior</option>\n' +
                '<option value="middle" class="levelType">Middle</option>\n' +
                '<option value="senior" class="levelType">Senior</option>\n' +
                '</select>\n' +
                '</div>';

            register.levelSelect.html(html);
            register.levelSelect.removeClass('d-none');
        } else if (register.selectMode === 'manager' || val === 'manager') {
            register.levelSelect.addClass('d-none');
        }
    },
};

register.roleChange();

$(document).on('change', '#role', (event) => {
    register.selectMode = $(event.target).val();
    register.roleChange($(event.target).val());
});