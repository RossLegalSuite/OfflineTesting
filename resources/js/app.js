/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import "jquery-ui/ui/widgets/datepicker.js";
import "jquery-ui/ui/widget.js";
import "jquery-ui/ui/widgets/mouse.js";
import "jquery-ui/ui/widgets/draggable.js";
import "jquery-ui/ui/widgets/resizable.js";

// window.JSZip = require("jszip");

window.$ = window.jQuery = require("jquery");
var dt = require("datatables.net-bs4");

require("datatables.net-buttons/js/buttons.html5.js");
require("datatables.net-buttons/js/buttons.print.js");
require("datatables.net-scroller-bs4");
require("datatables.net-select-bs4");
require("datatables.net-responsive-bs4");

window.moment = require("moment");

window.Vue = require("vue");

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
