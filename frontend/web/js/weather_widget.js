try {
    console.log(jQuery)
} catch (t) {
    var script = document.createElement("script");
    script.src = "https://code.jquery.com/jquery-1.11.0.min.js", script.type = "text/javascript", document.getElementsByTagName("head")[0].appendChild(script)
}
var o = document.getElementById("Oplao"), url = 'https://oplao.com'/*document.getElementById("weather_widget").src.split('/js')[0]*/, c = document.createElement("link"),
    dataTemp = o.getAttribute("data-t"), u = o.getAttribute("data-wg"), l = o.getAttribute("data-l"),
    wd = o.getAttribute("data-wd"), hg = o.getAttribute("data-hg"), dataHtml = url + "/en/wid/" + u + ".html",
    t = "F" == dataTemp ? "F" : "C", p = o.getAttribute("data-p"), w = o.getAttribute("data-w"), fV, cl,
    n = o.getAttribute("class").split(" ")[0], r = o.getAttribute("class").split(" ")[1];

function LoadInformer(e) {
    var i = e.hours <= 6 || e.hours >= 18 ? "night" : "day";
    jQuery.ajax({
        url: dataHtml, crossOrigin: !0, complete: function (a) {
            var s = jQuery("#Oplao");
            if (s.attr("class", "wg_choice_wrap"), s.html(a.responseText), s.find("img").each(function () {
                jQuery(this).attr("src", url + "/" + jQuery(this).attr("src"))
            }), s.find(".wg_respons_box2").css({
                width: wd,
                height: hg
            }), s.find(".wg_response_wrap2").attr("class", "wg_response_wrap wg_width_" + n + " wg_height_" + r), s.find(".wg_title") && s.find(".wg_title").html(e.city), s.find(".wg_weather_img") && (s.find(".wg_weather_img").attr("src", url + "/svg/wicons_svg/" + e.weatherIconCode + "_" + i + ".svg"), s.find(".wg_weather_img").css({height: "auto!important"})), s.find(".wg_temp") && s.find(".wg_temp").html("<span>" + ("F" == t ? e.temp_f : e.temp_c) + "</span><sup> " + t + "</sup>"), s.find(".wg_temp_feels") && (s.find(".wg_feels .title").html(e.feelsLikeName), s.find(".wg_temp_feels").html("<span>" + ("F" == t ? e.feelsLikeF : e.feelsLikeC) + "</span><sup>" + t + "</sup>")), s.find(".wg_pressure")) {
                s.find(".wg_pressure .title").html(e.pressureName);
                var d = "hPa" === p ? "hPa" : "in", g = "hPa" === p ? e.pressurehPa : e.pressureInch;
                s.find(".wg_pressure").html("<span>" + g + " " + d + "</span>")
            }
            s.find(".wg_response_wrap").css({'margin-top': '0px'});
            if (s.find(".wg_wind")) {
                s.find(".wind .title").html(e.windName);
                var h = "m/s" === w ? "m/s" : "mph", m = "m/s" === w ? e.windMs : e.windMph;
                s.find(".wg_wind").html('<img class="wind_icon" src="' + url + '/img/widget/wg_wind.png" style="-ms-transform: rotate(' + (e.windDegree + 20) + "deg); -webkit-transform: rotate(" + (e.windDegree + 20) + "deg);transform: rotate(" + (e.windDegree + 20) + 'deg);" alt=""><span> ' + m + " " + h + "</span>")
            }
            if (s.find("dayThreeDays")) {
                s.find(".wg_date").html(e.date), s.find(".wg_day").html(e.day);
                for (var _ = 1, f = 0; f <= 2; _++, f++) s.find(".wg_date" + _).html(e.threeDays[f].date), s.find(".wg_day" + _).html(e.threeDays[f].day), s.find(".wg_weather_img" + _).attr("src", url + "/svg/wicons_svg/" + e.threeDays[f].icon + "_" + i + ".svg"), s.find(".wg_temp" + _).html("<span>" + ("F" == t ? e.threeDays[f].temp_f : e.threeDays[f].temp_c) + "</span><sup> " + t + "</sup>")
            }


            if (s.find(".wg_wind_title") && s.find(".wg_wind_title").html(e.windName), s.find(".wg_pressure_title") && s.find(".wg_pressure_title").html(e.pressureName), s.find(".wg_feel_title") && s.find(".wg_feel_title").html(e.feelsLikeName), s.find(".wg_gust") && s.find(".wg_gust").find(".wg_title").html(e.pressureName), s.find(".wg_bottom").html('<a href="' + url + "/" + l + "/weather/outlook/" + e.location + '"><span>Oplao</span></a>'), s.find(".widget_4") || s.find(".widget_9")) for (s.find(".wg_date") && s.find(".wg_date").html(e.date), s.find(".wg_time") && s.find(".wg_time").html(e.time), _ = 1, f = 0; f <= 3; _++, f++) s.find(".wg_item_title" + _).html(e.wholeDay[f].name), s.find(".img" + _).attr("src", url + "/svg/wicons_svg/" + e.wholeDay[f].icon + "_" + i + ".svg"), s.find(".temp" + _).html("<span>" + ("F" == t ? e.wholeDay[f].temp_f : e.wholeDay[f].temp_c) + "</span><sup> " + t + "</sup>");
            var c = Object.keys(e.urls[0]), y = Object.keys(e.urls[1]), v = e.urls[0]["name" === c[0] ? c[1] : c[0]],
                b = e.urls[1]["name" === y[0] ? y[1] : y[0]], D = e.urls[0]["name" === c[0] ? c[0] : c[1]],
                k = e.urls[1]["name" === y[0] ? y[0] : y[1]];
            if ("widget_9" === u ? (s.find(".wg_bottom_wrap .wg_links:nth-child(1) a").attr("href", url + "/" + l + "/" + v), s.find(".wg_bottom_wrap .wg_links:nth-child(1) a").html(D), s.find(".wg_bottom_wrap .wg_links:nth-child(3) a").attr("href", url + "/" + l + "/" + b), s.find(".wg_bottom_wrap .wg_links:nth-child(3) a").html(k)) : (s.find(".wg_links a:nth-child(1)").attr("href", url + "/" + l + "/" + v), s.find(".wg_links a:nth-child(1)").html(D), s.find(".wg_links a:nth-child(2)").attr("href", url + "/" + l + "/" + b), s.find(".wg_links a:nth-child(2)").html(k)), s.find(".widget_6").find(".wg_info_list")) for (var x = 0, A = 1; A <= 3; A++) s.find(".wg_date" + A).html(e.threeDays[x].date), s.find(".wg_day" + A).html(e.threeDays[x].day), s.find(".wg_weather_img" + A).attr("src", url + "/svg/wicons_svg/" + e.threeDays[x].icon + "_" + i + ".svg"), s.find(".wg_temp" + A).html("<span>" + ("F" == t ? e.threeDays[x].temp_f : e.threeDays[x].temp_c) + "</span><sup> " + t + "</sup>"), x++;

            if (o.getAttribute("data-cl")) {

                if (o.getAttribute("data-cl") === 'white') {
                    fV = 'brightness(9)';
                    cl = '#ffffff';
                } else {
                    fV = 'brightness(0)';
                    cl = '#000000';
                }

                jQuery('.widget_3').css({'color': cl + '!important'});
                jQuery('.widget.widget_3 a').css({'color': cl + '!important'});

                jQuery('.widget_3 .wg_weather_img').css('filter', fV)
                    .css('webkitFilter', fV)
                    .css('mozFilter', fV)
                    .css('oFilter', fV)
                    .css('msFilter', fV);
                s.find(".wg_title").attr('href', url + "/" + l + "/weather/outlook/" + e.asciiName.toLowerCase() + "_" + e.countryCode.toLowerCase())
                jQuery('.widget_3 .wg_weather_img').attr('title', e.city + ", " + e.countryCode)
                s.find(".wg_temp") && s.find(".wg_temp").html("<a href='" + url + "/" + l + "/weather/outlook/" + e.asciiName.toLowerCase() + "_" + e.countryCode.toLowerCase() + "' target='_blank' style='color: "+cl+"'>" + ("F" == t ? e.temp_f : e.temp_c) + "<span class=\"wg_span\">" + t + "</span></a>")

            }


            o.style.display = "initial";

            setTimeout(function () {
                request();
            }, 900000)
        }
    })
}
function request(){
    var xhttp = new XMLHttpRequest, params = "city=" + o.getAttribute("data-c") + "&lang=" + l;
    xhttp.onreadystatechange = function () {
        4 == xhttp.readyState && 200 == xhttp.status && LoadInformer(JSON.parse(xhttp.responseText))
    }, xhttp.open("POST", url + "/get_info_widgets?city=" + o.getAttribute("data-c") + "&lang=" + l+"&id_wid="+o.getAttribute("data-id")+"&num_wid="+o.getAttribute("data-wg")), xhttp.send(params);
}
c.setAttribute("rel", "stylesheet"), c.setAttribute("type", "text/css"), c.setAttribute("href", "../css/widget.css"), document.getElementsByTagName("head")[0].appendChild(c);request();
