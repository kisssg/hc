var Distance = {
    url : "https://restapi.amap.com/v3/distance",
    key : "e13eeb025bd7aea5d98d892806ede356",
    type : 1,
    fetchStartPoints : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }

        if ($("#startPointCount").text() == '') {
            $('#info').prepend('Start fetching start points for <strong>' + visitDate + '</strong> -' + d.toLocaleString() + ' <br/>');
            $("#info").prepend('Sections of start points fetching completed:<span id="startPointCount">0</span> <br/>');
        }
        var url = 'fetchStartPoints/' + visitDate + '?t=' + Math.random();
        var noResponse = "noResponse";
        $.ajax({
            async : false,
            'url' : url,
            'success' : function (data) {
                noResponse = "hasResponse";
                if (data.result == 'unDone') {
                    $("#startPointCount").text(Number($("#startPointCount").text()) + 1);
                    return Distance.fetchStartPoints();// when start points not all done, re-fetch.
                } else if (data.result == 'allDone') {
                    $('#info').prepend('Start points of ' + visitDate + ' all done! -' + d.toLocaleString() + '<br/>');
                    return Distance.calc();// when start points all fetched, start distance calculation
                }
            },
            'type' : 'POST',
            'dataType' : 'json'
        });
        console.log(noResponse);
        // only if ajax not success, noResponse will remain 'noResponse'.
        if (noResponse == "noResponse") {
            return Distance.fetchStartPoints();
        }
    },
    clearStartPoints : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        var url = 'clearStartPoints/' + visitDate + '?t=' + Math.random();
        $("#info").prepend('Start clearing...-' + d.toLocaleString() + '<br/>');
        $.post(url, '', function (data) {
            result = JSON.parse(data);
            if (result.result == 'success') {
                $("#info").prepend('Start points of <strong>' + visitDate + '</strong> cleared. -' + d.toLocaleString() + '<br/>');
            } else {
                $("#info").prepend('Error');
            }
        })

    },
    calc : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        if ($("#calculated").text() == '') {
            $("#info").prepend('Distance calculation started.  -' + d.toLocaleString() + '<br/>');
            $("#info").prepend('Distance calculated:<span id="calculated">0</span> <br/>');
        }
        locations = this.fetchLocations(visitDate);
        if (locations == 'noResponse') {
            this.calc();
        }
        count = locations.length;
        for (i = 0; i < count; i++) {
            var origins = locations[i].lon_from + ',' + locations[i].lat_from;
            var destination = locations[i].lon + ',' + locations[i].lat;
            args = {
                "key" : this.key,
                "type" : this.type,
                "origins" : origins,
                "destination" : destination
            }
            var distance, duration;
            $.ajax({
                url : this.url,
                async : false,
                type : 'POST',
                data : args,
                success : function (data) {
                    distance = data.results[0].distance;
                    duration = data.results[0].duration;
                },
                dataType : 'json'
            })
            this.upload(locations[i].j_id, distance, duration);
            $("#calculated").text(Number($("#calculated").text()) + 1);
        }
        // if there are still journals there, do another round of calculation
        if (count == 100) {
            this.calc();
            return;
        }
        $("#info").prepend("Mileage calculation done for " + visitDate + "  -" + d.toLocaleString() + "<br/>")
    },
    clearCalc : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        cf = confirm('Are you sure to clear all distances of ' + visitDate + '?');
        if (cf) {
            url = 'clearDistance?t=' + Math.random();
            args = {
                "visitDate" : visitDate
            }
            $.post(url, args, function (data) {
                $('#info').prepend(data.result);
            }, 'json')
        }
    },
    fetchLocations : function (visitDate) {
        if (visitDate == undefined) {
            return false;
        }
        url = 'fetchLocations/' + visitDate + '?t=' + Math.random();
        var resultSets = 'noResponse';
        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'visitDate' : visitDate
            },
            async : false,
            dataType : 'json',
            success : function (data) {
                resultSets = data;
            }
        })
        return resultSets;
    },
    upload : function (j_id, distance, duration) {
        if (j_id == undefined || distance == undefined || duration == undefined) {
            return false;
        }
        url = 'uploadDistance?t=' + Math.random();
        args = {
            "j_id" : j_id,
            "distance" : distance,
            "duration" : duration
        }
        var result = false;
        $.ajax({
            type : 'POST',
            url : url,
            async : false,
            data : args,
            success : function (data) {
                result = data.result;
            },
            dataType : 'json'
        });
        return result;
    },
    createHomeLog : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        if ($("#homeLogCount").text() == '') {
            $('#info').prepend('Start creating homeLogs for <strong>' + visitDate + '</strong> -' + d.toLocaleString() + ' <br/>');
            $("#info").prepend('Sections of homeLog created:<span id="homeLogCount">0</span> <br/>');
        }
        url = 'createHomeLog/' + visitDate + '?t=' + Math.random();
        //console.log(url);
        var noResponse = "noResponse";
        $.ajax({
            async : false,
            'url' : url,
            'success' : function (data) {
                noResponse = "hasResponse";
                if (data.result == 'unDone') {
                    $("#homeLogCount").text(Number($("#homeLogCount").text()) + 1);
                    return Distance.createHomeLog();// when homeLogs not all created, re-do.
                } else if (data.result == 'allDone') {
                    $('#info').prepend('HomeLogs of ' + visitDate + ' all created! -' + d.toLocaleString() + '<br/>');
                    return Distance.fetchStartPoints();// when homeLogs all created, start fetching start points.
                } else {
                    $('#info').prepend("Error occured,re-try:" + data.msg + ' -' + d.toLocaleString() + '<br/>');
                    return Distance.createHomeLog();
                }
            },
            'type' : 'POST',
            'dataType' : 'json'
        });
        console.log(noResponse);
        // only if ajax not success, noResponse will remain 'noResponse'.     
        if (noResponse == "noResponse") {
            return Distance.createHomeLog();
        }
    },
    delHomeLog : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').prepend('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        url='delHomeLog/'+visitDate+'?t='+ Math.random();
        
        $.post(url,'',function(data){
            alert(data.result);
        },'json')
    },
    clearInfo : function () {
        $("#info").text('');
    }

}