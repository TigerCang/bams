$( document ).ready(function() {
  var theme = $('html').hasClass('light-style') ? 'default' : 'default-dark';

  $('#jstree-checkbox1').jstree({
    core: {
      themes: {
        'name': theme,
        'responsive': false
      },
    },
    plugins: ['types', 'checkbox', 'wholerow'],
    types: {
      default: {
        icon: 'ri-folder-4-line'
      },
      file: {
        icon: 'ri-file-4-line'
      }
    }
  });
});
