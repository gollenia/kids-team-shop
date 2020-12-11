

import UIkit from 'uikit';

import './../scss/app.scss';
window.UIkit = UIkit;




import textareaResize from './extras/textareaResize';
import  './icons';



UIkit.util.on('#mobile-menu', 'beforeshow', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.add("is-active");
    }
});

UIkit.util.on('#mobile-menu', 'beforehide', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.remove("is-active");
    }
});





textareaResize("textarea");





