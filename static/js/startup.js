pimcore.registerNS("pimcore.plugin.coreshopexport");

pimcore.plugin.coreshopexport = Class.create(pimcore.plugin.admin, {
    getClassName: function() {
        return "pimcore.plugin.coreshopexport";
    },

    initialize: function() {
        pimcore.plugin.broker.registerPlugin(this);
    },
 
    pimcoreReady: function (params,broker){
        // alert("CoreShopExport Plugin Ready!");
    }
});

var coreshopexportPlugin = new pimcore.plugin.coreshopexport();

