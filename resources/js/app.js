"use strict";
require('./bootstrap');

if (isCircleGraph) {
    require('./circle');
} else {
    require('./base');
}
