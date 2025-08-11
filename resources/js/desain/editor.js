import { fabric } from "fabric";

// Inisialisasi canvas
const canvas = new fabric.Canvas("canvas", {
    backgroundColor: "#ffffff",
    width: 500,
    height: 500,
});

// Muat desain lama jika ada
if (window.existingDesain) {
    const { canvas_json, judul, id } = window.existingDesain;

    if (canvas_json) {
        canvas.loadFromJSON(canvas_json, () => {
            canvas.renderAll();
        });
    }

    if (judul) {
        document.getElementById("judul").value = judul;
    }

    // Simpan id desain untuk update nanti
    canvas.desainId = id;
}

// Rezise Canvas
document.getElementById("resize-canvas").addEventListener("click", () => {
    const width = parseInt(document.getElementById("canvas-width").value);
    const height = parseInt(document.getElementById("canvas-height").value);

    canvas.setWidth(width);
    canvas.setHeight(height);
    canvas.renderAll();
});

// Zoom dan Pan
let zoom = 1;

document.addEventListener("keydown", function (e) {
    if (e.ctrlKey && e.key === "+") {
        e.preventDefault();
        zoom *= 1.1;
        canvas.setZoom(zoom);
    } else if (e.ctrlKey && e.key === "-") {
        e.preventDefault();
        zoom *= 0.9;
        canvas.setZoom(zoom);
    } else if (e.ctrlKey && e.key === "0") {
        e.preventDefault();
        zoom = 1;
        canvas.setZoom(zoom);
        canvas.viewportTransform = [1, 0, 0, 1, 0, 0];
        canvas.renderAll();
    }
});

// Pan pakai mouse tengah
let isPanning = false;

canvas.on("mouse:down", function (opt) {
    if (opt.e.button === 1) {
        isPanning = true;
        canvas.setCursor("grab");
    }
});

canvas.on("mouse:move", function (opt) {
    if (isPanning && opt.e) {
        const e = opt.e;
        const delta = new fabric.Point(e.movementX, e.movementY);
        canvas.relativePan(delta);
    }
});

canvas.on("mouse:up", function () {
    isPanning = false;
    canvas.setCursor("default");
});

// Undo/Redo
const state = [];
let currentState = -1;

function saveState() {
    currentState++;
    state.splice(currentState, state.length, JSON.stringify(canvas));
}

function undo() {
    if (currentState <= 0) return;
    currentState--;
    canvas.loadFromJSON(state[currentState], canvas.renderAll.bind(canvas));
}

function redo() {
    if (currentState >= state.length - 1) return;
    currentState++;
    canvas.loadFromJSON(state[currentState], canvas.renderAll.bind(canvas));
}

// Save state saat ada perubahan
canvas.on("object:added", saveState);
canvas.on("object:modified", saveState);
canvas.on("object:removed", saveState);

// Tombol undo/redo shortcut
document.addEventListener("keydown", function (e) {
    if (e.ctrlKey && e.key === "z") {
        e.preventDefault();
        undo();
    }
    if (e.ctrlKey && (e.key === "y" || e.key === "Z")) {
        e.preventDefault();
        redo();
    }
});

// Tombol Export
document.getElementById("btn-export").addEventListener("click", () => {
    if (!canvas) return;

    // Export PNG
    const pngData = canvas.toDataURL({
        format: "png",
        quality: 1,
        multiplier: 2,
    });

    const linkPNG = document.createElement("a");
    linkPNG.href = pngData;
    linkPNG.download = "desain.png";
    linkPNG.click();

    // Export JSON
    const json = JSON.stringify(canvas.toJSON());
    const blob = new Blob([json], { type: "application/json" });

    const linkJSON = document.createElement("a");
    linkJSON.href = URL.createObjectURL(blob);
    linkJSON.download = "desain.json";
    linkJSON.click();
});

