let project = {
    roleValue: $('.roleType'),
    levelSelect: $('#levelSelect'),

  roleChange: (event) => {
        let selectMode = $(event.target).val(),
            html = '';

        if (selectMode === 'developer') {
            html = '<label for="level" class="col-md-4 col-form-label text-md-right">Level</label>\n' +
                    '<div class="col-md-6">\n' +
                        '<select id="level" class="form-control" name="level">\n' +
                            '<option value="manager" class="levelType">Junior</option>\n' +
                            '<option value="manager" class="levelType">Middle</option>\n' +
                            '<option value="developer" class="levelType">Senior</option>\n' +
                        '</select>\n' +
                    '</div>';

            project.levelSelect.html(html);
            project.levelSelect.removeClass('d-none');
        } else if (selectMode === 'manager') {
            project.levelSelect.addClass('d-none');
        }
  }
};

$(document).on('change', '#role', (event) => {
    project.roleChange(event);
});