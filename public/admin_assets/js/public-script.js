var notyf = new Notyf({
    duration: 4000,
    position: {
        x: 'right',
        y: 'top',
    },
});

function alertMessage(message, error, timer = 4000) {
    notyf.dismissAll();
    if (error) {
        notyf.error({
            message: message,
            duration: timer
        });
    } else {
        notyf.success({
            message: message,
            duration: timer
        });
    }
}



function onRequestSuccess(response, button, buttonText, redirctUrl, form) {
    if (response.success == true) {
        alertMessage(response.message, false);
        setTimeout(() => {
            window.location.href = redirctUrl;
        }, 2000);
    } else {
        alertMessage(response.message, true);
        button.prop('disabled', false);
        button.html(buttonText);
        setTimeout(function () {
            $('.loading-bar').css('transition', 'none');
            $('.loading-bar').css('width', 0);
        }, 500);
    }
}

// loading bar function
function postUploadProgress(percentComplete) {
    $('.loading-bar').css('width', percentComplete + '%');
    $('.loading-bar').css('transition', 'all 0.8s');
}

function handleAjaxCall(form, action, btn, redirect, handleSuccessCallback, modalId = null) {
    var formData = new FormData(form[0]);
    var btnText = btn.html();
    var button = btn;
    $.ajax({
        type: "POST",
        url: action,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        mimeType: "multipart/form-data",
        beforeSend: function () {
            btn.prop('disabled', true);
            btn.html(' Processing.....');
        },
        success: function (res) {
            if (modalId !== null && modalId !== undefined) {
                $(modalId).modal('hide');
            }
            if ((handleSuccessCallback !== undefined) && (handleSuccessCallback !== null)) {
                handleSuccessCallback(res, button, btnText, redirect, form);
            } else {
                if (redirect === null) {
                    location.reload();
                } else {
                    window.location.href = redirect; 
                }
            }
        },
        error: function (e) {
            console.error("An error occurred:", e);
            btn.prop('disabled', false);
            btn.html(btnText);
        },
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = 100 * (evt.loaded / evt.total);
                    postUploadProgress(percentComplete.toFixed(2));
                }
            }, false);

            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = 100 * (evt.loaded / evt.total);
                    postUploadProgress(percentComplete.toFixed(2));
                }
            }, false);

            return xhr;
        }
    });
}
