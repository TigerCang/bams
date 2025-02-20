// Function for match string
// function stringMatch(term, candidate) {
//     return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
// }

// Matcher for .select2-subtext
// function matchCustom(params, data) {
//     if ($.trim(params.term) === '') return data;
//     if (typeof data.text === 'undefined') return null;
//     if (stringMatch(params.term, data.text)) return data;
//     if (stringMatch(params.term, $(data.element).attr('data-subtext'))) return data;
//     return null;
// }

// Template for show subtext
// function formatOption(state) {
//     if (!state.id) return state.text;
//     var subtext = state['data-subtext'] || $(state.element).attr('data-subtext') || '';
//     return $('<span>' + state.text + ' <small class="subtext">' + subtext + '</small></span>');
// }

// Template for selection option
// function formatOptionSelection(state) {
//     if (!state.id) return state.text;
//     var subtext = state['data-subtext'] || $(state.element).attr('data-subtext') || '';
//     return $('<span>' + state.text + ' <small class="subtext">' + subtext + '</small></span>');
// }

// Initialization Select2
$(function () {
    // .select2-subtext,
    $(".select2-non, .select2-tokenizer").each(function () {
        var $this = $(this);
        var dropdownParent = $this.closest('.modal').length ? $this.closest('.modal') : $(document.body);
        if ($this.hasClass('select2-non')) {
            var allowClear = $this.data('allow-clear') === true || $this.data('allow-clear') === "true";
            var placeholder = $this.data('placeholder');
            $this.select2({
                placeholder: placeholder,
                allowClear: allowClear,
                dropdownParent: dropdownParent
            });
        // } else if ($this.hasClass('select2-subtext')) {
        //     $this.select2({
        //         matcher: matchCustom,
        //         templateResult: formatOption,
        //         templateSelection: formatOptionSelection,
        //         dropdownParent: dropdownParent
        //     });
        } else if ($this.hasClass('select2-tokenizer')) {
            $this.select2({
                tags: true,
                tokenSeparators: ['/', ',', ';'],
                dropdownParent: dropdownParent
            });
        }
    });
});

// "template 1": "templateResult: formatOption",
// "template 2": "templateSelection: formatOptionSelection",
