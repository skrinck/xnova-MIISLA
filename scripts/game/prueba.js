$(document).ready(function(){
    iziToast.show({
        id: 'home',
        theme: 'light',
        icon: 'fas fa-bullhorn',
        title: 'Bienvenidos',
        message: 'Al Ogame de Cuba',
        position: 'bottomRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        transitionIn: 'flipInX',
        transitionInMobile: 'fadeInUp',
        transitionOutMobile: 'fadeOutDown'

    }); 
});