// Ziel-Datum in MEZ
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

// init output
var str_year = '';
var str_month = '';
var str_day = '';
var str_hour = '';
var str_minute = '';
var str_second = '';

function initCountdown(jahr, monat, tag, stunde, minute, sekunde, text, beforecd, aftercd, hideyear, hidemonth, hideday, hidehour, hideminute, hidesecond) {
	zielDatum = new Date(jahr, monat-1, tag, stunde, minute, sekunde);
	aftercount = text;
	beforecountdown = beforecd;
	aftercountdown = aftercd;
	hide_year = hideyear;
	hide_month = hidemonth;
	hide_day = hideday;
	hide_hour = hidehour;
	hide_minute = hideminute;
	hide_second = hidesecond;
	countdown();
}

function initLanguage(languagelabels) {
	languagelabels = languagelabels.split(" ");
	label_year = languagelabels[0];
	label_years = languagelabels[1];
	label_month = languagelabels[2];
	label_months = languagelabels[3];
	label_day = languagelabels[4];
	label_days = languagelabels[5];
	label_hour = languagelabels[6];
	label_hours = languagelabels[7];
	label_minute = languagelabels[8];
	label_minutes = languagelabels[9];
	label_second = languagelabels[10];
	label_seconds = languagelabels[11];
	label_and = languagelabels[12];
}

function countdown() {

	var startDatum = new Date(); // Aktuelles Datum

	// Countdown berechnen und anzeigen, bis Ziel-Datum erreicht ist
	if(startDatum < zielDatum)  {
		var jahre = 0, monate = 0, tage = 0, stunden = 0, minuten = 0, sekunden = 0;

		// Jahre
		while(startDatum < zielDatum) {
			jahre++;
			startDatum.setFullYear(startDatum.getFullYear() + 1);
		}
		startDatum.setFullYear(startDatum.getFullYear() - 1);
		jahre--;

		// Monate
		while(startDatum < zielDatum) {
			monate++;
			startDatum.setMonth(startDatum.getMonth() + 1);
		}
		startDatum.setMonth(startDatum.getMonth() - 1);
		monate--;

		// Tage
		while(startDatum.getTime() + (24*60*60*1000) < zielDatum) {
			tage++;
			startDatum.setTime(startDatum.getTime() + (24*60*60*1000));
		}

		// Stunden
		stunden = Math.floor((zielDatum - startDatum)/(60*60*1000));
		startDatum.setTime(startDatum.getTime() + stunden*60*60*1000);

		// Minuten
		minuten = Math.floor((zielDatum - startDatum)/(60*1000));
		startDatum.setTime(startDatum.getTime() + minuten*60*1000);

		// Sekunden
		sekunden = Math.floor((zielDatum - startDatum)/1000);

		//Anzeige formatieren

		var arrstr = new Array();
		var str = '';

		if (!hide_year) {
			(jahre != 1) ? str_year = jahre + " " + label_years : str_year = jahre + " " + label_year;
			arrstr.splice(0,0,str_year);
		};
		if (!hide_month) {
			(monate != 1) ? str_month = monate + " " + label_months : str_month = monate + " " + label_month;
			arrstr.splice(0,0,str_month);
		};
		if (!hide_day) {
			(tage != 1) ? str_day = tage + " " + label_days : str_day = tage + " " + label_day;
			arrstr.splice(0,0,str_day);
		};
		if (!hide_hour) {
			(stunden != 1) ? str_hour = stunden + " " + label_hours : str_hour = stunden + " " + label_hour;
			arrstr.splice(0,0,str_hour);
		};
		if (!hide_minute) {
			(minuten != 1) ? str_minute = minuten + " " + label_minutes : str_minute = minuten + " " + label_minute;
			arrstr.splice(0,0,str_minute);
		};
		if (!hide_second) { 
			if(sekunden < 10) sekunden = "0" + sekunden;
			(sekunden != 1) ? str_second = sekunden + " " + label_seconds : str_second = sekunden + " " + label_second;
			arrstr.splice(0,0,str_second);
		 };

		for (var i = arrstr.length - 1; i >= 0; i--) {
			str = str + arrstr[i];
			if (i > 1) { str = str + ", "; };
			if (i == 1) { str = str + " " + label_and + " "; };
		};

		// Anzeige aktualisieren
		document.getElementById("showcountdown").innerHTML = beforecountdown + str + aftercountdown;
		setTimeout('countdown()',200);
	}
	// after countdown
	else document.getElementById("showcountdown").innerHTML = aftercount;
}