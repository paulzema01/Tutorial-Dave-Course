import '../scss/bootstrap.scss';
import * as bootstrap from 'bootstrap';
import Alpine from 'alpinejs';
import registerForm from './register-form';

// Bootstrap's components work through data-bs-* attributes; the global is for
// scripts that need its JavaScript API (e.g. new bootstrap.Modal(...)).
window.bootstrap = bootstrap;

window.Alpine = Alpine;

Alpine.data('registerForm', registerForm);

Alpine.start();
