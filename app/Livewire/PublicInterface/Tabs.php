<?php

namespace App\Livewire\PublicInterface;

use Livewire\Component;

class Tabs extends Component
{
    /**
     * Tabs alineadas al PDF (ejes/pestañas).
     * Ref: Principal, Turismo interno, Receptivo, Prestadores, Alojamientos, Empleo, Conectividad. :contentReference[oaicite:0]{index=0}
     */
    public array $tabs = [
        'principal' => 'Principal',
        'turismo-interno' => 'Turismo interno',
        'turismo-receptivo' => 'Turismo receptivo',
        'prestadores' => 'Prestadores',
        'alojamientos' => 'Alojamientos',
        'empleo' => 'Empleo',
        'conectividad' => 'Conectividad aérea',
    ];

    /**
     * Tab activa (por defecto “principal”).
     * La dejamos en querystring para que puedas compartir links del estilo: /?tab=empleo
     */
    public string $activeTab = 'principal';

    protected array $queryString = [
        'activeTab' => ['as' => 'tab', 'except' => 'principal'],
    ];

    public function mount(): void
    {
        if (! array_key_exists($this->activeTab, $this->tabs)) {
            $this->activeTab = 'principal';
        }
    }

    public function setTab(string $key): void
    {
        if (array_key_exists($key, $this->tabs)) {
            $this->activeTab = $key;
        }
    }

    public function render()
    {
        return view('livewire.public-interface.tabs');
    }
}
