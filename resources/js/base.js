import * as d3Base from 'd3'
import { legendColor } from 'd3-svg-legend'
import { lineChunked } from 'd3-line-chunked'

const d3 = Object.assign(d3Base, { legendColor, lineChunked })


var lastNodeId = nodes.length;
const w = svgWidth ? svgWidth : 500,
    h = svgHeight ? svgHeight : 500,
    rad = 16;

if (isCircleGraph === false) {


    nodes.forEach(function (d, i) {
        d.y = (w / lastNodeId) * i;
        if (i % 2 === 0) d.x = d.y;
        else d.x = w - d.y;
    });
} else {
    const centerX = w / 2;
    const centerY = h / 2;
    const radius = Math.min(w,h) / 2 - 50;
    const angle = 360 / nodes.length;
    nodes.forEach(function (d, i) {
        d.x = centerX + radius * Math.cos(-angle*Math.PI*i/180);
        d.y = centerY + radius * Math.sin(-angle*Math.PI*i/180);
    });
}
var svg = d3
    .select("#svg-wrap")
    .append("svg")
    .attr("width", w)
    .attr("height", h);

var edges = svg.append("g").selectAll(".edge");

var vertices = svg.append("g").selectAll(".vertex");

var force = d3
    .forceSimulation()
    .force(
        "charge",
        d3
            .forceManyBody()
            .strength(-300)
            .distanceMax((w + h) / 2)
    )
    .force("link", d3.forceLink().distance(100))
    .force("x", d3.forceX(w / 2))
    .force("y", d3.forceY(h / 2))
    .on("tick", tick);

force.nodes(nodes);
force.force("link").links(links);

var colors = d3.schemeSet3;


function tick() {
    edges
        .attr("x1", function (d) {
            return d.source.x;
        })
        .attr("y1", function (d) {
            return d.source.y;
        })
        .attr("x2", function (d) {
            return d.target.x;
        })
        .attr("y2", function (d) {
            return d.target.y;
        });

    //here vertices are g.vertex elements
    vertices.attr("transform", function (d) {
        return "translate(" + d.x + "," + d.y + ")";
    });
}

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
        return "v" + d.source.id + "-v" + d.target.id;
    });

    edges = ed.merge(edges);

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
        //so that force.drag and addNode don't interfere
        //mousedown is initiated on circle which is stopped at .vertex
        .on("mousedown", function (e, d) {
            e.stopPropagation();

        });

    g.append("circle")
        .attr("r", rad)
        .style("fill", function (d, i) {
            return colors[d.id % 12];
        })
        .append("title")
        .text(function (d) {
            return "v" + d.id;
        });

    g.append("text")
        .attr("x", 0)
        .attr("y", 4)
        .text(function (d) {
            return d.id;// + ' - ' + d.degree;
        });

    vertices = g.merge(vertices);

    force.nodes(nodes);
    force.force("link").links(links);
    force.alpha(0.8).restart();
}

console.log('what Base?');

restart();

