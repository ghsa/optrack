// ## -*- coding: utf-8 -*-

/*jslint browser:true, sub:true, white:false */

function save_memory(params) {
    var expires = new Date();
    expires.setTime(expires.getTime() + 30 * 24 * 60 * 60 * 1000);
    // timezone irrelevant
    var sm = "bscalcs=";
    for (var nam in params) {
        if (typeof params[nam] !== "function") {
            sm += nam + ":" + params[nam] + " ";
        }
    }
    sm += "; expires=" + expires.toGMTString() + "; path=/";
    document.cookie = sm;
}


function recover_memory(params) {
    var recovered = 0;
    var ck = document.cookie.split(';');

    for (var f = 0; f < ck.length; ++f) {
        var cv = ck[f].split('=');
        if (cv.length != 2) {
            continue;
        }
        cv[0] = trim(cv[0]);
        cv[1] = trim(cv[1]);
        if (cv[0] != 'bscalcs') {
            continue;
        }
        var sm = cv[1].split(' ');
        for (var e = 0; e < sm.length; ++e) {
            var smpair = sm[e].split(':');
            if (smpair.length == 2) {
                var f = parseFloat(smpair[1]);
                if (!isNaN(f)) {
                    params[smpair[0]] = f;
                    recovered = 1;
                }
            }
        }
    }
    return recovered;
}

function tzoffset(d) {
    // returns the time zone offset, expressed as "hours *behind* UTC".
    // that would be 180 minutes for Brazil (-0300) and -60 minutes for Germany (+0100)
    return d.getTimezoneOffset() * 60000;
}

