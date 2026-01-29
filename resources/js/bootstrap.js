import axios from 'axios';
window.axios = axios;

// Importar o Bootstrap e o Popper.js
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';