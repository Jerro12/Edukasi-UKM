import "./bootstrap";
import "../css/app.css";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
// Load JS Editor jika berada di halaman editor desain
if (
    window.location.pathname.includes("/ukm/desain/editor") ||
    window.location.pathname.match(/^\/ukm\/desain\/\d+\/edit$/)
) {
    import("./desain/editor")
        .then(() => console.log("Editor.js loaded"))
        .catch((e) => console.error("Gagal load editor.js", e));
}
