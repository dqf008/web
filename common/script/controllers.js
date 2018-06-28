app.controller('LobbiesCtrl', ['$scope', '$rootScope', 'LobbyNavService', '$location',
    function(n, t, i, o) {
        n.g = '/cj/live/?type=';
        n.l = '/game/list.php?g=';
      	n.c = '/lot/';
        n.toMg = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'mg');
            else i.name = 'game', i.open(n.g + 'mg2&id=' + id);
        };
        n.toMw = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'mw');
            else i.name = 'game', i.open(n.g + 'mw&id=' + id);
        };
        n.toCq9 = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'cq9');
            else i.name = 'game', i.open(n.g + 'cq9&id=' + id);
        };
        n.toKg = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'kg');
            else i.name = 'game', i.open(n.g + 'kg&id=' + id);
        };
        n.toRt = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'rt');
            else i.name = 'game', i.open(n.g + 'rt&id=' + id);
        };
        n.toLax = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'lax');
            else i.name = 'game', i.open(n.g + 'lax&id=' + id);
        };
        n.toPt2 = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'pt2');
            else i.name = 'game', i.open(n.g + 'pt2&id=' + id);
        };
        n.toKy = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'ky');
            else i.name = 'game', i.open(n.g + 'ky&id=' + id);
        };
		n.toBb2 = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'bbin');
            else i.name = 'game', i.open(n.g + 'bbin2&id=' + id);
        };
        n.toZh = function() {
            i.open('/egame/egame2.php?w=1250');
        };
        n.toBb = function() {
            i.open(n.g + 'BBIN&gameType=5');
        };
        n.toPt = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'pt2');
            else i.name = 'game', i.open(n.g + 'pt2&id=' + id);
        };
        n.toFish = function() {
            i.open('/game/fish.php');
        };
        n.toYoplay = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'yoplay');
            else i.name = 'game', i.open(n.g + 'AGIN&gameType=' + id);
        };
        n.toXin = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'xin');
            else i.name = 'game', i.open(n.g + 'AGIN&gameType=' + id);
        };
        n.toBg = function(id) {
            if (id === undefined) i.name = 'list', i.open(n.l + 'bg');
            else i.name = 'game', i.open(n.g + 'AGIN&gameType=' + id);
        };
        n.toLottery = function(id) {
            if (id === undefined) window.location.href = '/lot/';
        };
        n.toLotteryVr = function(id){
            i.name = 'game';
            if (id === undefined) i.iopen(n.g + 'vr');
            else i.iopen(n.g + 'vr&id=' + id);
        };
        n.toLotteryBb = function(){
            i.iopen(n.g + 'BBIN&gameType=3');
        };
        n.toLive = function(type){
            i.iopen(n.g + type);
        };
    }
]);
app.controller('SlotGame', ['$scope', '$http', '$window', 'ReviewGameService', 'LobbyNavService',
    function(n, t, i, g, s) {
        function o(t) {
            for (var i = 0; i < t.length; i++)
                if (n.searchItem.CategoryKey === t[i].CategoryKey) return !0
        }
        n.Categories = [];
        n.GameData = [];
        n.itemsPerPage = n.GameCount;
        n.currentPage = 0;
        n.navActive = o;
        n.searchItem = {
            NameKeyword: '',
            CategoryKey: '',
            GameSupplierType: n.GameType,
            IsMobile: n.Mobile
        };
        n.searchItem.GameSupplierType || (n.searchItem.GameGroupName = n.GameGroupName, delete n.searchItem.GameSupplierType);
        n.init = function() {
            t.get(cdn_url + 'Common/SlotCasinoData/' + n.GameGroupName + '.json').then(function(t) {
                n.Categories = t.data.Categories;
                for (var i in t.data.Games) {
                    var game = t.data.Games[i];
                    game.ButtonImagePath = cdn_url + game.ButtonImagePath;
                    n.GameData.push(game);
                }
                t = n.Categories[0].CategoryKey;
                n.gamelist(0, t);
            });
        };
        n.gamelist = function(i, r) {
            if (n.GameData.length === 0) n.init();
            n.searchItem.NameKeyword = r !== 0 ? n.gamesearch = '' : n.gamesearch || '';
            n.searchItem.CategoryKey = r;
            n.currentPage = i;
            n.sorts = n.Categories;
            var s = g.view(n.GameData, n.searchItem, n.currentPage, n.itemsPerPage);
            n.games = s.games;
            n.totalGameCount = s.allCount;
        };
        n.pageCount = function() {
            return Math.ceil(n.totalGameCount / n.itemsPerPage) || 0
        };
        n.startPage = function() {
            n.gamelist(0, n.searchItem.CategoryKey)
        };
        n.endPage = function() {
            n.pageCount() > 0 && n.gamelist(n.pageCount() - 1, n.searchItem.CategoryKey)
        };
        n.prevPage = function() {
            n.currentPage != 0 && n.gamelist(n.currentPage - 1, n.searchItem.CategoryKey)
        };
        n.nextPage = function() {
            n.currentPage + 1 < n.pageCount() && n.gamelist(n.currentPage + 1, n.searchItem.CategoryKey)
        };
        n.toSlotGame = function(id) {
            var GameType = n.GameGroupName === 'MG' ? 'MG2' : n.GameGroupName;
            if (GameType === 'XIN' || GameType === 'YOPLAY' || GameType === 'BG') url = '/cj/live/?type=AGIN&gameType=' + id;
            else if (GameType === 'PT') url = '/cj/live/?type=PT&gameType=' + id;
            else url = '/cj/live/?type=' + GameType + '&id=' + id; if (!n.IsLogin && GameType === 'MG2') url = url + '&try=true';
            s.open(url)
        };
        n.init();
    }
]);
app.controller("LayoutCtrl", ["$scope", "$element", "$window", "$http", "$interval", "$location", "$timeout",
    function(n, t, i, r, u, f, o) {
        n.meiDonNow = moment($("html").attr("meidon-time").replace(/\//g, "-"));
        u(function() {
            n.meiDonNow.add(1, 'seconds');
        }, 990);
    }
]);