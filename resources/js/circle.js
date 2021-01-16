require('./bootstrap');

import * as d3Base from 'd3'
import { legendColor } from 'd3-svg-legend'
import {selection, select} from "d3-selection";
import { lineChunked } from 'd3-line-chunked'

const d3 = Object.assign(d3Base, { legendColor, lineChunked })

"use strict";

var lastNodeId = nodes.length;
const w = svgWidth ? svgWidth : 500,
    h = svgHeight ? svgHeight : 500,
    rad = 16;

const centerX = w / 2;
const centerY = h / 2;
const radius = Math.min(w,h) / 2 - 50;
const angle = 360 / nodes.length;
nodes.forEach(function (d, i) {
    d.x = centerX + radius * Math.cos((angle * i - 90) * Math.PI/180);
    d.y = centerY + radius * Math.sin((angle * i - 90) * Math.PI/180);
});

var svg = d3
    .select("#svg-wrap")
    .append("svg")
    .attr("width", w)
    .attr("height", h);

var edges = svg.append("g").selectAll(".edge");

var vertices = svg.append("g").selectAll(".vertex");

var colors = d3.schemeSet3;

//here vertices are g.vertex elements
vertices.attr("transform", function (d) {
    return "translate(" + d.x + "," + d.y + ")";
});


function restart() {
    edges = edges.data(links, function (d) {
        return "v" + d.source.id + "-v" + d.target.id;
    });
    edges.exit().remove();

    var ed = edges
        .enter()
        .append("line")
        .attr("class", "edge");

    ed.append("title").text(function (d) {
        return "v" + d.source+1 + "-v" + d.target+1;
    });

    edges = ed.merge(edges);

    edges
        .attr("x1", function (d) {
            return nodes[d.source].x;
        })
        .attr("y1", function (d) {
            return nodes[d.source].y;
        })
        .attr("x2", function (d) {
            return nodes[d.target].x;
        })
        .attr("y2", function (d) {
            return nodes[d.target].y;
        });


    //vertices are known by id
    vertices = vertices.data(nodes, function (d) {
        return d.id;
    });
    vertices.exit().remove();

    vertices.selectAll("text").text(function (d) {
        return d.degree;
    });

    var g = vertices
        .enter()
        .append("g")
        .attr("class", "vertex")
        .on("mousedown", function (a, b, c, e) {
            console.dir(a);
            console.dir(b);
            console.dir(c);
            console.dir(e);
            a.stopPropagation();
        });

    g.append("circle")
        .attr("r", rad)
        .attr("cx", (d) => d.x)
        .attr("cy", (d) => d.y)
        .style("fill", function (d, i) {
            return colors[d.id % 12];
        })
        .append("title")
        .text(function (d) {
            return "v" + d.id;
        });

    g.append("text")
        .attr("dx", (d) => d.x)
        .attr("dy", (d) => d.y)
        //.attr("y", 4)
        .text(function (d) {
            return d.id;// + ' - ' + d.degree;
        });

    vertices = g.merge(vertices);
}

console.log('what Circle?');

restart();
