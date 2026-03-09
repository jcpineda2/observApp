export function paraguayDepartmentMap(config) {
    return {
        map: null,
        layer: null,
        config,

        async init() {
            if (this.map) {
                this.map.remove();
                this.map = null;
            }

            const container = document.getElementById(this.config.mapId);

            if (!container) {
                return;
            }

            this.map = L.map(this.config.mapId, {
                zoomControl: true,
                attributionControl: true,
            }).setView([-23.4, -58.4], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(this.map);

            const response = await fetch(this.config.geoJsonUrl);
            const geoJson = await response.json();

            const values = this.config.values ?? {};

            const getColor = (value) => {
                if (value > 50000) return '#08306b';
                if (value > 20000) return '#2171b5';
                if (value > 10000) return '#4292c6';
                if (value > 5000) return '#6baed6';
                if (value > 1000) return '#9ecae1';
                if (value > 0) return '#c6dbef';
                return '#f3f4f6';
            };

            const normalizeName = (name) =>
                String(name || '')
                    .trim()
                    .toLowerCase();

            this.layer = L.geoJSON(geoJson, {
                style: (feature) => {
                    const departmentName =
                        feature?.properties?.name ||
                        feature?.properties?.NAME_1 ||
                        feature?.properties?.department ||
                        '';

                    const value = values[normalizeName(departmentName)] ?? 0;

                    return {
                        fillColor: getColor(value),
                        weight: 1,
                        opacity: 1,
                        color: '#ffffff',
                        fillOpacity: 0.8,
                    };
                },

                onEachFeature: (feature, layer) => {
                    const departmentName =
                        feature?.properties?.name ||
                        feature?.properties?.NAME_1 ||
                        feature?.properties?.department ||
                        'Sin nombre';

                    const value = values[normalizeName(departmentName)] ?? 0;

                    layer.bindTooltip(
                        `<strong>${departmentName}</strong><br>Turistas: ${new Intl.NumberFormat('es-PY').format(value)}`,
                        { sticky: true }
                    );
                },
            }).addTo(this.map);

            this.map.fitBounds(this.layer.getBounds(), { padding: [10, 10] });
        },
    };
}
