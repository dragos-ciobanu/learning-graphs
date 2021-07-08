/*
const width = svgWidth ? svgWidth : 500,
    height = svgHeight ? svgHeight : 500,
    rad = 16;
*/

rad = 16;
d3 = require("d3");
width = 900;
height = Math.min(500, width * 0.6);

const clamp = (x, lo, hi) => x < lo ? lo : x > hi ? hi : x;

graph = ({
    nodes: Array.from({length:6}, () => ({})),
    links: [
        { source: 0, target: 1 },
        { source: 0, target: 2 },
        { source: 0, target: 3 },
        { source: 0, target: 4 },
        { source: 1, target: 2 },
        { source: 1, target: 3 },
        { source: 1, target: 4 },
        { source: 2, target: 3 },
        { source: 2, target: 4 },
        { source: 3, target: 4 },
        { source: 0, target: 5 },
        { source: 1, target: 5 },
        { source: 2, target: 5 },
        { source: 3, target: 5 },
        { source: 4, target: 5 },
    ]
});
nodes = [];
links = [];
nodesCount = 0;
const color = d3.scaleOrdinal(d3.schemeCategory10);

{
    const svg = d3.
        select("#svg-wrap-playground").
        append("svg").
        attr("viewBox", [0, 0, width, height]);

    svg.on("click", addNode);

    let link = svg
        .selectAll(".link")
        .data(links)
        .join("line")
        .classed("link", true);
    let node = svg
        .selectAll(".node")
        .data(nodes)
        .join("circle")
        .attr("r", rad)
        .classed("node", true)
        .classed("fixed", d => d.fx !== undefined);

    const simulation = d3
        .forceSimulation()
        .nodes(nodes)
        .force("charge", d3.forceManyBody().strength(-300))
        .force("center", d3.forceCenter(width / 2, height / 2))
        .force("link", d3.forceLink(links).distance(200))
        .on("tick", tick);

    const drag = d3
        .drag()
        .on("start", dragstart)
        .on("drag", dragged);

    node.call(drag).on("click", click);

    function restart() {
        node = node.data(nodes, function(d) { return d.id;});
        node.exit().remove();

        node = node.
            enter().
            append("circle").
                attr("fill", function(d) {
                    return color(d.id);
                }).
                attr("r", rad).
            classed("node", true).
            classed("fixed", d => d.fx !== undefined).
            merge(node);

        link = link.data(links, function(d) { return d.source.id + "-" + d.target.id; });
        link.exit().remove();
        link = link.enter().append("line").merge(link);

        simulation.nodes(nodes);
        simulation.force("link").links(links);
        simulation.alpha(1).restart();
    }

    let once = false;

    function tick() {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);
        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);
        if (!once) {
            console.log(node.selectAll());
            once = true;
        }
/*
        node.forEach((a,b,c,d) => {
           console.log(a);
           console.log(b);
           console.log(c);
           console.log(d);
        });
*/
    }

    function click(event, d) {
        delete d.fx;
        delete d.fy;
        d3.select(this).classed("fixed", false);
        simulation.alpha(1).restart();
    }

    function dragstart() {
        d3.select(this).classed("fixed", true);
    }

    function dragged(event, d) {
        d.fx = clamp(event.x, 0, width);
        d.fy = clamp(event.y, 0, height);
        restart();
    }


    function addNode(e, a, b, c) {
        console.log(a);
        console.log(b);
        console.log(c);

        if (e.button === 0) {
            let coords = d3.pointer(e);
            let newNode = { x: coords[0], y: coords[1], id: ++nodesCount };
            nodes.push(newNode);
            restart();
        }
    }
}
