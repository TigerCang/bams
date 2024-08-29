  'use strict';
$(function() {
    
    /*date*/
    $(".date").inputmask({ mask: "99/99/9999"});
    $(".date2").inputmask({ mask: "99-99-9999"});
    /*time*/
    $(".hour").inputmask({ mask: "99:99:99"});
    $(".dateHour").inputmask({ mask: "99/99/9999 99:99:99"});

    /*phone no*/
    $(".mob_no").inputmask({ mask: "9999-999-999"});
    $(".phone").inputmask({ mask: "9999-9999"});
    $(".telphone_with_code").inputmask({ mask: "(99) 9999-9999"});
    $(".us_telephone").inputmask({ mask: "(999) 999-9999"});
    $(".ip").inputmask({ mask: "999.999.999.999"});
    $(".isbn1").inputmask({ mask: "999-99-999-9999-9"});
    $(".isbn2").inputmask({ mask: "999 99 999 9999 9"});
    $(".isbn3").inputmask({ mask: "999/99/999/9999/9"});
    $(".ipv4").inputmask({ mask: "999.999.999.9999"});
    $(".ipv6").inputmask({ mask: "9999:9999:9999:9:999:9999:9999:9999"});

    /*tambahan*/
    $(".noakun").inputmask({ mask: "999.999"});
    $(".nip").inputmask({ mask: "99.99.9999"});
    $(".barang").inputmask({ mask: "aaaa-aaaa.999"});
    $(".barangns").inputmask({ mask: "aaa-aaa.999"});
    $(".barangbekas").inputmask({ mask: "aa-aa.999"});
    $(".inventaris").inputmask({ mask: "aaa-a-aaa-999.999"});
    $(".obpajak").inputmask({ mask: "99-999-99"});
    $(".masapajak").inputmask({ mask: "99-9999"});
    $(".nopotongpph").inputmask({ mask: "9999999999"});
    // $('.autonumber').autoNumeric('init');

    /*numbers*/
    $(function() {
      $('.autonumber').each(function() {
        var digitAfterDecimal = $(this).data('digit-after-decimal');
        $(this).autoNumeric('init', {
            // vMax: digitAfterDecimal === 0 ? '9999999999999' : '9999999999999.99',
            vMax: '9999999999999' + (digitAfterDecimal > 0 ? '.' + '9'.repeat(digitAfterDecimal) : ''),
            vMin: '-9999999999999' + (digitAfterDecimal > 0 ? '.' + '9'.repeat(digitAfterDecimal) : '')
          });
      });
    });
  });