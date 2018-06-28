app.filter("dateTime", function() {
    return function(n) {
        return n ? moment(n).format("YYYY-MM-DD (dd) HH:mm:ss") : ""
    }
});