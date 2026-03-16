

import Chart from 'chart.js/auto';

window.observatorioChart = function ({ id, config }) {
    return {
        chart: null,
        canvas: null,
        chartId: id,
        initialConfig: config,

        init(canvas) {
            if (!canvas) return;

            this.canvas = canvas;

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            if (this.chart) return;

            this.chart = new Chart(ctx, this.normalizedConfig(this.initialConfig));

            this.$el.addEventListener('alpine:destroy', () => {
                this.destroy();
            });
        },

        normalizedConfig(config) {
            return {
                type: config?.type ?? 'bar',
                data: {
                    labels: [...(config?.data?.labels ?? [])],
                    datasets: (config?.data?.datasets ?? []).map(dataset => ({ ...dataset })),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    ...(config?.options ?? {}),
                },
            };
        },

        destroy() {
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }
        },
    };
};


window.observatorioDepartmentMap = function ({ mapId, geojsonUrl }) {
  let map = null;
  let geojsonLayer = null; // Guardamos la referencia de la capa completa
  let rawGeojsonData = null;
  let valuesByDept = {}; // Datos que vienen de Laravel: {"Central": 1200, "Itapúa": 850...}

  /**
   * Intenta encontrar el nombre del departamento en las propiedades del GeoJSON
   */
  function resolveDeptName(props) {
    if (!props) return null;
    const preferredKeys = [
      'name', 'NAME', 'Name', 'department', 'Departamento',
      'departamento', 'NOMBRE', 'NOMBRE_DPT', 'DPTO', 'Dpto',
      'ADM1_ES', 'ADM1', 'NAME_1'
    ];

    for (const k of preferredKeys) {
      if (props[k]) return String(props[k]).trim();
    }

    for (const [k, v] of Object.entries(props)) {
      if (typeof v === 'string' && v.length >= 3 && v.length <= 40) return v.trim();
    }
    return null;
  }

  function valueForFeature(feature) {
    const deptName = resolveDeptName(feature?.properties);
    if (!deptName) return 0;
    return Number(valuesByDept[deptName] ?? 0);
  }

  /**
   * Genera el color basado en la intensidad del valor
   */
  function colorFor(value, max) {
    if (!max || max <= 0) return 'rgba(30, 64, 175, 0.08)';
    const t = Math.min(1, value / max);
    // Escala de azul: de muy claro a azul sólido
    const alpha = 0.15 + 0.65 * t;
    return `rgba(30, 64, 175, ${alpha})`;
  }

  /**
   * Estilo base del mapa (Estado "Normal")
   */
  function getBaseStyle(feature) {
    const values = Object.values(valuesByDept).map(Number);
    const max = values.length > 0 ? Math.max(...values) : 0;
    const v = valueForFeature(feature);

    return {
      weight: 1,
      color: 'rgba(17, 24, 39, 0.4)', // Borde gris oscuro sutil
      fillColor: colorFor(v, max),
      fillOpacity: 1,
    };
  }

  /**
   * Configuración de interactividad por cada departamento
   */
  function onEachFeature(feature, layer) {
    const deptName = resolveDeptName(feature?.properties) ?? 'Departamento';
    const v = valueForFeature(feature);

    layer.on({
      mouseover: (e) => {
        const l = e.target;
        // Resaltado al pasar el cursor
        l.setStyle({
          weight: 2.5,
          color: 'rgba(17, 24, 39, 0.9)',
          fillOpacity: 0.9
        });
        if (!window.L.Browser.ie && !window.L.Browser.opera && !window.L.Browser.edge) {
          l.bringToFront();
        }
      },
      mouseout: (e) => {
        // MEJORA: Aplicamos el estilo base manualmente para asegurar que se restablezca
        const l = e.target;
        l.setStyle(getBaseStyle(feature));
      },
    });

    // Tooltip con formato de miles (ej: 1.250)
    const formattedValue = new Intl.NumberFormat('es-PY').format(v);
    layer.bindTooltip(`<strong>${deptName}</strong>: ${formattedValue}`, {
      sticky: true,
      className: 'map-tooltip'
    });
  }

  async function loadGeojsonOnce() {
    if (rawGeojsonData) return rawGeojsonData;
    const res = await fetch(geojsonUrl, { cache: 'force-cache' });
    rawGeojsonData = await res.json();
    return rawGeojsonData;
  }

  async function renderLayer() {
    const gj = await loadGeojsonOnce();

    if (geojsonLayer) geojsonLayer.remove();

    geojsonLayer = window.L.geoJSON(gj, {
      style: getBaseStyle,
      onEachFeature: onEachFeature
    });

    geojsonLayer.addTo(map);

    try {
      map.fitBounds(geojsonLayer.getBounds(), { padding: [20, 20] });
    } catch (_) {}
  }

  function listenUpdates() {
    window.addEventListener('observatorio:map:update', (event) => {
      // Livewire 3 envía los datos en event.detail
      const payload = event.detail || {};

      // Verificamos que los datos sean para este mapa específico
      if (payload.mapId && payload.mapId !== mapId) return;

      valuesByDept = payload.data || {};
      if (map) renderLayer();
    });
  }

  return {
    async init() {
      if (!window.L) {
        console.error('Leaflet no detectado.');
        return;
      }

      // Inicializar el contenedor del mapa
      map = window.L.map(this.$el, {
        zoomControl: true,
        attributionControl: false,
        dragging: !window.L.Browser.mobile, // Opcional: desactiva arrastre en móvil para scroll
        scrollWheelZoom: false, // Evita que el mapa "atrape" el scroll de la página
      });

      // Estética limpia del fondo
      this.$el.style.background = '#f8fafc';
      this.$el.style.outline = 'none';

      // Centrado inicial aproximado
      map.setView([-23.4, -58.3], 6);

      await renderLayer();
      listenUpdates();
    },
  };
};

window.observatorioDeptRanking = function (mapId) {
    return {
        ranking: [], // Estructura esperada: [{ name: 'Central', value: 1500 }, ...]
        maxValue: 0,

        // Formateador regional consistente con el mapa (es-PY)
        formatter: new Intl.NumberFormat('es-PY'),

        format(n) {
            return this.formatter.format(Number(n || 0));
        },

        // Calcula el ancho de la barra de progreso
        pct(n) {
            const v = Number(n || 0);
            if (this.maxValue <= 0) return 0;
            // Limitamos a 100 para evitar desbordes visuales
            return Math.min(100, Math.round((v / this.maxValue) * 100));
        },

        init() {
            // Usamos una función nombrada para poder limpiar el listener si fuera necesario
            const handler = (event) => {
                // Livewire 3 envía los datos en event.detail
                const payload = event.detail || {};

                // Validación de ID para que el ranking no se mezcle con otros mapas/tablas
                if (payload.mapId && payload.mapId !== mapId) return;

                // Actualizamos los datos
                this.ranking = payload.ranking || [];

                // Recalculamos el valor máximo para la escala de las barras
                const values = this.ranking.map(i => Number(i.value || 0));
                this.maxValue = values.length > 0 ? Math.max(...values) : 0;
            };

            window.addEventListener('observatorio:map:ranking', handler);

            // Opcional: Escuchar también el evento del mapa por si vienen juntos
            window.addEventListener('observatorio:map:update', (e) => {
                if (e.detail?.mapId === mapId && e.detail?.ranking) {
                    handler(e);
                }
            });
        },
    };


};
