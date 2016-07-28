
                            var map = null;
                            var latsgn = 1;
                            var lgsgn = 1;
                            var marker = null;
                            var posset = 0;
                            var ls = '';
                            var lm = '';
                            var ld = '';
                            var lgs = '';
                            var lgm = '';
                            var lgd = '';
                            var mrks = {mvcMarkers: new google.maps.MVCArray()};
                            var iw;
                            var drag = false;
                            
var geocoder;





function codeLatLng() {
     geocoder = new google.maps.Geocoder();
  //var input = document.getElementById('latlng').value;
 

  
  var lat = document.getElementById("latbox").value;
  var lng = document.getElementById("lonbox").value;
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        
        infowindow.setContent(results[1].formatted_address);
        infowindow.open(map, marker);
       
       var address = results[1].formatted_address
       
        document.getElementById('address').value=address;
      } else {
        alert('No results found');
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
  });
  
  
  
}
















                              
                               function xz() {
                                   
                            var lati1 =document.getElementById("latbox").value;
                             var long1 =document.getElementById("lonbox").value;
                           
                                
                                ll = new google.maps.LatLng(lati1, long1);
                                zoom = 2;
                                var mO = {
                                    scaleControl: true,
                                    zoom: zoom,
                                    zoomControl: true,
                                    zoomControlOptions: {style: google.maps.ZoomControlStyle.LARGE},
                                    center: ll,
                                    disableDoubleClickZoom: true,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                map = new google.maps.Map(document.getElementById("map"), mO);
                                map.setTilt(0);
                                map.panTo(ll);
                                marker = new google.maps.Marker({position: ll, map: map, draggable: true, title: 'Marker is Draggable'});

                                google.maps.event.addListener(marker, 'click', function(mll) {
                                    gC(mll.latLng);
                                    var html = "<div style='color:#000;background-color:#fff;padding:5px;width:150px;'><p>Latitude - Longitude:<br />" + String(mll.latLng.toUrlValue()) + "<br /><br />Lat: " + ls + "&#176; " + lm + "&#39; " + ld + "&#34;<br />Long: " + lgs + "&#176; " + lgm + "&#39; " + lgd + "&#34;</p></div>";
                                    iw = new google.maps.InfoWindow({content: html});
                                    iw.open(map, marker);
                                });
                                google.maps.event.addListener(marker, 'dragstart', function() {
                                    if (iw) {
                                        iw.close();
                                    }
                                });

                                google.maps.event.addListener(marker, 'dragend', function(event) {
                                    posset = 1;
                                    if (map.getZoom() < 10) {
                                        map.setZoom(10);
                                    }
                                    map.setCenter(event.latLng);
                                    computepos(event.latLng);
                                    drag = true;
                                    setTimeout(function() {
                                        drag = false;
                                    }, 250);
                                });

                                google.maps.event.addListener(map, 'click', function(event) {
                                    if (drag) {
                                        return;
                                    }
                                    posset = 1;
                                    fc(event.latLng);
                                    if (map.getZoom() < 10) {
                                        map.setZoom(10);
                                    }
                                    map.panTo(event.latLng);
                                    computepos(event.latLng);
                                });

                            }
                             function xyz() {
                                   
                             var lati1 =document.getElementById("latbox").value;
                             var long1 =document.getElementById("lonbox").value;
                           
                               if(lati1=='')
                               {
                                   lati1=22.301803;
                                   long1=70.800018;
                               }
                                ll = new google.maps.LatLng(lati1,long1);
                                
                                zoom = 4;
                                var mO = {
                                    scaleControl: true,
                                    zoom: zoom,
                                    zoomControl: true,
                                    zoomControlOptions: {style: google.maps.ZoomControlStyle.LARGE},
                                    center: ll,
                                    disableDoubleClickZoom: true,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                map = new google.maps.Map(document.getElementById("map"), mO);
                                map.setTilt(0);
                                map.panTo(ll);
                                marker = new google.maps.Marker({position: ll, map: map, draggable: true, title: 'Marker is Draggable'});

                                google.maps.event.addListener(marker, 'click', function(mll) {
                                    gC(mll.latLng);
                                    var html = "<div style='color:#000;background-color:#fff;padding:5px;width:150px;'><p>Latitude - Longitude:<br />" + String(mll.latLng.toUrlValue()) + "<br /><br />Lat: " + ls + "&#176; " + lm + "&#39; " + ld + "&#34;<br />Long: " + lgs + "&#176; " + lgm + "&#39; " + lgd + "&#34;</p></div>";
                                    iw = new google.maps.InfoWindow({content: html});
                                    iw.open(map, marker);
                                });
                                google.maps.event.addListener(marker, 'dragstart', function() {
                                    if (iw) {
                                        iw.close();
                                    }
                                });

                                google.maps.event.addListener(marker, 'dragend', function(event) {
                                    posset = 1;
                                    if (map.getZoom() < 10) {
                                        map.setZoom(10);
                                    }
                                    map.setCenter(event.latLng);
                                    computepos(event.latLng);
                                    drag = true;
                                    setTimeout(function() {
                                        drag = false;
                                    }, 250);
                                });

                                google.maps.event.addListener(map, 'click', function(event) {
                                    if (drag) {
                                        return;
                                    }
                                    posset = 1;
                                    fc(event.latLng);
                                    if (map.getZoom() < 10) {
                                        map.setZoom(10);
                                    }
                                    map.panTo(event.latLng);
                                    computepos(event.latLng);
                                    
                                });

                            }

                            function computepos(point)
                            {
                                
                                var latA = Math.abs(Math.round(point.lat() * 1000000.));
                                var lonA = Math.abs(Math.round(point.lng() * 1000000.));
                                if (point.lat() < 0)
                                {
                                    var ls = '-' + Math.floor((latA / 1000000)).toString();
                                }
                                else
                                {
                                    var ls = Math.floor((latA / 1000000)).toString();
                                }
                                var lm = Math.floor(((latA / 1000000) - Math.floor(latA / 1000000)) * 60).toString();
                                var ld = (Math.floor(((((latA / 1000000) - Math.floor(latA / 1000000)) * 60) - Math.floor(((latA / 1000000) - Math.floor(latA / 1000000)) * 60)) * 100000) * 60 / 100000).toString();
                                if (point.lng() < 0)
                                {
                                    var lgs = '-' + Math.floor((lonA / 1000000)).toString();
                                }
                                else
                                {
                                    var lgs = Math.floor((lonA / 1000000)).toString();
                                }
                                var lgm = Math.floor(((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60).toString();
                                var lgd = (Math.floor(((((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60) - Math.floor(((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60)) * 100000) * 60 / 100000).toString();
                                document.getElementById("latbox").value = point.lat().toFixed(6);
                                document.getElementById("latbox1").value = point.lat().toFixed(6);
                                document.getElementById("latboxm").value = ls;
                                document.getElementById("latboxmd").value = lm;
                                document.getElementById("latboxms").value = ld;
                                document.getElementById("lonbox").value = point.lng().toFixed(6);
                                document.getElementById("lonbox1").value = point.lng().toFixed(6);
                                document.getElementById("lonboxm").value = lgs;
                                document.getElementById("lonboxmd").value = lgm;
                                document.getElementById("lonboxms").value = lgd;
                                
                                codeLatLng();
                                
                            }

                            function showAddress(address) {
                               
                                var geocoder = new google.maps.Geocoder();
                                geocoder.geocode({'address': address}, function(results, status) {
                                     
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        map.setCenter(results[0].geometry.location);
                                        map.setMapTypeId(google.maps.MapTypeId.HYBRID);
                                        if (map.getZoom() < 16) {
                                            map.setZoom(16);
                                        } else {
                                        }
                                        marker.setPosition(results[0].geometry.location);
                                        posset = 1;
                                        computepos(results[0].geometry.location);
                                    } else {
                                        alert("Geocode was not successful for the following reason: " + status);
                                    }
                                });
                            }
                            
                            
                                 
                            

                            function showLatLong(latitude, longitude) {
                                if (isNaN(latitude)) {
                                    alert(' Latitude must be a number. e.g. Use +/- instead of N/S');
                                    return false;
                                }
                                if (isNaN(longitude)) {
                                    alert(' Longitude must be a number.  e.g. Use +/- instead of E/W');
                                    return false;
                                }

                                latitude1 = Math.abs(Math.round(latitude * 1000000.));
                                if (latitude1 > (90 * 1000000)) {
                                    alert(' Latitude must be between -90 to 90. ');
                                    document.getElementById("latbox1").value = '';
                                    return;
                                }
                                longitude1 = Math.abs(Math.round(longitude * 1000000.));
                                if (longitude1 > (180 * 1000000)) {
                                    alert(' Longitude must be between -180 to 180. ');
                                    document.getElementById("lonbox1").value = '';
                                    return;
                                }

                                var point = new google.maps.LatLng(latitude, longitude);
                                posset = 1;
                                if (map.getZoom() < 7) {
                                    map.setZoom(7);
                                } else {
                                }
                                map.setMapTypeId(google.maps.MapTypeId.HYBRID);
                                map.setCenter(point);
                                fc(point);
                                computepos(point);
                            }


                            function streetview()
                            {
                                if (posset == 0)
                                {
                                    alert("Position Not Set.  Please click on the spot on the map to set the street view point.");
                                    return;
                                }

                                var point = map.getCenter();
                                var t1 = String(point);
                                t1 = t1.replace(/[() ]+/g, "");
                                var str = "http://www.satelliteview.co/?e=" + t1 + ":0:Latitude-Longitude Point:sv:0";
                                var popup = window.open(str, "llwindow");
                                popup.focus();
                            }

                            function googleearth()
                            {
                                if (posset == 0)
                                {
                                    alert("Position Not Set.  Please click on the spot on the map to set the Google Earth map point.");
                                    return;
                                }
                                var point = map.getCenter();
                                var gearth_str = "/?r=googleearth&mt=Latitude-Longitude Point&ml=" + point.lat() + "&mg=" + point.lng();
                                var popup = window.open(gearth_str, "llwindow");
                                popup.focus();
                            }




                            function getaddress()
                            {
                                if (posset == 0)
                                {
                                    alert("Position Not Set.  Please click on the spot on the map to set the get address map point.");
                                    return;
                                }
                                var point = map.getCenter();
                                var t1 = String(point);
                                t1 = t1.replace(/[() ]+/g, "");
                                var getaddr_str = "http://www.satelliteview.co/?e=" + t1 + ":0:Latitude-Longitude Point:map:0";
                                var popup = window.open(getaddr_str, "llwindow");
                                popup.focus();
                            }
                            function initialize() {
                           ;
                                var latlng = new google.maps.LatLng(22.22, 77.910965);
                                var myOptions = {
                                    zoom: 1,
                                    center: latlng,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                }
                                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                               
                            }

                            function fc(point)
                            {
                                gC(point);
                                var html = "<div style='color:#000;background-color:#fff;padding:3px;width:150px;'><p>Latitude - Longitude:<br />" + String(point.toUrlValue()) + "<br /><br />Lat: " + ls + "&#176; " + lm + "&#39; " + ld + "&#34;<br />Long: " + lgs + "&#176; " + lgm + "&#39; " + lgd + "&#34;</p></div>";
                                var iw = new google.maps.InfoWindow({content: html});
                                var marker = new google.maps.Marker({position: point, map: map, icon: '/i/blue-dot.png', draggable: true});
                                mrks.mvcMarkers.push(marker);
                                google.maps.event.addListener(marker, 'click', function(event) {
                                    gC(event.latLng);
                                    var html = "<div style='color:#000;background-color:#fff;padding:3px;width:150px;'><p>Latitude - Longitude:<br />" + String(event.latLng.toUrlValue()) + "<br /><br />Lat: " + ls + "&#176; " + lm + "&#39; " + ld + "&#34;<br />Long: " + lgs + "&#176; " + lgm + "&#39; " + lgd + "&#34;</p></div>";
                                    var iw = new google.maps.InfoWindow({content: html});
                                    iw.open(map, marker);
                                    computepos(event.latLng);
                                });
                            }




                            var map;
                            var global_markers = [];
                            var markers = [[22.09024, 70.712891, 'trialhead0']];

                            var infowindow = new google.maps.InfoWindow({});

                            function initialize1() {
                           
                            var lati1 =document.getElementById("latbox").value;
                             var long1 =document.getElementById("lonbox").value;
                           
                           
                                geocoder = new google.maps.Geocoder();
                                var latlng = new google.maps.LatLng(lati1,long1);
                                
                                
                                
                                alert("f");
                                alert(latlng);
                             
                                var myOptions = {
                                    zoom: 1,
                                    center: latlng,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                }
                                map = new google.maps.Map(document.getElementById("map"), myOptions);
                                addMarker();
                            }
                            
                           


                            function addMarker() {
                               
                                for (var i = 0; i < markers.length; i++) {
                                    // obtain the attribues of each marker
                                    var lat = parseFloat(markers[i][0]);
                                    var lng = parseFloat(markers[i][1]);
                                    var trailhead_name = markers[i][2];

                                    var myLatlng = new google.maps.LatLng(lat, lng);

                                    var contentString = "<html><body><div><p><h2>" + trailhead_name + "</h2></p></div></body></html>";

                                    var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        map: map,
                                        title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name
                                    });

                                    marker['infowindow'] = contentString;

                                    global_markers[i] = marker;

                                    google.maps.event.addListener(global_markers[i], 'click', function() {
                                        infowindow.setContent(this['infowindow']);
                                        infowindow.open(map, this);
                                    });
                                }
                            }


                        