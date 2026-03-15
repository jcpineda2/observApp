<div class="kpi-card">
    <div class="kpi-card-accent"></div>

    <div class="kpi-card-content">
        <div class="kpi-card-header">
            <div class="kpi-card-title">
                {{ $title }}
            </div>

            @isset($badge)
                <span class="kpi-card-badge">
                    {{ $badge }}
                </span>
            @endisset
        </div>

        <div class="kpi-card-value">
            {{ $value }}

            @isset($unit)
                <span class="kpi-card-unit">
                    {{ $unit }}
                </span>
            @endisset
        </div>

        @isset($helpText)
            <div class="kpi-card-help">
                {{ $helpText }}
            </div>
        @endisset

        @isset($source)
            <div class="kpi-card-source">
                Fuente: {{ $source }}
            </div>
        @endisset
    </div>
</div>