// Tombol Simpan
document.getElementById("btn-simpan").addEventListener("click", async () => {
    const judul = document.getElementById("judul").value;
    if (!judul) return alert("Judul tidak boleh kosong");

    const json = JSON.stringify(canvas.toJSON());
    const blob = await new Promise((resolve) =>
        canvas.lowerCanvasEl.toBlob(resolve, "image/png")
    );

    const formData = new FormData();
    formData.append("judul", judul);
    formData.append("canvas_json", json);
    formData.append("thumbnail", blob, "thumbnail.png");

    // Cek apakah ada desainId (artinya edit)
    let url = "/ukm/desain";
    let method = "POST";

    if (canvas.desainId) {
        url = `/ukm/desain/${canvas.desainId}`;
        method = "POST"; // Karena Laravel butuh spoof method PUT
        formData.append("_method", "PUT"); // Spoof PUT method
    }

    try {
        const response = await fetch(url, {
            method,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: formData,
        });

        const result = await response.json();
        alert(result.message || "Desain berhasil disimpan.");
        window.location.href = "/ukm/desain";
    } catch (error) {
        console.error(error);
        alert("Gagal menyimpan desain.");
    }
});

// ==================== DELETE OBJECT ====================
document.addEventListener("keydown", function (e) {
    const target = e.target;
    const isTyping =
        target.tagName === "INPUT" ||
        target.tagName === "TEXTAREA" ||
        target.isContentEditable;

    if (!isTyping && (e.key === "Delete" || e.key === "Backspace")) {
        const activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.remove(activeObject);
            canvas.discardActiveObject();
            canvas.requestRenderAll();
        }
    }
});

// 🧲 Selection tool (default)
document.getElementById("tool-select").addEventListener("click", () => {
    canvas.isDrawingMode = false;
    canvas.selection = true;
});

// ✏️ Text tool
document.getElementById("tool-text").addEventListener("click", () => {
    const text = new fabric.IText("Teks baru", {
        left: 100,
        top: 100,
        fontSize: 24,
        fill: "#000",
    });
    canvas.add(text).setActiveObject(text);
});

// 🔲 Rectangle tool
document.getElementById("tool-rect").addEventListener("click", () => {
    const rect = new fabric.Rect({
        left: 100,
        top: 100,
        width: 100,
        height: 80,
        fill: "#ffe4e6",
        stroke: "#000",
        strokeWidth: 2,
    });
    canvas.add(rect).setActiveObject(rect);
});

// ⚪ Circle tool
document.getElementById("tool-circle").addEventListener("click", () => {
    const circle = new fabric.Circle({
        left: 120,
        top: 120,
        radius: 50,
        fill: "#f0f9ff",
        stroke: "#000",
        strokeWidth: 2,
    });
    canvas.add(circle).setActiveObject(circle);
});

// 🔺 Triangle tool
document.getElementById("tool-triangle").addEventListener("click", () => {
    const tri = new fabric.Triangle({
        left: 140,
        top: 140,
        width: 100,
        height: 100,
        fill: "#fff7ed",
        stroke: "#000",
        strokeWidth: 2,
    });
    canvas.add(tri).setActiveObject(tri);
});

// ➖ Line tool
document.getElementById("tool-line").addEventListener("click", () => {
    const line = new fabric.Line([50, 100, 200, 100], {
        stroke: "#000",
        strokeWidth: 2,
    });
    canvas.add(line).setActiveObject(line);
});

// ➡️ Arrow tool (custom shape)
document.getElementById("tool-arrow").addEventListener("click", () => {
    const arrow = new fabric.Triangle({
        width: 20,
        height: 30,
        fill: "#000",
        left: 200,
        top: 200,
        angle: 90,
    });
    canvas.add(arrow).setActiveObject(arrow);
});

// 🖼️ Upload image
document.getElementById("tool-image").addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (f) {
        fabric.Image.fromURL(f.target.result, function (img) {
            img.scaleToWidth(200);
            img.set({
                left: 100,
                top: 100,
            });
            canvas.add(img).setActiveObject(img);
        });
    };
    reader.readAsDataURL(file);
});

