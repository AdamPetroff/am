tinymce.init({
    selector:'#article_text',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect',
    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
    image_advtab: true,
    content_css: "/assets/css/style.css,/assets/css/bootstrap.min.css,/assets/css/fancy-links.css",
    link_class_list: [
        {title: 'None', value: ''},
        {title: 'Call to action', value: 'call_to_action'},
        {title: 'Fancy link 1', value: 'cl-effect-1'}
    ],
    formats: {
        ass: {classes: 'anal'}
    },
    height: "500"
});
tinymce.activeEditor.formatter.apply('ass');