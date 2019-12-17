/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import * as L from 'leaflet';
// eslint-disable-next-line import/no-unresolved
import 'leaflet-defaulticon-compatibility';
import 'leaflet/dist/leaflet.css';
import 'leaflet-defaulticon-compatibility/dist/leaflet-defaulticon-compatibility.webpack.css';
import { GestureHandling } from 'leaflet-gesture-handling';
import 'leaflet-gesture-handling/dist/leaflet-gesture-handling.css';

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
// eslint-disable-next-line import/no-extraneous-dependencies
require('bootstrap');

// eslint-disable-next-line import/no-extraneous-dependencies
require('@fortawesome/fontawesome-free/css/all.min.css');
// eslint-disable-next-line import/no-extraneous-dependencies
require('@fortawesome/fontawesome-free/js/all.js');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// eslint-disable-next-line import/no-extraneous-dependencies,no-unused-vars
const $ = require('jquery');

// eslint-disable-next-line import/no-unresolved
require('./map.js');
