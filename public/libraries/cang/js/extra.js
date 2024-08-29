{/* <script> */}

//fungsi klik
$(function() { 
    $(".klikini").trigger('click');
});

$(function() {
    let focusedElement;

    function handleFocus(event) {
        if (focusedElement === event.target) return;
        focusedElement = event.target;
        
        setTimeout(function() {
            focusedElement.select();
        }, 100);
    }
    $(document).on('focus', 'input[type="text"], textarea', handleFocus);
});

// Auto complete
$(function() {
    $("input, select, textarea").attr("autocomplete", "off");
    $(document).on('shown.bs.modal', function () {
        $("input, select, textarea", this).attr("autocomplete", "off");
    });
});

// Meload gambar dari folder
function previewImage() {
    const gambar = document.querySelector('#gambar');
    const imgPreview = document.querySelector('.img-preview');
    const fileGambar = new FileReader();    // gambarLabel.textContent = gambar.files[0].name; //ganti url di label

    fileGambar.readAsDataURL(gambar.files[0]); //ambil alamat penyimpanan
    fileGambar.onload = function(e) { //ganti preview image
        imgPreview.src = e.target.result;
    }
}

// menambah class aktif pada menu sidebar
$('.highlight-menu').click(function() {
    var path = location.pathname.split('/') //load side bar
    var url = '/' + path[1];   // var url = location.origin + '/' + path[1]; 
    url = (url === '/') ? '/home' : url;    
    if (window.location.href.indexOf('login') !== -1) return;

    $('ul.menu-sub li a').each(function() {
        if ($(this).attr('href').indexOf(url) !== -1){
            $(this).parent().addClass('active').parent().parent('li').addClass('active open').parent().parent('li').addClass('active open')
        }
    })
});

function flashdata(icon,judul) {
    Swal.fire({
        position: 'top-end',
        icon: icon,
        title: judul,
        showConfirmButton: false,
        timer: 3000,
    })
}

// format . dan ,
function formatAngka(nilai, model) {
    if (model === 'nol') {
        return nilai.split(".").join("").split(",").join(".");
    } else if (model === 'rp') {
        return nilai.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&*').split(".").join(",").split("*").join(".");
    } else if (model === 'koma') {
        return nilai.toString().split('.')[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',' + nilai.toString().split('.')[1];
    }
}

// Warna warni icon menu side bar
const icons = document.querySelectorAll('.fa-solid');
const colors = ['text-primary', 'text-danger', 'text-success', 'text-warning'];
icons.forEach((icon, index) => {
    icon.classList.add(colors[index % colors.length]);
});
