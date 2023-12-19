import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/bootstrap5.css'

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
