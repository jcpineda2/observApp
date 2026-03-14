const geoJsonCache = new Map()
const mapInstances = new Map()

export function paraguayDepartmentMap(config) {
    return {
        map: null,
        layer: null,
        isLoading: true,
        isEmpty: false,
        hasBeenInitialized: false,
        geoJsonData: null,
        currentValues: config.values ?? {},
        selectedDepartment: null,
        observer: null,
        updateHandler: null,
        config,

        init() {
            const container = document.getElementById(this.config.mapId)

            if (!container || typeof L === 'undefined') {
                return
            }

            this.refreshEmptyState()
            this.destroyPreviousMapInstance()
            this.setupBrowserListener()
            this.setupIntersectionObserver(container)
        },

        setupIntersectionObserver(container) {
            this.observer?.disconnect()

            this.observer = new IntersectionObserver(
                async (entries) => {
                    const [entry] = entries

                    if (!entry.isIntersecting || this.hasBeenInitialized) {
                        return
                    }

                    this.hasBeenInitialized = true
                    this.observer?.disconnect()

                    await this.bootMap()
                },
                {
                    root: null,
                    threshold: 0.1,
                }
            )

            this.observer.observe(container)
        },

        async bootMap() {
            try {
                this.isLoading = true

                this.createMap()
                this.geoJsonData = await this.loadGeoJson()
                this.renderLayer()

                this.isLoading = false
            } catch (error) {
                console.error('Error al inicializar el mapa de Paraguay:', error)
                this.isLoading = false
            }
        },

        createMap() {
            const container = document.getElementById(this.config.mapId)

            if (!container) {
                return
            }

            if (container._leaflet_id) {
                container._leaflet_id = null
            }

            const existingMap = mapInstances.get(this.config.mapId)

            if (existingMap) {
                existingMap.remove()
                mapInstances.delete(this.config.mapId)
            }

            this.map = L.map(container, {
                preferCanvas: true,
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

            mapInstances.set(this.config.mapId, this.map)
        },

        async loadGeoJson() {
            const url = this.config.geoJsonUrl

            if (geoJsonCache.has(url)) {
                return geoJsonCache.get(url)
            }

            const response = await fetch(url, {
                cache: 'force-cache',
                headers: {
                    Accept: 'application/json',
                },
            })

            if (!response.ok) {
                throw new Error(`No se pudo cargar el GeoJSON: ${response.status}`)
            }

            const data = await response.json()

            geoJsonCache.set(url, data)

            return data
        },

        setupBrowserListener() {
            if (this.updateHandler) {
                window.removeEventListener('paraguay-map:update', this.updateHandler)
            }

            this.updateHandler = (event) => {
                const payload = event.detail ?? {}

                if (payload.mapId !== this.config.mapId) {
                    return
                }

                this.currentValues = payload.values ?? {}
                this.selectedDepartment = payload.selectedDepartment ?? null
                this.refreshEmptyState()

                if (this.layer) {
                    this.updateLayerStyles()
                }
            }

            window.addEventListener('paraguay-map:update', this.updateHandler)
        },

        refreshEmptyState() {
            const values = Object.values(this.currentValues ?? {})
                .map(Number)
                .filter((value) => !Number.isNaN(value))

            this.isEmpty = values.length === 0 || values.every((value) => value <= 0)
        },

        renderLayer() {
            if (!this.map || !this.geoJsonData) {
                return
            }

            if (this.layer) {
                this.layer.remove()
                this.layer = null
            }

            this.layer = L.geoJSON(this.geoJsonData, {
                style: (feature) => this.getFeatureStyle(feature),
                onEachFeature: (feature, layer) => this.bindFeature(feature, layer),
            }).addTo(this.map)

            try {
                this.map.fitBounds(this.layer.getBounds(), {
                    padding: [16, 16],
                })
            } catch (_) { }
        },

        updateLayerStyles() {
            if (!this.layer) {
                return
            }

            this.layer.eachLayer((layer) => {
                const feature = layer.feature

                layer.setStyle(this.getFeatureStyle(feature))
                layer.unbindTooltip()
                layer.bindTooltip(this.buildTooltipHtml(feature), {
                    sticky: true,
                    className: 'paraguay-map-hover-tooltip',
                })
            })
        },

        bindFeature(feature, layer) {
            const departmentName = this.resolveDepartmentName(feature)
            const departmentKey = this.normalizeDepartmentName(departmentName)

            layer.bindTooltip(this.buildTooltipHtml(feature), {
                sticky: true,
                className: 'paraguay-map-hover-tooltip',
            })

            layer.on({
                mouseover: (event) => {
                    event.target.setStyle({
                        weight: 2,
                        color: '#6b7280',
                        fillOpacity: 1,
                    })

                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                        event.target.bringToFront()
                    }
                },
                mouseout: (event) => {
                    event.target.setStyle(this.getFeatureStyle(feature))
                },
                click: (event) => {
                    this.selectedDepartment = departmentKey
                    this.updateLayerStyles()

                    window.dispatchEvent(
                        new CustomEvent('paraguay-map:department-selected', {
                            detail: {
                                mapId: this.config.mapId,
                                department: departmentKey,
                                departmentName,
                            },
                        })
                    )
                },
            })
        },

        getFeatureStyle(feature) {
            const departmentName = this.resolveDepartmentName(feature)
            const key = this.normalizeDepartmentName(departmentName)
            const value = Number(this.currentValues[key] ?? 0)
            const isSelected = this.selectedDepartment === key

            return {
                fillColor: this.getColorByValue(value),
                weight: isSelected ? 3 : 1,
                opacity: 1,
                color: isSelected ? '#111827' : '#d7d9ea',
                fillOpacity: 1,
            }
        },

        buildTooltipHtml(feature) {
            const departmentName = this.resolveDepartmentName(feature)
            const key = this.normalizeDepartmentName(departmentName)
            const value = Number(this.currentValues[key] ?? 0)
            const formattedValue = new Intl.NumberFormat('es-PY').format(value)

            return `<strong>${departmentName}</strong><br>Turistas: ${formattedValue}`
        },

        resolveDepartmentName(feature) {
            const props = feature?.properties ?? {}

            return (
                props.dpto_desc ||
                props.shapeName ||
                props.name ||
                props.NAME_1 ||
                props.department ||
                props.DEPTO ||
                'Sin nombre'
            )
        },

        normalizeDepartmentName(name) {
            const normalized = String(name || '')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/\./g, '')
                .replace(/-/g, ' ')
                .replace(/\s+/g, ' ')
                .trim()
                .toLowerCase()

            const aliases = {
                'pdte hayes': 'presidente hayes',
                'alto parana': 'alto parana',
                'boqueron': 'boqueron',
                'canindeyu': 'canindeyu',
                'caaguazu': 'caaguazu',
                'caazapa': 'caazapa',
                'central': 'central',
                'concepcion': 'concepcion',
                'cordillera': 'cordillera',
                'guaira': 'guaira',
                'itapua': 'itapua',
                'misiones': 'misiones',
                'neembucu': 'neembucu',
                'paraguari': 'paraguari',
                'presidente hayes': 'presidente hayes',
                'san pedro': 'san pedro',
                'amambay': 'amambay',
                'asuncion': 'asuncion',
                'alto paraguay': 'alto paraguay',
            }

            return aliases[normalized] ?? normalized
        },

        getColorByValue(value) {
            const maxValue = this.getMaxValue()

            if (maxValue <= 0) {
                return '#ececf8'
            }

            const steps = this.buildLegendSteps(maxValue)

            if (value >= steps[4]) return '#2f49ff'
            if (value >= steps[3]) return '#5e74ff'
            if (value >= steps[2]) return '#8798ff'
            if (value >= steps[1]) return '#b8c0ff'
            if (value > 0) return '#dcdffd'

            return '#ececf8'
        },

        getMaxValue() {
            const allValues = Object.values(this.currentValues)
                .map(Number)
                .filter((value) => !Number.isNaN(value))

            return allValues.length ? Math.max(...allValues) : 0
        },

        buildLegendSteps(maxValue) {
            if (maxValue <= 0) {
                return [0, 1, 2, 3, 4]
            }

            return [
                Math.round(maxValue * 0.2),
                Math.round(maxValue * 0.4),
                Math.round(maxValue * 0.6),
                Math.round(maxValue * 0.8),
                Math.round(maxValue),
            ]
        },

        destroyPreviousMapInstance() {
            const existingMap = mapInstances.get(this.config.mapId)

            if (existingMap) {
                existingMap.remove()
                mapInstances.delete(this.config.mapId)
            }

            const container = document.getElementById(this.config.mapId)

            if (container && container._leaflet_id) {
                container._leaflet_id = null
            }
        },

        destroy() {
            this.observer?.disconnect()

            if (this.updateHandler) {
                window.removeEventListener('paraguay-map:update', this.updateHandler)
            }

            if (this.layer) {
                this.layer.remove()
                this.layer = null
            }

            if (this.map) {
                this.map.remove()
                mapInstances.delete(this.config.mapId)
                this.map = null
            }

            const container = document.getElementById(this.config.mapId)

            if (container && container._leaflet_id) {
                container._leaflet_id = null
            }
        },
    }
}
