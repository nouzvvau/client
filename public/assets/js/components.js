(function () {
  const mounts = Array.from(document.querySelectorAll("[data-component]"));

  if (!mounts.length) {
    window.FEComponentsReady = Promise.resolve();
    return;
  }

  const loadComponent = async function (mount) {
    const name = mount.dataset.component;
    const url = new URL("../components/" + name + ".html", document.baseURI);

    try {
      const response = await fetch(url, { cache: "no-cache" });

      if (!response.ok) {
        throw new Error(response.status + " " + response.statusText);
      }

      mount.innerHTML = await response.text();
      mount.dataset.componentLoaded = "true";
    } catch (error) {
      mount.innerHTML =
        '<p class="component-error">Komponen "' +
        name +
        '" gagal dimuat. Jalankan halaman melalui server lokal seperti dijelaskan pada README.md.</p>';
      console.error("[components] Gagal memuat " + url + ":", error);
    }
  };

  window.FEComponentsReady = Promise.all(mounts.map(loadComponent)).then(function () {
    document.dispatchEvent(new CustomEvent("components:loaded"));
  });
})();
