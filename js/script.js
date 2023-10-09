window.addEventListener('DOMContentLoaded', function(){
    let burgerOpen = document.querySelector('#burgerOpen'),
        mobileMenu = document.querySelector('.nav_menu');
        burgerClose = document.querySelector('#burgerClose');

    burgerOpen.addEventListener('click', ()=>{ 
        mobileMenu.classList.add('_active');
    });

    burgerClose.addEventListener('click', ()=>{ 
        mobileMenu.classList.remove('_active');
    });

});