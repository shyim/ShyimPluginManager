


Ext.override(Shopware.apps.PluginManager.controller.Navigation, {
    init: function () {
        this.cards['pluginComposerPage'] = 9;
        this.callParent(arguments);

        this.control({
            'plugin-manager-listing-window plugin-category-navigation': {
                'display-composer': this.displayPluginComposer
            }
        });
    },

    displayPluginComposer: function () {
        var me = this,
            navigation = me.getNavigation();

        me.switchView(me.cards.pluginComposerPage);
        me.setActiveNavigationLink(navigation.composerLink);
    },

    removeNavigationSelection: function() {
        var me = this,
            navigation = me.getNavigation();

        me.callParent(arguments);

        navigation.composerLink.removeCls('active');
    }
});