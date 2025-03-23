import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'jquery/dist/jquery.js';
import 'toastr/build/toastr.min.js';

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');