// 🎨 Color pickers
document.getElementById("fill-color").addEventListener("change", function () {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set("fill", this.value);
        canvas.requestRenderAll();
    }
});
document.getElementById("stroke-color").addEventListener("change", function () {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set("stroke", this.value);
        canvas.requestRenderAll();
    }
});

// ==================== OBJECT PROPERTIES PANEL LOGIC ==================== //
const propertiesPanel = document.getElementById("object-properties");
const xInput = document.getElementById("prop-x");
const yInput = document.getElementById("prop-y");
const widthInput = document.getElementById("prop-width");
const heightInput = document.getElementById("prop-height");
const lockAspect = document.getElementById("lock-aspect");
const angleInput = document.getElementById("prop-angle");
const opacityInput = document.getElementById("prop-opacity");

const btnBringFront = document.getElementById("btn-bring-front");
const btnSendBack = document.getElementById("btn-send-back");
const btnLock = document.getElementById("btn-lock");
const btnUnlock = document.getElementById("btn-unlock");

let isUpdating = false;
let aspectRatio = 1;

// Tampilkan panel saat objek dipilih
canvas.on("selection:created", updatePanel);
canvas.on("selection:updated", updatePanel);
canvas.on("selection:cleared", () => {
    propertiesPanel.classList.add("hidden");
});

// Fungsi update panel
function updatePanel(e) {
    const obj = e.selected ? e.selected[0] : canvas.getActiveObject();
    if (!obj) return;

    isUpdating = true;
    propertiesPanel.classList.remove("hidden");

    xInput.value = obj.left?.toFixed(0);
    yInput.value = obj.top?.toFixed(0);
    widthInput.value = obj.width ? (obj.width * obj.scaleX).toFixed(0) : "";
    heightInput.value = obj.height ? (obj.height * obj.scaleY).toFixed(0) : "";
    angleInput.value = obj.angle?.toFixed(0);
    opacityInput.value = obj.opacity;

    // Hitung aspect ratio awal
    if (obj.width && obj.height) {
        aspectRatio = (obj.width * obj.scaleX) / (obj.height * obj.scaleY);
    }

    isUpdating = false;
}

// Event listener untuk posisi
[xInput, yInput].forEach((input) => {
    input.addEventListener("input", () => {
        if (isUpdating) return;
        const obj = canvas.getActiveObject();
        if (!obj) return;
        obj.left = parseFloat(xInput.value) || 0;
        obj.top = parseFloat(yInput.value) || 0;
        obj.setCoords();
        canvas.requestRenderAll();
    });
});

// Ukuran dengan opsi lock aspect ratio
[widthInput, heightInput].forEach((input) => {
    input.addEventListener("input", () => {
        if (isUpdating) return;
        const obj = canvas.getActiveObject();
        if (!obj || !obj.width || !obj.height) return;

        const width = parseFloat(widthInput.value);
        const height = parseFloat(heightInput.value);

        if (lockAspect.checked) {
            if (input === widthInput) {
                obj.scaleX = width / obj.width;
                obj.scaleY = width / aspectRatio / obj.height;
                heightInput.value = (obj.height * obj.scaleY).toFixed(0);
            } else {
                obj.scaleY = height / obj.height;
                obj.scaleX = (height * aspectRatio) / obj.width;
                widthInput.value = (obj.width * obj.scaleX).toFixed(0);
            }
        } else {
            obj.scaleX = width / obj.width;
            obj.scaleY = height / obj.height;
        }

        canvas.requestRenderAll();
    });
});

// Rotasi
angleInput.addEventListener("input", () => {
    const obj = canvas.getActiveObject();
    if (!obj) return;
    obj.angle = parseFloat(angleInput.value) || 0;
    canvas.requestRenderAll();
});

// Opacity
opacityInput.addEventListener("input", () => {
    const obj = canvas.getActiveObject();
    if (!obj) return;
    obj.opacity = parseFloat(opacityInput.value);
    canvas.requestRenderAll();
});

