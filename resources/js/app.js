import.meta.glob([
    "../images/**",
    "../fonts/**",
]);

import "./bootstrap";
import QrScanner from "qr-scanner/qr-scanner.legacy.min.js";

/**
 * =========================
 * STATE MANAGEMENT
 * =========================
 */
let CURRENT_REQUEST = null;
let QR_SCANNER = null;
let SCANNER_ACTIVE = false;

/**
 * =========================
 * UTILITIES
 * =========================
 */
function getCookie(name) {
    return document.cookie
        .split("; ")
        .find(row => row.startsWith(name + "="))
        ?.split("=")[1];
}

/**
 * Prevents duplicate API calls + improves scan stability
 */
async function storeAttendance(token) {
    if (CURRENT_REQUEST) {
        const apiResponse = await CURRENT_REQUEST;
        return apiResponse.status;
    }

    const eventField = document.querySelector("#event");
    if (!eventField?.value) return 400;

    const timezone = getCookie("timezone") || "UTC";

    try {
        CURRENT_REQUEST = axios.post(`/api/attendance/${eventField.value}`, {
            token,
            timezone
        });

        const apiResponse = await CURRENT_REQUEST;
        return apiResponse.status;

    } catch (err) {
        console.error("Attendance error:", err);
        return 500;

    } finally {
        CURRENT_REQUEST = null;
    }
}

/**
 * =========================
 * UI STATE HANDLER
 * (This is where your "modern vibe" comes alive)
 * =========================
 */
function setScannerStatus(type) {
    const idScanner = document.getElementById("id-scanner");
    if (!idScanner) return;

    const indicator = idScanner.querySelector(".indicator");
    const statusData = JSON.parse(
        idScanner.querySelector(".status-values")?.textContent || "{}"
    );

    const timeout = indicator?.querySelector(".timeout");
    const statusText = indicator?.querySelector(".status .text");

    if (!indicator || !timeout || !statusText || !statusData[type]) return;

    // force reflow for smooth animation reset
    void indicator.offsetWidth;

    indicator.className = `indicator ${statusData[type].class}`;
    statusText.textContent = statusData[type].text;

    // auto reset after success/failure (clean UX loop)
    if (["success", "failure", "forbidden"].includes(type)) {
        timeout.addEventListener("animationend", function reset() {
            indicator.className = `indicator ${statusData.idle.class}`;
            statusText.textContent = statusData.idle.text;
            timeout.removeEventListener("animationend", reset);
        });
    }
}

/**
 * =========================
 * QR SCANNER CONTROL
 * =========================
 */
function startQrScanner() {
    if (SCANNER_ACTIVE) return;

    setScannerStatus("idle");

    const videoEl = document.querySelector("#id-scanner .video");
    const idScanner = document.getElementById("id-scanner");

    if (!videoEl || !idScanner) return;

    idScanner.hidden = false;

    if (!QR_SCANNER) {
        QR_SCANNER = new QrScanner(videoEl, async (result) => {
            if (!result?.data) return;

            SCANNER_ACTIVE = true;

            setScannerStatus("processing");

            const statusCode = await storeAttendance(result.data);

            switch (statusCode) {
                case 200:
                    setScannerStatus("success");
                    break;
                case 403:
                    setScannerStatus("forbidden");
                    break;
                case 404:
                    setScannerStatus("failure");
                    break;
                default:
                    setScannerStatus("failure");
            }

            SCANNER_ACTIVE = false;
        }, {
            returnDetailedScanResult: true
        });
    }

    QR_SCANNER.start();
}

/**
 * Stops scanner cleanly (prevents camera leaks)
 */
function stopQrScanner() {
    const idScanner = document.getElementById("id-scanner");
    if (idScanner) idScanner.hidden = true;

    if (QR_SCANNER) {
        QR_SCANNER.stop();
    }

    SCANNER_ACTIVE = false;
}

/**
 * =========================
 * MAIN FEATURE INIT
 * =========================
 */
function activateAttendanceRecorder() {
    const mainPage = document.querySelector(
        ".main-content.attendance .article"
    );

    if (!mainPage) return;

    const supportsCamera = navigator.mediaDevices?.getUserMedia;

    if (!supportsCamera) {
        const warning = document.createElement("div");
        warning.className = "alert alert-warning";
        warning.textContent =
            "Camera is not supported in this browser. Please use a modern device.";
        mainPage.append(warning);
        return;
    }

    const template = document.querySelector(".attendance #scanner-feature");

    if (!template) return;

    const clone = template.content.cloneNode(true);
    template.before(clone);

    const selectEvent = mainPage.querySelector("select#event");

    if (selectEvent) {
        selectEvent.addEventListener("change", (e) => {
            if (e.target.value) startQrScanner();
            else stopQrScanner();
        });
        return;
    }

    startQrScanner();
}

activateAttendanceRecorder();
