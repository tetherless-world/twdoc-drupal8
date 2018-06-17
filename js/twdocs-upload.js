const twDialog = '<div> \
            <input class="tw-file-attach" type="button" value="Select File" onclick="twForceClick(\'fileToUpload\')" /> \
        </div> \
        <div id="file-line" class="tw-file-line-name"></div> \
        <input class="tw-file-selection" type="file" name="fileToUpload" id="fileToUpload" onchange="twFileChanged(\'file-line\')" /> \
        <div> \
            <button class="tw-file-submit" onclick="((event) => twDoUpload(event))(event)">Upload File</button> \
        </div>'
let twUploadFile

function twOpenDialog(id, event) {
    twCloseDialog()
    const element = document.querySelector(`#${id}`)
    const dom = document.createElement('div')
    dom.classList = 'tw-dialog'
    dom.setAttribute('style', `top:${event.clientY}px;left:${event.clientX}px`)
    dom.innerHTML = twDialog
    element.appendChild(dom)
}

function twCloseDialog() {
    const element = document.querySelector('.tw-dialog')
    if (element) {
        const parent = element.parentElement
        parent.removeChild(element)
    }
    twUploadFile = null
}

function twForceClick(id) {
    const element = document.getElementById(id)
    element.click()
}

function twFileChanged(id) {
    if (window.event.currentTarget.files && window.event.currentTarget.files[0]) {
        twUploadFile = window.event.currentTarget.files.item(0)
        const element = document.getElementById(id)
        element.innerText = `${twUploadFile.name.substr(0, 40)}...`
        console.log(twUploadFile)
    }
}

function twArrayBufferToBase64(buffer) {
    var binary = '';
    var bytes = new Uint8Array(buffer);
    var len = bytes.byteLength;
    for (var i = 0; i < len; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return window.btoa(binary);
}

function twDoUpload(e) {
    if (twUploadFile) {
        e.preventDefault()
        const reader = new FileReader()
        reader.readAsArrayBuffer(twUploadFile)
        reader.onload = (src) => {
            const data = new FormData()
            data.append('name', twUploadFile.name)
            data.append('source', twArrayBufferToBase64(src.target.result))
            fetch('/~westp/newlook/something.php',
                { method: 'post', body: data }
            ).then((response) => {
                if (response.status === 200) {
                    console.log('good')
                } else {
                    console.log('bad')
                }
                twCloseDialog()
            }).catch((((err) => console.log('err = ', err))))
        }
    }
}

document.onkeydown = function (evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        twCloseDialog()
    }
};
