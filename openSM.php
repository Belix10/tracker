<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>OpenLayers</title>
     <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/css/ol.css">
  </head>
  <body>
    <div id="mapa" style="height: 875px; border: 5px outset red; background-color: lightblue; text-align:center;"></div>
  </body>
  <script type="text/javascript">


/*Se crea una variable que guarda latitud y longitud de un  punto*/
var p1 = [-93.55905,16.66842];
var p2 = [-93.60043,16.62352];
var p3  = [-93.52431,16.61872];

var posicion = new ol.proj.fromLonLat(p1);
var posicion2 = new ol.proj.fromLonLat(p2);
var posicion3 = new ol.proj.fromLonLat(p3);



/*Se crea una vista para visualizar en el mapa*/
  var vista = new ol.View({
      center: posicion,
      zoom: 12,
    });

/*Creación de capa*/
var capa = new ol.layer.Tile({source: new ol.source.OSM()});
var source = new ol.source.Vector();


/*Creación del Mapa*/

var mapa = new ol.Map({
  target: 'mapa',/*id del elemento HMTL*/
  layers: [capa],
  view: vista,
  projection: new ol.proj.Projection("EPSG:900913"),
  displayProjection: new ol.proj.Projection("EPSG:4326"),
});



/*Se crea el punto para identificar la posicion de lonLat*/
  var a = new ol.geom.Point(posicion);
  var b = new ol.geom.Point(posicion2);
  var c = new ol.geom.Point(posicion3);



/*aqui empezaremos a experimentar*/

   var vectorCapa1 = new ol.layer.Vector({
       source: new ol.source.Vector({
         features: [new ol.Feature(a)],
       }),
       style: new ol.style.Style({
         image: new ol.style.Circle({
           radius:9,
           fill: new ol.style.Fill({
             color: [255,0,0,0.5]
           })
         })
       }),
   });
   var vectorCapa2 = new ol.layer.Vector({
       source: new ol.source.Vector({
         features: [new ol.Feature(b)],

       }),
       style: new ol.style.Style({
         image: new ol.style.Circle({
           radius:9,
           fill: new ol.style.Fill({
             color: [0,60,120,0.6]
           })
         })
       })
   });

   var vectorCapa3 = new ol.layer.Vector({
       source: new ol.source.Vector({
         features: [new ol.Feature(c)],

       }),
       style: new ol.style.Style({
         image: new ol.style.Circle({
           radius:4,
           fill: new ol.style.Fill({
             color: [110,0,20,0.5]
           })
         })
       })
   });

/*experimento*/

var points = [p1,p2];


for (var i = 0; i < points.length; i++) {
    points[i] = ol.proj.transform(points[i], 'EPSG:4326', 'EPSG:3857');

}

var featureLine = new ol.Feature({
    geometry: new ol.geom.LineString(points)

});

var vectorLine = new ol.source.Vector({});
vectorLine.addFeature(featureLine);

var vectorLineLayer = new ol.layer.Vector({
    source: vectorLine,
    style: new ol.style.Style({
        fill: new ol.style.Fill({ color: '#0a43c5', weight: 4 }),
        stroke: new ol.style.Stroke({ color: '#0a43c5', width: 5 })
    })
});

mapa.addLayer(vectorLineLayer);

/*experimento #1*/
/*otro experimento*/
      var lonlat = ol.proj.fromLonLat(p2);
      var location2 = ol.proj.fromLonLat(p3);
      var linie2style = [
				// linestring
				new ol.style.Style({
				  stroke: new ol.style.Stroke({
					color: '#d12710',
					width: 2
				  })
				})
			  ];

			var linie2 = new ol.layer.Vector({
					source: new ol.source.Vector({
					features: [new ol.Feature({
						geometry: new ol.geom.LineString([lonlat, location2]),
						name: 'Line',
					})]
				})
			});

		//	linie2.setStyle(linie2style);//se aplica el estilo al vector
			mapa.addLayer(linie2);

/*experimento #2*/



/*no funciona no se por que
https://stackoverflow.com/questions/51301657/draw-a-line-between-two-coordinates-in-openlayers-4
https://jsfiddle.net/jdrucvqg/
*/
mapa.addLayer(vectorCapa1);
mapa.addLayer(vectorCapa2);
mapa.addLayer(vectorCapa3);




  </script>
</html>
