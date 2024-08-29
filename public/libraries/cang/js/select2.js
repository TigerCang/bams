// Deklarasi fungsi
function stringMatch(term, candidate) {
    return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
}

function matchCustom(params, data) {
    if ($.trim(params.term) === '') return data;
    if (typeof data.text === 'undefined') return null;
    if (stringMatch(params.term, data.text)) return data;
    if (stringMatch(params.term, $(data.element).attr('data-subtext'))) return data;
    return null;
}

function formatOption(state) {
    if (!state.id) return state.text;
    if (state['data-subtext']) {
        return $('<span>' + state.text + ' <small class="subtext">' + state['data-subtext'] + '</small></span>');
    }
    return $('<span>' + state.text + ' <small class="subtext">' + $(state.element).attr('data-subtext') + '</small></span>');
}

function formatOptionSelection(state) {
    if (!state.id) return state.text;
    if (state['data-subtext']) {
        return $('<span>' + state.text + ' <small class="subtext">' + (state['data-subtext'] || '') + '</small></span>');
    }
    return $('<span>' + state.text + ' <small class="subtext">' + $(state.element).attr('data-subtext') + '</small></span>');
}

$(function() {
    $(".select2-subtext, .select2-non, .select2-tokenizer").each(function() {
        var dropdownParent = $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body);

        if ($(this).hasClass('select2-subtext')) {
            $(this).select2({
                matcher: matchCustom,
                templateResult: formatOption,
                templateSelection: formatOptionSelection,
                dropdownParent: dropdownParent
            });
        } else if ($(this).hasClass('select2-non')) {
            var allowClear = $(this).data('allow-clear') === true || $(this).data('allow-clear') === "true";
            var placeholder = $(this).data('placeholder');
            
            $(this).select2({
                placeholder: placeholder,
                allowClear: allowClear,
                dropdownParent: dropdownParent
            });
        } else if ($(this).hasClass('select2-tokenizer')) {
            $(this).select2({
                tags: true,
                tokenSeparators: ['/', ',', ';'],
                dropdownParent: dropdownParent
            });
        }
    });
});
