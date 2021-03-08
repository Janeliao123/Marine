// function createEditor(name) {
//     // find the textarea
//     var textarea = document.querySelector("form textarea[name=" + name + "]");

//     // create ace editor
    var editor = ace.edit("editor")
    // editor.container.style.height = "100%";
    // editor.container.style.width = "100%";
    //editor.session.setValue(textarea.value)
    // editor.selection.getCursor();
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/c_cpp");
    editor.setFontSize(20);
//     // replace textarea with ace
//     textarea.parentNode.insertBefore(editor.container, textarea)
//     textarea.style.display = "none"
//     // find the parent form and add submit event listener
//     var form = textarea
//     while (form && form.localName != "form") form = form.parentNode
//     form.addEventListener("onchange", function() {
//         // update value of textarea to match value in ace
//         textarea.value = editor.getValue()
//     }, true)
// }
// createEditor("code")
// // createEditor("input")
 //var editor = ace.edit("editor");