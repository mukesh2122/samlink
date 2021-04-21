<script type="text/javascript">
/* NEW ACCOUNT - Universal Analytics */
    (function(i,s,o,g,r,a,m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() { (i[r].q = i[r].q || []).push(arguments); },
        i[r].l = 1*new Date();
        a = s.createElement(o), m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a,m);
    }(window,document,'script','//www.google-analytics.com/analytics.js','ga'));

    ga('create', 'UA-48403208-1', 'playnation.eu');
    ga('send', 'pageview');
    // This is for internal site link tracking, place between 'send' and 'create'
//    ga('require', 'linkid', 'linkid.js');

/* OLD ACCOUNT IS IT EVEN USED ?? - Classic Analytics */
    var _gaq = _gaq || [];
    // This is for internal site link tracking
//    var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
//    _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
    _gaq.push(['_setAccount', 'UA-32336732-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        // This is for demography and interest tracking (https://support.google.com/analytics/answer/2700409)
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    //      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    }());
</script>