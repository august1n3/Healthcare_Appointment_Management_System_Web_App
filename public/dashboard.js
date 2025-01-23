/* globals Chart:false */

(() => {
  'use strict'

  // Graphs
  const ctx = document.getElementById('myChart')
  const ctx2 = document.getElementById('myChart2')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          null
        ],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#4ec963',
        borderWidth: 4,
        pointBackgroundColor: '#4ec963'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })
  const myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: [
        'ROOM.1',
        'ROOM.2',
        'ROOM.3',
        'ROOM.4',
        'ROOM.5',
        'ROOM.6',
        'ROOM.7'
      ],
      datasets: [{
        data: [
          15,
          21,
          11,
          9,
          7,
          0,
          45
        ],
        lineTension: 0,
        backgroundColor: '#4ec963',
        borderColor: '#4ec963',
        borderWidth: 0,
        pointBackgroundColor: '#4ec963'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: !false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })
 
})()