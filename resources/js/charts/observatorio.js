import Chart from 'chart.js/auto';

export function observatorioChart(config, chartId) {
  return {
    chart: null,
    cfg: config,
    id: chartId,

    init(canvasEl) {
      // Inicializa o reinicia
      if (this.chart) {
        this.chart.destroy();
        this.chart = null;
      }

      this.chart = new Chart(canvasEl, this.cfg);

      // Actualización selectiva por chartId
      window.addEventListener('observatorio:chart:update', (e) => {
        const { chartId: targetId, config: nextCfg } = e.detail || {};
        if (!nextCfg) return;
        if (targetId && targetId !== this.id) return;

        this.cfg = nextCfg;

        this.chart.destroy();
        this.chart = new Chart(canvasEl, this.cfg);
      });
    },
  };
}

// Exponer a Alpine
window.observatorioChart = observatorioChart;
