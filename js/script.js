window.addEventListener('DOMContentLoaded', function(){

    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        const mainContent = document.querySelector('body');
    
       
        setTimeout(function() {
            preloader.style.opacity = '0';
            setTimeout(function() {
                preloader.style.display = 'none';
                mainContent.style.display = 'block';
            }, 500); 
        }, 1000); 
    });

    
    let burgerOpen = document.querySelector('#burgerOpen'),
        mobileMenu = document.querySelector('.nav_menu');
        burgerClose = document.querySelector('#burgerClose');

    burgerOpen.addEventListener('click', ()=>{ 
        mobileMenu.classList.add('_active');
        document.body.style.overflowY = 'hidden'; 
    });

    burgerClose.addEventListener('click', ()=>{ 
        mobileMenu.classList.remove('_active');
        document.body.style.overflowY = 'auto';
    });

    const colorItems = document.querySelectorAll('.color_item');
    const mainImg = document.querySelector('.main-img');
    let productCode = document.querySelector('.product-code');

    const productCodes = [
        "C1000/C1000", "C1001/C1001", "C1002/C1002", "C1003/C1003", "C1004/C1004",
        "C1020/C1020", "C1022/C1022", "C1023/C1023", "C1024/C1024", "C1025/C1025",
        "C1060/C1060", "C1062/C1062", "C1063/C1063", "C1064/C1064", "C1065/C1065",
        "C1070/C1070", "C1072/C1072", "C1073/C1073", "C1075/C1075", "C1113/C1113",
        "C1132/C1132", "C1135/C1135", "C1150/C1150", "C1151/C1151", "C1152/C1152",
        "C1153/C1153", "C1154/C1154", "C1181/C1181", "C1182/C1182", "C1200/C1200",
        "C1201/C1201", "C1202/C1202", "C1203/C1203", "C1204/C1204", "C1300/C1300",
        "C1301/C1301", "C1302/C1302", "C1303/C1303", "C1304/C1304", "C1305/C1305",
        "C1306/C1306", "C1307/C1307", "C1308/C1308", "C1310/C1310", "C1312/C1312",
        "C1313/C1313", "C1501/C1501", "C1502/C1502" ];

    colorItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            const backgroundColor = window.getComputedStyle(item).getPropertyValue('background-color');
            mainImg.style.backgroundColor = backgroundColor;
            productCode.textContent = productCodes[index];
        });
    });


    const form = document.getElementById('contact-form');

    form.addEventListener('submit', formSend);

    async function formSend(e){
        e.preventDefault();

        let error = formValidate(form);
        let formData = new FormData(form);

        if(error === 0){
            form.classList.add('_sending');
            let response = await fetch('sendmail.php', {
                method: 'POST',
                body: formData
            });

            if(response.ok){
                let result = await response.json();
                alert(result.message);
                form.reset();
                form.classList.remove('_sending');
            } else {
                alert('Chyba při odesílání formuláře');
                form.classList.remove('_sending');
            }
        }
        else 
            alert('Vyplňte všechna pole');
    }


    function formValidate(form){
        let error = 0;
        let formReq = document.querySelectorAll('._req');

        for(let index = 0; index < formReq.length; index++)
        {
            const input = formReq[index];

            formRemoveError(input);

            if (input.classList.contains('_email')){
                if(emailTest(input)){
                    formAddError(input);
                    error++;
                }
            } else {
                if(input.value === ''){
                    formAddError(input);
                    error++;
                }
            }
        }
        return error;
    }

    function formAddError(input) {
        input.parentElement.classList.add('_error');
        input.classList.add('_error');
    }

    function formRemoveError(input) {
        input.parentElement.classList.remove('_error');
        input.classList.remove('_error');
    }

    function emailTest(input) {
        return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
    }
});