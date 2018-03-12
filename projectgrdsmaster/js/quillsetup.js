var toolbarOptions = [
    [{ 'list': 'bullet' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],
    ['link']];

var quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions
    }
    , theme: 'snow'
});

