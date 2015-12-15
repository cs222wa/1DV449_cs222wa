var TrafficMap = {
    map: {},
    myIcon: {},
    messages: undefined,
    date: undefined,
    json: undefined,
    markers : [],
    url: "response.json",
    init:function(){
        TrafficMap.map = L.map( 'map', {
            center: [20.0, 5.0],
            minZoom: 2,
            zoom: 2
        });
        L.tileLayer( 'http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright" title="OpenStreetMap" target="_blank">OpenStreetMap</a> contributors | Tiles Courtesy of <a href="http://www.mapquest.com/" title="MapQuest" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" width="16" height="16">',
            subdomains: ['otile1','otile2','otile3','otile4']
        }).addTo( TrafficMap.map );
        var myURL = jQuery( 'script[src$="leaf-demo.js"]' ).attr( 'src' ).replace( 'leaf-demo.js', '' );
        TrafficMap.myIcon = L.icon({
            iconUrl: myURL + 'images/pin24.png',
            iconRetinaUrl: myURL + 'images/pin48.png',
            iconSize: [29, 24],
            iconAnchor: [9, 21],
            popupAnchor: [0, -14]
        });
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (xhr.readyState === 4 && xhr.status === 200){
                TrafficMap.json = JSON.parse(xhr.responseText);
            }
        };
        xhr.open("GET", TrafficMap.url, false);
        xhr.send(null);
        TrafficMap.getMarkers();
    },

    getMarkers: function (){
        TrafficMap.messages = TrafficMap.json["messages"];

        TrafficMap.messages = TrafficMap.messages.sort(TrafficMap.sortByDate);
        for ( var i=0; i < TrafficMap.messages.length; ++i )
        {
            TrafficMap.date = new Date(parseInt(TrafficMap.messages[i].createddate.substr(6)));
            var marker = L.marker( [TrafficMap.messages[i].latitude, TrafficMap.messages[i].longitude] , {icon: TrafficMap.myIcon} )
                .bindPopup( TrafficMap.getDate() + TrafficMap.messages[i].title + ", " + TrafficMap.messages[i].subcategory + " " + TrafficMap.messages[i].exactlocation )
                .addTo( TrafficMap.map );
            TrafficMap.markers.push(marker);
        }
        TrafficMap.getList(TrafficMap.messages);
    },

    getDate:function(){
        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        Date.prototype.getDayName = function() {
            return days[ TrafficMap.date.getDay() ];
        };
        var day = TrafficMap.date.getDayName().toString();
        var yyyy = TrafficMap.date.getFullYear().toString();
        var mm = (TrafficMap.date.getMonth()+1).toString(); // getMonth() is zero-based
        var dd  = TrafficMap.date.getDate().toString();
        var hh = TrafficMap.date.getHours().toString();
        var mn = TrafficMap.date.getMinutes().toString();

        return day + " " + yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]) + " " + hh + ':' + mn+ " ";
    },

    getList:function(messageArray){

        var listContainer = document.createElement("div");
        listContainer.setAttribute("class", "markerList");

        //create drop down list

        document.getElementsByTagName("body")[0].appendChild(listContainer);
        var listUl = document.createElement("ul");
        listContainer.appendChild(listUl);
        for( var i =  0 ; i < messageArray.length ; ++i){
            var listMessage = document.createElement("li");
            var listLink = document.createElement("a");
            listLink.innerHTML = messageArray[i].title + ", " + messageArray[i].exactlocation;
            listLink.setAttribute("href", "#");
            listLink.setAttribute("value", messageArray[i].latitude + ", " + messageArray[i].longitude );
            //listLink.setAttribute("data-id", messageArray[i].id);
            listLink.addEventListener("click", function(){TrafficMap.activateMarker(this);});
            listMessage.appendChild(listLink);
            listUl.appendChild(listMessage);
        }
        //fix category-links (drop down?)
        //add onclick event on the category links
        //when clicked, list the category clicked first and then add remaining categories
    },

    sortByDate: function(a,b) {
        if (a['createddate'] < b['createddate'])
            return 1;
        if (a['createddate'] > b['createddate'])
            return -1;
        return 0;
    },

    activateMarker:function(link){
        var value = link.getAttribute("value");
        value = value.split(", ", 2);
        var lat = value[0];
        var lng = value[1];
        for( var i =  0 ; i < TrafficMap.markers.length ; ++i)
        {
            if(TrafficMap.markers[i].getLatLng()['lat']== lat && TrafficMap.markers[i].getLatLng()['lng']== lng){
                TrafficMap.markers[i].openPopup();
            }

        }
    }
};
window.onload = TrafficMap.init;
