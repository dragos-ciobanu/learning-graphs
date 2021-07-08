d3 = require("d3");

const rad = 16;
const width = 900;
const height = Math.min(500, width * 0.6);

let nodes = [];
let links = [];
let nodesCount = 0;
const color = d3.scaleOrdinal(d3.schemeCategory10);

{
    const svg = d3
        .select("#svg-wrap-draw")
        .append("svg")
        .attr("viewBox", [0, 0, width, height])
        .attr("width", width)
        .attr("height", height);

    let dragLine = svg
        .append("path")
        .attr("class", "dragLine hidden")
        .attr("d", "M0,0L0,0");

    let edges = svg
        .append("g")
        .selectAll(".edge")
        .data(links)
        .join("line")
        .classed("link", true);

    let vertices = svg
        .append("g")
        .selectAll(".vertex")
        .data(nodes)
        .join("circle")
        .attr("r", rad)
        .classed("node", true);

    const simulation = d3
        .forceSimulation()
        .nodes(nodes)
        .force("link", links)
        .force("link", d3.forceLink().distance(100))
        .force("charge", d3.forceManyBody().strength(-300).distanceMax(width / 2))
        .force("center", d3.forceCenter(width / 2, height / 2))
        .force("x", d3.forceX(width / 2))
        .force("y", d3.forceY(height / 2))
        .on("tick", tick);

    let mousedownNode = null;

    const clrBtn = d3.select("#clear-graph");
    clrBtn.on("click", clearGraph);

    function clearGraph() {
        nodes.splice(0);
        links.splice(0);
        nodesCount = 0;
        restart();
        showGraphLatex();
    }



    function restart() {
        edges = edges.data(links, function (d) {
            return d.source.id + "-" + d.target.id;
        });
        edges.exit().remove();
        const tempEdges = edges.enter().append("line").attr("class", "edge")
            .on("mousedown", function (e) {
                e.stopPropagation();
            })
            .on("contextmenu", removeEdge);

        tempEdges.append("title").text(function(d) {
            return d.source.id + " - " + d.target.id;
        });
        edges = tempEdges.merge(edges);


        vertices = vertices.data(nodes, function (d) {
            return d.id;
        });
        vertices.exit().remove();

        const tempVertices = vertices.enter().append("g").attr("class", "vertex").on("mousedown", e => e.stopPropagation());
        tempVertices.append("circle").attr("fill", d => color(d.id)).attr("r", rad)
            .on("mousedown", beginDragLine)
            .on("mouseup", endDragLine)
            .on("contextmenu", removeNode);
        tempVertices.append("title").text(function(d) {
            return d.id;
        });
        tempVertices.append("text")
            .attr("x", 0)
            .attr("y", 4)
            .text(d => d.id);


        vertices = tempVertices.merge(vertices);

        simulation.nodes(nodes);
        simulation.force("link").links(links);
        simulation.alphaMin(0.8);
        simulation.alpha(1).restart();
        updateForm();
    }

    let once = false;

    function tick() {
        edges
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);
        vertices.attr("transform", function(d) {
            return "translate(" + d.x + "," + d.y + ")";
        });
        if (!once) {
            console.log(vertices.selectAll());
            once = true;
        }
    }

    svg
        .on("mousedown", addNode)
        .on("mousemove", updateDragLine)
        .on("mouseup", hideDragLine)
        .on("contextmenu", function(e) {
            e.preventDefault();
        })
        .on("mouseleave", hideDragLine);

    restart();
    showGraphLatex();

    function addNode(e) {
        if (e.button === 0) {
            let coords = d3.pointer(e);
            let newNode = { x: coords[0], y: coords[1], id: ++nodesCount };
            nodes.push(newNode);
            restart();
            showGraphLatex();
        }
    }
    function removeNode(e, d) {
        if (e.ctrlKey) return;
        nodes.splice(nodes.indexOf(d), 1);
        const linksToRemove = links.filter(function(l) {
            return l.source === d || l.target === d;
        });
        linksToRemove.map(function(l) {
            links.splice(links.indexOf(l), 1);
        });
        e.preventDefault();
        restart();
        showGraphLatex();
    }

    function removeEdge(e, d) {
        links.splice(links.indexOf(d), 1);
        e.preventDefault();
        restart();
        showGraphLatex();
    }

    function beginDragLine(e, d) {
        e.stopPropagation();
        e.preventDefault();
        if (e.ctrlKey || e.button !== 0) return;
        mousedownNode = d;
        dragLine
            .classed("hidden", false)
            .attr(
                "d",
                "M" +
                mousedownNode.x +
                "," +
                mousedownNode.y +
                "L" +
                mousedownNode.x +
                "," +
                mousedownNode.y
            );
    }

    function updateDragLine(e) {
        const coords = d3.pointer(e);
        if (!mousedownNode) return;
        dragLine.attr(
            "d",
            "M" +
            mousedownNode.x +
            "," +
            mousedownNode.y +
            "L" +
            coords[0] +
            "," +
            coords[1]
        );
    }

    function hideDragLine() {
        dragLine.classed("hidden", true);
        mousedownNode = null;
        restart();
    }

    function endDragLine(e, d) {
        if (!mousedownNode || mousedownNode === d) return;
        for (let i = 0; i < links.length; i++) {
            var l = links[i];
            if (
                (l.source === mousedownNode && l.target === d) ||
                (l.source === d && l.target === mousedownNode)
            ) {
                return;
            }
        }
        var newLink = { source: mousedownNode, target: d };
        links.push(newLink);
        showGraphLatex();
    }

    function updateForm() {
        d3.select("#vertices_count").property("value", nodes.length);
        d3.select("#edges_count").property("value", links.length);
        const edges = links.map((link) => link.source.id + " " + link.target.id).join("\n");
        d3.select("#edges").property("value", edges);
    }


    function showGraphLatex() {
        let v = "\\[V=\\{";
        for (let i = 0; i < nodes.length; i++) {
            if (i === 0) v += "v_{" + nodes[i].id + "}";
            else v += "," + "v_{" + nodes[i].id + "}";
            //add line break
            if ((i + 1) % 15 === 0) v += "\\\\";
        }
        v += "\\}\\]";

        let e = "\\[E=\\{";
        for (let i = 0; i < links.length; i++) {
            if (i === links.length - 1)
                e += "v_{" + links[i].source.id + "}" + "v_{" + links[i].target.id + "}";
            else
                e +=
                    "v_{" +
                    links[i].source.id +
                    "}" +
                    "v_{" +
                    links[i].target.id +
                    "}" +
                    ",";
            //add line break
            if ((i + 1) % 10 === 0) e += "\\\\";
        }
        e += "\\}\\]";


        MathJax.typesetPromise().then(() => {
            document.getElementById("math-output").textContent = v + e;
            MathJax.typesetPromise();
        }).catch((err) => console.log(err.message));    }

}
