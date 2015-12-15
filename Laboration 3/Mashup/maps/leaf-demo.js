var TrafficMap = {
    map: {},
    myIcon: {},
    messages: undefined,
    date: undefined,
    json: undefined,
    markers : [],
    categorySelection: "4",
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
        TrafficMap.getMarkers(TrafficMap.categorySelection);
    },

    getMarkers: function (value){
        for( var i=0; i < TrafficMap.markers.length; i++){
            TrafficMap.map.removeLayer(TrafficMap.markers[i]);
        }
        TrafficMap.markers = [];
        TrafficMap.messages = TrafficMap.json["messages"];
        for( var i=0; i < TrafficMap.messages.length; i++){
            if (TrafficMap.messages[i]["category"] == TrafficMap.categorySelection || TrafficMap.categorySelection == 4) {
                TrafficMap.messages = TrafficMap.messages.sort(TrafficMap.sortByDate);
                TrafficMap.date = new Date(parseInt(TrafficMap.messages[i].createddate.substr(6)));
                var marker = L.marker([TrafficMap.messages[i].latitude, TrafficMap.messages[i].longitude], {icon: TrafficMap.myIcon})
                    .bindPopup(TrafficMap.getDate() + TrafficMap.messages[i].title + ", " + TrafficMap.messages[i].subcategory + " " + TrafficMap.messages[i].exactlocation)
                    .addTo(TrafficMap.map);
                TrafficMap.markers.push(marker);
            }
        }
        TrafficMap.getList(TrafficMap.messages, value);
    },

    getDate:function(){
        var days = ['Söndag','Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag'];
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

    getList:function(messageArray, value){

        //remove listContainer element
        var existingList = document.getElementById("List");
        if(existingList){
            existingList.parentNode.removeChild(existingList);
        }
        //create new div
        var listContainer = document.createElement("div");
        listContainer.setAttribute("id", "List");
        //create drop down list
        var button = document.createElement("button");
        button.setAttribute("value", "Välj kategori");
        var frag = document.createDocumentFragment();
        var select = document.createElement("select");
        select.options.add( new Option("Alla Kategorier","4", value == "4", value == "4"));
        select.options.add( new Option("Vägtrafik","0", value == "0", value == "0"));
        select.options.add( new Option("Kollektivtrafik","1", value == "1", value == "1"));
        select.options.add( new Option("Planerad störning","2", value == "2", value == "2"));
        select.options.add( new Option("Övrigt","3", value == "3", value == "3"));
        frag.appendChild(select);
        select.addEventListener("change", function(){
            //this.option[value].prop("selected", true);
           //select.attr('selected', true);
            TrafficMap.getCategory(select.value);
        });
        listContainer.appendChild(frag);
        //create list
        document.getElementsByTagName("body")[0].appendChild(listContainer);
        var listUl = document.createElement("ul");
        listContainer.appendChild(listUl);
        for( var i =  0 ; i < messageArray.length ; ++i){
            if (messageArray[i]["category"] == TrafficMap.categorySelection || TrafficMap.categorySelection == 4) {
                var listMessage = document.createElement("li");
                var listLink = document.createElement("a");
                listLink.innerHTML = messageArray[i].title + ", " + messageArray[i].exactlocation;
                listLink.setAttribute("href", "#");
                listLink.setAttribute("value", messageArray[i].latitude + ", " + messageArray[i].longitude);
                listLink.addEventListener("click", function () {
                    TrafficMap.activateMarker(this);
                });
                listMessage.appendChild(listLink);
                listUl.appendChild(listMessage);
            }
        }
    },

    getCategory: function(value){
        switch(value) {
            case "0":
                TrafficMap.categorySelection = 0;
                console.log("cat 0");
                TrafficMap.getMarkers(value);
                break;
            case "1":
                TrafficMap.categorySelection = 1;
                console.log("cat 1");
                TrafficMap.getMarkers(value);
                break;
            case "2":
                TrafficMap.categorySelection = 2;
                console.log("cat 2");
                TrafficMap.getMarkers(value);
                break;
            case "3":
                TrafficMap.categorySelection = 3;
                console.log("cat 3");
                TrafficMap.getMarkers(value);
                break;
            default:
                TrafficMap.categorySelection = 4;
                console.log("cat 4");
                TrafficMap.getMarkers(value);
        }
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
