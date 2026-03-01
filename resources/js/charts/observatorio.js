import Chart from 'chart.js/auto';

export function observatorioChart(config, chartId) {
  return {
    chart: null,
    cfg: config,
    id: chartId,
    _handler: null,

    resolveCanvas(canvasEl) {
      if (canvasEl && canvasEl.tagName?.toLowerCase() === 'canvas') return canvasEl;

      const byId = document.getElementById(this.id);
      if (byId && byId.tagName?.toLowerCase() === 'canvas') return byId;

      if (canvasEl && canvasEl.querySelector) {
        const inside = canvasEl.querySelector('canvas');
        if (inside) return inside;
      }

      return null;
    },

    destroy() {
      if (this.chart) {
        this.chart.destroy();
        this.chart = null;
      }
      if (this._handler) {
        window.removeEventListener('observatorio:chart:update', this._handler);
        this._handler = null;
      }
    },

    init(canvasMaybe) {
      const canvas = this.resolveCanvas(canvasMaybe);

      // 🔥 Si no existe aún, reintenta (esto arregla el tab receptivo)
      if (!canvas) {
        requestAnimationFrame(() => this.init(canvasMaybe));
        return;
      }

      // reinicialización segura
      this.destroy();

      this.chart = new Chart(canvas, this.cfg);

      // cleanup si Livewire lo desmonta
      const observer = new MutationObserver(() => {
        if (!document.body.contains(canvas)) {
          this.destroy();
          observer.disconnect();
        }
      });
      observer.observe(document.body, { childList: true, subtree: true });

      // ✅ listener único por instancia
      this._handler = (e) => {
        const { chartId: targetId, config: nextCfg } = e.detail || {};
        if (!nextCfg) return;
        if (targetId && targetId !== this.id) return;

        const c = this.resolveCanvas(canvas);
        if (!c) return;

        // recrear seguro
        if (this.chart) this.chart.destroy();
        this.chart = new Chart(c, nextCfg);
      };

      window.addEventListener('observatorio:chart:update', this._handler);
    },
  };
}

window.observatorioChart = observatorioChart;
