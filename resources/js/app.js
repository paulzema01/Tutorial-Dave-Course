import '../scss/bootstrap.scss';
import 'bootstrap-icons/font/bootstrap-icons.css';
import * as bootstrap from 'bootstrap';
import Alpine from 'alpinejs';
import registerForm from './register-form';

// Bootstrap's components work through data-bs-* attributes; the global is for
// scripts that need its JavaScript API (e.g. new bootstrap.Modal(...)).
window.bootstrap = bootstrap;

window.Alpine = Alpine;

Alpine.data('registerForm', registerForm);

Alpine.start();

// Chart.js is only downloaded on pages that have charts.
if (document.querySelector('canvas[data-chart]')) {
    import('./dashboard-charts').then(({ default: initDashboardCharts }) => initDashboardCharts());
}
