<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
  #container {
    max-width: 400px;
    height: 400px;
    margin: auto;
  }
</style>
</head>
<body>

<?php include "includes/sigmajs.inc" ?>

<div id="container">
  <style>
    #graph-container {
      width: 600px;
    height: 600px;
    margin: 0px auto;
    border: 1px black solid;
    }
  </style>
  <div id="graph-container"></div>
</div>
<script>
/**
 * This example shows the available edge label renderers for the canvas
 * renderer.
 */
var i,
    s,
    N = 5,
    E = 12,
    g = {
      nodes: [],
      edges: []
    };


g.nodes.push({
    id: "b1",
    label: "Base",
    x: Math.random(),
    y: Math.random(),
    size: 4,
    color: '#666'
});

g.nodes.push({
    id: "f1",
    label: "Farm",
    x: Math.random(),
    y: Math.random(),
    size: 2,
    color: '#666'
});
g.nodes.push({
    id: "f2",
    label: "Farm",
    x: Math.random(),
    y: Math.random(),
    size: 2,
    color: '#666'
});

  g.edges.push({
    id: 'e1',
    source: 'f1',
    target: 'b1',
    size: 6,
    color: '#ccc',
    type: 'arrow'
  });
  g.edges.push({
    id: 'e2',
    source: 'f2',
    target: 'b1',
    size: 6,
    color: '#ccc',
    type: 'arrow'
  });




// Generate a random graph:
for (i = 0; i < 40; i++) {
g.nodes.push({
    id: "m"+i,
    label: "Machine",
    x: Math.random(),
    y: Math.random(),
    size:  0.8,
    color: '#666'
});
g.edges.push({
    id: 'e2'+i,
    source: "m"+i,
    target: 'f1',
    size: 6,
    color: '#ccc',
    type: 'arrow'
  });
}

// Generate a random graph:
for (i = 0; i < 5; i++) {
g.nodes.push({
    id: "m210"+i,
    label: "Machine",
    x: Math.random(),
    y: Math.random(),
    size:  0.8,
    color: '#666'
});
g.edges.push({
    id: 'e403'+i,
    source: "m210"+i,
    target: 'f2',
    size: 60,
    color: '#ccc',
    type: 'arrow'
  });
}


// Instantiate sigma:
s = new sigma({
  graph: g,
  renderer: {
    container: document.getElementById('graph-container'),
    type: 'canvas'
  },
  settings: {
    edgeLabelSize: 'proportional'
  }
});
// Add a method to the graph model that returns an
  // object with every neighbors of a node inside:
  sigma.classes.graph.addMethod('neighbors', function(nodeId) {
    var k,
        neighbors = {},
        index = this.allNeighborsIndex[nodeId] || {};

    for (k in index)
      neighbors[k] = this.nodesIndex[k];

    return neighbors;
  });
s.bind('clickNode', function(e) {
        var nodeId = e.data.node.id,
            toKeep = s.graph.neighbors(nodeId);
        toKeep[nodeId] = e.data.node;

        s.graph.nodes().forEach(function(n) {
          if (toKeep[n.id])
            n.color = n.originalColor;
          else
            n.color = '#eee';
        });

        s.graph.edges().forEach(function(e) {
          if (toKeep[e.source] && toKeep[e.target])
            e.color = e.originalColor;
          else
            e.color = '#eee';
        });

        // Since the data has been modified, we need to
        // call the refresh method to make the colors
        // update effective.
        s.refresh();
      });
//Start the ForceAtlas2 algorithm:
// s.startForceAtlas2({worker: true, barnesHutOptimize: false});//Start the ForceAtlas2 algorithm to optimize network layout

	s.startForceAtlas2({worker: false, barnesHutOptimize: false, slowDown: 1000, iterationsPerRender: 1000});
	
	//Set time interval to allow layout algorithm to converge on a good state
	var t = 0;
	var interval = setInterval(function() {
		t += 1;
		if (t >= 5) {
			clearInterval(interval);
			s.stopForceAtlas2();
		}
	}, 100);
</script>

</body>
</html>
