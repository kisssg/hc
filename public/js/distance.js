var Distance = {
    url : "https://restapi.amap.com/v3/distance",
    key : "e13eeb025bd7aea5d98d892806ede356",
    type : 1,
    fetchStartPoints : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').append('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        var url = 'fetchStartPoints/' + visitDate + '?t=' + Math.random();
        $('#info').append('Start fetching start points for <strong>' + visitDate + '</strong> -' + d.toLocaleString() + ' <br/>');
        $.post(url, '', function (data) {
            result = JSON.parse(data);
            if (result.result == 'unDone') {
                $('#info').append('Section done...doing another section...pls wait until all done! -' + d.toLocaleString() + '<br/>');
                return Distance.fetchStartPoints();
            } else if (result.result == 'allDone') {
                $('#info').append('All done!<br/>');
            }
        });
    },
    clearStartPoints : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').append('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        var url = 'clearStartPoints/' + visitDate + '?t=' + Math.random();
        $("#info").append('Start clearing...<br/>');
        $.post(url, '', function (data) {
            result = JSON.parse(data);
            if (result.result == 'success') {
                $("#info").append('Start points of <strong>' + visitDate + '</strong> cleared. -' + d.toLocaleString() + '<br/>');
            } else {
                $("#info").append('Error');
            }
        })

    },
    calc : function () {
        visitDate = $("#visitDate").val();
        var d = new Date();
        if (visitDate == '') {
            $('#info').append('Visit Date can\'t be blank<br/>');
            $('#visitDate').focus();
            return;
        }
        locations = this.fetchLocations(visitDate);
        count = locations.length;
        if(count==0){
            $("#info").append("Mileage calculation done for " + visitDate + "  -" +d.toLocaleString() + "<br/>")
        }
        for (i = 0; i < count; i++) {      
            var origins = locations[i].lon_from + ',' + locations[i].lat_from;
            var destination = locations[i].lon + ',' + locations[i].lat;
            args = {
                "key" : this.key,
                "type" : this.type,
                "origins" : origins,
                "destination" : destination
            }
            var distance,duration;
            $.ajax({
                url : this.url,
                async : false,
                type : 'POST',
                data : args,
                success : function (data) {
                    distance=data.results[0].distance;
                    duration=data.results[0].duration;
                },
                dataType : 'json'
            })
            this.upload(locations[i].j_id,distance,duration);
        }
        //if there are still journals there, do another calculation round
        if(count==100){
            this.calc();
        }
    },
    clearCalc : function () {
        alert(this.upload(95230,1,2));
    },
    fetchLocations : function (visitDate) {
        if (visitDate == undefined) {
            return false;
        }
        url = 'fetchLocations/' + visitDate + '?t=' + Math.random();
        var resultSets = false;
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
    clearInfo : function () {
        $("#info").text('');
    }

}