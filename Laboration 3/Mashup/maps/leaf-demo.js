var TrafficMap = {
    unsortedMessages: undefined,
    messages: undefined,
    date: undefined,
    json: undefined,
    markers : {},
    url: "response.json",
    init:function(){
        var map = L.map( 'map', {
            center: [20.0, 5.0],
            minZoom: 2,
            zoom: 2
        });
        L.tileLayer( 'http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright" title="OpenStreetMap" target="_blank">OpenStreetMap</a> contributors | Tiles Courtesy of <a href="http://www.mapquest.com/" title="MapQuest" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" width="16" height="16">',
            subdomains: ['otile1','otile2','otile3','otile4']
        }).addTo( map );

        var myURL = jQuery( 'script[src$="leaf-demo.js"]' ).attr( 'src' ).replace( 'leaf-demo.js', '' );
        var myIcon = L.icon({
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
                TrafficMap.unsortedMessages = TrafficMap.json["messages"];
                TrafficMap.messages = TrafficMap.unsortedMessages.sort(TrafficMap.sortByDate);
                for ( var i=0; i < TrafficMap.messages.length; ++i )
                {
                    TrafficMap.date = new Date(parseInt(TrafficMap.messages[i].createddate.substr(6)));
                    var marker = L.marker( [TrafficMap.messages[i].latitude, TrafficMap.messages[i].longitude], {icon: myIcon} )
                        .bindPopup( TrafficMap.getDate() + TrafficMap.messages[i].title + ", " + TrafficMap.messages[i].subcategory + " " + TrafficMap.messages[i].exactlocation )
                        .addTo( map );
                    TrafficMap.markers[TrafficMap.messages[i]["id"]] = marker;
                }
                TrafficMap.getList(TrafficMap.messages);
            }
        };
        xhr.open("GET", TrafficMap.url, true);
        xhr.send(null);
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
        document.getElementsByTagName("body")[0].appendChild(listContainer);
        var listUl = document.createElement("ul");
        listContainer.appendChild(listUl);

        for( var i =  0 ; i < messageArray.length ; ++i){
            var listMessage = document.createElement("li");
            var listLink = document.createElement("a");
            listLink.innerHTML = messageArray[i].title + ", " + messageArray[i].exactlocation;
            listLink.setAttribute("href", "#");
            listLink.setAttribute("data-id", messageArray[i].id);
            listLink.addEventListener("click", function(){TrafficMap.activateMarker(this);});
            listMessage.appendChild(listLink);
            listUl.appendChild(listMessage);
        }

        //fix category-link

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

    activateMarker:function(identifier){

        var dataId = identifier.getAttribute("data-id");
        //TrafficMap.messages[dataId].openPopup();

        console.log(TrafficMap.messages);
        console.log(dataId);


        //getPopup
        //get popup properties

        //console.log(TrafficMap.markers);


        //console.log(identifier.getAttribute("data-id"));

       /* for ( var i=0; i < TrafficMap.markers.length; ++i )
        {
            var e = TrafficMap.markers[i]._isOpen;
            console.log(e);
        }
*/


        //console.log(messageId);
        //Check which link is clicked and then open that specific marker on the map
        //L.marker.openPopup()?
    }


};
window.onload = TrafficMap.init;
