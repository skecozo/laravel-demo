import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'

var simplemde = new SimpleMDE({
    element: document.getElementById("editor"),
    autoDownloadFontAwesome: false,
    spellChecker: false,
    placeholder: '将图片直接拖动到编辑区即可上传',
});
this.simplemde.codemirror.on("drop", function(editor,e){
    // console.log(e.dataTransfer.files[0]);
    if(!(e.dataTransfer&&e.dataTransfer.files)){
        alert("该浏览器不支持操作");
        return;
    }
    for(var i=0;i<e.dataTransfer.files.length;i++){
        console.log(e.dataTransfer.files[i]);
        fileUpload(e.dataTransfer.files[i]);
    }
    e.preventDefault();
});

this.simplemde.codemirror.on("paste",function(editor,e){
    if(!(e.clipboardData&&e.clipboardData.items)){
        alert("该浏览器不支持操作");
        return;
    }
    for (var i = 0, len = e.clipboardData.items.length; i < len; i++) {
        var item = e.clipboardData.items[i];
        // console.log(item.kind+":"+item.type);
        if (item.kind === "string") {
            item.getAsString(function (str) {
                // str 是获取到的字符串
            })
        } else if (item.kind === "file") {
            var pasteFile = item.getAsFile();
            // pasteFile就是获取到的文件
            console.log(pasteFile);
            fileUpload(pasteFile);
        }
    }
});

function fileUpload(fileObj){

    var formData = new FormData(event.target);
    formData.append("file",fileObj);
    console.log(formData);


    Vue.http.post('/api/upload', formData)
        .then((response) => {
            var data=simplemde.codemirror.getValue()
            simplemde.codemirror.setValue(data+response.data.url)
        })
}
window.addEventListener("drop",function(e){
    e = e || event;
    e.preventDefault();
    if (e.target.tagName == "simplemde") {  // check wich element is our target
        e.preventDefault();
    }
},false);


export default simplemde