// Layering
btnBringFront.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        canvas.bringToFront(obj);
        canvas.requestRenderAll();
    }
});
btnSendBack.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        canvas.sendToBack(obj);
        canvas.requestRenderAll();
    }
});

// Lock/unlock
btnLock.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set({ selectable: false, evented: false, hasControls: false });
        canvas.discardActiveObject();
        canvas.requestRenderAll();
        propertiesPanel.classList.add("hidden");
    }
});
btnUnlock.addEventListener("click", () => {
    canvas.getObjects().forEach((obj) => {
        obj.set({ selectable: true, evented: true, hasControls: true });
    });
    canvas.requestRenderAll();
});

// ==================== LAYERS PANEL LOGIC ==================== //
const layersPanel = document.getElementById("layers-panel");
const layersList = document.getElementById("layers-list");

function refreshLayersPanel() {
    if (!layersPanel) return;

    layersList.innerHTML = "";

    const objects = canvas.getObjects().slice().reverse(); // Reverse biar urutan visual sesuai
    objects.forEach((obj, index) => {
        const listItem = document.createElement("div");
        listItem.className =
            "layer-item flex justify-between items-center px-2 py-1 border-b hover:bg-gray-100 cursor-pointer";
        listItem.dataset.index = index;

        const name =
            obj.name || `Object ${canvas.getObjects().indexOf(obj) + 1}`;

        listItem.innerHTML = `
            <div class="flex items-center gap-2">
                <input type="checkbox" class="toggle-visible" ${
                    obj.visible === false ? "" : "checked"
                } />
                <span class="layer-name editable">${name}</span>
            </div>
            <div class="drag-handle text-gray-400 cursor-move">☰</div>
        `;

        // Pilih objek saat item diklik
        listItem.addEventListener("click", (e) => {
            if (!e.target.classList.contains("toggle-visible")) {
                canvas.setActiveObject(obj);
                canvas.requestRenderAll();
            }
        });

        // Toggle visibility
        listItem
            .querySelector(".toggle-visible")
            .addEventListener("change", (e) => {
                obj.visible = e.target.checked;
                canvas.requestRenderAll();
            });

        // Rename
        const nameEl = listItem.querySelector(".layer-name");
        nameEl.addEventListener("dblclick", () => {
            const input = document.createElement("input");
            input.type = "text";
            input.value = nameEl.textContent;
            input.className = "w-full text-sm border px-1";
            nameEl.replaceWith(input);
            input.focus();
            input.addEventListener("blur", () => {
                obj.name = input.value;
                refreshLayersPanel();
            });
            input.addEventListener("keydown", (e) => {
                if (e.key === "Enter") {
                    input.blur();
                }
            });
        });

        layersList.appendChild(listItem);
    });

    initDragAndDrop();
}

// Drag & drop reorder
function initDragAndDrop() {
    let draggingEl;
    let startIndex;

    layersList.querySelectorAll(".layer-item").forEach((item, index) => {
        item.draggable = true;

        item.addEventListener("dragstart", () => {
            draggingEl = item;
            startIndex = index;
            item.classList.add("opacity-50");
        });

        item.addEventListener("dragend", () => {
            draggingEl = null;
            item.classList.remove("opacity-50");
        });

        item.addEventListener("dragover", (e) => e.preventDefault());

        item.addEventListener("drop", (e) => {
            e.preventDefault();
            const endIndex = [...layersList.children].indexOf(item);

            if (startIndex !== endIndex) {
                const objs = canvas.getObjects();
                const reversed = objs.slice().reverse();

                const [moved] = reversed.splice(startIndex, 1);
                reversed.splice(endIndex, 0, moved);

                const newOrder = reversed.reverse();
                canvas._objects = newOrder;
                canvas.renderAll();
                refreshLayersPanel();
            }
        });
    });
}

