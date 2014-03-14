// target date (MEZ)
var zielDatum;

// output strings
var aftercount;
var beforecountdown;
var aftercountdown;

// language labels
var label_year;
var label_years;
var label_month;
var label_months;
var label_day;
var label_days;
var label_hour;
var label_hours;
var label_minute;
var label_minutes;
var label_second;
var label_seconds;

// other labels
var label_and;

// hide elements
var hide_year;
var hide_month;
var hide_day;
var hide_hour;
var hide_minute;
var hide_second;
var hide_leading_zero;

// init output
var str_year = '';
var str_month = '';
var str_day = '';
var str_hour = '';
var str_minute = '';
var str_second = '';

// get id
var id = "0";

/**
 * initializes needed values for countdown
 *
 * @param {string}  languagelabels  space separated language labels
 * @param {integer} jahr            year
 * @param {integer} monat           month
 * @param {integer} tag             day
 * @param {integer} stunde          hour
 * @param {integer} minute          minute
 * @param {integer} sekunde         second
 * @param {string}  text            output for finished countdown
 * @param {string}  beforecd        wrap
 * @param {string}  aftercd         wrap
 * @param {boolean} hideyear        hide year
 * @param {boolean} hidemonth       hide month
 * @param {boolean} hideday         hide day
 * @param {boolean} hidehour        hide hour
 * @param {boolean} hideminute      hide minute
 * @param {boolean} hidesecond      hide second
 * @param {boolean} hideleadingzero hide elements that are already zero
 * @param {integer} num             id
 *
 * @return {void} call countdown()
 */
function initCountdown(languagelabels, jahr, monat, tag, stunde, minute, sekunde, text, beforecd, aftercd, hideyear, hidemonth, hideday, hidehour, hideminute, hidesecond, hideleadingzero, num)
{
    languagelabels    = languagelabels.split(" ");
    label_year        = languagelabels[0];
    label_years       = languagelabels[1];
    label_month       = languagelabels[2];
    label_months      = languagelabels[3];
    label_day         = languagelabels[4];
    label_days        = languagelabels[5];
    label_hour        = languagelabels[6];
    label_hours       = languagelabels[7];
    label_minute      = languagelabels[8];
    label_minutes     = languagelabels[9];
    label_second      = languagelabels[10];
    label_seconds     = languagelabels[11];
    label_and         = languagelabels[12];
    zielDatum         = new Date(jahr, monat-1, tag, stunde, minute, sekunde);
    aftercount        = text;
    beforecountdown   = beforecd;
    aftercountdown    = aftercd;
    hide_year         = hideyear;
    hide_month        = hidemonth;
    hide_day          = hideday;
    hide_hour         = hidehour;
    hide_minute       = hideminute;
    hide_second       = hidesecond;
    hide_leading_zero = hideleadingzero;
    id                = num;
    countdown();
}

/**
 * function to evaluate countdown
 *
 * @return {strubg} countdown
 */
function countdown()
{
    var startDatum = new Date(); // current date

    // evaluate countdown until target date
    if(startDatum < zielDatum) {
        var jahre = 0, monate = 0, tage = 0, stunden = 0, minuten = 0, sekunden = 0;

        // years
        while(startDatum < zielDatum) {
            jahre++;
            startDatum.setFullYear(startDatum.getFullYear() + 1);
        }
        startDatum.setFullYear(startDatum.getFullYear() - 1);
        jahre--;

        // months
        while(startDatum < zielDatum) {
            monate++;
            startDatum.setMonth(startDatum.getMonth() + 1);
        }
        startDatum.setMonth(startDatum.getMonth() - 1);
        monate--;

        // days
        while(startDatum.getTime() + (24*60*60*1000) < zielDatum) {
            tage++;
            startDatum.setTime(startDatum.getTime() + (24*60*60*1000));
        }

        // hours
        stunden = Math.floor((zielDatum - startDatum)/(60*60*1000));
        startDatum.setTime(startDatum.getTime() + stunden*60*60*1000);

        // minutes
        minuten = Math.floor((zielDatum - startDatum)/(60*1000));
        startDatum.setTime(startDatum.getTime() + minuten*60*1000);

        // seconods
        sekunden = Math.floor((zielDatum - startDatum)/1000);

        // initialize output string
        var arrstr = new Array();
        var str = '';

        // get booleans wether to show specific element
        var show_year = !hide_year & !(hide_leading_zero & jahre == 0);
        var show_month = !hide_month & !(hide_leading_zero & jahre == 0 & monate == 0);
        var show_day = !hide_day & !(hide_leading_zero & jahre == 0 & monate == 0 & tage == 0);
        var show_hour = !hide_hour & !(hide_leading_zero & jahre == 0 & monate == 0 & tage == 0 & stunden == 0);
        var show_minute = !hide_minute & !(hide_leading_zero & jahre == 0 & monate == 0 & tage == 0 & stunden == 0 & minuten == 0);
        var show_second = !hide_second;

        // format output
        if (show_year) {
            (jahre != 1) ? str_year = jahre + " " + label_years : str_year = jahre + " " + label_year;
            arrstr.splice(0,0,str_year);
        };
        if (show_month) {
            (monate != 1) ? str_month = monate + " " + label_months : str_month = monate + " " + label_month;
            arrstr.splice(0,0,str_month);
        };
        if (show_day) {
            (tage != 1) ? str_day = tage + " " + label_days : str_day = tage + " " + label_day;
            arrstr.splice(0,0,str_day);
        };
        if (show_hour) {
            (stunden != 1) ? str_hour = stunden + " " + label_hours : str_hour = stunden + " " + label_hour;
            arrstr.splice(0,0,str_hour);
        };
        if (show_minute) {
            (minuten != 1) ? str_minute = minuten + " " + label_minutes : str_minute = minuten + " " + label_minute;
            arrstr.splice(0,0,str_minute);
        };
        if (show_second) {
            if(sekunden < 10) sekunden = "0" + sekunden;
            (sekunden != 1) ? str_second = sekunden + " " + label_seconds : str_second = sekunden + " " + label_second;
            arrstr.splice(0,0,str_second);
         };

        for (var i = arrstr.length - 1; i >= 0; i--) {
            str = str + arrstr[i];
            if (i > 1) { str = str + ", "; };
            if (i == 1) { str = str + " " + label_and + " "; };
        };

        // update output
        document.getElementById(id).innerHTML = beforecountdown + str + aftercountdown;
        setTimeout('countdown()',200);
    } else {
        // show text for after count
        document.getElementById(id).innerHTML = aftercount;
    }
}