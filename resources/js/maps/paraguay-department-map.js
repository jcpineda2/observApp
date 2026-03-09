export function paraguayDepartmentMap(config) {
    return {
        map: null,
        layer: null,
        legendControl: null,
        config,

        async init() {
            if (this.map) {
                this.map.remove()
                this.map = null
            }

            const container = document.getElementById(this.config.mapId)

            if (!container || typeof L === 'undefined') {
                return
            }

            this.map = L.map(this.config.mapId, {
                zoomControl: false,
                attributionControl: false,
                dragging: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                keyboard: false,
                tap: false,
                touchZoom: false,
            }).setView([-23.4, -58.4], 6)

            const response = await fetch(this.config.geoJsonUrl)

            if (!response.ok) {
                throw new Error(`No se pudo cargar el GeoJSON: ${response.status}`)
            }

            const geoJson = await response.json()
            const values = this.config.values ?? {}

            const normalizeName = (name) =>
                String(name || '')
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/\./g, '')
                    .replace(/-/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim()
                    .toLowerCase()

            const aliases = {
                'alto parana': 'alto parana',
                'boqueron': 'boqueron',
                'canindeyu': 'canindeyu',
                'caaguazu': 'caaguazu',
                'caazapa': 'caazapa',
                'concepcion': 'concepcion',
                'cordillera': 'cordillera',
                'central': 'central',
                'guaira': 'guaira',
                'itapua': 'itapua',
                'misiones': 'misiones',
                'neembucu': 'neembucu',
                'paraguari': 'paraguari',
                'presidente hayes': 'presidente hayes',
                'pdte hayes': 'presidente hayes',
                'san pedro': 'san pedro',
                'amambay': 'amambay',
                'asuncion': 'asuncion',
                'alto paraguay': 'alto paraguay',
            }

            const resolveKey = (name) => {
                const normalized = normalizeName(name)
                return aliases[normalized] ?? normalized
            }

            const allValues = Object.values(values).map(Number).filter((v) => !Number.isNaN(v))
            const maxValue = allValues.length ? Math.max(...allValues) : 0

            const steps = this.buildLegendSteps(maxValue)

            const getColor = (value) => {
                if (value >= steps[4]) return '#2f49ff'
                if (value >= steps[3]) return '#5e74ff'
                if (value >= steps[2]) return '#8798ff'
                if (value >= steps[1]) return '#b8c0ff'
                if (value > 0) return '#dcdffd'
                return '#ececf8'
            }

            const defaultStyle = (feature) => {
                const rawName =
                    feature?.properties?.shapeName ||
                    feature?.properties?.name ||
                    feature?.properties?.NAME_1 ||
                    feature?.properties?.department ||
                    feature?.properties?.DEPTO ||
                    ''

                const key = resolveKey(rawName)
                const value = values[key] ?? 0

                return {
                    fillColor: getColor(value),
                    weight: 1,
                    opacity: 1,
                    color: '#d7d9ea',
                    fillOpacity: 1,
                }
            }

            this.layer = L.geoJSON(geoJson, {
                style: defaultStyle,

                onEachFeature: (feature, layer) => {
                    const rawName =
                        feature?.properties?.shapeName ||
                        feature?.properties?.name ||
                        feature?.properties?.NAME_1 ||
                        feature?.properties?.department ||
                        feature?.properties?.DEPTO ||
                        'Sin nombre'

                    const key = resolveKey(rawName)
                    const value = values[key] ?? 0
                    const formattedValue = new Intl.NumberFormat('es-PY').format(value)

                    layer.bindTooltip(
                        `<strong>${rawName}</strong><br>Turistas: ${formattedValue}`,
                        {
                            sticky: true,
                            className: 'paraguay-map-hover-tooltip',
                        }
                    )

                    const center = layer.getBounds().getCenter()

                    L.marker(center, {
                        interactive: false,
                        icon: L.divIcon({
                            className: 'paraguay-map-label-wrapper',
                            html: `<div class="paraguay-map-label">${rawName}: ${formattedValue}</div>`,
                            iconSize: null,
                        }),
                    }).addTo(this.map)

                    layer.on({
                        mouseover: (e) => {
                            e.target.setStyle({
                                fillColor: '#b8d64a',
                                weight: 2,
                                color: '#6b7d2e',
                                fillOpacity: 1,
                            })
                        },
                        mouseout: (e) => {
                            e.target.setStyle(defaultStyle(feature))
                        },
                    })
                },
            }).addTo(this.map)

            this.map.fitBounds(this.layer.getBounds(), { padding: [20, 20] })

            this.renderLegend(steps)
        },

        buildLegendSteps(maxValue) {
            if (maxValue <= 0) {
                return [0, 1, 2, 3, 4]
            }

            const step1 = Math.round(maxValue * 0.2)
            const step2 = Math.round(maxValue * 0.4)
            const step3 = Math.round(maxValue * 0.6)
            const step4 = Math.round(maxValue * 0.8)
            const step5 = Math.round(maxValue)

            return [step1, step2, step3, step4, step5]
        },

        renderLegend(steps) {
            if (this.legendControl) {
                this.legendControl.remove()
            }

            this.legendControl = L.control({ position: 'bottomright' })

            this.legendControl.onAdd = () => {
                const div = L.DomUtil.create('div', 'paraguay-map-legend')

                div.innerHTML = `
                    <div class="paraguay-map-legend-scale">
                        <span style="background:#ececf8"></span>
                        <span style="background:#dcdffd"></span>
                        <span style="background:#b8c0ff"></span>
                        <span style="background:#8798ff"></span>
                        <span style="background:#5e74ff"></span>
                        <span style="background:#2f49ff"></span>
                    </div>
                    <div class="paraguay-map-legend-labels">
                        <span>0</span>
                        <span>${new Intl.NumberFormat('es-PY').format(steps[1])}</span>
                        <span>${new Intl.NumberFormat('es-PY').format(steps[3])}</span>
                        <span>${new Intl.NumberFormat('es-PY').format(steps[4])}</span>
                    </div>
                `

                return div
            }

            this.legendControl.addTo(this.map)
        },
    }
}