// Update panel setiap ada perubahan objek
canvas.on("object:added", refreshLayersPanel);
canvas.on("object:removed", refreshLayersPanel);
canvas.on("object:modified", refreshLayersPanel);
canvas.on("object:visibility", refreshLayersPanel);
canvas.on("selection:created", refreshLayersPanel);
canvas.on("selection:updated", refreshLayersPanel);
canvas.on("selection:cleared", refreshLayersPanel);

// Inisialisasi awal
refreshLayersPanel();

// ==================== STYLE PANEL LOGIC ====================

// Referensi elemen UI
const fontSelect = document.getElementById("style-font");
const fontSizeInput = document.getElementById("style-font-size");
const btnBold = document.getElementById("btn-bold");
const btnItalic = document.getElementById("btn-italic");
const btnUnderline = document.getElementById("btn-underline");
const fillColorInput = document.getElementById("style-fill");
const strokeColorInput = document.getElementById("style-stroke");
const strokeWidthInput = document.getElementById("style-stroke-width");

// Fungsi untuk memperbarui panel style berdasarkan objek aktif
function updateStylePanel(obj) {
    if (!obj) return;

    if (
        obj.type === "text" ||
        obj.type === "i-text" ||
        obj.type === "textbox"
    ) {
        fontSelect.value = obj.fontFamily || "Arial";
        fontSizeInput.value = obj.fontSize || 20;
        btnBold.classList.toggle("active", obj.fontWeight === "bold");
        btnItalic.classList.toggle("active", obj.fontStyle === "italic");
        btnUnderline.classList.toggle("active", !!obj.underline);
    } else {
        fontSelect.value = "Arial";
        fontSizeInput.value = "";
        btnBold.classList.remove("active");
        btnItalic.classList.remove("active");
        btnUnderline.classList.remove("active");
    }

    fillColorInput.value = obj.fill || "#000000";
    strokeColorInput.value = obj.stroke || "#000000";
    strokeWidthInput.value = obj.strokeWidth || 0;
}

// Event listeners
fontSelect.addEventListener("change", () => {
    const obj = canvas.getActiveObject();
    if (obj && obj.type.includes("text")) {
        obj.set("fontFamily", fontSelect.value);
        canvas.requestRenderAll();
    }
});

fontSizeInput.addEventListener("change", () => {
    const obj = canvas.getActiveObject();
    if (obj && obj.type.includes("text")) {
        obj.set("fontSize", parseInt(fontSizeInput.value));
        canvas.requestRenderAll();
    }
});

btnBold.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj && obj.type.includes("text")) {
        const newWeight = obj.fontWeight === "bold" ? "normal" : "bold";
        obj.set("fontWeight", newWeight);
        btnBold.classList.toggle("active");
        canvas.requestRenderAll();
    }
});

btnItalic.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj && obj.type.includes("text")) {
        const newStyle = obj.fontStyle === "italic" ? "normal" : "italic";
        obj.set("fontStyle", newStyle);
        btnItalic.classList.toggle("active");
        canvas.requestRenderAll();
    }
});

btnUnderline.addEventListener("click", () => {
    const obj = canvas.getActiveObject();
    if (obj && obj.type.includes("text")) {
        const newUnderline = !obj.underline;
        obj.set("underline", newUnderline);
        btnUnderline.classList.toggle("active");
        canvas.requestRenderAll();
    }
});

fillColorInput.addEventListener("change", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set("fill", fillColorInput.value);
        canvas.requestRenderAll();
    }
});

strokeColorInput.addEventListener("change", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set("stroke", strokeColorInput.value);
        canvas.requestRenderAll();
    }
});

strokeWidthInput.addEventListener("change", () => {
    const obj = canvas.getActiveObject();
    if (obj) {
        obj.set("strokeWidth", parseFloat(strokeWidthInput.value));
        canvas.requestRenderAll();
    }
});

// Update panel saat objek aktif berubah
canvas.on("selection:created", (e) => {
    updateStylePanel(e.selected[0]);
});

canvas.on("selection:updated", (e) => {
    updateStylePanel(e.selected[0]);
});

canvas.on("selection:cleared", () => {
    updateStylePanel(null);
});
