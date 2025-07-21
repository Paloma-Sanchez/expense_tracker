<template>
  <svg 
    ref="svg"
    :width="width" 
    :height="height" 
  ></svg>
</template>

<script setup>
import * as d3 from 'd3';
import { onMounted, ref, useTemplateRef } from 'vue';

const props = defineProps({
  width:{
    type: Number,
    default: 200
  },

  height: {
    type: Number,
    default: 200
  },

  data:{
    type: Array,
    default: () => []
  }
})

const svg = ref(null);

const color = d3.scaleOrdinal()
  .domain(props.data.map(d => d.name))
  .range(d3.schemeCategory10);

onMounted(() => {
  createPie()
})

const createPie = () => {
// Clear previous SVG content
d3.select(svg.value).selectAll('*').remove();

// Create the pie layout and arc generator.
const pie = d3.pie()
  .sort(null)
  .value(d => Math.abs(d.value));

const arc = d3.arc()
  .innerRadius(0)
  .outerRadius(Math.min(props.width, props.height) / 2 - 1);

const labelRadius = arc.outerRadius()() * 0.75;

// A separate arc generator for labels.
const arcLabel = d3.arc()
      .innerRadius(labelRadius)
      .outerRadius(labelRadius);

const arcs = pie(props.data);

// Center the pie chart
const g = d3.select(svg.value)
  .append('g')
  .attr("stroke", "white")
  .attr('transform', `translate(${props.width / 2},${props.height / 2})`);


  // Add a sector path for each value.
  g.selectAll('path')
    .data(arcs)
    .join("path")
      .attr("d", arc)
      .attr('fill', d => color(d.data.name))
    .append("title")
      .text(d => `${d.data.name}: ${d.data.value.toLocaleString("en-US")}`);

  // Create a new arc generator to place a label close to the edge.
  // The label shows the value if there is enough room.
  g.append("g")
      .attr("text-anchor", "middle")
    .selectAll('text')
    .data(arcs)
    .join("text")
      .attr("transform", d => `translate(${arcLabel.centroid(d)})`)
      .attr("font-size", "10px") 
      .call(text => text.append("tspan")
          .attr("y", "-0.4em")
          // .attr("font-weight", "bold")
          .text(d => d.data.name))
      .call(text => text.filter(d => (d.endAngle - d.startAngle) > 0.55).append("tspan")
          .attr("x", 0)
          .attr("y", "0.7em")
          .attr("fill-opacity", 0.7)
          .text(d => d.data.value.toLocaleString("en-US")));
}
</script>