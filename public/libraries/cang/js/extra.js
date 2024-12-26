(function() {
    // Click Function 
    $(function() { 
        $(".clickThis").trigger('click');

        let focusedElement;
        function handleFocus(event) {
            if (focusedElement === event.target) return;
            focusedElement = event.target;
            
            setTimeout(function() {
                focusedElement.select();
            }, 100);
        }
        $(document).on('focus', 'input[type="text"], textarea', handleFocus);

        // Inactive Auto complete
        $("input, select, textarea").attr("autocomplete", "off");
        $(document).on('shown.bs.modal', function () {
            $("input, select, textarea", this).attr("autocomplete", "off");
        });
    });

  
    // Add active class on menu sidebar
    $('.highlight-menu').click(function() {
        var path = location.pathname.split('/');
        var url = '/' + path[1];   
        url = (url === '/') ? '/home' : url;    
        if (window.location.href.indexOf('login') !== -1) return;

        $('ul.menu-sub li a').each(function() {
            if ($(this).attr('href').indexOf(url) !== -1){
                $(this).parent().addClass('active').parent().parent('li').addClass('active open').parent().parent('li').addClass('active open');
            }
        });
    });

    // Sweet Alert flashData Function
    function flashData(icon, title) {
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 3000,
        });
    }
    
    // set icon menu sidebar multi color
    const iconElements = document.querySelectorAll('.fa-solid');
    const colors = ['text-primary', 'text-danger', 'text-success', 'text-warning'];
    iconElements.forEach((icon, index) => {
        icon.classList.add(colors[index % colors.length]);
    });
})();

// Format Amount
function formatAmount(nValue, model) {
    if (model === 'nol') {
        return nValue.split(".").join("").split(",").join(".");
    } else if (model === 'rp') {
        return nValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&*').split(".").join(",").split("*").join(".");
    } else if (model === 'coma') {
        return nValue.toString().split('.')[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',' + nValue.toString().split('.')[1];
    }
}

// Load Picture from folder
function previewImage() {
    const picture = document.querySelector('#picture');
    const imgPreview = document.querySelector('.img-preview');
    const filePicture = new FileReader();    

    filePicture.readAsDataURL(picture.files[0]); 
    filePicture.onload = function(e) { 
        imgPreview.src = e.target.result;
    }
}

// Function SweetAlert2 for delete confirmation
function deleteConfirmation(title) {
    return Swal.fire({
        title: title,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
            cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false
    })
}

// Function toggle Full Screen
function toggleFullScreen() {
    $(window).height();
    document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT), $(".full-screen").toggleClass("ri-expand-diagonal-line"), $(".full-screen").toggleClass("ri-collapse-diagonal-line")                         
}

// Function icon eyes on toggle-password 
document.querySelectorAll('.toggle-password').forEach((icon) => {
    let passwordField = icon.previousElementSibling; // Get element input password before icon
    let isClickingIcon = false; // Sign icon is click

    passwordField.addEventListener('focus', function () { // icon input onfocus
        icon.style.display = 'inline'; // Show icon
    });

    passwordField.addEventListener('blur', function () { // Hide icon input out focus, except icon on click
        if (!isClickingIcon) icon.style.display = 'none'; // Hide icon
    });

    icon.addEventListener('mousedown', function () { // Handle click on icon toggle password
        isClickingIcon = true;
    });

    icon.addEventListener('mouseup', function () {
        isClickingIcon = false;
        passwordField.focus(); // set focus on input
    });

    icon.addEventListener('click', function () {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            this.src = 'assets/image/eye-open.png';
        } else {
            passwordField.type = 'password';
            this.src = 'assets/image/eye-hide.png';
        }
    });
    icon.style.display = 'none'; // Set icon hide by default
});