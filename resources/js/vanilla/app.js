/*
 |--------------------------------------------------------------------------
 | Midone Built-in Components
 |--------------------------------------------------------------------------
 |
 | Import Midone built-in components.
 |
 */
import "./bootstrap";
import "@left4code/tw-starter/dist/js/svg-loader";
// import "@left4code/tw-starter/dist/js/accordion";
import "./accordian";
import "@left4code/tw-starter/dist/js/alert";
import "@left4code/tw-starter/dist/js/dropdown";
import "@left4code/tw-starter/dist/js/modal";
import "@left4code/tw-starter/dist/js/tab";

/*
 |--------------------------------------------------------------------------
 | 3rd Party Libraries
 |--------------------------------------------------------------------------
 |
 | Import 3rd party library JS files.
 |
 */
// import "./chart";
// import "./highlight";
import "./lucide";
// import "./tiny-slider";
// import "./tippy";
import "./datepicker";
import "./tom-select";
// import "./dropzone";
// import "./validation";
// import "./zoom";
// import "./notification";
// import "./tabulator";
// import "./calendar";
/*
 |--------------------------------------------------------------------------
 | Custom Components
 |--------------------------------------------------------------------------
 |
 | Import JS custom components.
 |
 */
// import "./maps";
// import "./chat";
// import "./show-modal";
// import "./show-slide-over";
// import "./show-dropdown";
// import "./search";
// import "./copy-code";
// import "./show-code";
import "./side-menu";
// import "./mobile-menu";
// import "./side-menu-tooltip";
// import "./dark-mode-switcher";
import Toastify from "toastify-js";

window.toaster = (type, message) => {
    if (!['success', 'failed'].includes(type)) {
        throw Error("Given toaster type is invalid, use 'success or failed'");
    }

    const node = $(`#${type}-notification-content`)
        .clone()
        .removeClass("hidden");

    node.find(".font-medium").text(`${type}`)
    node.find(".text-slate-500").text(`${message}`)

    new Toastify({
        node: node[0],
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true
    }).showToast()
}