export default function bscalc(p = null) {
    var c = {};
    const util_days = 21;
    if (p == null) {
        p = {
            spot: 20.70,
            strike: 22.14,
            interest: 2.0,
            expiration: 0.003968 * util_days,
            volatility: 32,
        }
    }

    c.premium = opremium(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.intrinsic = Math.max(p.spot - p.strike, 0);
    c.delta = odelta(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.gamma = ogamma(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.theta = otheta(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.vega = ovega(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.rho = orho(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    c.probability = 1 - stock_price_probability(0.01, p.strike, p.spot, p.interest / 100, p.volatility / 100, p.expiration);

    // console.log(c);

    var u = {};
    u.premium = putzopremium(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.intrinsic = Math.max(- p.spot + p.strike, 0);
    u.delta = putzodelta(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.gamma = putzogamma(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.theta = putzotheta(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.vega = putzovega(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.rho = putzorho(p.spot, p.strike, p.interest / 100, p.expiration, p.volatility / 100);
    u.probability = 1 - c.probability;

    var f = {};
    f.premium = function (n) { return n.toFixed(2); };
    f.intrinsic = f.premium;
    f.delta = function (n) { return n.toFixed(4); };
    f.gamma = f.delta;
    f.theta = f.delta;
    f.vega = f.delta;
    f.rho = f.delta;
    f.probability = function (n) { return (n * 100).toFixed(1) + "%"; };

    // console.log(u);

    return {
        call: c,
        put: u
    };

}

var attrs = ["strike", "spot", "expiration", "volatility", "interest"];
var decs = [2, 2, 6, 2, 2];

function check_input() {
    var err = false;
    var params = {};

    for (var i = 0; i < attrs.length; ++i) {
        $("#" + attrs[i]).removeClass("invalid");
        var f = parseFloat($("#" + attrs[i]).val());
        if (isNaN(f)) {
            err = true;
            $("#" + attrs[i]).addClass("invalid");
        }
        params[attrs[i]] = f;
    }
    if (err) {
        params = null;
    }
    return params;
}

function update_input(params) {
    for (var i = 0; i < attrs.length; ++i) {
        $('#' + attrs[i]).val(params[attrs[i]].toFixed(decs[i]));
    }
}

function changed() {
    var params = check_input();
    if (!params) {
        return;
    }
    save_memory(params);
    bscalc(params);
}

function dive(divisor) {
    check_input();
    var exp = parseFloat($("#expiration").val());
    if (!exp) {
        return;
    }
    $("#expiration").val((exp / divisor).toFixed(6));
    changed();
}

function Init_calc(ptbr) {
    var defs = {
        "spot": 100.0, "strike": 100.0, "expiration": 2 / 12,
        "volatility": 25.0, "interest": 12.0
    };
    recover_memory(defs);
    update_input(defs);
    changed();
}

bscalc();



























function normdistacum(x) {
    var kd1 = 0.0498673470;
    var kd3 = 0.0032776263;
    var kd5 = 0.0000488906;
    var kd2 = 0.0211410061;
    var kd4 = 0.0000380036;
    var kd6 = 0.0000053830;
    if (x < 0) {
        return 1 - normdistacum(-x);
    }
    var n = 1.0 - 0.5 * Math.pow(1 + kd1 * x + kd2 * Math.pow(x, 2) + kd3 * Math.pow(x, 3) + kd4 * Math.pow(x, 4) + kd5 * Math.pow(x, 5) + kd6 * Math.pow(x, 6), -16);
    return n;
}

function normdist(x) {
    var n = Math.exp(-(Math.pow(x, 2) / 2));
    n /= Math.pow((2 * Math.PI), 0.5);
    return n;
}
function d1(spot, strike, interest, time, volatility) {
    if (volatility < 0.0000001) {
        return 9999999999.9;
    }
    var x = Math.log(spot / strike) + (interest + Math.pow(volatility, 2) / 2) * time;
    x /= volatility * Math.pow(time, 0.5);
    return x;
}

function d2(spot, strike, interest, time, volatility) {
    var x = d1(spot, strike, interest, time, volatility) - volatility * Math.pow(time, 0.5);
    return x;
}



function opremium(spot, strike, interest, time, volatility) {

    var D1 = d1(spot, strike, interest, time, volatility);
    var nd1 = normdistacum(D1);
    var D2 = d2(spot, strike, interest, time, volatility);
    var nd2 = normdistacum(D2);
    console.log(nd1);
    return nd1 * spot - Math.exp(-interest * time) * nd2 * strike;
}

function putzopremium(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var nd1 = normdistacum(-D1);
    var D2 = d2(spot, strike, interest, time, volatility);
    var nd2 = normdistacum(-D2);
    return -nd1 * spot + Math.exp(-interest * time) * nd2 * strike;
}


function odelta(spot, strike, interest, time, volatility) {
    var x = normdistacum(d1(spot, strike, interest, time, volatility));
    return x;
}

function putzodelta(spot, strike, interest, time, volatility) {
    var x = normdistacum(d1(spot, strike, interest, time, volatility)) - 1;
    return x;
}

function ogamma(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var x = normdist(D1);
    x /= spot * volatility * Math.pow(time, 0.5);
    return x;
}

function putzogamma(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var x = normdist(D1);
    x /= spot * volatility * Math.pow(time, 0.5);
    return x;
}

function otheta(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var D2 = d2(spot, strike, interest, time, volatility);
    var x = - spot * normdist(D1) * volatility;
    x /= 2 * Math.pow(time, 0.5);
    x -= interest * strike * Math.exp(-interest * time) * normdistacum(D2);
    return x;
}

function putzotheta(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var D2 = d2(spot, strike, interest, time, volatility);
    var x = - spot * normdist(D1) * volatility;
    x /= 2 * Math.pow(time, 0.5);
    x += interest * strike * Math.exp(-interest * time) * normdistacum(-D2);
    return x;
}

function ovega(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var x = spot * Math.sqrt(time) * normdist(D1);
    return x;
}

function putzovega(spot, strike, interest, time, volatility) {
    var D1 = d1(spot, strike, interest, time, volatility);
    var x = spot * Math.sqrt(time) * normdist(D1);
    return x;
}

function orho(spot, strike, interest, time, volatility) {
    var D2 = d2(spot, strike, interest, time, volatility);
    var x = strike * time * Math.exp(-interest * time) * normdistacum(D2);
    return x;
}

function putzorho(spot, strike, interest, time, volatility) {
    var D2 = d2(spot, strike, interest, time, volatility);
    var x = -strike * time * Math.exp(-interest * time) * normdistacum(-D2);
    return x;
}


function stock_price_probability(strike1, strike2, spot, interest, volatility, time) {
    time = Math.max(time, 0.0001);
    volatility = Math.max(volatility, 0.001);
    strike1 = Math.max(strike1, 0.01);
    strike2 = Math.max(strike2, 0.01);
    var prob1 = normdistacum(normal_strike(spot, strike1, interest, time, volatility));
    var prob2 = normdistacum(normal_strike(spot, strike2, interest, time, volatility));
    return prob2 - prob1;
}

function stock_price_probability_max(spread, spot, interest, volatility, time) {
    // Determines the maximum probability that stock_price_probability() will return,
    // given a spread between strike prices (strike1 and strike2)

    // strike = average of expected future price
    var strike = spot * Math.exp((interest - Math.pow(volatility, 2) / 2) * time);
    var p = stock_price_probability(strike - spread, strike + spread, spot, interest, volatility, time);
    return p;
}

function normal_strike(spot, strike, interest, time, volatility) {
    // Returns a normalized strike price, with average=0 and standard dev=1
    if (volatility < 0.0000001) {
        return 9999999999.9;
    }
    var x = Math.log(strike / spot) - (interest - Math.pow(volatility, 2) / 2) * time;
    x /= volatility * Math.pow(time, 0.5);
    return x;
}
