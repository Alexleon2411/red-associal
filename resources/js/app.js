// import './bootstrap';
import Dropzone from 'dropzone';
// Importar CSS también
import 'dropzone/dist/dropzone.css';

// Configuración global (opcional)
Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aqui to imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function(){
        if(document.querySelector('[name="imagen"]').value.trim()){
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`)

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
})

dropzone.on("removedfile", function (){
    document.querySelector('[name="imagen"]').value =  '';
});


dropzone.on("success", function (file, response){
    console.log(response)
    document.querySelector('[name="imagen"]').value = response.imagen;
});

