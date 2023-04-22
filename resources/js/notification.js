import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

function notification(message, color) {
    return (
        Toastify({
            text: message,
            duration: 2500,
            newWindow: true,
            close: true,
            gravity: "top", // bottom-right, bottom-left, top-right, top-left
            position: "center", // left, right, center
            backgroundColor: color,
            stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast()
    )
}

export default notification