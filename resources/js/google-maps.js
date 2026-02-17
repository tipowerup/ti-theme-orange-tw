/**
 * Google Maps API Loader
 * Loads the Google Maps JavaScript API dynamically if not already loaded
 */
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.querySelector('[data-map-key]');
    const mapKey = modalElement?.dataset.mapKey;

    if (!mapKey || typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
        return;
    }

    // Google Maps loader snippet
    ((g) => {
        let h, a, k;
        const p = "The Google Maps JavaScript API";
        const c = "google";
        const l = "importLibrary";
        const q = "__ib__";
        const m = document;
        const b = window;
        b[c] = b[c] || {};
        const d = b[c].maps = b[c].maps || {};
        const r = new Set();
        const e = new URLSearchParams();
        const u = () => h || (h = new Promise(async (f, n) => {
            await (a = m.createElement("script"));
            e.set("libraries", [...r] + "");
            for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
            e.set("callback", c + ".maps." + q);
            a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
            d[q] = f;
            a.onerror = () => h = n(Error(p + " could not load."));
            a.nonce = m.querySelector("script[nonce]")?.nonce || "";
            m.head.append(a);
        }));
        d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n));
    })({ key: mapKey, v: "weekly" });
});
