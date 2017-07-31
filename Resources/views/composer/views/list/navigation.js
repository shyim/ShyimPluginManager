


Ext.override(Shopware.apps.PluginManager.view.list.Navigation, {
    createLocalContainer: function() {
        var me = this,
            parent = me.callParent(arguments);

        me.composerLink = Ext.create('PluginManager.container.Container', {
            cls: 'navigation-item',
            html: '<div class="content">{s name="navigation_composer"}Packagist{/s}</div>',
            handler: function() {
                me.fireEvent('display-composer');
            }
        });

        parent.add(me.composerLink);

        return parent;
    }
});
