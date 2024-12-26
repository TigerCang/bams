  'use strict';
$(function() {
  /*date*/
  $(".date").inputmask({ mask: "99/99/9999"});
  $(".date2").inputmask({ mask: "99-99-9999"});
  /*time*/
  $(".hour").inputmask({ mask: "99:99:99"});
  $(".dateHour").inputmask({ mask: "99/99/9999 99:99:99"});

  /*extra*/
  $(".accountNumber").inputmask({ mask: "999.999"});
  $(".eid").inputmask({ mask: "99.99.9999"});
  $(".item").inputmask({ mask: "aaaa-aaaa.9999"});
  // $(".barangns").inputmask({ mask: "aaa-aaa.999"});
  // $(".barangbekas").inputmask({ mask: "aa-aa.999"});
  $(".inventory").inputmask({ mask: "aaa-a-aaa-999.999"});
  $(".taxObject").inputmask({ mask: "99-999-99"});
  // $(".masapajak").inputmask({ mask: "99-9999"});
  // $(".nopotongpph").inputmask({ mask: "9999999999"});
  // $('.autonumber').autoNumeric('init');

  /*numbers*/
  $(function() {
    $('.autonumber').each(function() {
      // var digitAfterDecimal = $(this).data('digit-after-decimal') || 2;
      var digitAfterDecimal = $(this).data('digit-after-decimal') !== undefined ? $(this).data('digit-after-decimal') : 2; // default to 2 if undefined
      $(this).autoNumeric('init', {
          vMax: '9999999999999' + (digitAfterDecimal > 0 ? '.' + '9'.repeat(digitAfterDecimal) : ''),
          vMin: '-9999999999999' + (digitAfterDecimal > 0 ? '.' + '9'.repeat(digitAfterDecimal) : '')
        });
    });
  });
});