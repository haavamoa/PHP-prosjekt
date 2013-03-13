$(document).ready(function (){
    $('#nyttFagForm').hide();
    $('#nyttFag span').click(function(){
        $('#nyttFagForm').toggle();
        $('header select').toggle();
        $('#navigasjon').toggle();
})
});


