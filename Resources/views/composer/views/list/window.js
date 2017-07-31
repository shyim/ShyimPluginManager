


Ext.override(Shopware.apps.PluginManager.view.list.Window, {
    createCenterPanel: function() {
        var me = this;

        me.cards = [
            me.createHomePage(),
            me.createLocalPluginPage(),
            me.createPluginUpdatesPage(),
            me.createListingPage(),
            me.createAccountPage(),
            me.createLicencePage(),
            me.createPremiumPluginsPage(),
            me.createExpiredPluginsPage(),
            me.createConnectIntroductionPage(),
            me.createComposerPage()
        ];

        me.centerPanel = Ext.create('Ext.container.Container', {
            name: 'card-container',
            region: 'center',
            layout: 'card',
            items: me.cards
        });

        return me.centerPanel;
    },

    createComposerPage: function () {
        var me = this;

        me.pluginUpdatesPage = Ext.create('Ext.container.Container', {
            layout: { type: 'fit' },
            items: [
                Ext.create('Shopware.apps.PluginManager.view.list.ComposerPage', {
                    subApp: me.subApp
                })
            ],
            cardIndex: 9
        });

        return me.pluginUpdatesPage;
    }
});