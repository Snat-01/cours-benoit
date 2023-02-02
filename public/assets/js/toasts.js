window.addEventListener("DOMContentLoaded", (event) => {
    toasts();
});

function toasts(){
    var toastLiveExample = document.getElementById('liveToast')

    if (toastLiveExample) {
        toastLiveExample.classList.add('show');
    }
}
